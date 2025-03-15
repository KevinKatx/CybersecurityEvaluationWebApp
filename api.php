<?php
error_reporting(E_ALL);
ini_set('display_errors', 1); // Ensure response is JSON
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once("db.php");

$request_method = $_SERVER["REQUEST_METHOD"];

$input = json_decode(file_get_contents('php://input'), true);

switch ($request_method){
    case "GET":
        global $conn;
        $id = isset($_GET["id"]) ? intval($_GET["id"]) : null;

        try {
            if ($id) {
                $query = "SELECT employee.*, evaluation.scoreP1, evaluation.scoreP2
                        FROM employee 
                        LEFT JOIN evaluation ON employee.id = evaluation.employeeID 
                        WHERE employee.id = ? ORDER BY evaluation.date DESC LIMIT 1";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    echo json_encode($result->fetch_assoc());
                } else {
                    echo json_encode(["message" => "Employee not found"]);
                }
            } else {
                $query = "SELECT * FROM employee";
                $result = $conn->query($query);
                $data = [];

                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
                echo json_encode($data);
            }
        } catch (Exception $e) {
            echo json_encode(["error" => $e->getMessage()]);
        }
        break;


    case "POST":
        global $conn;
        $data = json_decode(file_get_contents("php://input"), true);
    
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

            $query = "INSERT INTO employee (first_name, last_name, age, gender, phone, email, role, password) 
                      VALUES ('$first_name', '$last_name', $age, '$gender', '$phone', '$email', 'Employee', '$password')";
            
            if ($conn->query($query)) {
                echo "<script>
                    alert('Employee added successfully!');
                    window.location.href = 'login.php'; // Redirect to login page
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
                isset($data["phone"]) && isset($data["email"]) && isset($data["role"])
            ) {
                $id = intval($data["id"]);
                $first_name = $conn->real_escape_string($data["first_name"]);
                $last_name = $conn->real_escape_string($data["last_name"]);
                $age = intval($data["age"]);
                $gender = $conn->real_escape_string($data["gender"]);
                $phone = $conn->real_escape_string($data["phone"]);
                $email = $conn->real_escape_string($data["email"]);
                $role = $conn->real_escape_string($data["role"]);
            
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
                            email = '$email', role = '$role' 
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
            $id = isset($data["id"]) ? intval($data["id"]) : null;
        
            if (!$id && isset($_GET["id"])) {
                $id = intval($_GET["id"]);
            }
        
            if ($id) {
                // First, delete from the evaluation table
                $query2 = "DELETE FROM evaluation WHERE employeeID = ?";
                $stmt2 = $conn->prepare($query2);
                $stmt2->bind_param("i", $id);
                $stmt2->execute();
                $stmt2->close();
        
                // Then, delete from the employee table
                $query = "DELETE FROM employee WHERE id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $id);
        
                if ($stmt->execute()) {
                    echo json_encode(["success" => true, "message" => "Employee deleted successfully"]);
                } else {
                    echo json_encode(["success" => false, "message" => "Error deleting employee"]);
                }
        
                $stmt->close();
            } else {
                echo json_encode(["success" => false, "message" => "Invalid input"]);
            }
            exit();
        break;
}
    



?>