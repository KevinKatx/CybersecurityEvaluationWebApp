<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once("db.php");

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method){
    case "GET":
        if(!empty($_GET["id"])){
            $id = $_GET["id"];
            global $conn;
            $stmt = $conn->prepare("SELECT * FROM employee WHERE id = $id");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $data = [];

            while ($row = $result->fetch_assoc()){
                $data[] = $row; 
            }

            echo json_encode($data);
        }else{
            global $conn;
            $query= "SELECT * FROM employee";
            $result = $conn->query($query);
            $data = [];

            while ($row = $result->fetch_assoc()){
                $data[] = $row; 
            }

            echo json_encode($data);
        }
        break;


    case "POST":
        global $conn;
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data["first_name"], $data["last_name"], $data["age"], $data["gender"], $data["phone"], $data["email"])) {
            echo json_encode(["status" => "error", "message" => "Missing required fields"]);
            exit();
        }
        
        // Ensure 'age' is an integer
        if (!is_numeric($data["age"])) {
            echo json_encode(["status" => "error", "message" => "Age must be a number"]);
            exit();
        }

        $stmt = $conn->prepare("INSERT INTO employee (first_name, last_name, age, gender, phone, email) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssisss", 
            $data["first_name"], 
            $data["last_name"], 
            $data["age"], 
            $data["gender"], 
            $data["phone"], 
            $data["email"]);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Employee added successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Database error: " . $stmt->error]);
        }

        $stmt->close();
        break;
    case "PUT":
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data["id"],$data["first_name"], $data["last_name"], $data["age"], $data["gender"], $data["phone"], $data["email"])) {
            echo json_encode(["status" => "error", "message" => "Missing required fields"]);
            exit();
        }
        
        // Ensure 'age' is an integer
        if (!is_numeric($data["age"])) {
            echo json_encode(["status" => "error", "message" => "Age must be a number"]);
            exit();
        }

        $stmt = $conn->prepare("UPDATE employee SET first_name = ?, last_name = ?, age = ?, gender = ?, phone = ?, email = ? WHERE id = ?");
        $stmt->bind_param("ssisssi",
            $data["first_name"], 
            $data["last_name"], 
            $data["age"], 
            $data["gender"], 
            $data["phone"], 
            $data["email"],
            $data["id"]);
        if($stmt->execute()){
            echo json_encode(["status" => "success", "message" => "Employee entry update successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Database error: " . $stmt->error]);
        }
        $stmt->close();
        
        break;

    case "DELETE":
        $data = json_decode(file_get_contents("php://input"), true);
        if(!isset($data["id"])){
            echo json_encode(["status" => "error", "message" => "User not found"]);
            exit();
        }
        $stmt = $conn->prepare("DELETE FROM employee WHERE id = ?");
        $stmt->bind_param("i",$data["id"]);
        if($stmt->execute()){
            echo json_encode(["status" => "success", "message" => "Employee entry deleted successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Database error: " . $stmt->error]);
        }
        $stmt->close();
        break;
}
    



?>