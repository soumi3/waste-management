
<?php
  
 include('checkToken.php');
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization, X-APP-VERSION, X-APP-VERSION, X-DEVELOPMENT-VERSION");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
 if($_SERVER['REQUEST_METHOD']=='POST'){
    checkToken(function(){  // this function check token exist or not
       //include_once('../config/db_connect2.php');

       include("../config/db_connect2.php");


    //  $con = mysqli_connect('localhost','root');

    //  if($con){
    //    echo "ok...";
    //  }else{
    //    echo "connection fail";
    //  }

        $user_id = $_POST['user_id'];
        // $district_id = $_POST['district_id'];
        // $municipality_id = $_POST['municipality_id'];
        $ward_id =$_POST['ward_id'];
        $processing_unit_name = $_POST['processing_unit_name'];
        $waste_type_id = $_POST['waste_type_id'];
        $how_much = $_POST['how_much'];

          // find `which_state`, `which_district` ,`which_municipalty`
          $q = "select * from word_master where id = $ward_id";
          $get_word_data = mysqli_query($con,$q);
          $word_data = mysqli_fetch_array($get_word_data);
          
              $district_id = $word_data['dist'];
              $municipality_id = $word_data['municipalty'];
        

        // $q = "INSERT INTO `waste_at_process_unit` (`id`, `user_id`, `district_id`, `municipality_id`, `ward_id`, `processing_unit_name`, `waste_type_id`, `how_much`, `created_date`, `updated_at`) 
        // VALUES (NULL, '1', '2', '3', '4', 'processing_unit_name', '1', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);";
          

                    
            $q = "INSERT INTO `waste_at_process_unit` (`id`, `user_id`, `district_id`, `municipality_id`, `ward_id`, `processing_unit_name`, `waste_type_id`, `how_much`, `created_date`, `updated_at`) 
            VALUES (NULL, '$user_id', '$district_id', '$municipality_id', '$ward_id', '$processing_unit_name', '$waste_type_id', '$how_much', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);";
                    $is_insert = mysqli_query($con,"$q");

        if(mysqli_affected_rows($con) == 1 ){ 
            $response['status'] = 'success';
            $response['msg'] = 'insert successfully';
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