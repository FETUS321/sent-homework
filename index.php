<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "fooddelivery_db";


$conn = new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error) {
   die("Connection_failed: " . $conn->connect_error);
}


$category = isset($_POST['category']) ? $_POST['category'] : '';
$sql = "SELECT m.*, COALESCE(ROUND(AVG(c.rating)),0) AS avg_rating
       FROM menu_db m
       LEFT JOIN comments c ON m.id = c.food_id";


if($category != '') {
   $sql .= " WHERE m.category = '" . $conn->real_escape_string($category) . "'";
}
$sql .= " GROUP BY m.id";


$result = $conn->query($sql);


function showStars($rating){
   $stars = "";
   for($i=1;$i<=5;$i++){
       if($i <= $rating){
           $stars .= "⭐";
       } else {
           $stars .= "☆";
       }
   }
   return $stars;
}

?>



<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ร้านขายอาหาร</title>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="index.css">
</head>
<body>

  <nav>
    <h1><a href="index.php">          <img src="wongnokrmbg.png" alt="brand"></a>
        </h1>
    <ul>
      <li>
        <ul>

        </ul>
      </li>

<form method="post">
   <select name="category" onchange="this.form.submit()">
       <option value="">เลือกเมนูอาหาร</option>
       <option value="ข้าว" <?= $category =='ข้าว'?'selected':''?>>เมนูข้าว</option>
       <option value="ของทอด" <?= $category =='ของทอด'?'selected':''?>>เมนูของทอด</option>
       <option value="ยำ" <?= $category =='ยำ'?'selected':''?>>เมนูยำ</option>
   </select>
</form>









      <li class="cart-icon">
        <a href="cart.php">
          <img src="cart2.png" alt="Cart">
        </a>
      </li>
    </ul>
  </nav>



<section class="hero">
  <video autoplay muted loop class="hero-video">
    <source src="preview.mp4" type="video/mp4">
    เบราว์เซอร์ของคุณไม่รองรับวิดีโอ
  </video>
</section>


<br>

  <main>
    <h2>ยินดีต้อนรับเข้าสู่ร้านอาหารของครูบีการันตีโดยวงนอก</h2>
    <p>นี่แหละร้านอาหารที่อร่อยที่สุดในโลก</p>
  </main>

<br>

<div class="card-container">
    <?php
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo "<div class='card'>
                    <div class='image'><img src='img.jpg' alt=''></div>
                    <div class='food-name'>".$row['food_name']."</div>
                    <div class='price'>".$row['price']." บาท</div>
                    <div class='rating'>".showStars($row['avg_rating'])."</div>
                    <div class='card-actions'>
                        <a href='add_to_cart.php?food_id=".$row['id']."' class='cart-btn'>
                            <img src='cart2.png' alt='เพิ่มลงตะกร้า'>
                        </a>
                        <a href='review.php?food_id=".$row['id']."' class='detail-btn'>รายละเอียด</a>
                    </div>
                  </div>";
                 
        }
    } else {
        echo "<p>ไม่มีข้อมูล</p>";
    }
    ?>


</div>




</body>
</html>
