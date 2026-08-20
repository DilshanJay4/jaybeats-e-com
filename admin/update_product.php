<?php

session_start();

include '../components/connect.php';

$admin_id = $_SESSION['admin_id'] ?? '';

if(empty($admin_id)){
   header('location:admin_login.php');
   exit;
}

if(isset($_POST['update'])){

   $pid = $_POST['pid'];
   $pid = filter_var($pid, FILTER_SANITIZE_NUMBER_INT);
   $name = $_POST['name'];
   $name = htmlspecialchars(strip_tags($name), ENT_QUOTES, 'UTF-8');
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_NUMBER_INT);
   $category = $_POST['category'];
   $category = htmlspecialchars(strip_tags($category), ENT_QUOTES, 'UTF-8');

   $update_product = $conn->prepare("UPDATE `products` SET name = ?, category = ?, price = ? WHERE id = ?");
   $update_product->execute([$name, $category, $price, $pid]);

   $message[] = 'product updated!';

   $old_image = $_POST['old_image'];
   $image = $_FILES['image']['name'];
   $image = htmlspecialchars(strip_tags($image), ENT_QUOTES, 'UTF-8');
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_img/'.$image;

   if(!empty($image)){
      if($image_size > 2000000){
         $message[] = 'images size is too large!';
      }else{
         $update_image = $conn->prepare("UPDATE `products` SET image = ? WHERE id = ?");
         $update_image->execute([$image, $pid]);
         move_uploaded_file($image_tmp_name, $image_folder);
         if(!empty($old_image)){
            @unlink('../uploaded_img/'.$old_image);
         }
         $message[] = 'image updated!';
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>jaybeats admin | update product</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- update product section starts  -->

<section class="update-product">

   <?php
      $update_id = $_GET['update'] ?? 0;
      $update_id = filter_var($update_id, FILTER_SANITIZE_NUMBER_INT);
      $show_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
      $show_products->execute([$update_id]);
      if($show_products->rowCount() > 0){
         while($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)){  
   ?>
   <div class="form-card" style="margin: 0 auto;">
      <h2 class="form-card-title"><i class="fas fa-edit" style="color: var(--primary);"></i> Update Product #<?= $fetch_products['id']; ?></h2>

      <form action="" method="POST" enctype="multipart/form-data">
         <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
         <input type="hidden" name="old_image" value="<?= htmlspecialchars($fetch_products['image']); ?>">

         <div style="text-align: center; margin-bottom: 2rem;">
            <img src="../uploaded_img/<?= htmlspecialchars($fetch_products['image']); ?>" alt="" style="width: 140px; height: 140px; object-fit: contain; background: #f8fafc; border-radius: var(--radius-sm); padding: 1rem; border: 1px solid var(--border);">
         </div>

         <div class="form-group">
            <label>Product Name</label>
            <input type="text" required placeholder="Enter product name" name="name" maxlength="100" class="form-control" value="<?= htmlspecialchars($fetch_products['name']); ?>">
         </div>

         <div class="form-grid">
            <div class="form-group">
               <label>Price ($ USD)</label>
               <input type="number" min="0" max="9999999999" required placeholder="Enter price" name="price" onkeypress="if(this.value.length == 10) return false;" class="form-control" value="<?= $fetch_products['price']; ?>">
            </div>

            <div class="form-group">
               <label>Category</label>
               <select name="category" class="form-control" required>
                  <option selected value="<?= htmlspecialchars($fetch_products['category']); ?>"><?= htmlspecialchars($fetch_products['category']); ?></option>
                  <option value="Headphones">Headphones</option>
                  <option value="Earbuds">Earbuds</option>
                  <option value="Wireless">Wireless</option>
                  <option value="Gaming">Gaming</option>
                  <option value="Speakers">Speakers</option>
                  <option value="Accessories">Accessories</option>
               </select>
            </div>
         </div>

         <div class="form-group">
            <label>Update Image (Optional)</label>
            <input type="file" name="image" class="form-control" accept="image/jpg, image/jpeg, image/png, image/webp">
         </div>

         <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
            <button type="submit" name="update" class="btn" style="flex: 1;">
               <i class="fas fa-save"></i> Save Changes
            </button>
            <a href="products.php" class="option-btn" style="flex: 1;">
               <i class="fas fa-arrow-left"></i> Go Back
            </a>
         </div>
      </form>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty-table"><i class="fas fa-exclamation-triangle"></i>Product not found!</p>';
      }
   ?>

</section>

</div> <!-- End .main-wrapper -->

<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>
