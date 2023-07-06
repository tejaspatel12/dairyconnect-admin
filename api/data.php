<?php 
    include '../connection.php';


        // $deliveryboy_id=$_POST["deliveryboy_id"];
        // $date=$_POST["date"];
        
       $deliveryboy_id="2";
        $date="2021-12-02";
        
        $result=mysqli_query($conn,"select product_id,product_name,product_image from tbl_product") or die(mysqli_error($conn));

        if(mysqli_num_rows($result)<=0)
        {
            $response["status"]="no";
            $response["error"]="No Data Available!";
        }
        else
        {
            while($row=mysqli_fetch_assoc($result))
            {
                echo $row["product_id"]." ".$row["product_name"]." = ";
                
                $result1=mysqli_query($conn,"select * from tbl_order as o left join tbl_order_calendar as oc on o.order_id=oc.order_id left join tbl_user as u on o.user_id=u.user_id where o.product_id='".$row["product_id"]."' and u.deliveryboy_id='$deliveryboy_id' and oc.order_date='$date'") or die(mysqli_error($conn));
                while($rowq=mysqli_fetch_assoc($result1))
                {
                    $qty +=$rowq["order_qty"]++;
                    // echo "1";
                }
                echo $qty."<br>";
                
            }
        }
?>