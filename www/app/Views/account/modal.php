<div x-data="initModalData()" class="fixed left-0 top-0 flex h-full w-full items-center justify-center bg-black bg-opacity-50  z-20">
    <div class="max-h-full w-full max-w-xl overflow-y-auto sm:rounded-2xl bg-white">
      <div class="m-5">
        <h1 class="text-2xl mb-5">アカウント追加</h1>
        <div class="border rounded mb-5 p-5">
          <div class="grid grid-cols-2 gap-4 mb-4">
            <div class="flex flex-col">
              <label for="service_id">サービス名</label>
              <select id="service_id" x-model="modal.account.service_id" class="rounded border border-indigo-500">
                <option value="">未選択</option>
                <template x-for="service in table.services">
                  <option x-bind:value="service.id" x-text="service.service_name"></option>
                </template>
              </select>
            </div>
            <div class="flex flex-col">
              <label for="category_id">
                カテゴリー名
              </label>
              <select id="category_id" x-model="modal.account.category_id" @change="modal.errors.category_id = false" class="rounded col-span-1 border border-indigo-500">
                <option value="">未選択</option>
                <template x-for="category in table.categories">
                  <option x-bind:value="category.id" x-text="category.category_name"></option>
                </template>
              </select>
            </div>
          </div>
          <div class="flex flex-col mb-4">
            <label for="url">
              URL
              <span class="text-red-500">*</span>
            </label>
            <input id="url" x-model="modal.account.url" @change="modal.errors.url = false"
            x-bind:class="{ 'border-2 border-red-500': modal.errors.url,'border border-indigo-500': !modal.errors.url }" type="text" placeholder="URL" class="rounded">
          </div>
          <div class="flex flex-col mb-4">
            <label for="login_id">
              ログインID
              <span class="text-red-500">*</span>
            </label>
            <input id="login_id" x-model="modal.account.login_id" @change="modal.errors.login_id = false"
            x-bind:class="{ 'border-2 border-red-500': modal.errors.login_id,'border border-indigo-500': !modal.errors.login_id }" type="text" placeholder="ログインID" class="rounded">
          </div>
          <div class="flex flex-col mb-4">
            <label for="password">
              パスワード
              <span class="text-red-500">*</span>
            </label>
            <input id="password" x-model="modal.account.password" @change="modal.errors.password = false"
            x-bind:class="{ 'border-2 border-red-500': modal.errors.password,'border border-indigo-500': !modal.errors.password }" type="password" placeholder="パスワード" class="rounded">
          </div>
          <div class="flex flex-col mb-4">
            <label for="email">登録アドレス</label>
            <input id="email" x-model="modal.account.email" type="email" placeholder="Email" class="rounded border border-indigo-500">
          </div>
          <div class="flex flex-col">
            <label for="description">備考</label>
            <textarea id="description" x-model="modal.account.description" placeholder="備考" class="rounded border border-indigo-500"></textarea>
          </div>
        </div>
        <div>
          <div x-show="modal.adding" class="text-center">
            追加中...
          </div>
          <div x-show="!modal.adding" class="flex">
            <button x-bind="addAccount" class="p-3 mr-1 bg-indigo-500 hover:bg-indigo-600 rounded text-white w-full ">追加</button>
            <button x-bind="reset" class="p-3 ml-1 bg-white hover:border-indigo-500 border rounded w-full ">キャンセル</button>            
          </div>
        </div>
      </div>
    </div>
  </div>

<script>
  document.addEventListener('alpine:init',() => {

    Alpine.bind('addAccount',()=> ({
      type: 'button',
      '@click':async function(){
        if(this.isRequiredEmpty()){
          this.modal.error = true;
          return;
        }
        this.modal.adding = true;
        this.modal.error = false;
        let account = this.modal.account; 
        let response = await this.addAccount(account);
        if(response.status == 200){
          let services = this.$data.table.services;
          let categories = this.$data.table.categories;
          account.service_name = getServiceName(account.service_id,services);
          account.category_name = getCategoryName(account.category_id,categories);
          this.$data.table.accounts.push(account);
          this.reset();
          this.$data.addModal = false;
          this.modal.addinfg = false;
          swalSuccess('追加しました');
        }
        else{
          console.error(response);
        }
      }
    }));

    Alpine.bind('reset',()=> ({
      type: 'button',
      '@click':function(){
        this.reset();
        this.$data.addModal = false;
      }
    }));


  });

  function initModalData(){
    return {
      modal:{
        account: {
          service_id:0,
          category_id:0,
          url:'',
          login_id:'',
          password:'',
          email:'',
          description:'',
        },
        error:false,
        errors:{
          url:false,
          login_id:false,
          password:false,
        },      
      },
      adding:false,
      addAccount:addAccount,
      isRequiredEmpty:isRequiredEmpty,
      reset:reset,
    }
  }  

  function isRequiredEmpty(){
    let error = false;
    let requires = {
      url: '',
      login_id: '',
      password: '',
    }
    for(let key in requires){
      if(this.modal.account[key] == requires[key]){
        error = true;
        this.modal.errors[key] = true;
      }
    }
    return error;
  }

  async function addAccount(account) {
    let url = '<?=base_url();?>admin/account/create';
    let formData = createFormData(account);
    let response = await fetch(url,{
      method: 'POST',
      body: formData,
    });
    let resData = await response.json();
    return resData;
  }  

  function reset(){
    Object.assign(this,initModalData());
  }


</script>