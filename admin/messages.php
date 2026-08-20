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
   $delete_message = $conn->prepare("DELETE FROM `messages` WHERE id = ?");
   $delete_message->execute([$delete_id]);
   header('location:messages.php');
   exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>jaybeats admin | messages</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- messages section starts  -->

<section class="messages">

   <div class="table-header-bar">
      <h2 class="table-header-title">Customer Messages</h2>
   </div>

   <div class="table-container">
      <table class="admin-table">
         <thead>
            <tr>
               <th>Msg ID</th>
               <th>Sender Name</th>
               <th>Contact Details</th>
               <th>Message Content</th>
               <th>Actions</th>
            </tr>
         </thead>
         <tbody>
         <?php
            $select_messages = $conn->prepare("SELECT * FROM `messages` ORDER BY id DESC");
            $select_messages->execute();
            if($select_messages->rowCount() > 0){
               while($fetch_messages = $select_messages->fetch(PDO::FETCH_ASSOC)){
         ?>
            <tr>
               <td><strong>#<?= $fetch_messages['id']; ?></strong></td>
               <td>
                  <div class="user-cell">
                     <span class="name"><?= htmlspecialchars($fetch_messages['name']); ?></span>
                     <span class="sub">User ID: <?= $fetch_messages['user_id']; ?></span>
                  </div>
               </td>
               <td>
                  <div class="contact-cell">
                     <div><i class="fas fa-envelope"></i> <?= htmlspecialchars($fetch_messages['email']); ?></div>
                     <div><i class="fas fa-phone"></i> <?= htmlspecialchars($fetch_messages['number']); ?></div>
                  </div>
               </td>
               <td>
                  <div class="message-text"><?= htmlspecialchars($fetch_messages['message']); ?></div>
               </td>
               <td>
                  <a href="messages.php?delete=<?= $fetch_messages['id']; ?>" class="action-btn delete-btn" onclick="return confirm('Delete this message?');">
                     <i class="fas fa-trash"></i> Delete
                  </a>
               </td>
            </tr>
         <?php
               }
            }else{
               echo '<tr><td colspan="5" class="empty-table"><i class="fas fa-envelope-open"></i>You have no messages yet</td></tr>';
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
