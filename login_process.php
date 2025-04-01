<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include 'db.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"));
    $email = $data->email;
    $password = $data->password;

    $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo json_encode(["status" => "success", "message" => "Login Successful"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid Credentials"]);
    }
}
?>
