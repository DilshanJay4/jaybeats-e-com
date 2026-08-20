<?php

session_start();

include '../components/connect.php';

$admin_id = $_SESSION['admin_id'] ?? '';

if(empty($admin_id)){
   header('location:admin_login.php');
   exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>jaybeats admin | dashboard</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- admin dashboard section starts  -->

<section class="dashboard">

   <div class="dashboard-grid">

   <div class="metric-card">
      <div class="metric-header">
         <div class="metric-icon"><i class="fas fa-user-circle"></i></div>
         <span class="badge badge-primary">Admin Profile</span>
      </div>
      <div>
         <div class="metric-value"><?= htmlspecialchars($fetch_profile['name'] ?? 'Admin'); ?></div>
         <div class="metric-title">Welcome back!</div>
      </div>
      <div class="metric-footer">
         <a href="update_profile.php" class="metric-link">Update profile <i class="fas fa-arrow-right"></i></a>
      </div>
   </div>

   <div class="metric-card">
      <?php
         $total_pendings = 0;
         $select_pendings = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
         $select_pendings->execute(['pending']);
         while($fetch_pendings = $select_pendings->fetch(PDO::FETCH_ASSOC)){
            $total_pendings += $fetch_pendings['total_price'];
         }
      ?>
      <div class="metric-header">
         <div class="metric-icon" style="background: var(--warning-bg); color: var(--warning-text);"><i class="fas fa-hourglass-half"></i></div>
         <span class="badge badge-pending">Pending</span>
      </div>
      <div>
         <div class="metric-value">$<?= $total_pendings; ?></div>
         <div class="metric-title">Total Pendings</div>
      </div>
      <div class="metric-footer">
         <a href="placed_orders.php" class="metric-link">See orders <i class="fas fa-arrow-right"></i></a>
      </div>
   </div>

   <div class="metric-card">
      <?php
         $total_completes = 0;
         $select_completes = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
         $select_completes->execute(['completed']);
         while($fetch_completes = $select_completes->fetch(PDO::FETCH_ASSOC)){
            $total_completes += $fetch_completes['total_price'];
         }
      ?>
      <div class="metric-header">
         <div class="metric-icon" style="background: var(--success-bg); color: var(--success-text);"><i class="fas fa-check-circle"></i></div>
         <span class="badge badge-completed">Completed</span>
      </div>
      <div>
         <div class="metric-value">$<?= $total_completes; ?></div>
         <div class="metric-title">Completed Orders</div>
      </div>
      <div class="metric-footer">
         <a href="placed_orders.php" class="metric-link">See orders <i class="fas fa-arrow-right"></i></a>
      </div>
   </div>

   <div class="metric-card">
      <?php
         $select_orders = $conn->prepare("SELECT * FROM `orders`");
         $select_orders->execute();
         $numbers_of_orders = $select_orders->rowCount();
      ?>
      <div class="metric-header">
         <div class="metric-icon"><i class="fas fa-shopping-bag"></i></div>
         <span class="badge badge-secondary">All Time</span>
      </div>
      <div>
         <div class="metric-value"><?= $numbers_of_orders; ?></div>
         <div class="metric-title">Total Orders Placed</div>
      </div>
      <div class="metric-footer">
         <a href="placed_orders.php" class="metric-link">Manage orders <i class="fas fa-arrow-right"></i></a>
      </div>
   </div>

   <div class="metric-card">
      <?php
         $select_products = $conn->prepare("SELECT * FROM `products`");
         $select_products->execute();
         $numbers_of_products = $select_products->rowCount();
      ?>
      <div class="metric-header">
         <div class="metric-icon"><i class="fas fa-box-open"></i></div>
         <span class="badge badge-info">Inventory</span>
      </div>
      <div>
         <div class="metric-value"><?= $numbers_of_products; ?></div>
         <div class="metric-title">Products Added</div>
      </div>
      <div class="metric-footer">
         <a href="products.php" class="metric-link">Manage products <i class="fas fa-arrow-right"></i></a>
      </div>
   </div>

   <div class="metric-card">
      <?php
         $select_users = $conn->prepare("SELECT * FROM `users`");
         $select_users->execute();
         $numbers_of_users = $select_users->rowCount();
      ?>
      <div class="metric-header">
         <div class="metric-icon"><i class="fas fa-users"></i></div>
         <span class="badge badge-secondary">Customers</span>
      </div>
      <div>
         <div class="metric-value"><?= $numbers_of_users; ?></div>
         <div class="metric-title">User Accounts</div>
      </div>
      <div class="metric-footer">
         <a href="users_accounts.php" class="metric-link">See user accounts <i class="fas fa-arrow-right"></i></a>
      </div>
   </div>

   <div class="metric-card">
      <?php
         $select_admins = $conn->prepare("SELECT * FROM `admin`");
         $select_admins->execute();
         $numbers_of_admins = $select_admins->rowCount();
      ?>
      <div class="metric-header">
         <div class="metric-icon"><i class="fas fa-user-shield"></i></div>
         <span class="badge badge-primary">Staff</span>
      </div>
      <div>
         <div class="metric-value"><?= $numbers_of_admins; ?></div>
         <div class="metric-title">Admin Accounts</div>
      </div>
      <div class="metric-footer">
         <a href="admin_accounts.php" class="metric-link">See admin accounts <i class="fas fa-arrow-right"></i></a>
      </div>
   </div>

   <div class="metric-card">
      <?php
         $select_messages = $conn->prepare("SELECT * FROM `messages`");
         $select_messages->execute();
         $numbers_of_messages = $select_messages->rowCount();
      ?>
      <div class="metric-header">
         <div class="metric-icon"><i class="fas fa-envelope"></i></div>
         <span class="badge badge-info">Inbox</span>
      </div>
      <div>
         <div class="metric-value"><?= $numbers_of_messages; ?></div>
         <div class="metric-title">Customer Messages</div>
      </div>
      <div class="metric-footer">
         <a href="messages.php" class="metric-link">Read messages <i class="fas fa-arrow-right"></i></a>
      </div>
   </div>

   </div>

</section>

</div> <!-- End .main-wrapper -->

<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>
