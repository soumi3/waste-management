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
    checkToken(function($con,$data,$user_id){  // this function check token exist or not
    $json = file_get_contents('php://input');
    $data = json_decode($json, true); // Decoding JSON to associative array

    if (isset($data['wardId'])) {
        $wardid = $data['wardId'];

        $result = mysqli_query($con, "SELECT * FROM live_stock_shed WHERE ward = $wardid &&  user_id=$user_id order by id desc");

        if ($result->num_rows > 0) {
            $rows = array();
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }

            $response['livestockShedlist'] = $rows;
            $response['status'] = 'success';
            $response['msg'] = "Data Found";
            header('HTTP/1.1 200 OK');
        } else {
            $response['status'] = 'error';
            $response['msg'] = "No data found for the given ward_id";
            header('HTTP/1.0 404 Not Found');
        }
    } else {
        $response['status'] = 'error';
        $response['msg'] = "Missing ward_id in the request";
        header('HTTP/1.0 400 Bad Request');
    }
    return $response;
});
} else {
    $response['status'] = 'error';
    $response['msg'] = "Invalid request method. Please use POST method.";
    header('HTTP/1.0 405 Method Not Allowed');
    // return $response;
    echo json_encode($response);
}

// echo json_encode($response);
