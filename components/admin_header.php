<?php

$current_page = basename($_SERVER['PHP_SELF']);

if(isset($message)){
   foreach($message as $msg){
      echo '
      <div class="message">
         <span>'.htmlspecialchars($msg).'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}

if(!isset($fetch_profile) && !empty($admin_id)){
   $select_profile = $conn->prepare("SELECT * FROM `admin` WHERE id = ?");
   $select_profile->execute([$admin_id]);
   $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
}
?>

<!-- Left Navigation Sidebar -->
<aside class="sidebar" id="sidebar">
   <div class="sidebar-header">
      <a href="dashboard.php" class="sidebar-logo">
         jaybeats<span>ADMIN</span>
      </a>
   </div>

   <nav class="sidebar-menu">
      <span class="sidebar-nav-title">Navigation</span>
      
      <a href="dashboard.php" class="sidebar-link <?= ($current_page == 'dashboard.php') ? 'active' : ''; ?>">
         <i class="fas fa-chart-pie"></i>
         <span>Dashboard</span>
      </a>

      <a href="products.php" class="sidebar-link <?= ($current_page == 'products.php' || $current_page == 'update_product.php') ? 'active' : ''; ?>">
         <i class="fas fa-box-open"></i>
         <span>Products</span>
      </a>

      <a href="placed_orders.php" class="sidebar-link <?= ($current_page == 'placed_orders.php') ? 'active' : ''; ?>">
         <i class="fas fa-shopping-bag"></i>
         <span>Orders</span>
      </a>

      <a href="admin_accounts.php" class="sidebar-link <?= ($current_page == 'admin_accounts.php' || $current_page == 'register_admin.php') ? 'active' : ''; ?>">
         <i class="fas fa-user-shield"></i>
         <span>Admins</span>
      </a>

      <a href="users_accounts.php" class="sidebar-link <?= ($current_page == 'users_accounts.php') ? 'active' : ''; ?>">
         <i class="fas fa-users"></i>
         <span>Users</span>
      </a>

      <a href="messages.php" class="sidebar-link <?= ($current_page == 'messages.php') ? 'active' : ''; ?>">
         <i class="fas fa-envelope"></i>
         <span>Messages</span>
      </a>
   </nav>

   <div class="sidebar-footer">
      &copy; <?= date('Y'); ?> Jaybeats Control Panel
   </div>
</aside>

<!-- Main Workspace Wrapper -->
<div class="main-wrapper">

   <!-- Top App Bar -->
   <header class="top-app-bar">
      <div class="left-section">
         <div id="menu-btn" class="fas fa-bars"></div>
         <h1 class="page-title">
            <?php
               switch($current_page) {
                  case 'dashboard.php': echo 'Dashboard Overview'; break;
                  case 'products.php': echo 'Product Management'; break;
                  case 'update_product.php': echo 'Update Product'; break;
                  case 'placed_orders.php': echo 'Customer Orders'; break;
                  case 'admin_accounts.php': echo 'Admin Accounts'; break;
                  case 'register_admin.php': echo 'Register Admin'; break;
                  case 'users_accounts.php': echo 'User Accounts'; break;
                  case 'messages.php': echo 'Customer Messages'; break;
                  case 'update_profile.php': echo 'Update Profile'; break;
                  default: echo 'Admin Panel';
               }
            ?>
         </h1>
      </div>

      <div class="right-section">
         <div class="admin-avatar-btn" id="user-btn">
            <i class="fas fa-user-circle"></i>
            <span><?= htmlspecialchars($fetch_profile['name'] ?? 'Admin'); ?></span>
            <i class="fas fa-chevron-down" style="font-size: 1.1rem; color: var(--text-muted);"></i>
         </div>

         <div class="profile-dropdown" id="profile-dropdown">
            <div class="profile-dropdown-info">
               <p><?= htmlspecialchars($fetch_profile['name'] ?? 'Admin'); ?></p>
               <span>System Administrator</span>
            </div>
            <a href="update_profile.php" class="btn" style="width: 100%; font-size: 1.3rem; padding: 0.8rem 1.4rem;">
               <i class="fas fa-user-edit"></i> Edit Profile
            </a>
            <a href="register_admin.php" class="option-btn" style="width: 100%; font-size: 1.3rem; padding: 0.8rem 1.4rem;">
               <i class="fas fa-user-plus"></i> Add New Admin
            </a>
            <a href="../components/admin_logout.php" onclick="return confirm('Logout from admin panel?');" class="delete-btn" style="width: 100%; font-size: 1.3rem; padding: 0.8rem 1.4rem;">
               <i class="fas fa-sign-out-alt"></i> Logout
            </a>
         </div>
      </div>
   </header>
