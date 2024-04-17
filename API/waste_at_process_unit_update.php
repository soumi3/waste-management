
<?php
  include('checkToken.php');
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization, X-APP-VERSION, X-APP-VERSION, X-DEVELOPMENT-VERSION");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

  if($_SERVER['REQUEST_METHOD']=='POST'){
    checkToken(function(){  // this function check token exist or not
      include_once('../config/db_connect2.php');

            $_id = $_POST['_id'];
            $processing_unit_name = $_POST['processing_unit_name'];
            $waste_type_id = $_POST['waste_type_id'];
            $how_much = $_POST['how_much'];

           $q = "UPDATE `waste_at_process_unit` 
           SET  `processing_unit_name` = '$processing_unit_name', 
                `waste_type_id` = '$waste_type_id',
                `how_much` = '$how_much' WHERE `waste_at_process_unit`.`id` = $_id ";
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