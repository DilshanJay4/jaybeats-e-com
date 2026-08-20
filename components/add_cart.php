<?php

if(isset($_POST['add_to_cart'])){

   if($user_id == ''){
      header('location:login.php');
      exit;
   }else{

      $pid = $_POST['pid'];
      $pid = filter_var($pid, FILTER_SANITIZE_NUMBER_INT);
      $qty = $_POST['qty'];
      $qty = filter_var($qty, FILTER_SANITIZE_NUMBER_INT);
      $qty = ($qty < 1) ? 1 : $qty;

      $select_product = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
      $select_product->execute([$pid]);

      if($select_product->rowCount() > 0){
         $fetch_product = $select_product->fetch(PDO::FETCH_ASSOC);
         $name = $fetch_product['name'];
         $price = $fetch_product['price'];
         $image = $fetch_product['image'];

         $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE pid = ? AND user_id = ?");
         $check_cart_numbers->execute([$pid, $user_id]);

         if($check_cart_numbers->rowCount() > 0){
            $message[] = 'already added to cart!';
         }else{
            $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
            $insert_cart->execute([$user_id, $pid, $name, $price, $qty, $image]);
            $message[] = 'added to cart!';
         }
      }else{
         $message[] = 'product not found!';
      }

   }

}
