<?php
namespace App\Models;

use CodeIgniter\Model;

class AccountModel extends Model
{
  protected $table      = 'accounts';
  protected $primaryKey = 'id';

  protected $returnType = 'array';
  protected $useSoftDeletes = false;

  protected $allowedFields = [];

  protected $useTimestamps = false;
  protected $createdField  = 'created_at';
  protected $updatedField  = 'updated_at';
  // protected $deletedField  = 'deleted_at';

  protected $validationRules    = [];
  protected $validationMessages = [];
  protected $skipValidation     = false;

  /**
   * @param string $url 
   * 
   * @return array
   */
  function getAccounts($url){
    $data = $this->builder()
                  ->where('url',$url)
                  ->get()
                  ->getResultArray();
    return $data;
  }

  function getAll(){
    $data = $this->db->query(
    'SELECT accounts.*,categories.category_name,services.service_name 
      FROM accounts
      LEFT JOIN categories ON categories.id = accounts.category_id 
      LEFT JOIN services ON services.id = accounts.service_id 
      WHERE accounts.deleted = 0'      
      )
      ->getResultArray();
    return $data;
  }

  function updateAccount($id,$data){
    $result = $this->builder()
                   ->where("id", $id)
                   ->update($data);
    return $result;
  }

  function removeAccount($id){
    $data = [
      'deleted' => 1
    ];
    $result = $this->builder()
                   ->where("id", $id)
                   ->update($data);
    return $result;
  }

  /**
   * @param array $search
   * {
   *   'word' => string,
   *  'service_id' => int,
   * 'category_id' => int
   * }
   * @return array 
   */
  function search($search){
    $word = $search['word'];
    $service_id = $search['service_id'];
    $category_id = $search['category_id'];
    $sql = 'SELECT accounts.*,categories.category_name,services.service_name 
            FROM accounts
            INNER JOIN categories ON categories.id = accounts.category_id 
            LEFT JOIN services ON services.id = accounts.service_id 
            WHERE accounts.deleted = 0';      
    if($word != ''){
      $sql .= ' AND (
        accounts.url LIKE "%'.$word.'%" 
        OR accounts.login_id LIKE "%'.$word.'%" 
        OR accounts.email LIKE "%'.$word.'%" 
        OR accounts.description LIKE "%'.$word.'%")';
    }
    if($service_id != 0){
      $sql .= ' AND accounts.service_id = '.$service_id;
    }   
    if($category_id != 0){
      $sql .= ' AND accounts.category_id = '.$category_id;
    }
    $data = $this->db->query($sql)
                    ->getResultArray();
    return $data;
  }
}