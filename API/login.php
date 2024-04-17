<?php
include('Token.php');
// $con = mysqli_connect('localhost','wasteebs','wNw~7f617');
// mysqli_select_db($con,'ebluesys_waste'); 
include_once('../config/db_connect2.php');
//   if($con){
//     echo "connected";
//   }else {
//     echo "not connect";
//   }

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization, X-APP-VERSION, X-APP-VERSION, X-DEVELOPMENT-VERSION");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
//$method = $_SERVER['REQUEST_METHOD'];
// if ($method == "OPTIONS") {
//     die();
// }


function  get_client_ip() {
   $ipaddress = '';
   if (getenv('HTTP_CLIENT_IP'))
       $ipaddress = getenv('HTTP_CLIENT_IP');
   else if(getenv('HTTP_X_FORWARDED_FOR'))
       $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
   else if(getenv('HTTP_X_FORWARDED'))
       $ipaddress = getenv('HTTP_X_FORWARDED');
   else if(getenv('HTTP_FORWARDED_FOR'))
       $ipaddress = getenv('HTTP_FORWARDED_FOR');
   else if(getenv('HTTP_FORWARDED'))
      $ipaddress = getenv('HTTP_FORWARDED');
   else if(getenv('REMOTE_ADDR'))
       $ipaddress = getenv('REMOTE_ADDR');
   else
       $ipaddress = 'UNKNOWN';
   return $ipaddress;
}


 if($_SERVER['REQUEST_METHOD']=='POST'){
   
        // select database
       // mysqli_select_db($con,'ebluesys_waste'); 

        $user_pass =$_POST['user_pass']; 
        $user_name = $_POST['user_name'];

        $q = "select * from user where user_name = '$user_name'";
        $is_login = mysqli_query($con,$q);
        $user_info = mysqli_fetch_array($is_login);
           
       // print_r($user_info);
       if(mysqli_num_rows($is_login) > 0){ 
          if($user_info['user_pass'] == md5($user_pass)){

            //user_type_id and $user_id
             $user_type_id =$user_info['user_type_id'];
            $user_id = $user_info['id'];
  
            // user response query
           $q = "select * from 
                  user_pemission,district_master,municipalty_master,word_master,user_type where
                  user_pemission.user_id = $user_id && 
                  district_master.id = user_pemission.which_dist && 
                  municipalty_master.id = user_pemission.which_muni && 
                  word_master.id = user_pemission.which_word && 
                  user_type.id =$user_type_id";
         
           $user_pemission = mysqli_query($con,$q);
             if(mysqli_num_rows($user_pemission) > 0){
               // echo "all data fund";
               
                         // user pemission data
                        $user_pemission_info = mysqli_fetch_array($user_pemission);
               
                        // user pemission details
                        $token = Token::Sign(array("name"=>$user_info['user_name'],"user_contact"=>$user_info['user_contact'],"date"=>date("l jS \of F Y h:i:s A")),'KEY');
                        // $is_insert_token = mysqli_query($con,"update user_access_time set token = '$token' where user_id = $user_id"); 
                        $current_time = time();
                        $user_ip =get_client_ip();
                 
                        // insert data
                        $q = "insert into user_access_time (user_id,user_ip,access_time,token) 
                        values ($user_id,'$user_ip',$current_time,'$token')";
                        $is_insert_token = mysqli_query($con,$q); 

                        // get user access time id
                           $user_access_time_id=mysqli_insert_id($con);
                           
                        // user response 
                        $response = array("name"=>$user_info['user_name'],
                                          "user_contact"=>$user_info['user_contact'],
                                          "block"=>$user_pemission_info['muni_name'],
                                          "block_id"=>$user_pemission_info['id'],
                                          "gp"=>$user_pemission_info['word_name'],
                                          "gp_id"=>$user_pemission_info['id'],
                                          "district"=>$user_pemission_info['district_name'],
                                          "district_id"=>$user_pemission_info['id'],
                                          "user-type_name"=>$user_pemission_info['type_name'],
                                          "user-type_name_id"=>$user_pemission_info['id'],
                                          "user_access_time_id" =>$user_access_time_id

                                       );
               
               
                        $response['status'] = 'success';
                        $response['token'] = $token;
                        header('HTTP/1.1 200 OK');
               }else{
               $response["data_not_found_error"] = "some data not fund";
         
               }
           

          }else{
            $response['status'] = 'fail';
            $response['msg'] = "authentication fail";
            header('HTTP/1.0 404 Not Found');
          }
       }else{
            $response['status'] = 'fail';
            $response['msg'] = "authentication fail";        
            header('HTTP/1.0 404 Not Found');
       }

       echo json_encode($response);
           
    }
    mysqli_close($con);

    
    
?>
