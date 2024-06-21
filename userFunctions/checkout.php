<?php 
include '../includes/db_connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:user_login.php');
};

if(isset($_POST['order'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   $address = 'flat no. '. $_POST['flat'] .', '. $_POST['street'] .', '. $_POST['city'] .', '. $_POST['state'] .' - '. $_POST['pin_code'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];

   $check_cart = $connDB->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if($check_cart->rowCount() > 0){

      $insert_order = $connDB->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
      $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

      $delete_cart = $connDB->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart->execute([$user_id]);

      $message[] = 'order placed successfully!';
   }else{
      $message[] = 'your cart is empty';
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
</head>

<body>
    <?php include '../includesUser/user_header.php'; ?>
    <section class="checkout-orders">
        <form action="" method="POST" class="form-container">

            <div class="delivery">
                <h3 class="heading">place your orders</h3>
                <div class="flex">
                    <div class="personal-details">
                        <h4 class="s-heading">Personal details</h4>
                        <div class="inputBox">
                            <span>Full name :</span>
                            <input type="text" name="name" placeholder="John dinkles" class="box" maxlength="20"
                                required>
                        </div>
                        <div class="inputBox">
                            <span>your number :</span>
                            <input type="number" name="number" placeholder="061 123 1234" class="box" min="0"
                                max="9999999999" onkeypress="if(this.value.length == 10) return false;" required>
                        </div>
                        <div class="inputBox">
                            <span>your email :</span>
                            <input type="email" name="email" placeholder="jdickles1234@gmail.com" class="box"
                                maxlength="50" required>
                        </div>
                        <div class="inputBox">
                            <span>payment method :</span>
                            <select name="method" class="box" required>
                                <option value="cash on delivery">cash on delivery</option>
                                <option value="credit card">YOCO</option>

                            </select>
                        </div>
                    </div>
                    <div class="d-address">
                        <h4 class="s-heading"></h4>
                        <div class="inputBox">
                            <span>address line 01 :</span>
                            <input type="text" name="flat" placeholder="e.g. flat number" class="box" maxlength="50"
                                required>
                        </div>
                        <div class="inputBox">
                            <span>address line 02 :</span>
                            <input type="text" name="street" placeholder="e.g. street name" class="box" maxlength="50"
                                required>
                        </div>
                        <div>
                            <div class="inputBox">
                                <span>city :</span>
                                <input type="text" name="city" class="box" maxlength="50" required>
                            </div>
                            <div class="inputBox">
                                <span>Province: </span>
                                <input type="text" name="state" class="box" maxlength="50" required>
                            </div>
                            <div class="inputBox">
                                <span>Postal Code:</span>
                                <input type="number" min="0" name="pin_code" placeholder="e.g. 2190" min="0"
                                    max="999999" onkeypress="if(this.value.length == 6) return false;" class="box"
                                    required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="display-orders ta-c">
                <h3 class="heading">order summary</h3>
                <?php
      $grand_total = 0;
      $cart_items[] = '';
      $select_cart = $connDB->prepare("SELECT * FROM `cart` WHERE user_id = ?");
      $select_cart->execute([$user_id]);
      if($select_cart->rowCount() > 0){
         while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
            $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].') - ';
            $total_products = implode($cart_items);
            $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
   ?>
                <p> <?= $fetch_cart['name']; ?>
                    <span>(<?= '$'.$fetch_cart['price'].'/- x '. $fetch_cart['quantity']; ?>)</span>
                </p>
                <?php
         }
      }else{
         echo '<p class="empty">your cart is empty!</p>';
      }
   ?>
                <input type="hidden" name="total_products" value="<?= $total_products; ?>">
                <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
                <div class="s-heading">grand total : <span>$<?= $grand_total; ?>/-</span></div>
                <input type="submit" name="order" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>"
                    value="place order">
            </div>

        </form>

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