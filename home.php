<?php

session_start();

include 'components/connect.php';

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/add_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>jaybeats | home</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>



<section class="hero">

   <div class="swiper hero-slider">

      <div class="swiper-wrapper">

         <div class="swiper-slide slide">
            <div class="content">
               <span>premium audio</span>
               <h3>wireless headphones</h3>
               <a href="menu.php" class="btn">shop now</a>
            </div>
            <div class="image">
               <img src="uploaded_img/1.JBL_TUNE_710BT_Product Image_Hero_White.webp" alt="">
            </div>
         </div>

         <div class="swiper-slide slide">
            <div class="content">
               <span>pure sound</span>
               <h3>noise cancelling</h3>
               <a href="menu.php" class="btn">shop now</a>
            </div>
            <div class="image">
               <img src="uploaded_img/1.JBL_TUNE_760NC_Product Image_Hero_Blue.webp" alt="">
            </div>
         </div>

         <div class="swiper-slide slide">
            <div class="content">
               <span>game louder</span>
               <h3>gaming headsets</h3>
               <a href="menu.php" class="btn">shop now</a>
            </div>
            <div class="image">
               <img src="uploaded_img/1.JBL_TUNE_710BT_Product Image_Hero_White.webp" alt="">
            </div>
         </div>

      </div>

      <div class="swiper-pagination"></div>

   </div>

</section>

<section class="category">

   <h1 class="title">product categories</h1>

   <div class="box-container">

      <a href="category.php?category=Headphones" class="box">
         <i class="fas fa-headphones"></i>
         <h3>headphones</h3>
      </a>

      <a href="category.php?category=Earbuds" class="box">
         <i class="fas fa-headset"></i>
         <h3>earbuds</h3>
      </a>

      <a href="category.php?category=Wireless" class="box">
         <i class="fas fa-wifi"></i>
         <h3>wireless</h3>
      </a>

      <a href="category.php?category=Gaming" class="box">
         <i class="fas fa-gamepad"></i>
         <h3>gaming</h3>
      </a>

      <a href="category.php?category=Speakers" class="box">
         <i class="fas fa-volume-high"></i>
         <h3>speakers</h3>
      </a>

      <a href="category.php?category=Accessories" class="box">
         <i class="fas fa-plug"></i>
         <h3>accessories</h3>
      </a>

   </div>

</section>




<section class="products">

   <h1 class="title">latest products</h1>

   <div class="box-container">

      <?php
         $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 6");
         $select_products->execute();
         if($select_products->rowCount() > 0){
            while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
      ?>
      <form action="" method="post" class="box">
         <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
         <a href="quick_view.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
         <button type="submit" class="fas fa-shopping-cart" name="add_to_cart"></button>
         <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
         <a href="category.php?category=<?= $fetch_products['category']; ?>" class="cat"><?= htmlspecialchars($fetch_products['category']); ?></a>
         <div class="name"><?= htmlspecialchars($fetch_products['name']); ?></div>
         <div class="flex">
            <div class="price"><span>$</span><?= $fetch_products['price']; ?></div>
            <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">
         </div>
      </form>
      <?php
            }
         }else{
            echo '<p class="empty">no products added yet!</p>';
         }
      ?>

   </div>

   <div class="more-btn">
      <a href="menu.php" class="btn">view all</a>
   </div>

</section>










<?php include 'components/footer.php'; ?>


<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".hero-slider", {
   loop:true,
   grabCursor: true,
   effect: "flip",
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
});

</script>

</body>
</html>
