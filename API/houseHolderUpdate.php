<?php
 include('./checkToken.php');


    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization, X-APP-VERSION, X-APP-VERSION, X-DEVELOPMENT-VERSION");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

 checkToken(function(){

        if($_SERVER['REQUEST_METHOD']=='POST'){
            include_once('../config/db_connect2.php'); 

        $_id = $_POST['_id'];
        $locality = $_POST['locality'];
        $addahar_no = $_POST['addahar_no'];
        $family_members = $_POST['family_members'];
        $house_hold_name = $_POST['house_hold_name'];
        $mobile_no  = $_POST['mobile_no'];
        $ocupation = $_POST['ocupation'];
        $owner_type = $_POST['owner_type'];
        $holding_number = $_POST['holding_number'];
        $road_lane = $_POST['road_lane'];
        $home_base_manage_rat = $_POST['home_base_manage_rat'];//
        $road = $_POST['road'];
        $type_of_wgu = $_POST['type_of_wgu'];  //Type of Establishment
        

        $q = "UPDATE `house_holder` SET              
                            `house_hold_name` = '$house_hold_name', 
                            `addahar_no` = '$addahar_no',
                            `family_members` = '$family_members', 
                            `holding_number` = '$holding_number',
                            `road_lane` = '$road_lane', 
                            `type_of_wgu` = '$type_of_wgu', 
                            `home_base_manage_rat` = '$home_base_manage_rat',
                            `mobile_no` = '$mobile_no', 
                            `road` = '$road', 
                            `locality` = '$locality',
                            -- `owner_type`= '$owner_type', 
                            `ocupation` = '$ocupation'  WHERE `house_holder`.`id` = $_id";
                            $is_insert = mysqli_query($con,$q);

                            if(mysqli_affected_rows($con) == 1 ){ 
                                $response['status'] = 'success';
                                $response['msg'] = 'update successfully';
                                header('HTTP/1.1 200 OK');
                            }
                            else{
                                $response['status'] = 'fail';
                                $response['msg'] = "update fail";
                                header('HTTP/1.0 404 Not Found');
                            }
                           // echo json_encode($response);
               }
    return $response;
});

?>