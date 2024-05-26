<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\CategoryModel;

class Category extends BaseController
{
  protected $model;

  public function __construct()
  {
    $this->model = new CategoryModel();
  }

  public function index()
  {
    echo view('inc/header');
    echo view('category');
    echo view('inc/footer');
  }

  public function getAll()
  {
    $categories = $this->model->findAll();
    return $this->response->setJSON($categories);
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
      'id' => $this->request->getPost('id'),
      'category_name' => $this->request->getPost('category_name')
    ];
    $result = $this->model->updateCategory($data);
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
      'category_name' => $this->request->getPost('category_name')
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