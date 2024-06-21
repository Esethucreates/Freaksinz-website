<?php

include '../includes/db_connect.php';

session_start();
$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:./admin_login.php');
 }


 if(isset($_POST['update'])){

    $pid = $_POST['pid'];
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);
    $details = $_POST['details'];
    $details = filter_var($details, FILTER_SANITIZE_STRING);
 
    $category = $_POST['category'];
    $category = strtolower($category);
    $category = filter_var($category, FILTER_SANITIZE_STRING);
    $made = $_POST['made_by'];
    $made = filter_var($made, FILTER_SANITIZE_STRING);



    $update_product = $connDB->prepare("UPDATE `products` SET name = ?, price = ?, details = ?, category = ?, created_by = ? WHERE id = ?");
    $update_product->execute([$name, $price, $details, $category, $made, $pid]);
 
    $message[] = 'product updated successfully!';
 
    $old_image_01 = $_POST['old_image_01'];
    $image_01 = $_FILES['image_01']['name'];
    $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
    $image_size_01 = $_FILES['image_01']['size'];
    $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
    $image_folder_01 = '../uploaded_img/'.$image_01;
 
    if(!empty($image_01)){
       if($image_size_01 > 2000000){
          $message[] = 'image size is too large!';
       }else{
          $update_image_01 = $connDB->prepare("UPDATE `products` SET image_01 = ? WHERE id = ?");
          $update_image_01->execute([$image_01, $pid]);
          move_uploaded_file($image_tmp_name_01, $image_folder_01);
          unlink('../uploaded_img/'.$old_image_01);
          $message[] = 'image 01 updated successfully!';
       }
    }
 
    $old_image_02 = $_POST['old_image_02'];
    $image_02 = $_FILES['image_02']['name'];
    $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING);
    $image_size_02 = $_FILES['image_02']['size'];
    $image_tmp_name_02 = $_FILES['image_02']['tmp_name'];
    $image_folder_02 = '../uploaded_img/'.$image_02;
 
    if(!empty($image_02)){
       if($image_size_02 > 2000000){
          $message[] = 'image size is too large!';
       }else{
          $update_image_02 = $connDB->prepare("UPDATE `products` SET image_02 = ? WHERE id = ?");
          $update_image_02->execute([$image_02, $pid]);
          move_uploaded_file($image_tmp_name_02, $image_folder_02);
          unlink('../uploaded_img/'.$old_image_02);
          $message[] = 'image 02 updated successfully!';
       }
    }
   
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
    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet" />

    <!-- Semantic -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.5.0/dist/semantic.min.css">

    <!-- Swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- Custom scripts -->
    <link rel="stylesheet" href="../css/general.css">
    <style>
    /* Change it */
    .update-product .form-container {
        max-width: 70rem;
        margin: 0 auto;
        background-color: #fff;
        padding: 3.2rem 2.4rem;
        font-size: 1.4rem;
        font-family: inherit;
        color: #212121;
        display: flex;
        flex-direction: column;
        gap: 2rem;
        box-sizing: border-box;
        border-radius: 1rem;
        box-shadow: 0px 0px 3px rgba(0, 0, 0, 0.084), 0px 2px 3px rgba(0, 0, 0, 0.168);
    }

    .update-product .form-container .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.2rem;
    }

    .update-product .form-container .form-group label {
        display: block;
        margin-bottom: 0.5rem;
    }

    .update-product .form-container .form-group input {
        width: 100%;
        padding: 1.2rem 1.6rem;
        border-radius: 0.6rem;
        font-family: inherit;
        border: 1px solid #ccc;
    }


    .update-product form .image-container {
        margin-bottom: 2rem;
    }

    .update-product form .image-container .main-image img {
        height: 20rem;
        width: 100%;
        object-fit: contain;
    }

    .update-product form .image-container .sub-image {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin: 1rem 0;
    }

    .update-product form .image-container .sub-image img {
        height: 5rem;
        width: 7rem;
        object-fit: contain;
        padding: 0.5rem;
        border: var(--border);
        cursor: pointer;
        transition: 0.2s linear;
    }

    .update-product form .image-container .sub-image img:hover {
        transform: scale(1.1);
    }

    .update-product form .box {
        width: 100%;
        border-radius: 0.5rem;
        padding: 1.4rem;
        font-size: 1.8rem;
        color: var(--black);
        background-color: var(--light-bg);
        margin: 1rem 0;
    }

    .update-product form span {
        font-size: 1.7rem;
        color: var(--light-color);
    }

    .update-product form textarea {
        height: 15rem;
        resize: none;
        border: 1px solid #ccc;

    }
    </style>
</head>

<body>

    <?php include '../includes/admin_header.php'; ?>
    <!-- Update products -->
    <section class="update-product ">
        <h1 class="heading">update product</h1>
        <?php
   $update_id = $_GET['update'];
   $select_products = $connDB->prepare("SELECT * FROM `products` WHERE id = ?");
   $select_products->execute([$update_id]);
   if($select_products->rowCount() > 0){
      while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
?>
        <form action="" method="post" enctype="multipart/form-data" class="form-container">
            <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
            <input type="hidden" name="old_image_01" value="<?= $fetch_products['image_01']; ?>">
            <input type="hidden" name="old_image_02" value="<?= $fetch_products['image_02']; ?>">
            <div class="image-container">
                <div class="main-image">
                    <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">
                </div>
                <div class="sub-image">
                    <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">
                    <img src="../uploaded_img/<?= $fetch_products['image_02']; ?>" alt="">
                </div>
            </div>


            <div class="form-group">
                <label for="name">update name</label>
                <input id="name" type="text" name="name" class="box form-control" maxlength="100"
                    placeholder="enter product name" value="<?= $fetch_products['name']; ?>">
            </div>
            <div class="form-group">
                <label for="number">update price</label>
                <input id="price" type="number" name="price" class="box form-control" min="0" max="9999999999"
                    placeholder="enter product price" onkeypress="if(this.value.length == 10) return false;"
                    value="<?= $fetch_products['price']; ?>">
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <input id="category" type="text" class="form-control box" required maxlength="100"
                    placeholder="Enter the category name" name="category" value="<?= $fetch_products['category']; ?>">
            </div>

            <div class="form-group">
                <label for="made">Made by</label>
                <input id="made" type="text" class="form-control box" required maxlength="100"
                    placeholder="Enter the designer name" name="made_by" value="<?= $fetch_products['created_by']; ?>">
            </div>

            <div class="form-group">
                <span>update details</span>
                <textarea name="details" class="box form-control" cols="30"
                    rows="10"><?= $fetch_products['details']; ?></textarea>
            </div>
            <div class="form-group">
                <span>update image 01</span>
                <input type="file" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp"
                    class="box form-control">
            </div>
            <div class="form-group">
                <span>update image 02</span>
                <input type="file" name="image_02" accept="image/jpg, image/jpeg, image/png, image/webp"
                    class="form-control box">

                <div class="flex-btn">
                    <input type="submit" name="update" class="btn" value="update">
                    <a href="products.php" id="closeModal" class="option-btn">go back</a>
                </div>
        </form>
        <?php
      }
   }else{
      echo '<p class="empty">no product found!</p>';
   }
?>
    </section>






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