
<?php
   include('./checkToken.php');
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization, X-APP-VERSION, X-APP-VERSION, X-DEVELOPMENT-VERSION");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

 if($_SERVER['REQUEST_METHOD']=='POST'){
        checkToken(function(){  // this function check token exist or not
            include_once('../config/db_connect2.php');
            
            $_id = $_POST['_id'];
            $house_hold_id = $_POST['house_hold_id'];
            $house_hold_no = $_POST['house_hold_no'];
            $waste_given = $_POST['waste_given'];
            $wastegiveninsegregatedmanner = $_POST['wastegiveninsegregatedmanner'];
            $home_comp = $_POST['home_comp'];

            $q = "UPDATE `collection_waste` 
                        SET `house_hold_id` = '$house_hold_id', 
                        `house_hold_no` = '$house_hold_no', 
                        `waste_given` = '$waste_given', 
                        `wastegiveninsegregatedmanner` = '$wastegiveninsegregatedmanner',
                        `home_comp` = '$home_comp' WHERE `collection_waste`.`id` = $_id";

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
        
            return $response;
        });


  }



?>