<div x-data="initData()" class="w-full my-5 ">
  <div x-show="loading" class="flex justify-center">
    <img src="<?=base_url();?>images/loading.gif">
  </div>
  <div x-show="!loading">
    <div class="flex justify-between items-center border border-[#e4e4e4] bg-white rounded-xl mx-5 mb-5 p-5">
      <!-- サービス・カテゴリ絞り込み、ワード検索 -->
      <div class="flex">
        <select x-model="filter.search.service_id" class="rounded border border-indigo-500 mr-2">
          <option value="">サービス名未選択</option>
          <template x-for="service in table.services">
            <option x-bind:value="service.id" x-text="service.service_name"></option>
          </template>
        </select>
        <select x-model="filter.search.category_id" class="rounded border border-indigo-500 mr-2">
          <option value="">カテゴリ名未選択</option>
          <template x-for="category in table.categories">
            <option x-bind:value="category.id" x-text="category.category_name"></option>
          </template>
        </select>
        <input x-model="filter.search.word" type="text" placeholder="検索ワード" class="rounded border border-indigo-500 mr-2">
        <button @click="search()" class="flex items-center py-2 px-4 rounded text-white bg-gradient-to-tr bg-indigo-500 hover:bg-indigo-600">
          <span class="material-icons">search</span>
        </button>
      </div>
      <div class="flex">
        <label for="count">表示件数：</label>
        <select @change="changeFilterCount()" id="count" class="rounded border border-indigo-500">
          <template x-for="count in filter.count.list">
            <option x-bind:value="count" x-text="count"></option>
          </template>
        </select>
      </div>
    </div>
    <div class="flex justify-end mx-5 mb-5">
      <button @click="addModal=true" class="flex items-center p-3 rounded border text-white bg-gradient-to-tr bg-blue-500 hover:bg-blue-600">
        <span class="material-icons">add</span>
      </button>
    </div>
    <div class="mousedragscrollable  overflow-auto  max-h-screen relative rounded border border-gray-200 shadow-md mx-5 mb-5">
      <table class="table-auto border-collapse bg-white text-left w-full">
        <thead class="bg-gray-50 sticky top-0 z-10">
          <tr>
            <th scope="col" class="px-6 py-4  text-gray-900 whitespace-nowrap">サービス名</th>
            <th scope="col" class="px-6 py-4  text-gray-900 whitespace-nowrap">カテゴリー名</th>
            <th scope="col" class="px-6 py-4  text-gray-900 whitespace-nowrap">URL</th>
            <th scope="col" class="px-6 py-4  text-gray-900 whitespace-nowrap">ログインID</th>
            <th scope="col" class="px-6 py-4  text-gray-900 whitespace-nowrap">パスワード</th>
            <th scope="col" class="px-6 py-4  text-gray-900 whitespace-nowrap">登録アドレス</th>
            <th scope="col" class="px-6 py-4  text-gray-900 whitespace-nowrap">備考</th>
            <th scope="col" class="px-6 py-4  text-gray-900 text-center bg-indigo-200 sticky right-0">操作</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 border-t border-gray-100">
          <template x-for="account in table.pageAccounts" >
            <tr class="hover:bg-gray-200 whitespace-nowrap">
              <td class="px-6 py-4  text-gray-900 " x-text="account.service_name" x-show="!account.editing"></td>
              <td class="px-6 py-4  text-gray-900 " x-text="account.category_name" x-show="!account.editing"></td>
              <td class="px-6 py-4  text-gray-900 " x-text="account.url" x-show="!account.editing"></td>
              <td class="px-6 py-4  text-gray-900 " x-text="account.login_id" x-show="!account.editing"></td>
              <td class="px-6 py-4  text-gray-900 " x-text="account.password" x-show="!account.editing"></td>
              <td class="px-6 py-4  text-gray-900 " x-text="account.email" x-show="!account.editing"></td>
              <td class="px-6 py-4  text-gray-900 " x-html="account.description.replace(/\n/g, '<br>')" x-show="!account.editing"></td>
              <td x-show="account.editing" class="px-6 py-4  text-gray-900">
                <select x-model="account.service_id" class="rounded border border-indigo-500">
                  <option value="">未選択</option>
                  <template x-for="service in table.services">
                    <option x-bind:value="service.id" x-text="service.service_name" x-bind:selected="service.id == account.service_id"></option>
                  </template>
                </select>
              </td> 
              <td x-show="account.editing" class="px-6 py-4  text-gray-900">
                <select x-model="account.category_id" class="rounded border border-indigo-500">
                  <option value="">未選択</option>
                  <template x-for="category in table.categories">
                    <option x-bind:value="category_id" x-text="category.category_name" x-bind:selected="category.id == account.category_id"></option>
                  </template>
                </select>
              </td>
              <td x-show="account.editing" class="px-6 py-4  text-gray-900">
                <input type="text" x-model="account.url" class="rounded border border-indigo-500">
              </td>
              <td x-show="account.editing" class="px-6 py-4  text-gray-900">
                <input type="text" x-model="account.login_id" class="rounded border border-indigo-500">
              </td>
              <td x-show="account.editing" class="px-6 py-4  text-gray-900">
                <input type="text" x-model="account.password" class="rounded border border-indigo-500">
              </td>
              <td x-show="account.editing" class="px-6 py-4  text-gray-900">
                <input type="text" x-model="account.email" class="rounded border border-indigo-500">
              </td>
              <td x-show="account.editing" class="px-6 py-4  text-gray-900">
                <textarea type="text" x-model="account.description" cols="32" rows="8" class="rounded border border-indigo-500"></textarea>
              </td>
              <td class="px-6 py-4  sticky right-0 bg-indigo-200">
                <div x-show="account.saving">
                  保存中...
                </div>
                <div x-show="account.removing">
                  削除中...
                </div>
                <div x-show="!account.saving && !account.removing">
                  <div class="flex">
                    <button x-show="!account.editing" @click="editAccount(account)" class="flex items-center py-2 px-4 mr-1 rounded text-white bg-gradient-to-tr bg-indigo-500 hover:bg-indigo-600">
                      <span class="material-icons">edit</span>
                    </button>
                    <button x-show="!account.editing" @click="removeAccount(account)" class="flex items-center py-2 px-4 ml-1 rounded text-white bg-gradient-to-tr bg-red-500 hover:bg-red-600">
                      <span class="material-icons">delete</span>
                    </button>
                  </div>
                  <div class="flex">
                    <button x-show="account.editing" @click="saveAccount(account)" class="flex items-center py-2 px-4 mr-1 rounded text-white bg-gradient-to-tr bg-indigo-500 hover:bg-indigo-600">
                      <span class="material-icons">save</span>
                    </button>
                    <button x-show="account.editing" @click="cancelEdit(account)" class="flex items-center py-2 px-4 ml-1 rounded text-white bg-gradient-to-tr bg-red-500 hover:bg-red-600">
                      <span class="material-icons">close</span>
                    </button>
                  </div>
                </div>
              </td>
            </tr>
          </template>
        </tbody>
      </table>
    </div>
    <div class="flex justify-center border border-[#e4e4e4] bg-white  rounded-xl mx-5 p-4">
      <ul class="flex items-center -mx-[6px]">
          <li class="px-[6px]">
            <a @click="changePage(page.selected-1)" class=" w-9 h-9 flex items-center justify-center rounded-md border border-[#EDEFF1] text-[#838995] text-base hover:border-indigo-500">
              前
            </a>
          </li>
          <template x-for="(value,index) in Array.from({length: countPages()})">
            <li class="px-[6px] ">
              <a x-text="index+1" @click="changePage(index+1)" x-bind:class="{ 'border-indigo-500': page.selected == index+1}" 
              class=" w-9 h-9 flex items-center justify-center rounded-md border border-[#EDEFF1] text-[#838995] text-base  hover:border-indigo-500"></a>
            </li>          
          </template>
          <li class="px-[6px]">
            <a @click="changePage(page.selected+1)" class=" w-9 h-9 flex items-center justify-center rounded-md border border-[#EDEFF1] text-[#838995] text-base hover:border-indigo-500">
              次
            </a>
          </li>
      </ul>
    </div>
    <div x-show="addModal">
      <?=$this->include('account/modal');?>
    </div>
  </div>
</div>
<script>


  function initData(){
    let countFilters = [10,20,30]; 
    return {
      filter:{
        count:{
          list: countFilters,
          selected: countFilters[0],
        },
        search:{
          word:'',
          category_id:0,
          service_id:0,
        }
      },
      table:{
        accounts: [],
        categories: [],
        services:[],
        pageAccounts: [],
        empty: false,
      },
      page:{
        count: 0,
        selected: 1,
      },
      loading: true,
      addModal:false,
      fetchAccounts: fetchAccounts,
      fetchCategories: fetchCategories,
      fetchServices: fetchServices,
      splitAccounts: splitAccounts,
      saveAccount: saveAccount,
      removeAccount: removeAccount,
      countPages: countPages,
      changePage: changePage,
      changeFilterCount: changeFilterCount,
      search: search,
      init:async function(){
        this.$watch('page.selected', () => this.splitAccounts());
        this.$watch('page.count', () => this.splitAccounts());
        this.$watch('filter.count.selected', () => this.splitAccounts());
        this.$watch('table.accounts', () => this.splitAccounts());
        await Promise.all([
          this.fetchAccounts(),
          this.fetchCategories(),
          this.fetchServices(),
        ]);
        this.loading = false;
        }
    };
  }

  //表示件数からページ数をカウント
  function countPages(){
    let count = this.filter.count.selected;
    let length = this.table.accounts.length;
    this.page.count = Math.ceil(length / count);
    return this.page.count;
  }

  async function fetchAccounts(){
    let url = '<?=base_url();?>admin/account/getAll';
    let response = await fetch(url);
    let data = await response.json();
    this.table.accounts = data;
  }
 
  async function fetchCategories(){
    let url = '<?=base_url();?>admin/category/getAll';
    let response = await fetch(url);
    let data = await response.json();
    this.table.categories = data;
  } 

  async function fetchServices(){
    let url = '<?=base_url();?>admin/service/getAll';
    let response = await fetch(url);
    let data = await response.json();
    this.table.services = data;
  }

  //accountsを件数とページに合わせて分割
  function splitAccounts(){
    let accounts = this.table.accounts;
    let length = accounts.length;
    let count = this.filter.count.selected;
    let page = this.page.selected;
    let start = (page-1) * count;
    let end = start + count;
    //最終ページの場合
    if(length - start < count){
      this.table.pageAccounts = accounts.slice(start);
    }
    this.table.pageAccounts = accounts.slice(start,end);
  }

  //表示件数変更
  function changeFilterCount(){
    this.filter.count.selected = Number(event.target.value);
    this.page.selected = 1;//ページ初期化
  }
  //ページ変更
  function changePage(page){
    let count = this.page.count;
    if(page < 1 || count < page) return;
    this.page.selected = page;
  }
  
  async function saveAccount(account) {
    account.saving = true;
    let url = '<?=base_url();?>admin/account/update';
    account.service_id = Number(account.service_id);
    account.category_id = Number(account.category_id);

    let formData = createFormData(account);
    let response = await fetch(url, {
      method: 'POST',
      body: formData,
    });
    let resData = await response.json();
    if(resData.status == 200){
      account.saving = false;
      account.editing = false;
      account.service_name = getServiceName(account.service_id, this.table.services);
      account.category_name = getCategoryName(account.category_id, this.table.categories);
      swalSuccess('更新しました');
    }
    else{
      console.error(resData);
    }
  }

  async function removeAccount(account){
    if(!(await swalConfirm('このデータを削除しますか？'))){
      return;
    }
    account.removing = true;
    let url = '<?=base_url();?>admin/account/remove';
    let data = {
      id:account.id
    }
    let formData = createFormData(data);
    let response = await fetch(url, {
      method: 'POST',
      body: formData,
    });
    let resData = await response.json();
    if(resData.status == 200){
      account.removing = false;
      //削除したアカウントの行を削除
      this.table.accounts = this.table.accounts.filter(item => item.id != account.id);
      swalSuccess('削除しました');
    }
    else{
      console.error(resData);
    }

  }

  function editAccount(account){
    account.editing = true;
    account.original = JSON.parse(JSON.stringify(account));
  }
  
  function cancelEdit(account) {
    Object.assign(account, account.original);
    account.editing = false;
  }

  async function search(){
    let data = {
      word: this.filter.search.word.trim(),
      category_id: Number(this.filter.search.category_id),
      service_id: Number(this.filter.search.service_id),
    }
    let url = '<?=base_url();?>admin/account/search';
    let formData = createFormData(data);
    let response = await fetch(url, {
      method: 'POST',
      body: formData,
    });
    let resData = await response.json();
    this.table.accounts = resData;
  }

  window.addEventListener('DOMContentLoaded', function(){
    mousedragscrollable('.mousedragscrollable');
  });  
</script>