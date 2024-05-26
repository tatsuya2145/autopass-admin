<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?=base_url();?>css/output.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.8/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<title>AutoPassAdmin</title>
</head>
<body>
<header>
  <nav>
    <div class="flex justify-between items-center py-3 px-6 container mx-auto">
      <div>
        <h1 class="text-2xl font-bold bg-gradient-to-tr from-indigo-500 to-green-500 bg-clip-text text-transparent">AutoPass</h1>
      </div>
      <div class="flex">
        <div class="md:flex items-center space-x-4 ml-8 lg:ml-12">
          <a href="/auth/logout" class="py-2 px-4 rounded text-white bg-gradient-to-tr from-indigo-500 to-green-500">ログアウト</a>
        </div>
      </div>
    </div>
  </nav>
</header>
<div class="bg-gray-100 sm:grid grid-cols-8 px-4 py-6 sm:gap-4 min-h-screen relative">
  <!-- navbar -->
  <div class="col-span-1">
    <div class="bg-white  rounded-md">
      <div class="bg-white rounded-md list-none  text-center ">
        <li class="py-3 border-b-2 "><a href="/admin/account" class="list-none hover:text-indigo-500">アカウント一覧</a></li>
        <li class="py-3 border-b-2 "><a href="/admin/service" class="list-none hover:text-indigo-500">サービス名一覧</a></li>
        <li class="py-3 border-b-2 "><a href="/admin/category" class="list-none hover:text-indigo-500">カテゴリー名一覧</a></li>
        <li class="py-3 border-b-2"><a href="/admin/user" class="list-none  hover:text-indigo-500">ユーザー設定</a></li>
      </div>
    </div>
  </div>
  <!-- endnavbar -->
  <!-- メイン画面 -->
  <div class="col-span-7 bg-gradient-to-tr bg-indigo-500 rounded-md flex justify-center">

  
