<?php 
include '../includes/db_connect.php';
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Semantic -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.5.0/dist/semantic.min.css">
    <!-- Swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- Custom scripts -->
    <link rel="stylesheet" href="../css/general.css">

    <style>
    .home-page {
        max-width: 120rem;
        margin: 0 auto;
        min-height: calc(100vh - 20px);
    }

    .img-self-contain {
        max-width: fit-content;
        display: flex;
        margin: 0 auto;
    }

    .center-img {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .ui.image img {
        width: 100%;
        height: 80rem;
        object-fit: contain;
    }



    .home-img-autoplay {

        position: relative;
    }

    .absolute-btn {

        max-width: fit-content;
        padding: .5rem 1rem;
        color: #fff;
        background-color: #db504a;
        border: 0.2rem solid rgba(0, 0, 0, 0.07);
        border-radius: 9px;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        position: absolute;
        z-index: 99999;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    </style>
</head>

<body>
    <?php include '../includesUser/user_header.php'; ?>
    <main class="home-page">
        <!-- Swiper  -->
        <div class="swiper home-img-autoplay">
            <a href="../userFunctions/shop.php" class="absolute-btn">View More</a>
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                <!-- Slides -->
                <div class="swiper-slide center-img">
                    <div class="ui large image">
                        <img src="../assets/img_02.jpg">
                    </div>
                </div>
                <div class="swiper-slide center-img">
                    <div class="ui medium image">
                        <img src="../assets/img_01.jpeg">
                    </div>
                </div>
                <div class="swiper-slide center-img">
                    <div class="ui medium image">
                        <img src="../assets/img_03.jpg">
                    </div>
                </div>
            </div>

        </div>

    </main>















    <?php include '../includesUser/footer.php'; ?>
    <!-- Semantic -->
    <script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.5.0/dist/semantic.min.js"></script>

    <!-- Boxicons -->
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>

    <!-- Swiper -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- custom scripts -->
    <script src="../js/script.js"></script>
    <script>
    // Swiper for carousel
    const swiper = new Swiper(".swiper", {
        loop: true,
        autoplay: {
            delay: 5000,
        },

        effect: "fade",
        fadeEffect: {
            crossFade: true,
        },
    });
    </script>
</body>

</html>