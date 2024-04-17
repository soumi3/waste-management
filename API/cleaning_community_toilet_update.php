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
    checkToken(function ($con, $data) {
        // $json = file_get_contents('php://input');
        // $data = json_decode($json, true); // Decoding JSON to associative array
        // print_r($data);
    if (isset($data['wardId'])) {
        $id = $data['id'];
        $wardId = $data['wardId'];

        $sqlget_muniid = mysqli_fetch_array(mysqli_query($con, "select municipalty from word_master where id=$wardId"));
        $muniid = $sqlget_muniid['municipalty'];

        $month_year = $data['monthYear'];
        $supervisor_id = $data['supervisorId'];
        $field_staff = $data['fieldStaff'];
        $community_toilet_id = $data['communityToiletId'];
        $moholla_committee = $data['mohollaCommittee'];
        $cleaning_status = $data['cleaningStatus'];
        $electricity = $data['electricity'];
        $cleaning_materials = $data['cleaningMaterials'];

        $swiper_charge = $data['swiperCharge'];
        $minor_repair = $data['minorRepair'];
        $major_repair = $data['majorRepair'];
        $om_collector = $data['omCollector'];
        $om_register_maintained = $data['omRegisterMaintained'];
        $sanitary_waste_managed = $data['sanitaryWasteManaged'];
        $htgentrain_undertaken = $data['htgentrainUndertaken'];
        $special_day_celebrated = $data['specialDayCelebrated'];
        $all_tap_functional = $data['allTapFunctional'];
        $all_doors_close = $data['allDoorsClose'];
        $condition_of_tiles = $data['conditionOfTiles'];
        $condition_of_roof = $data['conditionOfRoof'];
        $condition_of_washbasin = $data['conditionOfWashbasin'];
        $condition_of_boundarywall = $data['conditionOfBoundarywall'];
        $condition_of_overheadtank = $data['conditionOfOverheadtank'];
        $condition_of_bulb = $data['conditionOfBulb'];
        $condition_of_septictank = $data['conditionOfSeptictank'];
        $condition_of_pump = $data['conditionOfPump'];
        $total_usercharge_collect = $data['totalUserchargeCollect'];
        $total_house_mc_no = $data['totalHouseMcNo'];
        $entry_date = $data['entry_date'];
        // $userid = 0;

        $update_query = mysqli_query(
            $con,
            "update cleaning_community_toilet set municipality_id='$muniid',ward_id='$wardId',month_year='$month_year',supervisor_id='$supervisor_id',field_staff='$field_staff',community_toilet_id='$community_toilet_id',moholla_committee='$moholla_committee',cleaning_status='$cleaning_status',electricity='$electricity',cleaning_materials='$cleaning_materials',swiper_charge='$swiper_charge',minor_repair='$minor_repair',om_collector='$om_collector',major_repair='$major_repair',om_register_maintained='$om_register_maintained',sanitary_waste_managed='$sanitary_waste_managed',htgentrain_undertaken='$htgentrain_undertaken',special_day_celebrated='$special_day_celebrated',all_tap_functional='$all_tap_functional',all_doors_close='$all_doors_close',condition_of_tiles='$condition_of_tiles',condition_of_roof='$condition_of_roof',condition_of_washbasin='$condition_of_washbasin',condition_of_boundarywall='$condition_of_boundarywall',condition_of_overheadtank='$condition_of_overheadtank',condition_of_bulb='$condition_of_bulb',condition_of_septictank='$condition_of_septictank',condition_of_pump='$condition_of_pump',total_usercharge_collect='$total_usercharge_collect',total_house_mc_no='$total_house_mc_no',entry_date='$entry_date' where id=$id"
        );
            // echo "update cleaning_community_toilet set municipality_id='$muniid',ward_id='$wardId',month_year='$month_year',supervisor_id='$supervisor_id',field_staff='$field_staff',community_toilet_id='$community_toilet_id',moholla_committee='$moholla_committee',cleaning_status='$cleaning_status',electricity='$electricity',cleaning_materials='$cleaning_materials',swiper_charge='$swiper_charge',minor_repair='$minor_repair',om_collector='$om_collector',major_repair='$major_repair',om_register_maintained='$om_register_maintained',sanitary_waste_managed='$sanitary_waste_managed',htgentrain_undertaken='$htgentrain_undertaken',special_day_celebrated='$special_day_celebrated',all_tap_functional='$all_tap_functional',all_doors_close='$all_doors_close',condition_of_tiles='$condition_of_tiles',condition_of_roof='$condition_of_roof',condition_of_washbasin='$condition_of_washbasin',condition_of_boundarywall='$condition_of_boundarywall',condition_of_overheadtank='$condition_of_overheadtank',condition_of_bulb='$condition_of_bulb',condition_of_septictank='$condition_of_septictank',condition_of_pump='$condition_of_pump',total_usercharge_collect='$total_usercharge_collect',total_house_mc_no='$total_house_mc_no',entry_date='$entry_date' where id=$id";
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
        $response['msg'] = "Not Updated";
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
