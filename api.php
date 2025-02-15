<?php
error_reporting(E_ALL);
ini_set('display_errors', 1); // Ensure response is JSON
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once("db.php");

$request_method = $_SERVER["REQUEST_METHOD"];
<<<<<<< HEAD
$input = json_decode(file_get_contents('php://input'), true);

switch ($request_method){
    case "GET":
        if (!empty($_GET["id"])) {
            global $conn;
            $id = intval($_GET["id"]);
            $query = "SELECT * FROM employee WHERE id = $id ";
            $result = $conn->query($query);
            
            if ($result->num_rows > 0) {
                echo json_encode($result->fetch_assoc());
            } else {
                echo json_encode(["message" => "Employee not found"]);
            }
        } else {
            global $conn;
            $query = "SELECT * FROM employee";
=======

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
>>>>>>> 0a7eec4 (Api for the project)
            $result = $conn->query($query);
            $data = [];
        
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        
            echo json_encode($data);
        }
        break;


    case "POST":
        global $conn;
        $data = json_decode(file_get_contents("php://input"), true);
<<<<<<< HEAD
    
        if (
            isset($data["first_name"]) && isset($data["last_name"]) &&
            isset($data["age"]) && isset($data["gender"]) &&
            isset($data["phone"]) && isset($data["email"]) && isset($data["password"])
        ) {
            $first_name = $conn->real_escape_string($data["first_name"]);
            $last_name = $conn->real_escape_string($data["last_name"]);
            $age = intval($data["age"]);
            $gender = $conn->real_escape_string($data["gender"]);
            $phone = $conn->real_escape_string($data["phone"]);
            $email = $conn->real_escape_string($data["email"]);
            $password = $conn->real_escape_string($data["password"]);

            $query = "INSERT INTO employee (first_name, last_name, age, gender, phone, email, Role, password) 
                      VALUES ('$first_name', '$last_name', $age, '$gender', '$phone', '$email', 'Employee', '$password')";
            
            if ($conn->query($query)) {
                echo "<script>
                    alert('Employee added successfully!');
                    window.location.href = 'index.php'; // Redirect to login page
                </script>";
            } else {
                
                echo "<script>
                    alert('Error adding employee. Please try again.');
                    window.history.back(); // Go back to the registration form
                </script>";
            }
        } else {
            echo json_encode(["message" => "Invalid input"]);
        }
        break;
    case "PUT":
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            parse_str(file_get_contents("php://input"), $data);
            if (
                isset($data["id"]) && isset($data["first_name"]) && isset($data["last_name"]) &&
                isset($data["age"]) && isset($data["gender"]) &&
                isset($data["phone"]) && isset($data["email"]) && isset($data["Role"])
            ) {
                $id = intval($data["id"]);
                $first_name = $conn->real_escape_string($data["first_name"]);
                $last_name = $conn->real_escape_string($data["last_name"]);
                $age = intval($data["age"]);
                $gender = $conn->real_escape_string($data["gender"]);
                $phone = $conn->real_escape_string($data["phone"]);
                $email = $conn->real_escape_string($data["email"]);
                $role = $conn->real_escape_string($data["Role"]);
            
                // Handle password update only if provided
                $passwordUpdate = "";
                if (!empty($data["password"])) {
                    $password = $conn->real_escape_string($data["password"]);
                    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                    $passwordUpdate = ", password = '$hashedPassword'";
                }
            
                // SQL query with conditional password update
                $query = "UPDATE employee 
                        SET first_name = '$first_name', last_name = '$last_name', 
                            age = $age, gender = '$gender', phone = '$phone', 
                            email = '$email', Role = '$role' 
                            $passwordUpdate 
                        WHERE id = $id";
            
                if ($conn->query($query)) {
                    echo json_encode(["message" => "Employee updated successfully"]);
                } else {
                    echo json_encode(["message" => "Error updating employee", "error" => $conn->error]);
                }
            } else {
                echo json_encode(["message" => "Invalid input"]);
            }
        }
        break;      

    case "DELETE":
        global $conn;
        $data = json_decode(file_get_contents("php://input"), true);

        if (isset($data["id"])) {
            $id = intval($data["id"]);
            $query = "DELETE FROM employee WHERE id = $id";

            if ($conn->query($query)) {
                echo json_encode(["message" => "Employee deleted successfully"]);
            } else {
                echo json_encode(["message" => "Error deleting employee"]);
            }
        } else {
            echo json_encode(["message" => "Invalid input"]);
        }
=======

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
>>>>>>> 0a7eec4 (Api for the project)
        break;
}
    



?>