<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "fooddelivery_db";


$conn = new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
}


if(!isset($_GET['food_id'])){
   die("ไม่พบเมนูที่เลือก");
}


$food_id = intval($_GET['food_id']);


if($_SERVER['REQUEST_METHOD'] === 'POST'){
   $username = $conn->real_escape_string($_POST['username']);
   $comment  = $conn->real_escape_string($_POST['comment']);
   $rating   = isset($_POST['rating']) ? intval($_POST['rating']) : NULL;


   $sql_insert = "INSERT INTO comments (food_id, username, comment, rating)
                  VALUES ($food_id, '$username', '$comment', " . ($rating ?: "NULL") . ")";
   if($conn->query($sql_insert)){
       header("Location: review.php?food_id=$food_id");
       exit;
   } else {
       echo "<p style='color:red;'>เกิดข้อผิดพลาด: " . $conn->error . "</p>";
   }
}


$sql = "SELECT m.*, ROUND(AVG(c.rating),1) as avg_rating
       FROM menu_db m
       LEFT JOIN comments c ON m.id = c.food_id
       WHERE m.id = $food_id
       GROUP BY m.id";
$result = $conn->query($sql);
if($result->num_rows == 0){
   die("ไม่พบเมนูที่เลือกในฐานข้อมูล");
}
$food = $result->fetch_assoc();


$sql_comments = "SELECT * FROM comments WHERE food_id = $food_id ORDER BY create_at DESC";
$result_comments = $conn->query($sql_comments);


function renderStars($rating){
   $stars = "";
   for($i=1; $i<=5; $i++){
       $stars .= ($i <= $rating) ? "⭐" : "☆";
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
  <link rel="stylesheet" href="review.css">
</head>
<body>

  <nav>
    <h1>
      <a href="index.php">
        <img src="wongnokrmbg.png" alt="brand">
      </a>
    </h1>
    <ul>
      <li class="cart-icon">
        <a href="cart.php">
          <img src="cart2.png" alt="Cart">
        </a>
      </li>
    </ul>
  </nav>

<h2>รายละเอียดสินค้า</h2>
<br>
<div class="food-detail">
   <?php if(!empty($food['image'])): ?>
       <img src="<?= htmlspecialchars($food['image']) ?>" alt="<?= htmlspecialchars($food['food_name']) ?>">
   <?php endif; ?>
   <h3><?= htmlspecialchars($food['food_name']) ?></h3>
   <p>ราคา: <?= htmlspecialchars($food['price']) ?> บาท</p>
   <p>รายละเอียด: <?= nl2br(htmlspecialchars($food['detail'])) ?></p>
   <p>คะแนนเฉลี่ย:
       <?= renderStars(round($food['avg_rating'])) ?>
       (<?= $food['avg_rating'] ?: 0 ?>/5)
   </p>


<br>

<h3>แสดงความคิดเห็น</h3>
<form method="post" class="comment-form">
   <input type="text" name="username" placeholder="ชื่อของคุณ" required>
   <select name="rating" required>
       <option value="">กรุณาเลือกคะแนน</option>
       <option value="5">⭐⭐⭐⭐⭐ (5 ดาว)</option>
       <option value="4">⭐⭐⭐⭐ (4 ดาว)</option>
       <option value="3">⭐⭐⭐ (3 ดาว)</option>
       <option value="2">⭐⭐ (2 ดาว)</option>
       <option value="1">⭐ (1 ดาว)</option>
   </select>
   <textarea name="comment" placeholder="แสดงความคิดเห็น" required></textarea>
   <button type="submit">ส่งความคิดเห็น</button>
</form>

<br>

<h3>ความคิดเห็นล่าสุด</h3>
<div class="comment-list">
   <?php
   if($result_comments->num_rows > 0){
       while($row = $result_comments->fetch_assoc()){
           echo "<div class='comment-box'>";
           echo "<strong>".htmlspecialchars($row['username'])."</strong> ";
           if(!empty($row['rating'])){
               echo renderStars($row['rating']);
           }
           echo " <small>[".$row['create_at']."]</small>";
           echo "<p>".nl2br(htmlspecialchars($row['comment']))."</p>";
           echo "</div>";
       }
   } else {
       echo "<p>ยังไม่มีความคิดเห็น</p>";
   }
   ?>
</div>

</body>
</html>
