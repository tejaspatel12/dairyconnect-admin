<?php
include 'connection.php';


    if(isset($_REQUEST["BtnOneQtyChange"]))
    {
        $qty = $_REQUEST["txtqty"];
        $user = $_REQUEST["user"];
        $newid = $_REQUEST["newid"];
        echo $newid;
        $result=mysqli_query($conn,"update tbl_order_calendar set order_qty='$qty' where oc_id='".$newid."'") or die(mysqli_error($conn));
       
        if($result=true)
        {
            // echo "<script>window.location='user_detail.php?user=$user';</script>";
        }
        else
        {
            
        }
    }
    if(isset($_REQUEST["BtnDeleteOrder"]))
    {
        $order = $_REQUEST["order"];
        $user = $_REQUEST["user"];
        
        echo "User = ".$user."<br>";
        echo "order = ".$order."<br>";
        $result=mysqli_query($conn,"update tbl_order_calendar set order_qty='$qty' where oc_id='".$newid."'") or die(mysqli_error($conn));
       
        if($result=true)
        {
            // echo "<script>window.location='user_detail.php?user=$user';</script>";
        }
        else
        {
            
        }
    }
    else
    {
        echo "<script>window.location='index.php';</script>";
    }
?>