<div x-data="initData()" x-init="fetchData()">
  <div x-show="loading" >
    <img src="<?=base_url();?>images/loading.gif">
  </div>
  <div x-show="!loading">
    <div class="overflow-auto max-h-screen rounded-lg border border-gray-200 shadow-md m-5">
      <table class="w-full border-collapse bg-white text-left">
        <thead class="bg-gray-50 sticky top-0">
          <tr>
            <th scope="col" class="px-6 py-4  text-gray-900">名前</th>
            <th scope="col" class="px-6 py-4  text-gray-900">操作</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 border-t border-gray-100">
          <template x-for="category in categories">
            <tr class="hover:bg-gray-200">
              <td x-show="!category.editing" x-text="category.category_name" class="px-6 py-4  text-gray-900"></td>
              <td x-show="category.editing" class="px-6 py-4  text-gray-900">
                <input type="text" x-model="category.category_name" class="rounded-lg border border-indigo-500">
              </td>
              <td class="px-6 py-4">
                <div class="justify-end gap-4">
                  <div x-show="category.saving">
                    保存中...
                  </div>
                  <div x-show="category.deleting">
                    削除中...
                  </div>
                  <div x-show="!category.saving && !category.deleting">
                    <div class="flex">
                      <button x-show="!category.editing" @click="editCategory(category)" class="flex items-center py-2 px-4 mr-1 rounded text-white bg-gradient-to-tr bg-indigo-500 hover:bg-indigo-600">
                        <span class="material-icons">edit</span>
                      </button>
                      <button x-show="!category.editing" @click="deleteCategory(category)" class="flex items-center py-2 px-4 ml-1 rounded text-white bg-gradient-to-tr bg-red-500 hover:bg-red-600">
                        <span class="material-icons">delete</span>
                      </button>
                    </div>
                    <div class="flex">
                      <button x-show="category.editing" @click="saveCategory(category)" class="flex items-center py-2 px-4 mr-1 rounded text-white bg-gradient-to-tr bg-indigo-500 hover:bg-indigo-600">
                        <span class="material-icons">save</span>
                      </button>
                      <button x-show="category.editing" @click="cancelEdit(category)" class="flex items-center py-2 px-4 ml-1 rounded text-white bg-gradient-to-tr bg-red-500 hover:bg-red-600">
                        <span class="material-icons">close</span>
                      </button>                    
                    </div>
                  </div>
                </div>
              </td>
            </tr>
          </template>
        </tbody>
      </table>
    </div>
    <div class="bg-gray-50 rounded-lg border m-5">
      <div x-show="!adding" colspan="3" class="px-6 py-4">
        <div class="flex justify-center">
          <input type="text" placeholder="名前" x-model="newCategoryName" class="mr-1 rounded-lg border border-indigo-500">
          <button @click="addCategory()" class="flex items-center ml-1 py-2 px-4 rounded text-white bg-gradient-to-tr bg-indigo-500 hover:bg-indigo-600">
            <span class="material-icons">add</span>
          </button>
        </div>
      </div>
      <div x-show="adding" colspan="3" class="px-6 py-4 text-center">
        追加中...
      </div>
    </div>
  </div>
</div>
<script>

  function initData(){
    return {
      categories: [],
      loading: true,
      fetchData: fetchData,
      addCategory: addCategory,
      deleteCategory: deleteCategory,
      saveCategory: saveCategory,
      newCategoryName: '',
      adding: false,
    };
  }

  async function fetchData() {
    let url = '<?=base_url();?>admin/category/getAll';
    let response = await fetch(url);
    let data = await response.json();
    this.categories = data;
    this.loading = false;
  }

  async function addCategory() {
    let name = this.newCategoryName.trim();
    let exists = this.categories.some(item => item.category_name === name);
    if (exists) {
      swalError('この名前は既に存在しています');
      return;
    }
    if(name === '') {
      swalError('カテゴリ名は空にできません');
      return;
    }
    this.adding = true;
    let url = '<?=base_url();?>admin/category/create';    
    let data = {
      category_name: name,
    }
    let formData = createFormData(data);
    let response = await fetch(url, {
      method: 'POST',
      body: formData,
    });
    let resData = await response.json();
    let newData = {
      id: resData.insert_id,
      category_name: name,
    }        
    if(resData.status = 201){
      this.categories.push(newData);
      this.adding = false;
      this.newCategoryName = '';
      swalSuccess('追加しました'); 
    }
    else{
      console.error(resData);
    }

  }

  async function deleteCategory(category){
    if(!(await swalConfirm('このデータを削除しますか?'))){
      return;
    }
    category.deleting = true;
    let data = {
      id: category.id,
    }
    let formData = createFormData(data);
    let url = '<?=base_url();?>admin/category/delete';
    let response = await fetch(url, {
      method: 'POST',
      body: formData,
    });
    let resData = await response.json();
    if(resData.status = 200){
      category.deleting = false;
      this.categories = this.categories.filter(item => item.id !== category.id);
      swalSuccess('削除しました');
    }
    else{
      console.error(resData);
    }
  }

  async function saveCategory(category) {
    let id = category.id;
    let name = category.category_name.trim();
    let exists = this.categories.some(item => item.id != id && item.category_name === name);
    if (exists) {
      swalError('この名前は既に存在しています');
      return;
    }
    if(name === '') {
      swalError('カテゴリ名は空にできません');
      return;
    }
    category.saving = true;
    let url = '<?=base_url();?>admin/category/update';
    let data = {
      id: id,
      category_name: name,
    }
    let formData = createFormData(data);
    let response = await fetch(url, {
      method: 'POST',
      body: formData,
    });
    let resData = await response.json();
    if(resData.status = 200){
      category.saving = false;
      category.editing = false;
      swalSuccess('更新しました');
    }
    else{
      console.error(resData);
    }
  }

  function editCategory(category){
    category.editing = true;
    category.original = JSON.parse(JSON.stringify(category));
  }
  
  function cancelEdit(category) {
    Object.assign(category, category.original);
    category.editing = false;
  }

</script>




