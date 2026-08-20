<?php

session_start();

include '../components/connect.php';

$admin_id = $_SESSION['admin_id'] ?? '';

if(empty($admin_id)){
   header('location:admin_login.php');
   exit;
}

if(isset($_POST['update_payment'])){

   $order_id = $_POST['order_id'];
   $order_id = filter_var($order_id, FILTER_SANITIZE_NUMBER_INT);
   $payment_status = $_POST['payment_status'];
   $payment_status = htmlspecialchars(strip_tags($payment_status), ENT_QUOTES, 'UTF-8');
   $update_status = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
   $update_status->execute([$payment_status, $order_id]);
   $message[] = 'payment status updated!';

}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_NUMBER_INT);
   $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
   $delete_order->execute([$delete_id]);
   header('location:placed_orders.php');
   exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>jaybeats admin | placed orders</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- placed orders section starts  -->

<section class="placed-orders">

   <div class="table-header-bar">
      <h2 class="table-header-title">Placed Orders</h2>
   </div>

   <div class="table-container">
      <table class="admin-table">
         <thead>
            <tr>
               <th>Order ID</th>
               <th>Customer Name</th>
               <th>Contact & Address</th>
               <th>Products Ordered</th>
               <th>Total Price</th>
               <th>Method</th>
               <th>Placed On</th>
               <th>Payment Status</th>
               <th>Actions</th>
            </tr>
         </thead>
         <tbody>
         <?php
            $select_orders = $conn->prepare("SELECT * FROM `orders` ORDER BY id DESC");
            $select_orders->execute();
            if($select_orders->rowCount() > 0){
               while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
         ?>
            <tr>
               <td><strong>#<?= $fetch_orders['id']; ?></strong></td>
               <td>
                  <div class="user-cell">
                     <span class="name"><?= htmlspecialchars($fetch_orders['name']); ?></span>
                     <span class="sub">User ID: <?= $fetch_orders['user_id']; ?></span>
                  </div>
               </td>
               <td>
                  <div class="contact-cell">
                     <div><i class="fas fa-envelope"></i> <?= htmlspecialchars($fetch_orders['email']); ?></div>
                     <div><i class="fas fa-phone"></i> <?= htmlspecialchars($fetch_orders['number']); ?></div>
                     <div style="font-size: 1.2rem; color: var(--text-light); margin-top: 0.2rem;"><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($fetch_orders['address']); ?></div>
                  </div>
               </td>
               <td style="max-width: 250px; font-size: 1.3rem;"><?= htmlspecialchars($fetch_orders['total_products']); ?></td>
               <td class="price-text">$<?= $fetch_orders['total_price']; ?></td>
               <td><span class="badge badge-secondary"><?= htmlspecialchars($fetch_orders['method']); ?></span></td>
               <td style="font-size: 1.3rem; color: var(--text-muted);"><?= $fetch_orders['placed_on']; ?></td>
               <td>
                  <form action="" method="POST" class="inline-status-form">
                     <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
                     <select name="payment_status" class="table-select">
                        <option value="pending" <?= ($fetch_orders['payment_status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                        <option value="completed" <?= ($fetch_orders['payment_status'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
                     </select>
                     <button type="submit" name="update_payment" class="action-btn update-btn" title="Save status">
                        <i class="fas fa-check"></i>
                     </button>
                  </form>
               </td>
               <td>
                  <a href="placed_orders.php?delete=<?= $fetch_orders['id']; ?>" class="action-btn delete-btn" onclick="return confirm('Delete this order?');">
                     <i class="fas fa-trash"></i>
                  </a>
               </td>
            </tr>
         <?php
               }
            }else{
               echo '<tr><td colspan="9" class="empty-table"><i class="fas fa-shopping-bag"></i>No orders placed yet!</td></tr>';
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
