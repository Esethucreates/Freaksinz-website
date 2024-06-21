<?php

include '../includes/db_connect.php';

session_start();
session_unset();
session_destroy();

header('location:../userFunctions/shop.php');

?>