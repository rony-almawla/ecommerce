<?php
header('Access-Control-Allow-Origin:*');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: *");

include("connection.php");

$Email = $_POST['Email'];
$Password = $_POST['Password'];
$Username = $_POST['Username'];
$UserType = $_POST['UserType'];


$hashed_password = password_hash($Password, PASSWORD_DEFAULT);

$query = $mysqli->prepare('INSERT INTO users (Email,Password,Username,UserType) values(?,?,?,?)');
$query->bind_param('ssss', $Email, $hashed_password, $Username, $UserType);

$response = [];

if ($query->execute()) {
    $response["status"] = "true";
} else {
    $response["status"] = "false";
    $response["error"] = $mysqli->error;
}

echo json_encode($response);

$query->close();
$mysqli->close();
?>