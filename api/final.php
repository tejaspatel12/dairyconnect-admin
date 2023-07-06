<?php 
    include '../connection.php';
    
    $start_date = "2021-12-03";
    $user_id = "2";
    
    $result=mysqli_query($conn,"select * from tbl_time_slot as t left join tbl_deliveryboy as d on d.time_slot_id=t.time_slot_id left join tbl_user as u on d.deliveryboy_id=u.deliveryboy_id where u.user_id='$user_id'")or die(mysqli_error($conn));
        
                while($row=mysqli_fetch_assoc($result))
                {
                    $cutofftime= $row["time_slot_cutoff_time"];
                        
                }
                
        $combinedDT = date('Y-m-d H:i:s', strtotime("$start_date $cutofftime"));
        echo $combinedDT;
        
            $result=mysqli_query($conn,"update tbl_order_calendar set oc_cutoff_time='$combinedDT' where user_id='$user_id' and order_date='$start_date'") or die(mysqli_error($conn));
            if($result=true)
            {
                echo "ww";
            }
            else
            {
                echo "qq";
            }
        
        
?>