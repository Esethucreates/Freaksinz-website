<?php

include '../includes/db_connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:./admin_login.php');
 }
 
 
if(isset($_POST['add_product'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
        
    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);

    $category = $_POST['category'];
    $category = strtolower($category);
    $category = filter_var($category, FILTER_SANITIZE_STRING);
    $made = $_POST['made_by'];
    $made = filter_var($made, FILTER_SANITIZE_STRING);

    $details = $_POST['details'];
    $details = filter_var($details, FILTER_SANITIZE_STRING);
 
    $image_01 = $_FILES['image_01']['name'];
    $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
    $image_size_01 = $_FILES['image_01']['size'];
    $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
    $image_folder_01 = '../uploaded_img/'.$image_01;
 
    $image_02 = $_FILES['image_02']['name'];
    $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING);
    $image_size_02 = $_FILES['image_02']['size'];
    $image_tmp_name_02 = $_FILES['image_02']['tmp_name'];
    $image_folder_02 = '../uploaded_img/'.$image_02;
 
   
    $select_products = $connDB->prepare("SELECT * FROM `products` WHERE name = ?");
    $select_products->execute([$name]);
 
    if($select_products->rowCount() > 0){
       $message[] = 'product name already exist!';
       
    }else{
 
       $insert_products = $connDB->prepare("INSERT INTO `products`(name,price,category,created_by, details, image_01, image_02) VALUES(?,?,?,?,?,?,?)");
       $insert_products->execute([$name,$price, $category,$made, $details,  $image_01, $image_02]);
 
       if($insert_products){
          if($image_size_01 > 5000000 OR $image_size_02 > 5000000 ){
             $message[] = 'image size is too large!';
          }else{
             move_uploaded_file($image_tmp_name_01, $image_folder_01);
             move_uploaded_file($image_tmp_name_02, $image_folder_02);
             $message[] = 'new product added!';
          }
       }
 
    }  
 
 };

//  Delete 
 if(isset($_GET['delete'])){
 
    $delete_id = $_GET['delete'];
    $delete_product_image = $connDB->prepare("SELECT * FROM `products` WHERE id = ?");
    $delete_product_image->execute([$delete_id]);
    $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
    unlink('../uploaded_img/'.$fetch_delete_image['image_01']);
    unlink('../uploaded_img/'.$fetch_delete_image['image_02']);
    unlink('../uploaded_img/'.$fetch_delete_image['image_03']);
    $delete_product = $connDB->prepare("DELETE FROM `products` WHERE id = ?");
    $delete_product->execute([$delete_id]);
    $delete_cart = $connDB->prepare("DELETE FROM `cart` WHERE pid = ?");
    $delete_cart->execute([$delete_id]);
    $delete_wishlist = $connDB->prepare("DELETE FROM `wishlist` WHERE pid = ?");
    $delete_wishlist->execute([$delete_id]);
    header('location:../adminFunctions/products.php');
 };
 
 
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
</head>

<body>
    <?php include '../includes/admin_header.php'; ?>

    <section class="products">
        <h3 class="heading">Add Product</h3>
        <div class="card">

            <form action="" method="post" enctype="multipart/form-data" class="form-container">
                <div class="form-group">
                    <label for="name">Product name</label>
                    <input type="text" class="form-control box" required maxlength="100"
                        placeholder="enter product name" name="name">
                </div>

                <div class="form-group">
                    <label for="name">Product price</label>
                    <input type="number" min="0" class="form-control box" required max="9999999999"
                        placeholder="enter product price" onkeypress="if(this.value.length == 10) return false;"
                        name="price">
                </div>
                <div class="form-group">
                    <label for="name">Category</label>
                    <input type="text" class="form-control box" required maxlength="100"
                        placeholder="Enter the category name" name="category">
                </div>

                <div class="form-group">
                    <label for="name">Made by</label>
                    <input type="text" class="form-control box" required maxlength="100"
                        placeholder="Enter the designer name" name="made_by">
                </div>

                <div class="form-group">
                    <label>image 01 (required)</label>
                    <input type="file" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp"
                        class=" form-control box" required>
                </div>
                <div class="form-group">
                    <label>image 02 (required)</label>
                    <input type="file" name="image_02" accept="image/jpg, image/jpeg, image/png, image/webp"
                        class=" form-control box" required>
                </div>

                <div class="form-group">
                    <label for="details">Details </label>
                    <textarea name="details" placeholder="enter product details" class="form-control box" required
                        maxlength="500" cols="30" rows="5" style="resize: none;"></textarea>
                </div>

                <input type="submit" value="add product" class="option-btn" name="add_product">
            </form>
        </div>

    </section>

    <!-- Show products -->
    <section class="show-products">

        <h1 class="heading">products added</h1>

        <div class="box-container">
            <div class="ui items grid-panel">
                <?php
      $select_products = $connDB->prepare("SELECT * FROM `products`");
      $select_products->execute();
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
   ?>

                <div class="item">
                    <div class="image">
                        <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">
                    </div>
                    <div class="content middle aligned">
                        <div class="header ">
                            <p class="name"><?= $fetch_products['name']; ?></p>
                        </div>

                        <div class="meta">
                            <div class="price">
                                R<span><?= $fetch_products['price']; ?></span>/-
                            </div>
                        </div>
                        <div class="description">
                            <div class="details"><span><?= $fetch_products['details']; ?></span></div>
                        </div>
                        <div class="extra">
                            <div class="flex-btn">
                                <a href="../adminFunctions/update_product.php?update=<?=$fetch_products['id']; ?>"
                                    class="option-btn" id="openModal">update</a>

                                <a href="products.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn"
                                    onclick="return confirm('delete this product?');">delete</a>
                            </div>
                        </div>


                    </div>
                </div>

                <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
   ?>

            </div>
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