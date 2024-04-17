<?php
 include('./checkToken.php');
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization, X-APP-VERSION, X-APP-VERSION, X-DEVELOPMENT-VERSION");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
 if($_SERVER['REQUEST_METHOD']=='POST'){
        checkToken(function(){  // this function check token exist or not
            include_once('../config/db_connect2.php'); 

            $_id = $_POST['_id'];
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


            $q = "UPDATE `moholla_committee_meeting`
                SET `moholla_committee_id` = '$moholla_committee_id', 
                        `household_mc` = '$household_mc',
                        `household_segregation` = '$household_segregation', 
                        `hh_user_pay_charge` = '$hh_user_pay_charge',
                        `user_charge_collection` = '$user_charge_collection', 
                        `salarypicker_wastepicker` = '$salarypicker_wastepicker',
                        `other_expense` = '$other_expense',
                        `is_wastecollector_regular` = '$is_wastecollector_regular',
                        `is_wastecoming_composter1` = '$is_wastecoming_composter1',
                        `is_wastecoming_composter2` = '$is_wastecoming_composter2',
                        `manure_generated` = '$manure_generated',
                        `manure_sold` = '$manure_sold',
                        `incomefrom_manuresold` = '$incomefrom_manuresold',
                        `no_of_undertaken_homecomposting` = '$no_of_undertaken_homecomposting',
                        `balance` = '$balance' WHERE `moholla_committee_meeting`.`id` = $_id";
                         $is_update = mysqli_query($con,$q);  
               
           
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
            return $response;
        });
    }


?>