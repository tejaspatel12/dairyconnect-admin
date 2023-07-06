<?php 
    date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)
    include '../../connection.php';

    $result=mysqli_query($conn,"insert into tbl_test (test) 
                values ('12345')") or die(mysqli_error($conn));
?>