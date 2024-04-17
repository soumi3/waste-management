<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization, X-APP-VERSION, X-APP-VERSION, X-DEVELOPMENT-VERSION");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");


if($_SERVER['REQUEST_METHOD']=='POST'){
   function checkToken($checkTokenFunction){
       // import all necssary file
        require('Token.php');
        include_once('../config/db_connect2.php');

        $json = file_get_contents('php://input');
        $data = json_decode($json,true); // Decoding JSON to associative array
       // print_r($data);
         $token = $data['token'];       // token
       
                    $token_data = Token::Verify($token,'KEY');
                        if(isset($token_data['name'])){
                            
                            $response ['data'] =  $checkTokenFunction($con,$data,$token_data['id']);
                            $response['status'] = 'success';
                            $response["message"] = "token  valid";                          
                        }else{
                            $response["message"] = "token invalid";
                            $response['status'] = 'fail';
                            header('HTTP/1.0 404 Not Found');
                         }
         echo json_encode($response);
    }
    
} 

//  include('./checkToken.php');
//  checkToken(function($con,$data){  // this function check token exist or not
//      $response['data1']='pp';
//      $response['data2']='data2';
 
//      return $response;
//  });
 
// id = 6 if check


?>