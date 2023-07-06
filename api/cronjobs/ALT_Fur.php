<?php 
    date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)
    include '../../connection.php';

    // $DATE = date("Y-m-d");
    // $DATE = "2022-02-02";

    $sql = mysqli_query($conn,"select * from tbl_order as o left join tbl_delivery_schedule as ds on o.order_id=ds.order_id where o.order_subscription_status='1'");
    while($row=mysqli_fetch_assoc($sql))
    {
        $type = $row["delivery_schedule"];

        if($type == "Alternate Day")
        {

            $order_id = $row["order_id"];
            $product_id = $row["product_id"];
            $user_id = $row["user_id"];
            $ds_qty = $row["ds_qty"];
            $ds_alt_diff = $row["ds_alt_diff"];

            $resultuser=mysqli_query($conn,"select * from tbl_time_slot as t left join tbl_deliveryboy as d on d.time_slot_id=t.time_slot_id left join tbl_user as u on d.deliveryboy_id=u.deliveryboy_id where u.user_id='$user_id'")or die(mysqli_error($conn));
								
            while($rowuser=mysqli_fetch_array($resultuser))
            {
                $usertype = $rowuser["user_type"];
                $cutoff_time = $rowuser["time_slot_cutoff_time"];
            }



            // echo "User : ".$user_id." And Cut-Off ".$cutoff_time." Finalcutoff : ".$finalcutoff."<BR><BR>";

            
                
                $resultq=mysqli_query($conn,"select * from tbl_order_calendar where order_id='$order_id' ORDER BY oc_id DESC LIMIT 1")or die(mysqli_error($conn));			
                while($rowq=mysqli_fetch_array($resultq))
                {
                    $order_date = $rowq["order_date"];
                }
                echo "date : ".$order_date."<br>";

                if($ds_alt_diff=="Every 4th Day")
                {
                    $newdate = date('Y-m-d', strtotime($order_date. '+  4 days'));
                    echo "date : ".$newdate."<br>";

                    $finalcutoff = date('Y-m-d H:i:s', strtotime("$newdate $cutoff_time"));
                    if($cutoff_time == "14:00:00")
                    {
                    }
                    elseif($cutoff_time == "22:00:00")
                    {
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '-  1 days'));
                    }
                    else
                    {
                        
                    }

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