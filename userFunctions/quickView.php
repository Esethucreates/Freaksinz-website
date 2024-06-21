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
    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet" />

    <!-- Semantic -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.5.0/dist/semantic.min.css">

    <!-- Swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- Custom scripts -->
    <link rel="stylesheet" href="../css/general.css">
</head>

<body>

    <?php include '../includesUser/user_header.php'; ?>


    <section class="quick-view">
        <h1 class="heading">quick view</h1>

        <?php
  $pid = $_GET['pid'];
  $select_products = $connDB->prepare("SELECT * FROM `products` WHERE id = ?"); 
  $select_products->execute([$pid]);
  if($select_products->rowCount() > 0){
   while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
?>
        <form action="" method="post" class="box">
            <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
            <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
            <input type="hidden" name="category" value="<?= $fetch_product['category']; ?>">
            <input type="hidden" name="made_by" value="<?= $fetch_product['created_by']; ?>">
            <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
            <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
            <div class="row">
                <div class="image-container">
                    <div class="sub-image">
                        <img src="../uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">
                        <img src="../uploaded_img/<?= $fetch_product['image_02']; ?>" alt="">
                    </div>

                    <div class="main-image">
                        <img src="../uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">
                    </div>

                </div>
                <div class="content">
                    <div class="name"><?= $fetch_product['name']; ?></div>
                    <div class="accord">
                        <div class="ui accordion">
                            <div class="title ">
                                <p>Details</p>
                                <i class="dropdown icon"></i>
                            </div>
                            <div class="content ">
                                <div class="details"><?= $fetch_product['details']; ?></div>
                            </div>
                            <div class="title ">
                                <p>Created By</p>
                                <i class="dropdown icon"></i>
                            </div>
                            <div class="content ">
                                <div class="details"><?= $fetch_product['created_by']; ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="flex-btn">
                        <input type="submit" value="add to cart" class="btn" name="add_to_cart">
                        <input class="option-btn" type="submit" name="add_to_wishlist" value="add to wishlist">
                    </div>
                </div>
            </div>
        </form>
        <?php
   }
}else{
   echo '<p class="empty">no products added yet!</p>';
}
?>

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