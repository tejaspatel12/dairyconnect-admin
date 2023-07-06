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
        
        // $finaldata = $date . $hr;
        $finaltime = $date." ".$hr;
        // echo $finaltime;
        // $result=mysqli_query($conn,"select product_id,product_name,product_image from tbl_product") or die(mysqli_error($conn));
        
        // $result=mysqli_query($conn,"SELECT p.*,u.deliveryboy_id,oc.order_qty as order_qty from tbl_product as p LEFT JOIN tbl_order_calendar as oc ON oc.product_id=p.product_id left join tbl_user as u on u.user_id=oc.user_id where oc.order_date='$date' and u.deliveryboy_id='$deliveryboy_id' GROUP BY p.product_id");
                $result=mysqli_query($conn,"SELECT o.*,u.deliveryboy_id, p.*, SUM( o.order_qty ) as quantity
FROM  `tbl_order_calendar` o JOIN 
      tbl_product p
      ON p.product_id = o.product_id left join tbl_user as u on u.user_id=o.user_id where o.order_date='$date' and oc_cutoff_time='$finaltime' and u.deliveryboy_id='$deliveryboy_id' and o.oc_is_delivered!='3' and o.oc_is_delivered!='4'
GROUP BY p.product_id");

        if(mysqli_num_rows($result)<=0)
        {
            $response["status"]="no";
            $response["error"]="No Data Available!";
        }
        else
        {
            while($row=mysqli_fetch_assoc($result))
            {
                $response[]=array(
                    "product_id" => $row["product_id"],
                    "product_name" => $row["product_name"],
                    "product_image" => $row["product_image"],
                    "order_qty" => $row["quantity"],
                );
            }
        }
        
    echo json_encode($response);
?>