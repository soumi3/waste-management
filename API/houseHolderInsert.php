<?php
include('./checkToken.php');


header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization, X-APP-VERSION, X-APP-VERSION, X-DEVELOPMENT-VERSION");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

    checkToken(function(){
     
        if($_SERVER['REQUEST_METHOD']=='POST'){
            include_once('../config/db_connect2.php');

           $wordNo=$_POST['wordno'];
           $locality = $_POST['locality'];
           $addahar_no = $_POST['addahar_no'];
           $family_members = $_POST['family_members'];
           $house_hold_name = $_POST['house_hold_name'];
           $mobile_no  = $_POST['mobile_no'];
           $ocupation = $_POST['ocupation'];
           $owner_type = $_POST['owner_type'];
           $holding_number = $_POST['holding_number'];
           $road_lane = $_POST['road_lane'];
           $home_base_manage_rat = $_POST['home_base_manage_rat'];
           $road = $_POST['road'];
           $type_of_wgu = $_POST['type_of_wgu'];  //Type of Establishment
           $pets = $_POST['pets'];
           $patients = $_POST['patients'];

           // find `which_state`, `which_district` ,`which_municipalty`
           $q = "select * from word_master where id = $wordNo";
           $get_word_data = mysqli_query($con,$q);
           $word_data = mysqli_fetch_array($get_word_data);
          
            $which_state = $word_data['state'];
            $which_district = $word_data['dist'];
            $which_municipalty = $word_data['municipalty'];
           //   print_r($word_data);

         
            // $q = "INSERT INTO `house_holder` (`id`, `which_state`, `which_district`, `which_municipalty`, `which_word`, `house_hold_name`, `addahar_no`, `family_members`, `owner_type`, `holding_number`, `road_lane`, `type_of_wgu`, `home_base_manage_rat`, `entry_date`, `entry_by`, `is_delete`, `slr_no`, `is_lock`, `mobile_no`, `road`, `is_bulk`, `bulk_entry_id`, `appx_time`, `lat`, `longi`, `locality`, `ocupation`, `pets`, `patients`) 
            // VALUES (NULL, '$which_state', '$which_district', '$which_municipalty', '$wordNo', '$house_hold_name', '$addahar_no', '$family_members', '$owner_type', '$holding_number', '$road_lane', '$type_of_wgu', '$home_base_manage_rat', '3', '2', '5', '6', '7', '$mobile_no', '$road', '5', '6', '2', '2', 'longi', '$locality', '$ocupation', '$pets', '$patients')";

            $q = "INSERT INTO `house_holder` (`id`, `which_state`, `which_district`, `which_municipalty`, `which_word`, `house_hold_name`, `addahar_no`, `family_members`, `owner_type`, `holding_number`, `road_lane`, `type_of_wgu`, `home_base_manage_rat`, `mobile_no`, `road`, `locality`, `ocupation`, `pets`, `patients`) 
            VALUES (NULL, '$which_state', '$which_district', '$which_municipalty', '$wordNo', '$house_hold_name', '$addahar_no', '$family_members', '$owner_type', '$holding_number', '$road_lane', '$type_of_wgu', '$home_base_manage_rat', '$mobile_no', '$road', '$locality', '$ocupation', '$pets', '$patients')";
            $is_insert = mysqli_query($con,$q);
    
            if(mysqli_affected_rows($con) == 1 ){ 
                $response['status'] = 'success';
                $response['msg'] = 'insert  successfully';
                header('HTTP/1.1 200 OK');
            }
            else{
                $response['status'] = 'fail';
                $response['msg'] = "insert fail";
                header('HTTP/1.0 404 Not Found');
            }
              
                mysqli_close($con);
        }
        return $response;
    });


    

?>


<?php
// road_lane or road 
// type_of_wgu
// entry_date
// entry_by
// is_delete
// slr_no
// is_bulk
// is_lock
// bulk_entry_id
// appx_time
// lat
// longi


// type_of_wgu 
?>