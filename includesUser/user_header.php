<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
?>


<header>
    <section class="user-header">
        <nav class="ui pointing secondary menu navbar">
            <a href="../userFunctions/home.php" class="header item"><span class="logo">Freaksinz</span></a>
            <a href="../userFunctions/shop.php" class="item">shop</a>
            <a href="../userFunctions/orders.php" class="item">Orders</a>
            <a href="../userFunctions/about.php" class="item">About</a>

            <div class="icons right menu">
                <?php
            $count_wishlist_items = $connDB->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
            $count_wishlist_items->execute([$user_id]);
            $total_wishlist_counts = $count_wishlist_items->rowCount();

            $count_cart_items = $connDB->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $count_cart_items->execute([$user_id]);
            $total_cart_counts = $count_cart_items->rowCount();
         ?>
                <a href="wishlist.php" class="item"><i
                        class="fas fa-heart"></i><span>(<?= $total_wishlist_counts; ?>)</span></a>
                <a href="cart.php" class="item"><i
                        class="fas fa-shopping-cart"></i><span>(<?= $total_cart_counts; ?>)</span></a>

                <div id="user-btn" class="ui icon top left pointing dropdown button">
                    <i class="fas fa-user"></i>
                    <div class="menu">
                        <?php
            $select_profile = $connDB->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile -> rowCount()> 0){
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
                        <div class="header">
                            <p><?= $fetch_profile['name']; ?></p>
                        </div>
                        <div class="divider"></div>
                        <a class="item" href="../userFunctions/update_user.php" class="">update profile</a>
                        <a class="item" href="../userFunctions/user_logout.php" class=""
                            onclick="return confirm('logout from the website?');">logout</a>
                        <?php 
            } else {            
            ?>
                        <a class="item" href="../userFunctions/user_register.php" class="">register</a>
                        <a class="item" href="../userFunctions/user_login.php" class="">login</a>
                        <?php 
            }?>
                    </div>
                </div>
                <button id="menu-btn">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </nav>
    </section>
    <div class="ui sidebar thin vertical menu">
        <a href="../userFunctions/shop.php" class="item">shop</a>
        <a href="../userFunctions/orders.php" class="item">Orders</a>
        <a href="../userFunctions/about.php" class="item">About</a>
    </div>
</header>