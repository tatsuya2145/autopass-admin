<?php
namespace App\Controllers;
use App\Models\UserModel;


class Auth extends BaseController
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

  public function login()
  {
    $data = [
      'login_error' => ''
    ];
    if($this->request->getPost()){
      $login_id = $this->request->getPost('login_id');
      $password = $this->request->getPost('password');
      $user = $this->model->getUser($login_id);
      if($user){
        $decrypted_pass = $this->encrypter->decrypt(hex2bin($user['password']));
        if($password === $decrypted_pass){
          $this->session->set('isLoggedIn',true);
          $this->session->set('login_id',$login_id);
          return redirect()->to('admin/account');
        }
      }  
      $data['login_error'] = 'Login failed';
    }
    echo view('login',$data);
    echo view('inc/footer');
  }

  public function logout()
  {
    $this->session->destroy();
    return redirect()->to('auth/login');
  }

}