<?php

session_start();

include '../components/connect.php';

$admin_id = $_SESSION['admin_id'] ?? '';

if(empty($admin_id)){
   header('location:admin_login.php');
   exit;
}

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = htmlspecialchars(strip_tags($name), ENT_QUOTES, 'UTF-8');

   if(!empty($name)){
      $select_name = $conn->prepare("SELECT * FROM `admin` WHERE name = ? AND id != ?");
      $select_name->execute([$name, $admin_id]);
      if($select_name->rowCount() > 0){
         $message[] = 'username already taken!';
      }else{
         $update_name = $conn->prepare("UPDATE `admin` SET name = ? WHERE id = ?");
         $update_name->execute([$name, $admin_id]);
         $message[] = 'username updated successfully!';
      }
   }

   $old_pass = $_POST['old_pass'];
   $new_pass = $_POST['new_pass'];
   $confirm_pass = $_POST['confirm_pass'];

   if(!empty($old_pass)){

      $select_old_pass = $conn->prepare("SELECT password FROM `admin` WHERE id = ?");
      $select_old_pass->execute([$admin_id]);
      $fetch_prev_pass = $select_old_pass->fetch(PDO::FETCH_ASSOC);
      $prev_pass = $fetch_prev_pass['password'];

      if(!password_verify($old_pass, $prev_pass)){
         $message[] = 'old password not matched!';
      }elseif($new_pass != $confirm_pass){
         $message[] = 'confirm password not matched!';
      }elseif(!empty($new_pass)){
         $update_pass = $conn->prepare("UPDATE `admin` SET password = ? WHERE id = ?");
         $update_pass->execute([password_hash($new_pass, PASSWORD_DEFAULT), $admin_id]);
         $message[] = 'password updated successfully!';
      }else{
         $message[] = 'please enter a new password!';
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
   <title>jaybeats admin | update profile</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- admin profile update section starts  -->

<section class="form-container" style="min-height: auto;">

   <div class="form-card" style="margin: 0 auto;">
      <h2 class="form-card-title"><i class="fas fa-user-edit" style="color: var(--primary);"></i> Update Profile</h2>

      <form action="" method="POST">
         <div class="form-group">
            <label>Username</label>
            <input type="text" name="name" maxlength="20" class="form-control" oninput="this.value = this.value.replace(/\s/g, '')" value="<?= htmlspecialchars($fetch_profile['name'] ?? ''); ?>" placeholder="Enter new username">
         </div>

         <div class="form-group">
            <label>Old Password</label>
            <input type="password" name="old_pass" maxlength="50" placeholder="Enter old password" class="form-control" oninput="this.value = this.value.replace(/\s/g, '')">
         </div>

         <div class="form-group">
            <label>New Password</label>
            <input type="password" name="new_pass" maxlength="50" placeholder="Enter new password" class="form-control" oninput="this.value = this.value.replace(/\s/g, '')">
         </div>

         <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="confirm_pass" maxlength="50" placeholder="Confirm new password" class="form-control" oninput="this.value = this.value.replace(/\s/g, '')">
         </div>

         <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
            <button type="submit" name="submit" class="btn" style="flex: 1;">
               <i class="fas fa-save"></i> Save Changes
            </button>
            <a href="dashboard.php" class="option-btn" style="flex: 1;">
               <i class="fas fa-arrow-left"></i> Dashboard
            </a>
         </div>
      </form>
   </div>

</section>

</div> <!-- End .main-wrapper -->

<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>
