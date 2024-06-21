<?php

include '../includes/db_connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:./admin_login.php');
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
    <link rel="stylesheet" href="../css/general.css">
</head>

<body>
    <?php include '../includes/admin_header.php'; ?>

    <section id="admin-panel" class="dimmed pusher">
        <div class="grid-panel">

            <div class="box ">
                <div class="card">
                    <?php
            $total_pendings = 0;
            $select_pendings = $connDB->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
            $select_pendings->execute(['pending']);
            if($select_pendings->rowCount() > 0){
               while($fetch_pendings = $select_pendings->fetch(PDO::FETCH_ASSOC)){
                  $total_pendings += $fetch_pendings['total_price'];
               }
            }
         ?>
                    <div class="header">
                        <div class="image">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <g stroke-width="0" id="SVGRepo_bgCarrier"></g>
                                <g stroke-linejoin="round" stroke-linecap="round" id="SVGRepo_tracerCarrier"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path stroke-linejoin="round" stroke-linecap="round" stroke-width="1.5"
                                        stroke="#000000" d="M20 7L9.00004 18L3.99994 13"></path>
                                </g>
                            </svg>
                        </div>

                        <div class="content">
                            <h3 class="title"><span>R</span><?= $total_pendings; ?><span>/-</span></h3>
                            <p>total pendings</p>
                        </div>
                        <div class="actions">
                            <a href="../adminFunctions/orders.php" class="btn">see orders</a>
                        </div>
                    </div>
                </div>
            </div>


            <div class="box">
                <div class="card">
                    <?php
            $select_users = $connDB->prepare("SELECT * FROM `users`");
            $select_users->execute();
            $number_of_users = $select_users->rowCount()
         ?>
                    <div class="header">
                        <div class="image">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <g stroke-width="0" id="SVGRepo_bgCarrier"></g>
                                <g stroke-linejoin="round" stroke-linecap="round" id="SVGRepo_tracerCarrier"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path stroke-linejoin="round" stroke-linecap="round" stroke-width="1.5"
                                        stroke="#000000" d="M20 7L9.00004 18L3.99994 13"></path>
                                </g>
                            </svg>
                        </div>
                        <div class="content">
                            <h3 class="title"><?= $number_of_users; ?></h3>
                            <p>normal users</p>
                        </div>
                        <div class="actions">
                            <a href="../adminFunctions/user_accounts.php" class="btn">see users</a>
                        </div>
                    </div>
                </div>
            </div>



            <div class="box">
                <div class="card">
                    <?php
            $select_products = $connDB->prepare("SELECT * FROM `products`");
            $select_products->execute();
            $number_of_products = $select_products->rowCount()
         ?>
                    <div class="header">
                        <div class="image">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <g stroke-width="0" id="SVGRepo_bgCarrier"></g>
                                <g stroke-linejoin="round" stroke-linecap="round" id="SVGRepo_tracerCarrier"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path stroke-linejoin="round" stroke-linecap="round" stroke-width="1.5"
                                        stroke="#000000" d="M20 7L9.00004 18L3.99994 13"></path>
                                </g>
                            </svg>
                        </div>
                        <div class="content">
                            <h3 class="title"><?= $number_of_products; ?></h3>
                            <p>products added</p>
                        </div>
                        <div class="actions">
                            <a href="../adminFunctions/products.php" class="btn">see products</a>
                        </div>
                    </div>
                </div>
            </div>


            <div class="box">
                <div class="card">
                    <?php
            $select_admins = $connDB->prepare("SELECT * FROM `admins`");
            $select_admins->execute();
            $number_of_admins = $select_admins->rowCount()
         ?>
                    <div class="header">
                        <div class="image">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <g stroke-width="0" id="SVGRepo_bgCarrier"></g>
                                <g stroke-linejoin="round" stroke-linecap="round" id="SVGRepo_tracerCarrier"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path stroke-linejoin="round" stroke-linecap="round" stroke-width="1.5"
                                        stroke="#000000" d="M20 7L9.00004 18L3.99994 13"></path>
                                </g>
                            </svg>
                        </div>
                        <div class="content">
                            <h3 class="title"><?= $number_of_admins; ?></h3>
                            <p>admin users</p>
                        </div>
                        <div class="actions">

                            <a href="../adminFunctions/admin_accounts.php" class="btn">see admins</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>






    <!-- Semantic -->
    <script src="../js/adminScript.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.5.0/dist/semantic.min.js"></script>
    <!-- Boxicons -->
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <!-- custom scripts -->
    <script>
    // Toggle menu
    const menuBtn = document.querySelector(".right.menu .icons #menu-btn");
    const sidebarMenu = document.querySelector(".ui.sidebar");
    console.log(menuBtn);
    console.log(sidebarMenu);
    menuBtn.addEventListener("click", function() {
        sidebarMenu.classList.toggle("visible");
    });
    </script>
</body>

</html>