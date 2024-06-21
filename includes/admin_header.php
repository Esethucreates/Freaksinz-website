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
    <section class="admin-header">
        <nav class="ui secondary pointing menu navbar">
            <a href="../adminFunctions/admin_panel.php" class="item home">
                <span>Freaksinz</span>
            </a>
            <a href="../adminFunctions/products.php" class="item products">products</a>
            <a href="../adminFunctions/orders.php" class="item orders">orders</a>
            <a href="../adminFunctions/admin_accounts.php" class="item admins">admins</a>
            <a href="../adminFunctions/user_accounts.php" class="item users">users</a>


            <div class="right menu">
                <div class="icons">

                    <div id="user-btn" class="ui icon top left pointing dropdown button">
                        <i class="fas fa-user"></i>
                        <div class="menu">
                            <?php
            $select_profile = $connDB->prepare("SELECT * FROM `admins` WHERE id = ?");
            $select_profile->execute([$admin_id]);
            if($select_profile -> rowCount()> 0){
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
                            <div class="header">
                                <p><?= $fetch_profile['name']; ?></p>
                            </div>
                            <div class="divider"></div>
                            <a class="item" href="../adminFunctions/update_admin.php" class="">update profile</a>
                            <a class="item" href="../adminFunctions/admin_logout.php" class=""
                                onclick="return confirm('logout from the website?');">logout</a>
                            <?php 
            } ?>
                        </div>
                    </div>
                    <button id="menu-btn">
                        <div class="fas fa-bars"></div>
                    </button>

                </div>
            </div>
        </nav>
    </section>

    <div class="ui sidebar thin vertical menu">
        <a href="../adminFunctions/products.php" class="item products">products</a>
        <a href="../adminFunctions/orders.php" class="item orders">orders</a>
        <a href="../adminFunctions/admin_accounts.php" class="item admins">admins</a>
        <a href="../adminFunctions/user_accounts.php" class="item users">users</a>


    </div>
</header>