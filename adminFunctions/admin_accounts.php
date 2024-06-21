<?php

include '../includes/db_connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:./admin_login.php');
 }
 
if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $delete_admins = $conn->prepare("DELETE FROM `admins` WHERE id = ?");
    $delete_admins->execute([$delete_id]);
    header('location:admin_accounts.php');
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

    <!-- Semantic -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.5.0/dist/semantic.min.css">


    <!-- Custom scripts -->
    <link rel="stylesheet" href="../css/general.css">

</head>

<body>
    <?php include '../includes/admin_header.php'; ?>





    <section class="admin-accounts">
        <h1 class="heading">Admin accounts</h1>

        <div class="card-box">
            <div class="card">
                <div class="content">
                    <div class="right floated mini ui image">
                        <div class="fas fa-user"></div>
                    </div>
                    <div class="header">
                        <p>Add new admin</p>
                    </div>
                    <a href="../adminFunctions/new_admin.php" class="option-btn">register admin</a>
                </div>
            </div>
        </div>

        <div class="ui cards">


            <?php
   $select_accounts = $connDB->prepare("SELECT * FROM `admins`");
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
                        Admin ID
                    </div>
                    <div class="description">
                        <p><span><?= $fetch_accounts['id']; ?></span> </p>
                    </div>

                </div>
                <div class="extra content">
                    <div class="flex-btn">
                        <a href="admin_accounts.php?delete=<?= $fetch_accounts['id']; ?>"
                            onclick="return confirm('delete this account?')" class="delete-btn">delete</a>
                        <?php
         if($fetch_accounts['id'] == $admin_id){
             echo '<a href="../adminFunctions/update_admin.php" class="option-btn">update</a>';
             }
             ?>
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
    <!-- custom scripts -->
    <script src="../js/adminScript.js"></script>
</body>

</html>