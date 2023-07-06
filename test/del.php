<?php 
    include '../connection.php';
    
    
    $result=mysqli_query($conn,"SELECT o.*,u.deliveryboy_id,u.user_id, p.*
FROM  `tbl_order_calendar` o JOIN 
      tbl_product p
      ON p.product_id = o.product_id left join tbl_user as u on u.user_id=o.user_id where o.order_date='2022-02-10' and u.deliveryboy_id='19' and o.product_id='9'");
while($row=mysqli_fetch_array($result))
{
    echo $row['product_name'].$row['product_id']." | QTY : ".$row['order_qty']."User :".$row['user_id']."<br>";
                                                
}

?>