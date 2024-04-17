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

        $sqlget_muniid = mysqli_fetch_array(mysqli_query($con, "select municipalty,dist from word_master where id=$wardId"));

        $muniid = $sqlget_muniid['municipalty'];
        $distId = $sqlget_muniid['dist'];
        $locality = $data['localityId'];
        $mohollaId = $data['mohallaId'];
        $waste_collect = $data['wasteCollector'];
        $recylableSold = $data['recylableSold'];
        $plasticSold = $data['plasticSold'];
        $incomeRecylable = $data['incomeofRecylable'];
        
        $soldManure = $data['saleOfManure'];
        $crateDate = $data['create_date'];


        $update_query = mysqli_query($con, "update income set municipality_id='$muniid',district_id='$distId',ward_id='$wardId',locality_id='$locality',mohalla_id='$mohollaId',waste_collector='$waste_collect',recylable_sold='$recylableSold',plastic_sold='$plasticSold',income_of_recylable='$incomeRecylable',sale_of_manure='$soldManure',create_date='$crateDate' where id=$id");


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
