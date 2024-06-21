<?php

include '../includes/db_connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:./admin_login.php');
 }

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $delete_user = $connDB->prepare("DELETE FROM `users` WHERE id = ?");
    $delete_user->execute([$delete_id]);
    $delete_orders = $connDB->prepare("DELETE FROM `orders` WHERE user_id = ?");
    $delete_orders->execute([$delete_id]);
    $delete_messages = $connDB->prepare("DELETE FROM `messages` WHERE user_id = ?");
    $delete_messages->execute([$delete_id]);
    $delete_cart = $connDB->prepare("DELETE FROM `cart` WHERE user_id = ?");
    $delete_cart->execute([$delete_id]);
    $delete_wishlist = $connDB->prepare("DELETE FROM `wishlist` WHERE user_id = ?");
    $delete_wishlist->execute([$delete_id]);
    header('location:../adminFunctions/users_accounts.php');
 }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet" />

    <!-- Semantic -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.5.0/dist/semantic.min.css">


    <!-- Custom scripts -->
    <link rel="stylesheet" href="../css/adminStyle.css">
    <link rel="stylesheet" href="../css/general.css">
    <style>
    .ui.cards {
        justify-content: space-evenly;
    }
    </style>
</head>

<body>
    <?php include '../includes/admin_header.php'; ?>





    <section class="user-accounts">
        <h1 class="heading">User accounts</h1>
        <div class="ui cards">
            <?php
   $select_accounts = $connDB->prepare("SELECT * FROM `users`");
   $select_accounts->execute();
   if($select_accounts->rowCount() > 0){
      while($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)){   
?>
            <div class="box card">
                <div class="content">
                    <div class="header">
                        <p><span><?= $fetch_accounts['name']; ?></span> </p>
                    </div>
                    <div class="meta">
                        User ID
                    </div>
                    <div class="description">
                        <p><span><?= $fetch_accounts['id']; ?></span> </p>
                    </div>

                </div>
                <div class="extra content">
                    <div class="flex-btn">
                        <a href="user_accounts.php?delete=<?= $fetch_accounts['id']; ?>"
                            onclick="return confirm('delete this account?')" class="delete-btn">delete</a>

                    </div>
                </div>
            </div>
            <?php
      }
   }else{
      echo '<p class="empty">no accounts available!</p>';
   }
?>

        </div>
    </section>






    <!-- Semantic -->
    <script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.5.0/dist/semantic.min.js"></script>
    <!-- Boxicons -->
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <!-- custom scripts -->
    <script src="../js/adminScript.js"></script>
</body>

</html>