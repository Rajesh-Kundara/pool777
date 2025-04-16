<?php
include('common/config.php');

$response["isUpdateAvailable"] = true;
$response["forceToUpdate"] = false;
$response['success'] =0;
$response["message"] = "Not performed.";
if(!empty($_POST['versionCode'])){
		$versionCode=$_POST['versionCode'];
		
		//this should be set manualy by developer
		$lattestVersionCode=10;
		if($versionCode<$lattestVersionCode){
			$response["isUpdateAvailable"] = true;
			$response["forceToUpdate"] = true;
		}
		$response['success'] =1;
		$response["message"] = "New update for CrickExpert tips is available on Play Store.";
	}else{
		$response["message"] = "Parameters missing.";
	}
	echo json_encode($response);
	?>