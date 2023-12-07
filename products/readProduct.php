<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

include("../connection.php");

$ProductID = $_POST['ProductID'];

$query = $mysqli->prepare('SELECT ProductName, Description, Price FROM products  WHERE ProductID = ?');
$query->bind_param('d', $ProductID);
$query->execute();
$query->store_result();
$query->bind_result($ProductName, $Description, $Price);
$query->fetch();
$response = [];
$response["status"] = "true";
$response["ProductName"]= $ProductName;
$response["Description"]= $Description;
$response["Price"]= $Price;

echo json_encode($response);

?>
