<?php
header('Access-Control-Allow-Origin:*');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: *");
include("connection.php");
require 'vendor/autoload.php';

use \Firebase\JWT\JWT;

$Email = $_POST['Email'];
$Password = $_POST['Password'];

$query = $mysqli->prepare('SELECT UserID, UserType, Password FROM users WHERE Email = ?');
$query->bind_param('s', $Email);

$response = [];

if ($query->execute()) {
    $query->store_result();

    if ($query->num_rows == 0) {
        $response['status'] = 'user not found';
    } else {
        $query->bind_result($UserID, $UserType, $hashed_password);
        $query->fetch();

        if (Password_verify($Password, $hashed_password)) {
            $key = "your_secret";
            $payload_array = [];
            $payload_array["user_id"] = $UserID;
            $payload_array["usertype"] = $UserType;
            $payload_array["exp"] = time() + 3600;
            $payload = $payload_array;
            $response['status'] = 'logged in';
            $response['jwt'] = JWT::encode($payload, $key, 'HS256');
            $response['UserType'] = $UserType;
            $response['user_id'] = $UserID;
            $response['Email'] = $Email;
        } else {
            $response['status'] = 'wrong credentials';
        }
    }
} else {
    $response['status'] = 'false';
    $response['error'] = $mysqli->error;
}

echo json_encode($response);


$query->close();
$mysqli->close();
?>