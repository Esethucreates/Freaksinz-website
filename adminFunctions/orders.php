<?php

include '../includes/db_connect.php';

session_start();
$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:./admin_login.php');
 }

 

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_POST['update_payment'])){
   $order_id = $_POST['order_id'];
   $payment_status = $_POST['payment_status'];
   $payment_status = filter_var($payment_status, FILTER_SANITIZE_STRING);
   $update_payment = $connDB->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
   $update_payment->execute([$payment_status, $order_id]);
   $message[] = 'payment status updated!';
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
   $delete_order->execute([$delete_id]);
   header('location:placed_orders.php');
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

    <?php include '../includes/admin_header.php'; ?>


    <section class="orders">
        <h3 class="heading">All Orders</h3>
        <div class="orders-box-container">
            <?php 
$select_orders = $connDB-> prepare("SELECT * FROM `orders`");
$select_orders->execute();
if ($select_orders->rowCount() > 0){
while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){


?>
            <div class="box">
                <p class="heading">Customer name: <span><?= $fetch_orders['name']?></span></p>
                <div class="customer-details">
                    <div>
                        <p>Physical Address: <span><?= $fetch_orders['address']?></span> </p>
                    </div>
                    <div class="flex-details">
                        <div>
                            <p>order date: <span><?= $fetch_orders['placed_on']?></span> </p>
                            <p>phone number: <span><?= $fetch_orders['number']?></span></p>
                        </div>
                    </div>
                </div>
                <div class="item-details">
                    <div>
                        <p>total products: <span><?= $fetch_orders['total_products'];?></span></p>
                    </div>
                    <div>
                        <p>Product details: <span><?= $fetch_orders['total_price']?></span> </p>
                        <p>Product details: <span><?= $fetch_orders['method']?></span> </p>
                    </div>

                </div>
                <form action="" method="post">
                    <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
                    <select name="payment_status" class="select">
                        <option selected disabled><?= $fetch_orders['payment_status']; ?></option>
                        <option value="pending">pending</option>
                        <option value="completed">completed</option>
                    </select>
                    <div class="flex-btn">
                        <input type="submit" value="update" class="option-btn" name="update_payment">
                        <a href="placed_orders.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn"
                            onclick="return confirm('delete this order?');">delete</a>
                    </div>
                </form>
            </div>

            <?php 
}
} else {
echo '<p>There are no orders yet!</p>';
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