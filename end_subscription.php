<?php
include 'connection.php';
//     if(isset($_REQUEST["user"]))
//     {
// 		$user = $_REQUEST["user"];
//         $result=mysqli_query($conn,"select * from tbl_user as u left join tbl_deliveryboy as d on d.deliveryboy_id=u.deliveryboy_id left join tbl_time_slot as ts on ts.time_slot_id=d.time_slot_id where u.user_id='".$_REQUEST["user"]."'");
//         while($row=mysqli_fetch_array($result))
//         {
//             $cut_offtime;
//         }
        
//     }

	if(isset($_REQUEST["user"], $_REQUEST["order"]))
		{
            $time = date("Y-m-d");
            $user = $_REQUEST["user"];
            $order = $_REQUEST["order"];
            
            $time = date('Y-m-d', strtotime($time. ' +  1 days'));
            $resume_date = date('Y-m-d', strtotime($time. ' +  365 days')); 
            $result=mysqli_query($conn,"update tbl_order set push_date='$time',order_subscription_status='2' where user_id='".$user."' and order_id='".$order."'") or die(mysqli_error($conn));
                // $result=mysqli_query($conn,"update tbl_order set push_date='2021-12-30',order_subscription_status='2' where user_id='1' and order_id='375'") or die(mysqli_error($conn));
            
            $result1=mysqli_query($conn,"delete from tbl_order_calendar where order_id='".$order."' and user_id='".$user."' and order_date between '$time' and '$resume_date'") or die(mysqli_error($conn));
            // $result=mysqli_query($conn,"update tbl_order_calendar set oc_is_delivered='2' where user_id='$user_id' and order_id='$order_id' and oc_is_delivered='0'") or die(mysqli_error($conn));
            if($result=true && $result1=true)
            {
                echo "Please Wait";
                echo "<script>window.location='user_detail.php?user=$user';</script>";
            }
            else
            {
                echo "Please Wait";
                echo "<script>window.location='user_detail.php?user=$user';</script>";
            }
        
        
// 			$order = $_REQUEST["order"];
// 			$user = $_REQUEST["user"];

// 			// $resultuser=mysqli_query($conn,"select * from tbl_user where user_id='".$user."'");
// 			$resultuser=mysqli_query($conn,"select * from tbl_time_slot as t left join tbl_deliveryboy as d on d.time_slot_id=t.time_slot_id left join tbl_user as u on d.deliveryboy_id=u.deliveryboy_id where u.user_id='$user'")or die(mysqli_error($conn));
			
// 			while($rowuser=mysqli_fetch_array($resultuser))
// 			{
// 				$usertype = $rowuser["user_type"];
// 				$cutoff_time = $rowuser["time_slot_cutoff_time"];
// 			}
			
// 			$result=mysqli_query($conn,"select * from tbl_product where product_id='".$product."'");
// 			while($row=mysqli_fetch_array($result))
// 			{
// 				$product_name = $row["product_name"];
// 				$product_price = $usertype=="1"?$row["product_regular_price"]:$row["product_normal_price"];
// 				// $product_price = if($usertype=="1"){$row["product_name"];}else{$row["product_name"];}
// 			}
	}
?>