<?php
include('checkToken.php');
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization, X-APP-VERSION, X-APP-VERSION, X-DEVELOPMENT-VERSION");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
if($_SERVER['REQUEST_METHOD']=='GET'){
    checkToken(function(){  // this function check token exist or not

        include_once('../config/db_connect2.php');

              $q = "select * from moholla_committee_meeting";
              $moholla_committee_meeting_list = mysqli_query($con,$q);
              
              if(mysqli_num_rows($moholla_committee_meeting_list) > 0){
                    while($row = mysqli_fetch_assoc($moholla_committee_meeting_list)){
                        $lists[]= $row;
                    }
                }else{
                    $lists[] = "data not found"; 
                }

              $response['lists'] = $lists;
                return $response; 
    });
}




?>