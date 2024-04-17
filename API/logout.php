<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization, X-APP-VERSION, X-APP-VERSION, X-DEVELOPMENT-VERSION");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

include_once('../config/db_connect2.php');



if($_SERVER['REQUEST_METHOD']=='POST'){
    $id = $_POST['id'];
     $q = "update user_access_time set token = 'ended' where id = $id";
    $is_update = mysqli_query($con,$q);
 
    if(mysqli_affected_rows($con) == 1 ){ 
            $response['status'] = 'success';
            $response['msg'] = 'logout  successfully';
            header('HTTP/1.1 200 OK');
    }
    else{
        $response['status'] = 'fail';
        $response['msg'] = "logout fail";
        header('HTTP/1.0 404 Not Found');
    }
    echo json_encode($response);
    mysqli_close($con);      
}



?>