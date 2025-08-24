<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "fooddelivery_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT c.id, m.food_name, m.price, c.quantity
        FROM cart_db c
        JOIN menu_db m ON c.food_id = m.id";
$result = $conn->query($sql);

$total = 0;
$order_items = [];

if($result && $result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $sum = $row['price'] * $row['quantity'];
        $total += $sum;

        $order_items[] = [
            'food_name' => $row['food_name'],
            'price' => $row['price'],
            'quantity' => $row['quantity'],
            'sum' => $sum
        ];
    }

    $discount = 0;
    if ($total > 150 && $total <= 200) {
        $discount = $total * 0.03;
    } elseif ($total > 200 && $total <= 300) {
        $discount = $total * 0.05;
    } elseif ($total > 300) {
        $discount = $total * 0.10;
    }
    $final_total = $total - $discount;

    $stmt = $conn->prepare("INSERT INTO orders (total, discount, final_total, order_date) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("ddd", $total, $discount, $final_total);
    $stmt->execute();
    $order_id = $stmt->insert_id;
    $stmt->close();

    $stmt2 = $conn->prepare("INSERT INTO order_items (order_id, food_name, price, quantity) VALUES (?, ?, ?, ?)");
foreach($order_items as $item){
    $stmt2->bind_param("isdi", $order_id, $item['food_name'], $item['price'], $item['quantity']);
    $stmt2->execute();
}
    $stmt2->close();

    $conn->query("DELETE FROM cart_db");

} else {
    $total = 0;
    $discount = 0;
    $final_total = 0;
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ร้านขายอาหาร</title>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="checkout.css">
</head>
<body>

<nav>
  <h1><a href="index.php"><img src="wongnokrmbg.png" alt="brand"></a></h1>
  <ul>
    <li class="cart-icon">
      <a href="cart.php">
        <img src="cart2.png" alt="Cart">
      </a>
    </li>
  </ul>
</nav>

<h2>คำสั่งซื้อของคุณ สำเร็จ!!!</h2>

<div class="table-container">
  <table>
     <thead>
       <tr>
           <th>ชื่ออาหาร</th>
           <th>ราคา</th>
           <th>จำนวน</th>
           <th>รวม</th>
       </tr>
     </thead>
     <tbody>
     <?php
     if(count($order_items) > 0){
         foreach($order_items as $item){
             echo "<tr>
                     <td>".$item['food_name']."</td>
                     <td>".number_format($item['price'],2)." บาท</td>
                     <td>".$item['quantity']." รายการ</td>
                     <td>".number_format($item['sum'],2)." บาท</td>
                   </tr>";
         }

         echo "<tr>
                <td colspan='3' align='right'><strong>รวมทั้งหมด</strong></td>
                <td class='total'><strong>".number_format($total,2)." บาท</strong></td>
              </tr>";

         echo "<tr>
                <td colspan='3' align='right'><strong>ส่วนลด</strong></td>
                <td class='discount'><strong>".number_format($discount,2)." บาท</strong></td>
              </tr>";

         echo "<tr>
                <td colspan='3' align='right'><strong>ราคาสุทธิ</strong></td>
                <td class='final'><strong>".number_format($final_total,2)." บาท</strong></td>
              </tr>";

     } else {
         echo "<tr><td colspan='4'>ไม่มีสินค้าในตะกร้า</td></tr>";
     }
     ?>
     </tbody>
  </table>
</div>

<div class="back-button">
  <a href="index.php">
    <img src="backicon.png" alt="back">
  </a>
</div>

</body>
</html>
