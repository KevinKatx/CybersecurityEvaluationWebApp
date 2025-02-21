<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once("db.php");

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method){
    case "GET":
        if (!empty($_GET["id"])) {
            global $conn;
            $query = "SELECT * FROM employee WHERE id = $id";
            $result = $conn->query($query);
            
            if ($result->num_rows > 0) {
                echo json_encode($result->fetch_assoc());
            } else {
                echo json_encode(["message" => "Employee not found"]);
            }
        } else {
            global $conn;
            $query = "SELECT * FROM employee";
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
    
        if (
            isset($data["first_name"]) && isset($data["last_name"]) &&
            isset($data["age"]) && isset($data["gender"]) &&
            isset($data["phone"]) && isset($data["email"])
        ) {
            $first_name = $conn->real_escape_string($data["first_name"]);
            $last_name = $conn->real_escape_string($data["last_name"]);
            $age = intval($data["age"]);
            $gender = $conn->real_escape_string($data["gender"]);
            $phone = $conn->real_escape_string($data["phone"]);
            $email = $conn->real_escape_string($data["email"]);
            $password = password_hash($data["password"], PASSWORD_DEFAULT);

            $query = "INSERT INTO employee (first_name, last_name, age, gender, phone, email, password) 
                      VALUES ('$first_name', '$last_name', $age, '$gender', '$phone', '$email', '$password')";
            
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
        global $conn;
        $data = json_decode(file_get_contents("php://input"), true);

        if (
            isset($data["id"]) && isset($data["first_name"]) && isset($data["last_name"]) &&
            isset($data["age"]) && isset($data["gender"]) &&
            isset($data["phone"]) && isset($data["email"])
        ) {
            $id = intval($data["id"]);
            $first_name = $conn->real_escape_string($data["first_name"]);
            $last_name = $conn->real_escape_string($data["last_name"]);
            $age = intval($data["age"]);
            $gender = $conn->real_escape_string($data["gender"]);
            $phone = $conn->real_escape_string($data["phone"]);
            $email = $conn->real_escape_string($data["email"]);
            $password = password_hash($data["password"], PASSWORD_DEFAULT);
            $query = "UPDATE employee 
                    SET first_name = '$first_name', last_name = '$last_name', 
                        age = $age, gender = '$gender', phone = '$phone', email = '$email', password = '$password'
                    WHERE id = $id";
            
            if ($conn->query($query)) {
                echo json_encode(["message" => "Employee updated successfully"]);
            } else {
                echo json_encode(["message" => "Error updating employee"]);
            }
        } else {
            echo json_encode(["message" => "Invalid input"]);
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
        break;
}
    



?>