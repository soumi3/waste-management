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
    if (isset($data['wardId'])) {
        $id = $data['id'];
        $wardId = $data['wardId'];

        $sqlget_muniid = mysqli_fetch_array(mysqli_query($con, "select municipalty from word_master where id=$wardId"));
        $muniid = $sqlget_muniid['municipalty'];
        $locality = $data['localityId'];
        $reg_no = $data['regNumber'];
        $name_livestockshed = $data['nameOfLivestock'];
        $lat = $data['lat'];
        $long = $data['long'];
        $ownerName = $data['ownerName'];
        $cn_no = $data['contactNumber'];
        $livestock_type = $data['typeOflivestock'];
        $no_livestock = $data['noOflivestock'];
        $waste_wt = $data['wtOfwaste'];
        $userid = 0;

        $update_query = mysqli_query($con, "update live_stock_shed set municipality_id='$muniid',ward='$wardId',locality='$locality',user_id='$userid',regester_no='$reg_no',name_of_live_shed='$name_livestockshed',latitude='$lat',longitude='$long',name_of_owner='$ownerName',contact_number='$cn_no',livestock_type='$livestock_type',no_of_livestock='$no_livestock',compostable_waste='$waste_wt' where id=$id");

        if ($update_query) {

            $response['status'] = 'success';
            $response['msg'] = "Update Suceesfully";
            header('HTTP/1.1 200 OK');
        } else {
            $response['status'] = 'error';
            $response['msg'] = "Try again";
            header('HTTP/1.0 404 Not Found');
        }
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
