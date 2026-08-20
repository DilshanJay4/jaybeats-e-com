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
   $delete_admin = $conn->prepare("DELETE FROM `admin` WHERE id = ?");
   $delete_admin->execute([$delete_id]);
   header('location:admin_accounts.php');
   exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>jaybeats admin | admins</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- admins accounts section starts  -->

<section class="accounts">

   <div class="table-header-bar">
      <h2 class="table-header-title">Admin Accounts</h2>
      <a href="register_admin.php" class="btn">
         <i class="fas fa-user-plus"></i> Register New Admin
      </a>
   </div>

   <div class="table-container">
      <table class="admin-table">
         <thead>
            <tr>
               <th>Admin ID</th>
               <th>Username</th>
               <th>Role / Status</th>
               <th>Actions</th>
            </tr>
         </thead>
         <tbody>
         <?php
            $select_account = $conn->prepare("SELECT * FROM `admin` ORDER BY id ASC");
            $select_account->execute();
            if($select_account->rowCount() > 0){
               while($fetch_accounts = $select_account->fetch(PDO::FETCH_ASSOC)){  
         ?>
            <tr>
               <td><strong>#<?= $fetch_accounts['id']; ?></strong></td>
               <td>
                  <div class="user-cell">
                     <span class="name"><i class="fas fa-user-shield" style="color: var(--primary); margin-right: 0.6rem;"></i> <?= htmlspecialchars($fetch_accounts['name']); ?></span>
                  </div>
               </td>
               <td>
                  <?php if($fetch_accounts['id'] == $admin_id){ ?>
                     <span class="badge badge-primary"><i class="fas fa-check-circle" style="margin-right: 0.4rem;"></i> Current Account</span>
                  <?php } else { ?>
                     <span class="badge badge-secondary">Administrator</span>
                  <?php } ?>
               </td>
               <td>
                  <div class="table-actions">
                     <?php if($fetch_accounts['id'] == $admin_id){ ?>
                        <a href="update_profile.php" class="action-btn edit-btn">
                           <i class="fas fa-user-edit"></i> Edit Profile
                        </a>
                     <?php } ?>
                     <a href="admin_accounts.php?delete=<?= $fetch_accounts['id']; ?>" class="action-btn delete-btn" onclick="return confirm('Delete this admin account?');">
                        <i class="fas fa-trash"></i> Delete
                     </a>
                  </div>
               </td>
            </tr>
         <?php
               }
            }else{
               echo '<tr><td colspan="4" class="empty-table"><i class="fas fa-user-shield"></i>No admin accounts available</td></tr>';
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
