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

if ($request_method == "POST") {
    checkToken(function($con,$data){  // this function check token exist or not
    $json = file_get_contents('php://input');
    $data = json_decode($json, true); // Decoding JSON to associative array


    $slr = 0;
    $sql_query = mysqli_query($con, "select * from processing_unit");
    while ($res = mysqli_fetch_array($sql_query)) {

        $id = $res['id'];
        $disId = $res['district_id'];
        $muniId = $res['municipality_id'];
        $wId = $res['ward_id'];
        $localityId = $res['locality_id'];
        $name = $res['Name'];

        $data['id'] = $id;
        $data['dId'] = $disId;
        $data['mId'] = $muniId;
        $data['wId'] = $wId;
        $data['locId'] = $localityId;
        $data['name'] = $name;


        $allusers[$slr] = $data;

        $slr++;
    }



    if ($sql_query) {

        $response['processUnit'] = $allusers;
        $response['status'] = 'success';
        $response['msg'] = "Data Found";
        header('HTTP/1.1 200 OK');
    } else {
        $response['status'] = 'error';
        $response['msg'] = "Try again";
        header('HTTP/1.0 404 Not Found');
    }
    return $response;
});
} else {
    $response['status'] = 'error';
    $response['msg'] = "Invalid request method. Please use POST method.";
    header('HTTP/1.0 405 Method Not Allowed');
    return $response;
}


// echo json_encode($response);
