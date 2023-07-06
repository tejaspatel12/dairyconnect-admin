<?php 
    include '../connection.php';
    $action=$_POST["action"];
    
    $response=array();

        $deliveryboy_id=$_POST["deliveryboy_id"];
        $date=$_POST["date"];
        $deliveryboy_time=$_POST["deliveryboy_time"];
        
        $resulthr=mysqli_query($conn,"select * from tbl_time_slot where time_slot_name='$deliveryboy_time'")or die(mysqli_error($conn));
        while($row=mysqli_fetch_assoc($resulthr))
        {
         $hr = $row["time_slot_cutoff_time"];
        }
    
        $result=mysqli_query($conn,"select * from tbl_user_order_calendar as uoc left join tbl_user as u on u.user_id=uoc.user_id where u.deliveryboy_id='$deliveryboy_id' and uoc.uoc_date='$date' and uoc.uoc_cutoff='$hr' order by u.sorting_no + 0 ASC") or die(mysqli_error($conn));
        
        // $result=mysqli_query($conn,"select * from tbl_user as u left join tbl_order_calendar as oc on oc.user_id=u.user_id left join tbl_order as o on o.order_id=oc.order_id left join tbl_product as p on p.product_id=o.product_id where u.deliveryboy_id='$deliveryboy_id' and order_date='$date'") or die(mysqli_error($conn));
        
        if(mysqli_num_rows($result)<=0)
        {
            $response["status"]="no";
            $response["error"]="No Data Available!";
        }
        else
        {
            while($row=mysqli_fetch_assoc($result))
            {
                $response[]=$row;
            }
        }
        
    echo json_encode($response);
?>