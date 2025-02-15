<?php
$host = "localhost";
$username = "root";
$password = "";
$db_name = "employee_eval";

$conn = new mysqli($host, $username, $password, $db_name);

if($conn->cpnnect_error){
    die(json_encode(["error" => "Database connection failed: " . $conn->connect_error]));
}


?>