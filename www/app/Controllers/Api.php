<?php

namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class Api extends ResourceController
{
  use ResponseTrait;
  protected $modelName = 'App\Models\AccountModel';
  protected $format = 'json';

  public function accounts()
  {
    $response = [];
    $url = $this->request->getPost('url');
    $accounts = $this->model->getAccounts($url);
    
    if(empty($accounts)){
      return $this->failNotFound('',404,'Not Accounts Found');
    }
    
    $encrypter = \Config\Services::encrypter();
    foreach($accounts as $key => $value){
      $decrypted_pass = $encrypter->decrypt(hex2bin($value['password']));
      $response[] = [
        'login_id' => $value['login_id'],
        'password' => $decrypted_pass,
        'description' => $value['description'],
      ];
    }
    return $this->respond($response);
  }

}
