<?php 
    date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)
    include '../../connection.php';

    // $DATE = date("Y-m-d");
    // $DATE = "2022-02-02";

    $sql = mysqli_query($conn,"select * from tbl_order as o left join tbl_delivery_schedule as ds on o.order_id=ds.order_id where o.order_subscription_status='1'");
    while($row=mysqli_fetch_assoc($sql))
    {
        $type = $row["delivery_schedule"];

        if($type == "Everyday")
        {

            $order_id = $row["order_id"];
            $product_id = $row["product_id"];
            $user_id = $row["user_id"];
            $ds_qty = $row["ds_qty"];

            $resultuser=mysqli_query($conn,"select * from tbl_time_slot as t left join tbl_user as u on t.time_slot_id=u.user_time where u.user_id='$user_id'")or die(mysqli_error($conn));
								
            while($rowuser=mysqli_fetch_array($resultuser))
            {
                $user_time = $rowuser["user_time"];
                $usertype = $rowuser["user_type"];
                $cutoff_time = $rowuser["time_slot_cutoff_time"];
            }
            
            if($user_time=="0")
            {
                // echo "<b style='color:red'>User Not Assign any time slot</b>";
            }
            else{
            // echo "User : ".$user_id." And Cut-Off ".$cutoff_time." Finalcutoff : ".$finalcutoff."<BR><BR>";

            $resultq=mysqli_query($conn,"select * from tbl_order_calendar where order_id='$order_id' ORDER BY oc_id DESC LIMIT 1")or die(mysqli_error($conn));			
                while($rowq=mysqli_fetch_array($resultq))
                {
                    $order_date = $rowq["order_date"];
                }

                $newdate = date('Y-m-d', strtotime($order_date. '+  1 days'));
                // echo "date : ".$newdate."<br>";

                $finalcutoff = date('Y-m-d H:i:s', strtotime("$newdate $cutoff_time"));
                if($cutoff_time == "09:00:00")
                {
                }
                elseif($cutoff_time == "17:00:00")
                {
                    // $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '-  1 days'));
                }
                else
                {
                    
                }
                
                echo "USER : $user_id | ORDER DATE : $newdate | CUTOFF : $finalcutoff<BR><BR>";

                $result=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                values ('$order_id','$product_id','$user_id','$ds_qty','".date('Y-m-d', strtotime($newdate))."','".date('Y-m-d H:i:s', strtotime($finalcutoff))."','$order_date')") or die(mysqli_error($conn));
                if($result=true)
                {
                    $echo="yes";
                }
                else
                {
                    $echo="no";
                }
            }

        }
        

    }

?>