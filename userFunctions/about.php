<?php

include '../includes/db_connect.php';

session_start();
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
 }else{
    $user_id = '';
 };
 
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

    <section class="about-page">
        <div class="container">
            <div>
                <h1 class="heading"> Who we are </h1>
            </div>
            <div class="text">
                <p>
                    Freak sinz is Community of free thinkers from Turffontein (2190). the brand Interrupt the modern
                    cultural
                    landscape through clothes, hosting events, and music. 
                    Within The freak sinz community includes artists, photographers, designers and musicians.
                </p>
            </div>
            <div class="gallery">
                <div>
                    <img src="../assets/img_06.jpg" alt="">
                </div>
                <div>
                    <img src="../assets/img_04.jpg" alt="">
                </div>
                <div>
                    <img src="../assets/img_11.jpg" alt="">
                </div>
                <div>
                    <img src="../assets/img_08.jpg" alt="">
                </div>
                <div>
                    <img src="../assets/img_07.jpg" alt="">
                </div>
                <div>
                    <img src="../assets/img_10.jpg" alt="">
                </div>
            </div>
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