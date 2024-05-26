<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\ServiceModel;

class Service extends BaseController
{
  protected $model;

  public function __construct()
  {
    $this->model = new ServiceModel();
  }

  public function index()
  {
    echo view('inc/header');
    echo view('service');
    echo view('inc/footer');
  }

  public function getAll()
  {
    $services = $this->model->findAll();
    return $this->response->setJSON($services);
  }

  public function delete()
  {
    $id = $this->request->getPost('id');
    $result = $this->model->delete($id);
    if($result){
      $response = [
        'status' => 200,
        'message' => 'deleted'
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
    $data = [
      'id' => $id = $this->request->getPost('id'),
      'service_name' => $this->request->getPost('service_name')
    ];
    $result = $this->model->updateService($data);
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

  public function create()
  {
    $data = [
      'service_name' => $this->request->getPost('service_name')
    ];
    $result = $this->model->builder()->insert($data);
    
    if($result){
      $response = [
        'status' => 201,
        'message' => 'created',
        'insert_id' => $result
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