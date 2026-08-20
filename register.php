<?php

session_start();

include 'components/connect.php';

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = htmlspecialchars(strip_tags($name), ENT_QUOTES, 'UTF-8');
   $email = $_POST['email'];
   $email = htmlspecialchars(strip_tags($email), ENT_QUOTES, 'UTF-8');
   $number = $_POST['number'];
   $number = htmlspecialchars(strip_tags($number), ENT_QUOTES, 'UTF-8');
   $pass = $_POST['pass'];
   $cpass = $_POST['cpass'];
   $address = $_POST['address'];
   $address = htmlspecialchars(strip_tags($address), ENT_QUOTES, 'UTF-8');

   if($pass != $cpass){
      $message[] = 'confirm password not matched!';
   }else{

      $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? OR number = ?");
      $select_user->execute([$email, $number]);

      if($select_user->rowCount() > 0){
         $message[] = 'email or number already exists!';
      }else{
         $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

         $insert_user = $conn->prepare("INSERT INTO `users`(name, email, number, password, address) VALUES(?,?,?,?,?)");
         $insert_user->execute([$name, $email, $number, $hashed_password, $address]);

         $select_inserted_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
         $select_inserted_user->execute([$email]);

         if($select_inserted_user->rowCount() > 0){
            $row = $select_inserted_user->fetch(PDO::FETCH_ASSOC);
            $_SESSION['user_id'] = $row['id'];
            header('location:home.php');
            exit;
         }
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
   <title>jaybeats | register</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<section class="form-container">

   <form action="" method="post">
      <h3>register now</h3>
      <input type="text" name="name" required placeholder="enter your name" class="box" maxlength="50">
      <input type="email" name="email" required placeholder="enter your email" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="number" name="number" required placeholder="enter your number" class="box" min="0" max="9999999999" maxlength="10">
      <input type="text" name="address" required placeholder="enter your address" class="box" maxlength="500">
      <input type="password" name="pass" required placeholder="enter your password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="cpass" required placeholder="confirm your password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="register now" name="submit" class="btn">
      <p>already have an account? <a href="login.php">login now</a></p>
   </form>

</section>

<?php include 'components/footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
