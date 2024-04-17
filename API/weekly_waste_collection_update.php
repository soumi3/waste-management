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
        // $json = file_get_contents('php://input');
        // $data = json_decode($json, true); // Decoding JSON to associative array
        // print_r($data);
    if (isset($data['wardId'])) {
        $id = $data['id'];
        $wardId = $data['wardId'];


        $sqlget_muniid = mysqli_fetch_array(mysqli_query(
            $con,
            "select municipalty from word_master where id=$wardId"
        ));
        $muniid = $sqlget_muniid['municipalty'];

        $sqlget_mohllacommitteeid = mysqli_fetch_array(
            mysqli_query(
                $con,
                "select committee_name from  moholla_committee where ward_id=$wardId"
            )
        );
        $mohollaid = $sqlget_mohllacommitteeid['committee_name'];

        $date = $data['Date'];
        $supervisor_id = $data['supervisorId'];
        $field_staff_id = $data['fieldStaffId'];
        $house_number = $data['houseNumber'];
        $block = $data['Block'];
        $locality_id = $data['localityId'];
        $resident_name = $data['residentName'];
        $compostable_waste_collected = $data['compostableWasteCollected'];
        $iron = $data['Iron'];
        $aluminium = $data['Aluminium'];
        $other_metals = $data['otherMetals'];
        $pet_bottles = $data['petBottles'];
        $other_plastic = $data['otherPlastic'];
        $glass = $data['Glass'];
        $milkbag = $data['milkbag'];
        $paper = $data['Paper'];
        $card_board = $data['cardBoard'];
        $others = $data['Others'];
        $inert_waste = $data['inertinertWaste_waste'];
        $days_collection_in_week = $data['daysCollectionInWeek'];



        $update_query = mysqli_query(
            $con,
            "update weekly_waste_collection
     set date='$date',supervisor_id='$supervisor_id',
     field_staff_id='$field_staff_id',house_number='$house_number',moholla_committee_id='$mohollaid',
     block='$block',ward_no='$wardId',locality_id='$locality_id',resident_name='$resident_name',
     compostable_waste_collected='$compostable_waste_collected',iron='$iron',aluminium='$aluminium',
     other_metals='$other_metals',pet_bottles='$pet_bottles',other_plastic='$other_plastic',
     glass='$glass',milkbag='$milkbag',paper='$paper',card_board='$card_board',others='$others',
     inert_waste='$inert_waste',days_collection_in_week='$days_collection_in_week' where id=$id"
        );
    //         echo "update weekly_waste_collection
    //  set date='$date',supervisor_id='$supervisor_id',
    //  field_staff_id='$field_staff_id',house_number='$house_number',moholla_committee_id='$mohollaid',
    //  block='$block',ward_no='$wardId',locality_id='$locality_id',resident_name='$resident_name',
    //  compostable_waste_collected='$compostable_waste_collected',iron='$iron',aluminium='$aluminium',
    //  other_metals='$other_metals',pet_bottles='$pet_bottles',other_plastic='$other_plastic',
    //  glass='$glass',milkbag='$milkbag',paper='$paper',card_board='$card_board',others='$others',
    //  inert_waste='$inert_waste',days_collection_in_week='$days_collection_in_week' where id=$id";
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
