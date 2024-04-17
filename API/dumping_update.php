

<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
 include('./checkToken.php');
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization, X-APP-VERSION, X-APP-VERSION, X-DEVELOPMENT-VERSION");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
  checkToken(function(){  // this function check token exist or not
   
    include_once('../config/db_connect2.php');
    $image_file_locattion ="./public/"; // folder path of image
  
    $dumping_id = $_POST['_id'];
    $details = $_POST['details'];
    $image_link = $_FILES['image_link'];
    $image_Name = $image_link['name'];
    

     // All image formate accessible
     $all_image_formate_accessible = substr($image_link['type'],0,5);

     // find old image name
      $q ="select (image_link) from dumping where id = $dumping_id";
      $get_old_image_name = mysqli_query($con,$q);
      $image_old_name = mysqli_fetch_array($get_old_image_name)['image_link'];

     // chaking image or not
    if($all_image_formate_accessible == "image"){

           // old image delete
            if(file_exists($image_file_locattion.$image_old_name)){
                if(unlink($image_file_locattion.$image_old_name)){
                    $response['old_image_status'] = 'remove old image';
                }else{
                    $response['old_image_status'] = 'something wromg';
                }
            }else{
                $response['old_image_status'] = 'image not found';
            } 

            // upload new image
            if(move_uploaded_file($image_link['tmp_name'],$image_file_locattion.$image_Name)){
                $response['image_status'] = 'image successfully uploaded';

                    // insert data in mysql
                    $q = "UPDATE `dumping` 
                    SET `image_link` = '$image_Name', 
                    `details` = '$details' WHERE `dumping`.`id` = $dumping_id";
                    $is_insert = mysqli_query($con,$q);

                    if(mysqli_affected_rows($con) == 1 ){ 
                        $response['status'] = 'success';
                        $response['msg'] = 'updated successfully';
                        header('HTTP/1.1 200 OK');
                    }
                    else{
                        $response['status'] = 'fail';
                        $response['msg'] = "update fail";
                        header('HTTP/1.0 404 Not Found');
                    }
            }else{
                $response['image_status'] = 'something wrong image not upload';
            }
 
           

    } else{
            $response['image_status'] = 'only upload image file';
    
       }
 
     return $response;
 });
 
}
?>