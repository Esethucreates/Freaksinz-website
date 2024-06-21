<?php

include '../includes/db_connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:./admin_login.php');
 }

 
if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);

   $update_profile_name = $connDB->prepare("UPDATE `admins` SET name = ? WHERE id = ?");
   $update_profile_name->execute([$name, $admin_id]);

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
         $update_admin_pass = $connDB->prepare("UPDATE `admins` SET password = ? WHERE id = ?");
         $update_admin_pass->execute([$confirm_pass, $admin_id]);
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
    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet" />

    <!-- Semantic -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.5.0/dist/semantic.min.css">


    <!-- Custom scripts -->
    <link rel="stylesheet" href="../css/general.css">
</head>

<body>
    <?php include '../includes/admin_header.php'; ?>
    <section id="Update-admin">
        <div class="">
            <div class="">
                <h3 class="heading">update profile</h3>
            </div>
            <form action="" method="post" class="form-container">
                <input type="hidden" name="prev_pass" value="<?= $fetch_profile['password']; ?>">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="name" value="<?= $fetch_profile['name']; ?>" required
                        placeholder="enter your username" maxlength="20" class="form-control box"
                        oninput="this.value = this.value.replace(/\s/g, '')">
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
    <!-- Boxicons -->
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <!-- custom scripts -->
    <script src="../js/script.js"></script>
</body>

</html>