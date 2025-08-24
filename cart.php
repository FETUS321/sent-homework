<?php
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
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ร้านขายอาหาร</title>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="cart.css">
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

<h2>ตะกร้าของคุณ</h2>

<div class="table-container">
  <table>
    <thead>
      <tr>
         <th>ชื่ออาหาร</th>
         <th>ราคา</th>
         <th>จำนวน</th>
         <th>รวม</th>
         <th>จัดการ</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $total = 0;
      if($result->num_rows > 0){
          while($row = $result->fetch_assoc()){
              $sum = $row['price'] * $row['quantity'];
              $total += $sum;
              echo "<tr>
                      <td>".$row['food_name']."</td>
                      <td>".$row['price']."</td>
                      <td>".$row['quantity']."</td>
                      <td>".$sum."</td>
                      <td>
                          <a href='update_cart.php?action=add&id=".$row['id']."'> + </a>
                          <a href='update_cart.php?action=remove&id=".$row['id']."'> - </a>
                          <a href='update_cart.php?action=delete&id=".$row['id']."' onclick=\"return confirm('ลบเมนูนี้หรือไม่')\"> ลบ </a>
                      </td>
                    </tr>";
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

          echo "<tr>
                  <td colspan='4' align='right'><strong>รวมทั้งหมด</strong></td>
                  <td class='total'><strong>".number_format($total,2)." บาท</strong></td>
                </tr>";

          echo "<tr>
                  <td colspan='4' align='right'><strong>ส่วนลด</strong></td>
                  <td class='discount'><strong>".number_format($discount,2)." บาท</strong></td>
                </tr>";

          echo "<tr>
                  <td colspan='4' align='right'><strong>ราคาสุทธิ</strong></td>
                  <td class='final'><strong>".number_format($final_total,2)." บาท</strong></td>
                </tr>";

      } else {
          echo "<tr><td colspan='5'>ไม่มีสินค้าในตะกร้า</td></tr>";
      }
      ?>
    </tbody>
  </table>
</div>

<?php if($result->num_rows > 0){ ?>
<div class="checkout-button">
  <form action="checkout.php" method="post">
    <button type="submit">
      <img src="checkout.gif" alt="checkout">
    </button>
  </form>
</div>
<?php } ?>

</body>
</html>
