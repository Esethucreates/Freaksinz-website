<?php

include '../includes/db_connect.php';

session_start();

$admin_id = $_SESSION['user_id'];

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
 }else{
    $user_id = '';
 };
 
 if(isset($_POST['submit'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
 
    $update_profile = $connDB->prepare("UPDATE `users` SET name = ?, email = ? WHERE id = ?");
    $update_profile->execute([$name, $email, $user_id]);
 
    $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
    $prev_pass = $_POST['prev_pass'];
    $old_pass = sha1($_POST['old_pass']);
    $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
    $new_pass = sha1($_POST['new_pass']);
    $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
    $confirm_pass = sha1($_POST['confirm_pass']);
    $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);
 
    if($old_pass == $empty_pass){
       $message[] = 'please enter old password!';
    }elseif($old_pass != $prev_pass){
       $message[] = 'old password not matched!';
    }elseif($new_pass != $confirm_pass){
       $message[] = 'confirm password not matched!';
    }else{
       if($new_pass != $empty_pass){
          $update_admin_pass = $connDB->prepare("UPDATE `users` SET password = ? WHERE id = ?");
          $update_admin_pass->execute([$confirm_pass, $user_id]);
          $message[] = 'password updated successfully!';
       }else{
          $message[] = 'please enter a new password!';
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
    <title>Update Admin</title>
    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Semantic -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.5.0/dist/semantic.min.css">
    <!-- Custom scripts -->
    <link rel="stylesheet" href="../css/general.css">

</head>

<body>
    <?php include '../includesUser/user_header.php'; ?>
    <section id="Update-user">

        <div class="card">

            <form action="" method="post" class="form-container">
                <h3 class="s-heading">update profile</h3>
                <input type="hidden" name="prev_pass" value="<?= $fetch_profile['password']; ?>">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="name" value="<?= $fetch_profile['name']; ?>" required
                        placeholder="enter your username" maxlength="20" class="form-control box"
                        oninput="this.value = this.value.replace(/\s/g, '')">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" required placeholder="enter your email" maxlength="50" class="box"
                        oninput="this.value = this.value.replace(/\s/g, '')" value="<?= $fetch_profile["email"]; ?>">
                </div>
                <div class="form-group">
                    <label for="password">Old Password:</label>
                    <input type="password" id="old_password" name="old_pass" placeholder="enter old password"
                        maxlength="20" class="form-control box" oninput="this.value = this.value.replace(/\s/g, '')">
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="new_pass" placeholder="enter new password" maxlength="20"
                        class="form-control box" oninput="this.value = this.value.replace(/\s/g, '')">
                </div>

                <div class="form-group">
                    <label for="confirm-password">Confirm Password:</label>
                    <input type="password" id="confirm-password" name="confirm_pass" placeholder="confirm new password"
                        maxlength="20" class="form-control box" oninput="this.value = this.value.replace(/\s/g, '')">
                </div>
                <input type="submit" value="update now" class="btn" name="submit">
            </form>
        </div>


    </section>






    <!-- Semantic -->
    <script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.5.0/dist/semantic.min.js"></script>
    <!-- custom scripts -->
    <script src="../js/script.js"></script>
</body>

</html>