<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\AccountModel;

class Account extends BaseController
{
  protected $model;
  protected $encrypter;
  public function __construct()
  {
    $this->model = new AccountModel();
    $this->encrypter = \Config\Services::encrypter();
  }

  public function index()
  {
    echo view('inc/header');
    echo view('account/index');
    echo view('inc/footer');
  }
 
  public function getAll()
  {
    $accounts = $this->model->getAll();
    foreach($accounts as $key => $account){
      $decrypted_pass = $this->encrypter->decrypt(hex2bin($account['password']));
      $accounts[$key]['password'] = $decrypted_pass;
    }
    return $this->response->setJSON($accounts);
  }


  public function remove()
  {
    $id = $this->request->getPost('id');
    $result = $this->model->removeAccount($id);
    if($result){
      $response = [
        'status' => 200,
        'message' => 'removed'
      ];
    }
    else{
      $response = [
        'status' => 500,
        'message' => 'Database error'
      ];
    }
    return $this->response->setJSON($response);
  }


  public function create()
  {
    $pass = $this->request->getPost('password');
    $encrypted_pass = bin2hex($this->encrypter->encrypt($pass));
    $data = [
      'service_id'    => $this->request->getPost('service_id'),
      'category_id'   => $this->request->getPost('category_id'),
      'url'           => $this->request->getPost('url'),
      'login_id'      => $this->request->getPost('login_id'),
      'password'      => $encrypted_pass,
      'email'       => $this->request->getPost('email'),
      'description'   => $this->request->getPost('description'),
    ];
    $result = $this->model->builder()->insert($data);
    if($result){
      $response = [
        'insert_id' => $this->model->insertID(),
        'status' => 200,
        'message' => 'created'
      ];
    }
    else{
      $response = [
        'status' => 500,
        'message' => 'Database error'
      ];
    }
    return $this->response->setJSON($response);
  }

  public function update()
  {
    $pass = $this->request->getPost('password');
    $encrypted_pass = bin2hex($this->encrypter->encrypt($pass));
    $id = $this->request->getPost('id');
    $data = [
      'service_id'    => $this->request->getPost('service_id'),
      'category_id'   => $this->request->getPost('category_id'),
      'url'           => $this->request->getPost('url'),
      'login_id'      => $this->request->getPost('login_id'),
      'password'      => $encrypted_pass,
      'email'         => $this->request->getPost('email'),
      'description'   => $this->request->getPost('description'),
    ];
    $result = $this->model->updateAccount($id, $data);
    if($result){
      $response = [
        'status' => 200,
        'message' => 'updated'
      ];
    }
    else{
      $response = [
        'status' => 500,
        'message' => 'Database error'
      ];
    }
    return $this->response->setJSON($response);
  }

  public function search(){
    $search = [
      'word' => $this->request->getPost('word'),
      'service_id' => $this->request->getPost('service_id'),
      'category_id' => $this->request->getPost('category_id'),
    ];
    $accounts = $this->model->search($search);
    foreach($accounts as $key => $account){
      $decrypted_pass = $this->encrypter->decrypt(hex2bin($account['password']));
      $accounts[$key]['password'] = $decrypted_pass;
    }
    return $this->response->setJSON($accounts);
  }
}