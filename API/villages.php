<?php
// include_once('../config/db_connect2.php');
include('./checkToken.php');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization, X-APP-VERSION, X-APP-VERSION, X-DEVELOPMENT-VERSION");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
$method = $_SERVER['REQUEST_METHOD'];
if ($method == "OPTIONS") {
    die();
}


$request_method = $_SERVER["REQUEST_METHOD"];
if($request_method == "POST"){
    checkToken(function($con,$data){  // this function check token exist or not
    if(isset($data['ward_id'])){
        $slr = 0;
        $wardid = $data['ward_id'];
        $sql_query = mysqli_query($con, "select * from village_master where ward_id=$wardid");
        while ($res = mysqli_fetch_array($sql_query)) {

            $id = $res['id'];
            $wardid = $res['ward_id'];
            $villagename = $res['village_name'];


            $data['id'] = $id;
            $data['wardid'] = $wardid;
            $data['vname'] = $villagename;


            $allusers[$slr] = $data;

            $slr++;
        }



        if ($sql_query) {

            $response['village_master'] = $allusers;
            $response['status'] = 'success';
            $response['msg'] = "Data Found";
            header('HTTP/1.1 200 OK');
        } else {
            $response['status'] = 'error';
            $response['msg'] = "Try again";
            header('HTTP/1.0 404 Not Found');
        }

    }else{
        $response['status'] = 'error';
        $response['msg'] = "Try again";
        header('HTTP/1.0 404 Not Found');
    }
    return $response;
});
}else{
    $response['status'] = 'error';
    $response['msg'] = "Invalid request method. Please use POST method.";
    header('HTTP/1.0 405 Method Not Allowed');
    return $response;
}


// echo json_encode($response);
