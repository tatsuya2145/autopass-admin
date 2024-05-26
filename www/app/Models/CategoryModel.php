<?php
namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
  protected $table      = 'categories';
  protected $primaryKey = 'id';

  protected $returnType = 'array';
  protected $useSoftDeletes = false;

  protected $allowedFields = [];

  protected $useTimestamps = false;
  // protected $createdField  = 'created_at';
  // protected $updatedField  = 'updated_at';
  // protected $deletedField  = 'deleted_at';

  protected $validationRules    = [];
  protected $validationMessages = [];
  protected $skipValidation     = false;


    /**
   * @param $data
   * [
   *  $id : int,
   *  $category_name : string
   * ]
   * @return bool
   */
  function updateCategory($data){
    $id = $data['id'];
    $result = $this->builder()
                    ->where('id', $id)
                    ->update($data);
    return $result;
  }

}