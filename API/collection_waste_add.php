

<?php

 include('./checkToken.php');
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization, X-APP-VERSION, X-APP-VERSION, X-DEVELOPMENT-VERSION");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

 if($_SERVER['REQUEST_METHOD']=='POST'){
 checkToken(function(){  // this function check token exist or not


    include_once('../config/db_connect2.php');

                // $state_id = $_POST['state_id'];
                // $dist_id = $_POST['dist_id'];
                // $muni_id = $_POST['muni_id'];
                $word_id = $_POST['word_id'];
                $asyns_id = $_POST['asyns_id'];
                $date_id = $_POST['date_id'];
                $user_id = $_POST['user_id'];
                $house_hold_id = $_POST['house_hold_id'];
                $house_hold_no = $_POST['house_hold_no'];
                $waste_given = $_POST['waste_given'];
                $wastegiveninsegregatedmanner = $_POST['wastegiveninsegregatedmanner'];
                $entry_date = $_POST['entry_date'];
                $is_complete = $_POST['is_complete'];
                $complete_time = $_POST['complete_time'];
                $trp_id = $_POST['trp_id'];
                $is_lock = $_POST['is_lock'];
                $home_comp = $_POST['home_comp']; 


                  // find `which_state`, `which_district` ,`which_municipalty`
                $q = "select * from word_master where id = $word_id";
                $get_word_data = mysqli_query($con,$q);
                $word_data = mysqli_fetch_array($get_word_data);
                
                    $state_id = $word_data['state'];
                    $dist_id = $word_data['dist'];
                    $muni_id = $word_data['municipalty'];

                $q = "INSERT INTO `collection_waste` (`id`, `state_id`, `dist_id`, `muni_id`, `word_id`, `asyns_id`, `date_id`, `user_id`, `house_hold_id`, `house_hold_no`, `waste_given`, `wastegiveninsegregatedmanner`, `entry_date`, `is_complete`, `complete_time`, `trp_id`, `is_lock`, `home_comp`) 
                VALUES (NULL, '$state_id', '$dist_id', '$muni_id', '$word_id', '$asyns_id', '$date_id', '$user_id', '$house_hold_id', '$house_hold_no', '$waste_given', '$wastegiveninsegregatedmanner', '$entry_date', '$is_complete', '$complete_time', '$trp_id', '$is_lock', '$home_comp');";
                $is_insert = mysqli_query($con,"$q");
        
                if(mysqli_affected_rows($con) == 1 ){ 
                    $response['status'] = 'success';
                    $response['msg'] = "insert successfully";

                    header('HTTP/1.1 200 OK');
                }
                else{
                    $response['status'] = 'fail';
                    $response['msg'] = "insert fail";
                    header('HTTP/1.0 404 Not Found');
                }
                  
                    mysqli_close($con);
        
 
     return $response;
 });


 }





?>