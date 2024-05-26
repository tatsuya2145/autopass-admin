<?php
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
  protected $table      = 'users';
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
   * @param string $login_id
   * @return array|bool 配列でのユーザデータ or データが無い場合はfalse
   */
  function getUser($login_id){
    return $this->where('login_id',$login_id)->first();
  }

    /**
   * @param $data
   * [
   *  $login_id : string,
   *  $password : string (encripted)
   * ]
   * @return bool
   */

  function updateUser($data){
    $login_id = $data['login_id'];
    $result = $this->builder()
                    ->where('login_id', $login_id)
                    ->update($data);
    return $result;
  }

}