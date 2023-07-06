<?php
    include 'connection.php';
    $start_date = date("Y-m-d");
    $round = 365;
        for ($i = 0; $i <= $round; $i++){
            
            $result3=mysqli_query($conn,"insert into tbl_calendar (calendar_date) 
            values ('".date('Y-m-d', strtotime($start_date. ' +  '.$i.'days'))."')") or die(mysqli_error($conn));
        }
    if($result3 = true)
    {
        echo "<script>window.location='index.php';</script>";
    }
    else
    {
        echo "<script>window.location='index.php';</script>";
    }
?>
                