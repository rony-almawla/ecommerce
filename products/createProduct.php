<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

include("../connection.php");

$ProductName= $_POST['ProductName'];
$Description = $_POST['Description'];
$Price = $_POST['Price'];

$query = $mysqli->prepare('INSERT INTO products (ProductName, Description, Price) values(?,?,?)');
$query->bind_param('ssd', $ProductName, $Description, $Price);
$query->execute();

$response = [];
$response["status"] = "true";

echo json_encode($response);

?>
