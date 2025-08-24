<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fooddelivery_db";

$conn = new mysql($servername, $username, $password, $dbname);
if($conn->connect_error) {
    die("Connection_failed: " . $conn->connect_error);
}

$category  isset($_POST['category']) ? $_POST['category'] : '';
$sql = "SELECT * FROM menu";
if($category !='') {
    $sql .= "WHERE category ='".$conn->real_esacpe_string($category) : "'";
}

$result = $conn->queery($sql);
?>

