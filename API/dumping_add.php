

<?php

if($_SERVER['REQUEST_METHOD']=='POST'){
    include('./checkToken.php');
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization, X-APP-VERSION, X-APP-VERSION, X-DEVELOPMENT-VERSION");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    checkToken(function(){ // this function check token exist or not
        include_once('../config/db_connect2.php');
        $image_file_locattion ="./public/";  // folder path of image

        if(isset($_POST['is_clear'])){
            $is_clear = $_POST['is_clear'];
        }else{
            $is_clear = 0;
        }
        $ward_id = $_POST['ward_id'];
        $rootlane = $_POST['rootlane'];
        $nirmal_sathi_id = $_POST['nirmal_sathi_id'];
        $image_link = $_FILES['image_link'];
        $details = $_POST['details'];
        // $entry_date = $_POST['entry_date'];
        //$is_clear = $_POST['is_clear'];
        $is_delete = $_POST['is_delete'];
        // $claer_date = $_POST['claer_date'];
        $cur_lat = $_POST['cur_lat'];
        $cur_long = $_POST['cur_long'];
        $image_Name = $image_link['name'];
        $entry_date = time();
        $claer_date = time();

        
    // aAll image formate accessible
        $all_image_formate_accessible = substr($image_link['type'],0,5);

        if(file_exists($image_file_locattion.$image_Name)){
            $response['image_status'] = 'image already exist';
            $response['status'] = 'insert fail please select another image';

        }else if($all_image_formate_accessible == "image"){
            if(move_uploaded_file($image_link['tmp_name'],$image_file_locattion.$image_Name)){
                $response['image_status'] = 'image successfully uploaded';

                    // find state_id district_id muni_id
                    $q = "select * from word_master where id = $ward_id";
                    $get_word_data = mysqli_query($con,$q);
                    $word_data = mysqli_fetch_array($get_word_data);
                     
                    $state_id = $word_data['state'];
                    $district_id = $word_data['dist'];
                    $muni_id = $word_data['municipalty'];

                    // inset data
                    $q = "INSERT INTO `dumping` (`id`, `state_id`, `district_id`, `muni_id`, `ward_id`, `rootlane`, `nirmal_sathi_id`, `image_link`, `details`, `entry_date`, `is_clear`, `is_delete`, `claer_date`, `cur_lat`, `cur_long`) 
                    VALUES (NULL, '$state_id', '$district_id', '$muni_id', '$ward_id', '$rootlane', '$nirmal_sathi_id', '$image_Name', '$details', '$entry_date', '$is_clear', '$is_delete', '$claer_date', '$cur_lat', '$cur_long')";
                    $is_insert = mysqli_query($con,$q);

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
                        }else{
                            $response['image_status'] = 'something wrong image not upload';
                        }
                    
        }else{
            $response['image_status'] = 'only upload image file';

        }   
            mysqli_close($con);
    
        return $response;
    });
 
}

?>