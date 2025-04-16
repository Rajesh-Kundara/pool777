<?php
session_start();

// Define the whitelist of allowed IP addresses
$whitelist = array('127.0.0.1', '::1', '192.168.43.43', '192.168.1.101', '52.221.253.111');
$http = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
$host = "http://www.pools777.com";
if (!in_array($_SERVER['SERVER_ADDR'], $whitelist)) {
    $host = "http://www.pools777.com";
    $host = "";
    $db_host = "sg2plcpnl0102.prod.sin2.secureserver.net";
    $db_port = 3306; // Port for the database
    $dbu = "adminthar";
    $db_sec = "Chaman971";
    $db_name = "pools777";

    $rootPath = "";
} else {
    $host = "http://localhost:8008";
    // $host = "/marsleisure";
    $host = $http."://".$_SERVER['HTTP_HOST'].'/pool777/';
    // $host = "";
    $db_host = "localhost";
    $db_port = 3306;
    $dbu = "root";
    $db_sec = "";
    // $db_name = "marsleisure";
    $db_name = "pools777";
}

// SMS configuration
$sms_url = '';
$sms_uname = '';
$sms_pass = '';
$sms_sender_id = '';
// SMS configuration - END

// Database connection using MySQLi
$connection = new mysqli($db_host, $dbu, $db_sec, $db_name, $db_port);

// Check for connection errors
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Set the character set to UTF-8
$connection->set_charset("utf8");

// Error reporting settings
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Replace the `lastInsertId` function
function lastInsertId($connection) {
    return $connection->insert_id;
}

$SecretKeyPayStack = 'sk_test_ff1ddb7484316f0d80b0f7797f3928b45af043b4';
?>
