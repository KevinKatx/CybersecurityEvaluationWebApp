<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once("db.php");

$request_method = $_SERVER["REQUEST_METHOD "];

switch ($request_method){
    case "GET":
        if(!empty($_GET["id"])){
            global $conn;
            $query= "SELECT * FROM employee WHERE id = $id";
            $result = $conn->query($query);
            $data = [];

            while ($row = $result->fetch_assoc()){
                $data[] = $row; 
            }

            echo json_encode($data);
        }
        break;
    case "POST":
        break;
    case "PUT":
        break;
    case "DELETE":
        break;
}
    



?>