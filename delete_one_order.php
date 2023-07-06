<?php
include 'connection.php';

	if(isset($_REQUEST["user"], $_REQUEST["order"], $_REQUEST["date"]))
		{
		    
	    $user=$_REQUEST["user"];
        $order=$_REQUEST["order"];
        $date=$_REQUEST["date"];
        
        echo "user ".$user."<br>";
        echo "order ".$order."<br>";
        echo "date ".$date."<br>";
        
        $result=mysqli_query($conn,"delete from tbl_order_calendar where oc_id='".$_REQUEST['order']."' and user_id='".$_REQUEST['user']."'") or die(mysqli_error($conn));
        
        $sql = mysqli_query($conn,"select * from tbl_order_calendar where user_id='$user' and order_date='$date'");
        
        if(mysqli_num_rows($sql)<=0)
        {
            $resultq=mysqli_query($conn,"delete from tbl_user_order_calendar where uoc_date='".$_REQUEST['date']."' and user_id='".$_REQUEST['user']."'") or die(mysqli_error($conn));
        }
        else
        {
            
        }
        
        if($result=true)
        {
            echo "<script>window.location='user_detail.php?user=$user';</script>";
        }
        else
        {
            echo "<script>window.location='user_detail.php?user=$user';</script>";
        }
    	}
?>