<?php

session_start();

include '../components/connect.php';

$admin_id = $_SESSION['admin_id'] ?? '';

if(empty($admin_id)){
   header('location:admin_login.php');
   exit;
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_NUMBER_INT);
   $delete_users = $conn->prepare("DELETE FROM `users` WHERE id = ?");
   $delete_users->execute([$delete_id]);
   $delete_order = $conn->prepare("DELETE FROM `orders` WHERE user_id = ?");
   $delete_order->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart->execute([$delete_id]);
   header('location:users_accounts.php');
   exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>jaybeats admin | users</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- user accounts section starts  -->

<section class="accounts">

   <div class="table-header-bar">
      <h2 class="table-header-title">Customer Accounts</h2>
   </div>

   <div class="table-container">
      <table class="admin-table">
         <thead>
            <tr>
               <th>User ID</th>
               <th>Name</th>
               <th>Email</th>
               <th>Phone Number</th>
               <th>Address</th>
               <th>Actions</th>
            </tr>
         </thead>
         <tbody>
         <?php
            $select_account = $conn->prepare("SELECT * FROM `users` ORDER BY id DESC");
            $select_account->execute();
            if($select_account->rowCount() > 0){
               while($fetch_accounts = $select_account->fetch(PDO::FETCH_ASSOC)){  
         ?>
            <tr>
               <td><strong>#<?= $fetch_accounts['id']; ?></strong></td>
               <td>
                  <div class="user-cell">
                     <span class="name"><i class="fas fa-user-circle" style="color: var(--primary); margin-right: 0.6rem;"></i> <?= htmlspecialchars($fetch_accounts['name']); ?></span>
                  </div>
               </td>
               <td><?= htmlspecialchars($fetch_accounts['email']); ?></td>
               <td><?= htmlspecialchars($fetch_accounts['number']); ?></td>
               <td style="max-width: 300px; font-size: 1.3rem; color: var(--text-muted);"><?= htmlspecialchars($fetch_accounts['address'] ?? 'N/A'); ?></td>
               <td>
                  <a href="users_accounts.php?delete=<?= $fetch_accounts['id']; ?>" class="action-btn delete-btn" onclick="return confirm('Delete this user account and all associated orders/cart items?');">
                     <i class="fas fa-trash"></i> Delete Account
                  </a>
               </td>
            </tr>
         <?php
               }
            }else{
               echo '<tr><td colspan="6" class="empty-table"><i class="fas fa-users"></i>No user accounts available</td></tr>';
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
