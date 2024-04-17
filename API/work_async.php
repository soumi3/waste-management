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
    checkToken(function($con,$data){
    $json = file_get_contents('php://input');
    $data = json_decode($json, true); // Decoding JSON to associative array
    $slr = 0;
    $slr2 = 0;
    if (isset($data['nirmalsathiId'])) {

        $nsid = $data['nirmalsathiId'];


        $result = mysqli_query($con, "select * from  work_async where nirmal_sathi_id=$nsid and is_active=1");

        while ($res = mysqli_fetch_array($result)) {
            $assin_id = $res['id'];
            $fromhouse_no = $res['from_house_no'];
            $tohouse_no = $res['to_house_no'];

            $sdateint = $res['start_time'];
            $sdatee = date('Y-m-d', $sdateint);

            $edateint = $res['end_time'];
            $edatee = date('Y-m-d', $edateint);

            $stateId = $res['state_id'];
            $districtId = $res['dist_id'];
            $municipaltyId = $res['municipalty_id'];
            $nirmalsathiId = $res['nirmal_sathi_id'];

            $getroad_data = mysqli_fetch_array(mysqli_query($con, "select * from road_lane INNER JOIN work_async on road_lane.id=work_async.road_name"));


            $data['assignId'] = $assin_id;
            $data['wardId'] = $res['word_id'];

            $data['from_houseno'] = $fromhouse_no;
            $data['to_houseno'] = $tohouse_no;
            $data['sdate'] = $sdatee;
            $data['edate'] = $edatee;
            $data['sId'] = $stateId;
            $data['dId'] = $districtId;
            $data['mId'] = $municipaltyId;
            $data['nsId'] = $nirmalsathiId;

            $data['road_name'] = $getroad_data['road_name'];

            $sqladta_tripcheck = mysqli_fetch_array(mysqli_query($con, "select 1 from work_async_trip where assign_id=$assin_id"));
            if ($sqladta_tripcheck) {
                $sql_trip = mysqli_query($con, "select * from work_async_trip where assign_id=$assin_id");
                $slr2 = 1;
                while ($res2 = mysqli_fetch_array($sql_trip)) {
                    $trip['trip_no'] = $slr2++;

                    $trip['triprId'] = $res2['id'];
                    $trip['from_houseno'] = $res2['from_house'];
                    $trip['to_house'] = $res2['to_house'];

                    $datatrip[] = $trip;
                }

                $data['trip'] = $datatrip;
            } else {
                $data['trip'] = null;
            }



            $allusers[$slr] = $data;

            $slr++;
        }
        //   if ($result->num_rows > 0) {
        //         $rows = array();
        //         while ($row = $result->fetch_assoc()) {
        //             $rows[] = $row;
        //         }

        //         $response['house_holds'] = $rows;
        //         $response['status'] = 'success';
        //         $response['msg'] = "Data Found";
        //         header('HTTP/1.1 200 OK');
        //     } else {
        //         $response['status'] = 'error';
        //         $response['msg'] = "Try again";
        //         header('HTTP/1.0 404 Not Found');
        //     }

        if ($result) {

            $response['work_async'] = $allusers;
            $response['status'] = 'success';
            $response['msg'] = "Data Found";
            header('HTTP/1.1 200 OK');
        } else {
            $response['status'] = 'error';
            $response['msg'] = "Try again";
            header('HTTP/1.0 404 Not Found');
        }
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
