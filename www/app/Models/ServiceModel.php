<?php
namespace App\Models;

use CodeIgniter\Model;

class ServiceModel extends Model
{
  protected $table      = 'services';
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
   *  $service_name : string
   * ]
   * @return bool
   */
  function updateService($data){
    $id = $data['id'];
    $result = $this->builder()
                    ->where('id', $id)
                    ->update($data);
    return $result;
  }


}