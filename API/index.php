<?php 
$connection = mysqli_connect("localhost","root","","api");	
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization, X-APP-VERSION, X-APP-VERSION, X-DEVELOPMENT-VERSION");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
$method = $_SERVER['REQUEST_METHOD'];
if ($method == "OPTIONS") 
{
    die();
}

$content_type = $_SERVER["CONTENT_TYPE"];
$request_method = $_SERVER["REQUEST_METHOD"];
if($content_type == 'application/json'){
	$_POST = (array)json_decode(file_get_contents("php://input"));
}



$slr=0;
$sql_query=mysqli_query($connection,"select * from a_applications order by id desc limit 0,10");
while($res=mysqli_fetch_array($sql_query))
{

	$studentData['studentName']=$res['full_name'];
	$studentData['aadhaar']=$res['aadhaar'];
	$studentData['ration_card']=$res['ration_card'];
	$studentData['nationality']=$res['nationality'];


	$studentAllData[$slr]=$studentData;
	$slr++;
}

            

if($sql_query)
{
	$response['students'] = $studentAllData;
	$response['status'] = 'success';
	$response['msg'] = "Add Successfully";
	header('HTTP/1.1 200 OK');

}else{
	$response['status'] = 'error';
	$response['msg'] = "Try again";
	header('HTTP/1.0 404 Not Found');

}


 echo json_encode($response);
