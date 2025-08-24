<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "fooddelivery_db";


$conn = new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
}


if(isset($_GET['action']) && isset($_GET['id'])){
   $action = $_GET['action'];
   $id     = intval($_GET['id']);


   if($action == "add"){
       $conn->query("UPDATE cart_db SET quantity = quantity + 1 WHERE id = $id");
   } elseif($action == "remove"){
    
       $result = $conn->query("SELECT quantity FROM cart_db WHERE id = $id");
       $row = $result->fetch_assoc();
       if($row['quantity'] > 1){
           $conn->query("UPDATE cart_db SET quantity = quantity - 1 WHERE id = $id");
       } else {
           $conn->query("DELETE FROM cart_db WHERE id = $id");
       }
   } elseif($action == "delete"){
       $conn->query("DELETE FROM cart_db WHERE id = $id");
   }
}



header("Location: cart.php");
exit;