<div x-data="initData()" x-init="fetchData()">
  <div x-show="loading" >
    <img src="<?=base_url();?>images/loading.gif">
  </div>
  <div x-show="!loading">
    <div class="overflow-auto max-h-screen rounded-lg border border-gray-200 shadow-md m-5">
      <table class="w-full border-collapse bg-white text-left ">
        <thead class="bg-gray-50 sticky top-0">
          <tr>
            <th scope="col" class="px-6 py-4  text-gray-900">名前</th>
            <th scope="col" class="px-6 py-4  text-gray-900">操作</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 border-t border-gray-100">
          <template x-for="service in services">
            <tr class="hover:bg-gray-200">
              <td class="px-6 py-4  text-gray-900" x-text="service.service_name" x-show="!service.editing"></td>
              <td x-show="service.editing" class="px-6 py-4  text-gray-900">
                <input type="text" x-model="service.service_name" class="rounded-lg border border-indigo-500">
              </td>
              <td class="px-6 py-4">
                <div class="justify-end gap-4">
                  <div x-show="service.saving">
                    保存中...
                  </div>
                  <div x-show="service.deleting">
                    削除中...
                  </div>
                  <div x-show="!service.saving && !service.deleting">
                    <div class="flex">
                      <button x-show="!service.editing" @click="editService(service)" class="flex items-center py-2 px-4 mr-1 rounded text-white bg-gradient-to-tr bg-indigo-500 hover:bg-indigo-600">
                        <span class="material-icons">edit</span>
                      </button>
                      <button x-show="!service.editing" @click="deleteService(service)" class="flex items-center py-2 px-4 ml-1 rounded text-white bg-gradient-to-tr bg-red-500 hover:bg-red-600 ">
                        <span class="material-icons">delete</span>
                      </button>
                    </div>
                    <div class="flex">
                      <button x-show="service.editing" @click="saveService(service)" class="flex items-center py-2 px-4 mr-1 rounded text-white bg-gradient-to-tr bg-indigo-500 hover:bg-indigo-600">
                        <span class="material-icons">save</span>
                      </button>
                      <button x-show="service.editing" @click="cancelEdit(service)" class="flex items-center py-2 px-4 ml-1 rounded text-white bg-gradient-to-tr bg-red-500 hover:bg-red-600">
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
          <input type="text" placeholder="名前" x-model="newServiceName" class="mr-1 rounded-lg border border-indigo-500">
          <button @click="addService()" class="flex items-center ml-1 py-2 px-4 rounded text-white bg-gradient-to-tr bg-indigo-500 hover:bg-indigo-600">
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
      services: [],
      loading: true,
      fetchData: fetchData,
      addService: addService,
      deleteService: deleteService,
      saveService: saveService,
      newServiceName: '',
      adding: false,
    };
  }

  async function fetchData() {
    let url = '<?=base_url();?>admin/service/getAll';
    let response = await fetch(url);
    let data = await response.json();
    this.services = data;
    this.loading = false;
  }

  async function addService() {
    let name = this.newServiceName.trim();
    let exists = this.services.some(item => item.service_name === name);
    if (exists) {
      swalError('この名前は既に存在しています');
      return;
    }
    if(name === '') {
      swalError('サービス名は空にできません');
      return;
    }
    this.adding = true; 
    let url = '<?=base_url();?>admin/service/create';    
    let data = {
      service_name: name,
    }
    let formData = createFormData(data);
    let response = await fetch(url, {
      method: 'POST',
      body: formData,
    });
    let resData = await response.json();
    let newData = {
      id: resData.insert_id,
      service_name: name,
    }        
    if(resData.status = 201){
      this.services.push(newData);
      this.adding = false;
      this.newServiceName = '';
      swalSuccess('追加しました');
    }
    else{
      console.error(resData);
    }
  }

  async function deleteService(service){
    if(!(await swalConfirm('このデータを削除しますか?'))){
      return;
    }
    service.deleting = true;
    let data = {
      id: service.id,
    }
    let formData = createFormData(data);
    let url = '<?=base_url();?>admin/service/delete';
    let response = await fetch(url, {
      method: 'POST',
      body: formData,
    });
    let resData = await response.json();
    if(resData.status = 200){
      service.deleting = false;
      this.services = this.services.filter(item => item.id !== service.id);
      swalSuccess('削除しました');
    }
    else{
      console.error(resData);
    }
  }

  async function saveService(service) {
    let id = service.id;
    let name = service.service_name.trim();
    let exists = this.services.some(item => item.id != id && item.service_name === name);
    if (exists) {
      swalError('この名前は既に存在しています');
      return;
    }
    if(name === '') {
      swalError('サービス名は空にできません');
      return;
    }
    service.saving = true;
    let url = '<?=base_url();?>admin/service/update';
    let data = {
      id: id,
      service_name: name,
    }
    let formData = createFormData(data);
    let response = await fetch(url, {
      method: 'POST',
      body: formData,
    });
    let resData = await response.json();
    if(resData.status = 200){
      service.saving = false;
      service.editing = false;
      swalSuccess('更新しました');
    }
    else{
      console.error(resData);
    }

  }

  function editService(service){
    service.editing = true;
    service.original = JSON.parse(JSON.stringify(service));
  }
  
  function cancelEdit(service) {
    Object.assign(service, service.original);
    service.editing = false;
  }

</script>





