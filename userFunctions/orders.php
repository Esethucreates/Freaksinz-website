<?php

include '../includes/db_connect.php';

session_start();
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
 }else{
    $user_id = '';
 };
 

 include '../includesUser/cartWishFunc.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>

    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Semantic -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.5.0/dist/semantic.min.css">
    <!-- Custom scripts -->
    <link rel="stylesheet" href="../css/general.css">

</head>

<body>

    <?php include '../includesUser/user_header.php'; ?>
    <section class="orders">

        <h1 class="heading">placed orders</h1>

        <div class="orders-box-container">

            <?php
   if($user_id == ''){
      echo '<p class="empty">please login to see your orders</p>';
   }else{
      $select_orders = $connDB->prepare("SELECT * FROM `orders` WHERE user_id = ?");
      $select_orders->execute([$user_id]);
      if($select_orders->rowCount() > 0){
         while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
?>
            <div class="box">
                <div class="customer-details">
                    <div>
                        <p>Physical Address: <span><?= $fetch_orders['address']?></span> </p>
                    </div>
                    <div class="flex-details">
                        <div>
                            <p>order date: <span><?= $fetch_orders['placed_on']?></span></p>
                            <p>phone number: <span><?= $fetch_orders['number']?></span></p>
                        </div>
                    </div>
                </div>
                <div class="item-details">
                    <div>
                        <p> total product: <span><?= $fetch_orders['total_products'];?></span></p>
                    </div>
                    <div>
                        <p>Product details: <span><?= $fetch_orders['total_price']?></span></p>
                        <p>Product details: <span><?= $fetch_orders['method']?></span> </p>
                    </div>

                </div>
                <p> payment status : <span
                        style="color:<?php if($fetch_orders['payment_status'] == 'pending'){ echo 'red'; }else{ echo 'green'; }; ?>"><?= $fetch_orders['payment_status']; ?></span>
                </p>
            </div>
            <?php
   }
   }else{
      echo '<p class="empty">no orders placed yet!</p>';
   }
   }
?>

        </div>

    </section>


    <?php include '../includesUser/footer.php'; ?>
    <!-- Semantic -->
    <script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.5.0/dist/semantic.min.js"></script>

    <!-- Boxicons -->
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>

    <!-- Swiper -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- custom scripts -->
    <script src="../js/script.js"></script>
</body>

</html>