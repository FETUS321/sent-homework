<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fooddelivery_db";


$conn = new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error) {
   die("Connection_failed: " . $conn->connect_error);
}


if(isset($_GET['food_id'])) {
   $food_id = intval($_GET['food_id']);


   $check = $conn->query("SELECT * FROM cart_db WHERE food_id = $food_id");
   if($check->num_rows > 0) {

       $conn->query("UPDATE cart_db SET quantity = quantity + 1 WHERE food_id = $food_id");
   } else {
 
       $conn->query("INSERT INTO cart_db (food_id, quantity) VALUES ($food_id, 1)");
   }


   header('Location: index.php');
   exit();
} else {
   echo "ไม่พบเมนูอาหารที่เลือก";
}
?>

