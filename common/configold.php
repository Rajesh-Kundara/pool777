<?php
session_start();
$whitelist = array('127.0.0.1','::1','192.168.43.43','192.168.1.101:8180','52.221.253.111');

$host="http://www.pools777.com";
 if(!in_array($_SERVER['SERVER_ADDR'], $whitelist)){
	 //$host="http://".$_SERVER['HTTP_HOST'];
	 $host="http://www.pools777.com";
	 $host="";
	 $db_host="sg2plcpnl0102.prod.sin2.secureserver.net:3306";
	 //$dbu="tharwayc_admin";
	 $dbu="adminthar";
	 //$db_sec="tharberry971";
	 $db_sec="Chaman971";
	 //$db_name="tharwayc_tharberry";
	 $db_name="pools777";
	 
	 $rootPath="";
 }else{
	 $host="http://localhost:8008";
	 $host="/marsleisure";
	 $db_host="localhost";
	 $dbu="root";
	 $db_sec="";
	 $db_name="marsleisure";
 }

 //SMS configuration
 $sms_url='';
 $sms_uname='';
 $sms_pass='';
 $sms_sender_id='';
 //SMS configuration-END
 
 
 // This is the single point entry for the database connection on server
 mysql_connect($db_host,$dbu,$db_sec) or die(mysql_error()." NO CONNECTION FOUND ");

 //$connection = mysqli_connect($db_host,$dbu,$db_sec,$db_name) or die(mysqli_error($connection));
 
 // Database Name for the server
 mysql_select_db($db_name) or die(mysql_error()."NO DB FOUND");
 
 
mysql_query('SET character_set_results=utf8');
mysql_query('SET names=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_results=utf8');
mysql_query('SET collation_connection=utf8_general_ci');
 // Turn off all error reporting
 //error_reporting(0);

// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);

function lastInsertId($queryID) {
    sqlsrv_next_result($queryID);
    sqlsrv_fetch($queryID);
    return sqlsrv_get_field($queryID, 0);
}

$SecretKeyPayStack='sk_test_ff1ddb7484316f0d80b0f7797f3928b45af043b4';
?>