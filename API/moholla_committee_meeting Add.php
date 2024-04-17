
<?php

include('./checkToken.php');
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization, X-APP-VERSION, X-APP-VERSION, X-DEVELOPMENT-VERSION");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

if($_SERVER['REQUEST_METHOD']=='POST'){
checkToken(function(){  // this function check token exist or not

    include_once('../config/db_connect2.php');

               $date_of_meeting = $_POST['date_of_meeting'];
               $supervisor_id = $_POST['supervisor_id'];
               $field_staff_id = $_POST['field_staff_id'];
               $ward_id = $_POST['ward_id'];
               $locality_id = $_POST['locality_id'];
               $moholla_committee_id = $_POST['moholla_committee_id'];
               $household_mc = $_POST['household_mc'];
               $household_segregation = $_POST['household_segregation'];
               $hh_user_pay_charge = $_POST['hh_user_pay_charge'];
               $user_charge_collection = $_POST['user_charge_collection'];
               $salarypicker_wastepicker = $_POST['salarypicker_wastepicker'];
               $other_expense = $_POST['other_expense'];
               $is_wastecollector_regular = $_POST['is_wastecollector_regular'];
               $is_wastecoming_composter1 = $_POST['is_wastecoming_composter1'];
               $is_wastecoming_composter2 = $_POST['is_wastecoming_composter2'];
               $manure_generated = $_POST['manure_generated'];
               $manure_sold = $_POST['manure_sold'];
               $incomefrom_manuresold = $_POST['incomefrom_manuresold'];
               $no_of_undertaken_homecomposting = $_POST['no_of_undertaken_homecomposting'];
               $balance = $_POST['balance'];

    

               $q = "INSERT INTO `moholla_committee_meeting` (`id`, `date_of_meeting`, `supervisor_id`, `field_staff_id`, `ward_id`, `locality_id`, `moholla_committee_id`, `household_mc`, `household_segregation`, `hh_user_pay_charge`, `user_charge_collection`, `salarypicker_wastepicker`, `other_expense`, `is_wastecollector_regular`, `is_wastecoming_composter1`, `is_wastecoming_composter2`, `manure_generated`, `manure_sold`, `incomefrom_manuresold`, `no_of_undertaken_homecomposting`, `balance`)
                    VALUES (NULL, '$date_of_meeting', '$supervisor_id', '$field_staff_id', '$ward_id', '$locality_id', '$moholla_committee_id', '$household_mc', '$household_segregation', '$hh_user_pay_charge', '$user_charge_collection', '$salarypicker_wastepicker', '$other_expense', '$is_wastecollector_regular', '$is_wastecoming_composter1', '$is_wastecoming_composter2', '$manure_generated', '$manure_sold', '$incomefrom_manuresold', '$no_of_undertaken_homecomposting', '$balance');";     
             $is_insert = mysqli_query($con,$q);  
               
            //   $q = "INSERT INTO `moholla_committee_meeting` (`id`, `date_of_meeting`, `supervisor_id`, `field_staff_id`, `ward_id`, `locality_id`, `moholla_committee_id`, `household_mc`, `household_segregation`, `hh_user_pay_charge`, `user_charge_collection`, `salarypicker_wastepicker`, `other_expense`, `is_wastecollector_regular`, `is_wastecoming_composter1`, `is_wastecoming_composter2`, `manure_generated`, `manure_sold`, `incomefrom_manuresold`, `no_of_undertaken_homecomposting`, `balance`)
            //    VALUES (NULL, '2/2/2024', '0', '0', '0', '0', '0', 'household_mc', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');";


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
                  
           return $response;  

});
}





?>