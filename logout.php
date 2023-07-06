<?php
    session_start();
    unset($_SESSION["username"]);
    unset($_SESSION["admin_id"]);
    echo "<script>window.location='login.php';</script>";
?>