<?php


$routes->post('/api/accounts', 'Api::accounts');

$routes->get('auth/login', 'Auth::login');
$routes->post('auth/login', 'Auth::login');
$routes->get('auth/logout', 'Auth::logout');

$routes->group('admin', function($routes) {
  $routes->get('user', 'Admin\User::index');
  $routes->get('user/getUser', 'Admin\User::getUser');
  $routes->post('user/update', 'Admin\User::update');  
  
  $routes->get('account', 'Admin\Account::index');
  $routes->get('account/getAll', 'Admin\Account::getAll');
  $routes->post('account/remove', 'Admin\Account::remove');
  $routes->post('account/create', 'Admin\Account::create');
  $routes->post('account/update', 'Admin\Account::update');
  $routes->post('account/search', 'Admin\Account::search');

  $routes->get('service', 'Admin\Service::index');
  $routes->get('service/getAll', 'Admin\Service::getAll');
  $routes->post('service/delete', 'Admin\Service::delete');
  $routes->post('service/create', 'Admin\Service::create');
  $routes->post('service/update', 'Admin\Service::update');

  $routes->get('category', 'Admin\Category::index');
  $routes->get('category/getAll', 'Admin\Category::getAll');
  $routes->post('category/delete', 'Admin\Category::delete');
  $routes->post('category/create', 'Admin\Category::create');
  $routes->post('category/update', 'Admin\Category::update');



});


