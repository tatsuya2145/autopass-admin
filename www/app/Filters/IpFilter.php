<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

//IPアドレスでアクセス制限をかける
class IpFilter implements FilterInterface
{
  public function before(RequestInterface $request,$arguments = null)
  {
    if($_ENV['CI_ENVIRONMENT']==='development'){
      $allowed_ip = $_ENV['custom.developmentIP'];
    }
    if($_ENV['CI_ENVIRONMENT']==='production'){
      $allowed_ip = $_ENV['custom.productionIP'];
    }
    
    $request_ip = $request->getIPAddress();
    
    if($allowed_ip!=$request_ip){
      $response = \Config\Services::response();
      $response->setStatusCode(403,'Access Denied');
      return $response;
    }
  }

  //--------------------------------------------------------------------

  public function after(RequestInterface $request, ResponseInterface $response,$arguments = null)
  {
      
  }
}