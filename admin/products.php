<?php

session_start();

include '../components/connect.php';

$admin_id = $_SESSION['admin_id'] ?? '';

if(empty($admin_id)){
   header('location:admin_login.php');
   exit;
}

if(isset($_POST['add_product'])){

   $name = $_POST['name'];
   $name = htmlspecialchars(strip_tags($name), ENT_QUOTES, 'UTF-8');
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_NUMBER_INT);
   $category = $_POST['category'];
   $category = htmlspecialchars(strip_tags($category), ENT_QUOTES, 'UTF-8');

   $image = $_FILES['image']['name'];
   $image = htmlspecialchars(strip_tags($image), ENT_QUOTES, 'UTF-8');
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_img/'.$image;

   $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
   $select_products->execute([$name]);

   if($select_products->rowCount() > 0){
      $message[] = 'product name already exists!';
   }else{
      if($image_size > 2000000){
         $message[] = 'image size is too large';
      }else{
         move_uploaded_file($image_tmp_name, $image_folder);

         $insert_product = $conn->prepare("INSERT INTO `products`(name, category, price, image) VALUES(?,?,?,?)");
         $insert_product->execute([$name, $category, $price, $image]);

         $message[] = 'new product added!';
      }

   }

}

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_NUMBER_INT);
   $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
   $delete_product_image->execute([$delete_id]);
   $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
   if($fetch_delete_image && !empty($fetch_delete_image['image'])){
      @unlink('../uploaded_img/'.$fetch_delete_image['image']);
   }
   $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
   $delete_product->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
   $delete_cart->execute([$delete_id]);
   header('location:products.php');
   exit;

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>jaybeats admin | products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- add products section starts  -->

<section class="add-products">

   <div class="form-card">
      <h2 class="form-card-title"><i class="fas fa-plus-circle" style="color: var(--primary);"></i> Add New Product</h2>
      
      <form action="" method="POST" enctype="multipart/form-data">
         <div class="form-group">
            <label>Product Name</label>
            <input type="text" required placeholder="Enter product name" name="name" maxlength="100" class="form-control">
         </div>

         <div class="form-grid">
            <div class="form-group">
               <label>Price ($ USD)</label>
               <input type="number" min="0" max="9999999999" required placeholder="Enter price" name="price" onkeypress="if(this.value.length == 10) return false;" class="form-control">
            </div>

            <div class="form-group">
               <label>Category</label>
               <select name="category" class="form-control" required>
                  <option value="" disabled selected>Select category --</option>
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
            <label>Product Image</label>
            <input type="file" name="image" class="form-control" accept="image/jpg, image/jpeg, image/png, image/webp" required>
         </div>

         <button type="submit" name="add_product" class="btn" style="margin-top: 1rem;">
            <i class="fas fa-save"></i> Add Product
         </button>
      </form>
   </div>

</section>

<!-- show products section starts  -->

<section class="show-products" style="padding-top: 0;">

   <div class="table-header-bar">
      <h2 class="table-header-title">Product Inventory</h2>
   </div>

   <div class="table-container">
      <table class="admin-table">
         <thead>
            <tr>
               <th>Preview</th>
               <th>Product Name</th>
               <th>Category</th>
               <th>Price</th>
               <th>Actions</th>
            </tr>
         </thead>
         <tbody>
         <?php
            $show_products = $conn->prepare("SELECT * FROM `products` ORDER BY id DESC");
            $show_products->execute();
            if($show_products->rowCount() > 0){
               while($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)){  
         ?>
            <tr>
               <td>
                  <img src="../uploaded_img/<?= htmlspecialchars($fetch_products['image']); ?>" alt="" class="table-thumb">
               </td>
               <td style="font-weight: 600;"><?= htmlspecialchars($fetch_products['name']); ?></td>
               <td>
                  <span class="badge badge-category"><?= htmlspecialchars($fetch_products['category']); ?></span>
               </td>
               <td class="price-text">$<?= $fetch_products['price']; ?></td>
               <td>
                  <div class="table-actions">
                     <a href="update_product.php?update=<?= $fetch_products['id']; ?>" class="action-btn edit-btn">
                        <i class="fas fa-edit"></i> Edit
                     </a>
                     <a href="products.php?delete=<?= $fetch_products['id']; ?>" class="action-btn delete-btn" onclick="return confirm('Delete this product?');">
                        <i class="fas fa-trash"></i> Delete
                     </a>
                  </div>
               </td>
            </tr>
         <?php
               }
            }else{
               echo '<tr><td colspan="5" class="empty-table"><i class="fas fa-box-open"></i>No products added yet!</td></tr>';
            }
         ?>
         </tbody>
      </table>
   </div>

</section>

</div> <!-- End .main-wrapper -->

<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>
