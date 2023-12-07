<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

include("../connection.php");

$ProductID = $_POST['ProductID'];


$checkQuery = $mysqli->prepare('SELECT ProductID FROM products WHERE ProductID = ?');
$checkQuery->bind_param('d', $ProductID);
$checkQuery->execute();
$checkResult = $checkQuery->get_result();

if ($checkResult->num_rows > 0) {
    $deleteQuery = $mysqli->prepare('DELETE FROM products WHERE ProductID = ?');
$deleteQuery->bind_param('d', $ProductID);
    $deleteQuery->execute();

    $response = [
        "status" => "true",
        "message" => "Product deleted successfully."
    ];
} else {
    $response = [
        "status" => "false",
        "message" => "Product not found."
    ];
}

echo json_encode($response);
?>