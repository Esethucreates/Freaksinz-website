<?php

include '../includes/db_connect.php';

session_start();
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
 }else{
    $user_id = '';
    header('location:../userFunctions/user_login.php');
 };
 
 include '../includesUser/cartWishFunc.php';

 if(isset($_POST['delete'])){
    $wishlist_id = $_POST['wishlist_id'];
    $delete_wishlist_item = $connDB->prepare("DELETE FROM `wishlist` WHERE id = ?");
    $delete_wishlist_item->execute([$wishlist_id]);
 }
 
 if(isset($_GET['delete_all'])){
    $delete_wishlist_item = $connDB->prepare("DELETE FROM `wishlist` WHERE user_id = ?");
    $delete_wishlist_item->execute([$user_id]);
    header('location:wishlist.php');
 }
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

    <section class="wishlist">

        <h3 class="heading">your wishlist</h3>

        <div class="cart-wish-box-container">

            <?php
   $grand_total = 0;
   $select_wishlist = $connDB->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
   $select_wishlist->execute([$user_id]);
   if($select_wishlist->rowCount() > 0){
      while($fetch_wishlist = $select_wishlist->fetch(PDO::FETCH_ASSOC)){
         $grand_total += $fetch_wishlist['price'];  
?>
            <form action="" method="post" class="box">
                <input type="hidden" name="pid" value="<?= $fetch_wishlist['pid']; ?>">
                <input type="hidden" name="wishlist_id" value="<?= $fetch_wishlist['id']; ?>">
                <input type="hidden" name="name" value="<?= $fetch_wishlist['name']; ?>">
                <input type="hidden" name="price" value="<?= $fetch_wishlist['price']; ?>">
                <input type="hidden" name="image" value="<?= $fetch_wishlist['image']; ?>">
                <div class="content">
                    <div class="img-box">
                        <img src="../uploaded_img/<?= $fetch_wishlist['image']; ?>" alt="">
                    </div>
                    <div class="text-box">
                        <div class="name"><?= $fetch_wishlist['name']; ?></div>
                        <div class="flex">
                            <div class="price">R<?= $fetch_wishlist['price']; ?></div>
                        </div>
                        <div class="flex-btn">
                            <input type="submit" value="add to cart" class="btn" name="add_to_cart">
                            <input type="submit" value="delete item"
                                onclick="return confirm('delete this from wishlist?');" class="delete-btn"
                                name="delete">
                        </div>
                    </div>

                </div>
            </form>
            <?php
   }
}else{
   echo '<p class="empty">your wishlist is empty</p>';
}
?>
        </div>

        <div class="cart-wish-total mw-90">
            <p class="heading">grand total : <span>$<?= $grand_total; ?>/-</span></p>
            <a href="shop.php" class="option-btn">continue shopping</a>
            <a href="wishlist.php?delete_all" class="delete-btn <?= ($grand_total > 1)?'':'disabled'; ?>"
                onclick="return confirm('delete all from wishlist?');">delete all item</a>
        </div>

    </section>


    <?php include '../includesUser/footer.php'; ?>
    <!-- Semantic -->
    <script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.5.0/dist/semantic.min.js"></script>

    <!-- custom scripts -->
    <script src="../js/script.js"></script>
</body>

</html>