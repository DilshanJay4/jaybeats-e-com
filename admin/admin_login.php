<?php

session_start();

include '../components/connect.php';

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = htmlspecialchars(strip_tags($name), ENT_QUOTES, 'UTF-8');
   $pass = $_POST['pass'];

   $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE name = ?");
   $select_admin->execute([$name]);

   if($select_admin->rowCount() > 0){
      $fetch_admin = $select_admin->fetch(PDO::FETCH_ASSOC);

      if(password_verify($pass, $fetch_admin['password'])){
         $_SESSION['admin_id'] = $fetch_admin['id'];
         header('location:dashboard.php');
         exit;
      }else{
         $message[] = 'incorrect username or password!';
      }
   }else{
      $message[] = 'incorrect username or password!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>jaybeats admin | login</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body style="background: var(--bg); display: flex; align-items: center; justify-content: center; min-height: 100vh;">

<div style="width: 100%; max-width: 440px; padding: 2rem;">

   <?php
   if(isset($message)){
      foreach($message as $msg){
         echo '
         <div class="message" style="margin: 0 0 2rem 0;">
            <span>'.htmlspecialchars($msg).'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
   ?>

   <div class="form-center-box">
      <div style="text-align: center; margin-bottom: 2rem;">
         <h1 style="font-size: 2.8rem; font-weight: 700; color: var(--text-main);">jaybeats<span style="color: var(--primary); font-size: 1.6rem; margin-left: 0.6rem;">ADMIN</span></h1>
         <p style="font-size: 1.4rem; color: var(--text-muted); margin-top: 0.4rem;">Sign in to access control panel</p>
      </div>

      <form action="" method="POST">
         <div class="form-group">
            <label>Username</label>
            <input type="text" name="name" maxlength="20" required placeholder="Enter username" class="form-control" oninput="this.value = this.value.replace(/\s/g, '')">
         </div>

         <div class="form-group">
            <label>Password</label>
            <input type="password" name="pass" maxlength="50" required placeholder="Enter password" class="form-control" oninput="this.value = this.value.replace(/\s/g, '')">
         </div>

         <button type="submit" name="submit" class="btn" style="width: 100%; margin-top: 1rem; padding: 1.4rem;">
            <i class="fas fa-sign-in-alt"></i> Login Now
         </button>
      </form>
   </div>

</div>

</body>
</html>
