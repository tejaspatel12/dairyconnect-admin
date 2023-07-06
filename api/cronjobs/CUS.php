<?php 
    date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)
    include '../../connection.php';

    // $DATE = date("Y-m-d");
    // $DATE = "2022-02-02";

    $sql = mysqli_query($conn,"select * from tbl_order as o left join tbl_delivery_schedule as ds on o.order_id=ds.order_id where o.order_subscription_status='1'");
    while($row=mysqli_fetch_assoc($sql))
    {
        $type = $row["delivery_schedule"];

        if($type == "Customize")
        {

            $order_id = $row["order_id"];
            $product_id = $row["product_id"];
            $user_id = $row["user_id"];

            $ds_Sun = $row["ds_Sun"];
            $ds_Mon = $row["ds_Mon"];
            $ds_Tue = $row["ds_Tue"];
            $ds_Wed = $row["ds_Wed"];
            $ds_Thu = $row["ds_Thu"];
            $ds_Fri = $row["ds_Fri"];
            $ds_Sat = $row["ds_Sat"];

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


                $new_date = date('Y-m-d', strtotime($order_date));

                if($new_date = date('D', strtotime($new_date))=='Sun')
                {
                    $new_date = date('Y-m-d', strtotime($order_date. '+  1 days'));
                    echo "date : ".$new_date."<br>";

                    $finalcutoff = date('Y-m-d H:i:s', strtotime("$new_date $cutoff_time"));
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
                    values ('$order_id','$product_id','$user_id','$ds_Mon','".date('Y-m-d', strtotime($new_date))."','".date('Y-m-d H:i:s', strtotime($finalcutoff))."','$order_date')") or die(mysqli_error($conn));
                    if($result=true)
                    {
                        $echo="yes";
                    }
                    else
                    {
                        $echo="no";
                    }
                }
                if($new_date = date('D', strtotime($new_date))=='Mon')
                {
                    $new_date = date('Y-m-d', strtotime($order_date. '+  1 days'));
                    echo "date : ".$new_date."<br>";

                    $finalcutoff = date('Y-m-d H:i:s', strtotime("$new_date $cutoff_time"));
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
                    values ('$order_id','$product_id','$user_id','$ds_Tue','".date('Y-m-d', strtotime($new_date))."','".date('Y-m-d H:i:s', strtotime($finalcutoff))."','$order_date')") or die(mysqli_error($conn));
                    if($result=true)
                    {
                        $echo="yes";
                    }
                    else
                    {
                        $echo="no";
                    }
                }

                if($new_date = date('D', strtotime($new_date))=='Tue')
                {
                    $new_date = date('Y-m-d', strtotime($order_date. '+  1 days'));
                    echo "date : ".$new_date."<br>";

                    $finalcutoff = date('Y-m-d H:i:s', strtotime("$new_date $cutoff_time"));
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
                    values ('$order_id','$product_id','$user_id','$ds_Wed','".date('Y-m-d', strtotime($new_date))."','".date('Y-m-d H:i:s', strtotime($finalcutoff))."','$order_date')") or die(mysqli_error($conn));
                    if($result=true)
                    {
                        $echo="yes";
                    }
                    else
                    {
                        $echo="no";
                    }
                }

                if($new_date = date('D', strtotime($new_date))=='Wed')
                {
                    $new_date = date('Y-m-d', strtotime($order_date. '+  1 days'));
                    echo "date : ".$new_date."<br>";

                    $finalcutoff = date('Y-m-d H:i:s', strtotime("$new_date $cutoff_time"));
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
                    values ('$order_id','$product_id','$user_id','$ds_Thu','".date('Y-m-d', strtotime($new_date))."','".date('Y-m-d H:i:s', strtotime($finalcutoff))."','$order_date')") or die(mysqli_error($conn));
                    if($result=true)
                    {
                        $echo="yes";
                    }
                    else
                    {
                        $echo="no";
                    }
                }

                if($new_date = date('D', strtotime($new_date))=='Thu')
                {
                    $new_date = date('Y-m-d', strtotime($order_date. '+  1 days'));
                    echo "date : ".$new_date."<br>";

                    $finalcutoff = date('Y-m-d H:i:s', strtotime("$new_date $cutoff_time"));
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
                    values ('$order_id','$product_id','$user_id','$ds_Fri','".date('Y-m-d', strtotime($new_date))."','".date('Y-m-d H:i:s', strtotime($finalcutoff))."','$order_date')") or die(mysqli_error($conn));
                    if($result=true)
                    {
                        $echo="yes";
                    }
                    else
                    {
                        $echo="no";
                    }
                }

                if($new_date = date('D', strtotime($new_date))=='Fri')
                {
                    $new_date = date('Y-m-d', strtotime($order_date. '+  1 days'));
                    echo "date : ".$new_date."<br>";

                    $finalcutoff = date('Y-m-d H:i:s', strtotime("$new_date $cutoff_time"));
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
                    values ('$order_id','$product_id','$user_id','$ds_Sat','".date('Y-m-d', strtotime($new_date))."','".date('Y-m-d H:i:s', strtotime($finalcutoff))."','$order_date')") or die(mysqli_error($conn));
                    if($result=true)
                    {
                        $echo="yes";
                    }
                    else
                    {
                        $echo="no";
                    }
                }

                if($new_date = date('D', strtotime($new_date))=='Sat')
                {
                    $new_date = date('Y-m-d', strtotime($order_date. '+  1 days'));
                    echo "date : ".$new_date."<br>";

                    $finalcutoff = date('Y-m-d H:i:s', strtotime("$new_date $cutoff_time"));
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
                    values ('$order_id','$product_id','$user_id','$ds_Sun','".date('Y-m-d', strtotime($new_date))."','".date('Y-m-d H:i:s', strtotime($finalcutoff))."','$order_date')") or die(mysqli_error($conn));
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