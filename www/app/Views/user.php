<div x-data="initData()" x-init="fetchData()" class="w-full">
  <div x-show="loading" class="flex justify-center">
    <img src="<?=base_url();?>images/loading.gif">
  </div>
  <div x-show="!loading" class="rounded-lg border border-gray-200 shadow-md m-5">
    <table class="border-collapse bg-white text-left w-full">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-4  text-gray-900 whitespace-nowrap">ログインID</th>
          <th class="px-6 py-4  text-gray-900 whitespace-nowrap">パスワード</th>
          <th class="px-6 py-4  text-gray-900 whitespace-nowrap text-center">操作</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100 border-t border-gray-100">
        <tr class="hover:bg-gray-200">
          <td x-show="!editing" x-text="user.login_id" class="px-6 py-4  text-gray-900"></td>
          <td x-show="!editing" x-text="user.password" class="px-6 py-4  text-gray-900"></td>            
          <td x-show="editing" class="px-6 py-4  text-gray-900">
            <input type="text" x-model="user.login_id" class="rounded-lg border border-indigo-500">
          </td>
          <td x-show="editing" class="px-6 py-4  text-gray-900">
            <input type="text" x-model="user.password" class="rounded-lg border border-indigo-500">
          </td>
          <td class="flex px-6 py-4 justify-center">
            <div x-show="saving">
              保存中...
            </div>
            <div x-show="!saving">
              <button x-show="!editing" @click="editUser(user)" class="flex items-center py-2 px-4 mr-1 rounded text-white bg-gradient-to-tr bg-indigo-500 hover:bg-indigo-600">
                <span class="material-icons">edit</span>
              </button>
              <div class="flex">
                <button x-show="editing" @click="saveUser(user)" class="flex items-center py-2 px-4 mr-1 rounded text-white bg-gradient-to-tr bg-indigo-500 hover:bg-indigo-600">
                  <span class="material-icons">save</span>
                </button>
                <button x-show="editing" @click="cancelEdit(user)" class="flex items-center py-2 px-4 ml-1 rounded text-white bg-gradient-to-tr bg-red-500 hover:bg-red-600">
                  <span class="material-icons">close</span>
                </button>                    
              </div>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<script>
function initData(){
  return {
    user:[],
    loading:true,
    saving:false,
    editing:false,
    fetchData:fetchData,
    editUser:editUser,
    saveUser:saveUser,
    cancelEdit:cancelEdit,
  }
}

async function fetchData() {
  let url = '<?=base_url();?>admin/user/getUser';
  let response = await fetch(url);
  let data = await response.json();
  this.user = data;
  this.loading = false;
}

async function saveUser(user){
  let login_id = user.login_id.trim();
  let password = user.password.trim();
  if(login_id === '' || password === ''){
    swalError('未入力の箇所があります');
  }
  this.saving = true;
  let url = '<?=base_url();?>admin/user/update';
  let data = {
    login_id: login_id,
    password: password,
  }
  let formData = createFormData(data);
  let response = await fetch(url, {
      method: 'POST',
      body: formData,
  });
  let resData = await response.json();
  if(resData.status = 200){
    this.saving = false;
    this.editing = false;
    swalSuccess('更新しました');
  }
  else{
    console.error(resData);
  }

}

function editUser(user){
  this.editing = true;
  user.original = JSON.parse(JSON.stringify(user));
}


function cancelEdit(user){
  Object.assign(user, user.original);
  this.editing = false;  
}

</script>