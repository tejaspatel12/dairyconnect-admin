<?php 
    include '../connection.php';

        $user_id=$_POST["user_id"];
        $product_id=$_POST["product_id"];
        $attribute_id=$_POST["attribute_id"];
        $order_amt=$_POST["order_amt"];
        $order_qty=$_POST["order_qty"];
        $start_date=$_POST["start_date"];
        $cdate=$_POST["current_date"];
        $order_instructions=$_POST["order_instructions"];
        $order_ring_bell=$_POST["order_ring_bell"];
        
        $total_one_amt = $order_amt * $order_qty;

        $result=mysqli_query($conn,"select * from tbl_time_slot as t left join tbl_deliveryboy as d on d.time_slot_id=t.time_slot_id left join tbl_user as u on d.deliveryboy_id=u.deliveryboy_id where u.user_id='$user_id'")or die(mysqli_error($conn));
        
        while($row=mysqli_fetch_assoc($result))
        {
            $cutofftime= $row["time_slot_cutoff_time"];
                
        }
        echo $cutofftime."<br>";
        
        echo $finalcutoff = date('Y-m-d H:i:s', strtotime("$start_date $cutofftime"))."<br>";
        
        

            $result=mysqli_query($conn,"insert into tbl_order (user_id,product_id,attribute_id,start_date,order_instructions,order_ring_bell) 
            values ('$user_id','$product_id','$attribute_id','$start_date','$order_instructions','$order_ring_bell')") or die(mysqli_error($conn));
            if($result=true)
            {
                
                $order_id = $conn->insert_id;
                $result1=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_one_unit_price,order_total_amt,order_date,oc_cutoff_time,oc_date) 
                    values ('$order_id','$product_id','$user_id','$order_qty','$order_amt','$total_one_amt','$start_date','".$finalcutoff."','$start_date')") or die(mysqli_error($conn));
                
                if($result1=true)
                {
                    $response["status"]="yes";
                    $response["message"]="Successfully Ordered $finalcutoff";
                    echo "Successfully Ordered $finalcutoff";
                }
                else
                {
                    $response["status"]="no";
                    $response["message"]="Something is Wrong";
                }
            }
            else
            {
                $response["status"]="no";
                $response["message"]="Something is Wrong";
            }
            
            
?>