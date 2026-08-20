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
   $pass = $_POST['pass'];
   $cpass = $_POST['cpass'];

   $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE name = ?");
   $select_admin->execute([$name]);
   
   if($select_admin->rowCount() > 0){
      $message[] = 'username already exists!';
   }elseif($pass != $cpass){
      $message[] = 'confirm password not matched!';
   }else{
      $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
      $insert_admin = $conn->prepare("INSERT INTO `admin`(name, password) VALUES(?,?)");
      $insert_admin->execute([$name, $hashed_password]);
      $message[] = 'new admin registered!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>jaybeats admin | register</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- register admin section starts  -->

<section class="form-container" style="min-height: auto;">

   <div class="form-card" style="margin: 0 auto;">
      <h2 class="form-card-title"><i class="fas fa-user-plus" style="color: var(--primary);"></i> Register New Admin</h2>

      <form action="" method="POST">
         <div class="form-group">
            <label>Username</label>
            <input type="text" name="name" maxlength="20" required placeholder="Enter username" class="form-control" oninput="this.value = this.value.replace(/\s/g, '')">
         </div>

         <div class="form-group">
            <label>Password</label>
            <input type="password" name="pass" maxlength="50" required placeholder="Enter password" class="form-control" oninput="this.value = this.value.replace(/\s/g, '')">
         </div>

         <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="cpass" maxlength="50" required placeholder="Confirm password" class="form-control" oninput="this.value = this.value.replace(/\s/g, '')">
         </div>

         <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
            <button type="submit" name="submit" class="btn" style="flex: 1;">
               <i class="fas fa-check"></i> Register Admin
            </button>
            <a href="admin_accounts.php" class="option-btn" style="flex: 1;">
               <i class="fas fa-arrow-left"></i> Go Back
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
