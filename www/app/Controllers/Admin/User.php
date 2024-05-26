<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\UserModel;


class User extends BaseController
{
  protected $model;
  protected $encrypter;
  protected $session;

  public function __construct()
  {
    $this->model = new UserModel();
    $this->encrypter = \Config\Services::encrypter();
    $this->session = \Config\Services::session();
  }

  public function index()
  {
    echo view('inc/header');
    echo view('user');
    echo view('inc/footer');

  }

  public function getUser()
  {
    $login_id = $this->session->get('login_id');
    $user = $this->model->getUser($login_id);
    $decrypted_pass = $this->encrypter->decrypt(hex2bin($user['password']));
    $response = [
      'login_id' => $user['login_id'],
      'password' => $decrypted_pass,
    ];
    return $this->response->setJSON($response);
  }

  public function update()
  {
    $login_id = $this->request->getPost('login_id');
    $password = $this->request->getPost('password');

    $encrypted_pass = bin2hex($this->encrypter->encrypt($password));
    $data = [
      'login_id' => $login_id,
      'password' => $encrypted_pass,
    ];

    $result = $this->model->updateUser($data);
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
}