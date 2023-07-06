<?php 
    include '../connection.php';
    $action=$_POST["action"];
    
    $response=array();

    if($action=='get_my_calendar')
    {
        $user_id=$_POST["user_id"];
        $date=$_POST["date"];
        
        $result=mysqli_query($conn,"select * from tbl_order_calendar as oc left join tbl_order as o on oc.order_id=o.order_id left join tbl_product as p on p.product_id=o.product_id left join tbl_user as u on u.user_id=o.user_id where o.user_id='$user_id' and order_date='$date' and oc_is_delivered!='2'") or die(mysqli_error($conn));
            if(mysqli_num_rows($result)>0)
            {
                while($row=mysqli_fetch_assoc($result))
                {
                    $response[]=array(
                    "oc_id" => $row["oc_id"],
                    "order_id" => $row["order_id"],
                    "user_id" => $row["user_id"],
                    "order_qty" => intval($row["order_qty"]),
                    "order_date" => $row["order_date"],
                    "oc_cutoff_time" => $row["oc_cutoff_time"],
                    "product_id" => $row["product_id"],
                    "delivery_schedule" => $row["delivery_schedule"],
                    "order_instructions" => $row["order_instructions"],
                    "order_ring_bell" => $row["order_ring_bell"],
                    "product_name" => $row["product_name"],
                    "product_image" => $row["product_image"],
                    "product_regular_price" => intval($row["product_regular_price"]),
                    "product_normal_price" => intval($row["product_normal_price"]),
                    "user_type" => $row["user_type"],
                    "oc_is_delivered" => $row["oc_is_delivered"],
                    "order_total_amt" => $row["order_total_amt"],
                    );
                }
            }
            else
            {
                $response["status"]="no";
                $response["message"]="Something is Wrong";
            }
    }
    elseif($action=='get_calendar_detail')
    {
        $order_id=$_POST["order_id"];
        $user_id=$_POST["user_id"];
        $date=$_POST["date"];
        
        $result=mysqli_query($conn,"select * from tbl_order as o left join tbl_order_calendar as oc on o.order_id=oc.order_id left join tbl_product as p on p.product_id=o.product_id left join tbl_user as u on u.user_id=o.user_id where oc.order_date='$date' and o.order_id='$order_id' and o.user_id='$user_id'") or die(mysqli_error($conn));
            if(mysqli_num_rows($result)>0)
            {
                while($row=mysqli_fetch_assoc($result))
                {
                    $response[]=array(
                    "oc_id" => $row["oc_id"],
                    "order_id" => $row["order_id"],
                    "user_id" => $row["user_id"],
                    "order_qty" => intval($row["order_qty"]),
                    "order_date" => $row["order_date"],
                    "oc_cutoff_time" => $row["oc_cutoff_time"],
                    "product_id" => $row["product_id"],
                    "delivery_schedule" => $row["delivery_schedule"],
                    "order_instructions" => $row["order_instructions"],
                    "order_ring_bell" => $row["order_ring_bell"],
                    "product_name" => $row["product_name"],
                    "product_image" => $row["product_image"],
                    "product_regular_price" => intval($row["product_regular_price"]),
                    "product_normal_price" => intval($row["product_normal_price"]),
                    "user_type" => $row["user_type"],
                    "oc_is_delivered" => $row["oc_is_delivered"],
                    );
                }
            }
            else
            {
                $response["status"]="no";
                $response["message"]="Something is Wrong";
            }
    }
    elseif($action=='update_calendar_subscription')
    {
        $oc_id=$_POST["oc_id"];
        $user_id=$_POST["user_id"];
        $date=$_POST["date"];
        $order_qty=$_POST["order_qty"];
        $order_one_unit_price=$_POST["order_one_unit_price"];
        
        $total_amt = $order_one_unit_price * $order_qty;
        
        // $total = $product_price * $qty;

        $result1=mysqli_query($conn,"select * from tbl_user where user_id='$user_id'")or die(mysqli_error($conn));
        while($row=mysqli_fetch_assoc($result1))
        {
            $user_balance = $row['user_balance'];
            $accept_nagative_balance = $row['accept_nagative_balance'];

        }

        if(($accept_nagative_balance == '0') && ($total_amt > $user_balance))
        {
            $response["status"]="insufficient_balance";
            $response["message"]="Insufficient Balance";
            $response["description"]="Please Recharge Your Wallet";
        }
        else
        {
            $result=mysqli_query($conn,"update tbl_order_calendar set order_qty='$order_qty',order_one_unit_price='$order_one_unit_price',order_total_amt='$total_amt' where user_id='$user_id' and oc_id='$oc_id' and order_date='$date'") or die(mysqli_error($conn));
            if($result=true)
            {
                $response["status"]="yes";
                $response["message"]="Successfully Inserted";
            }
            else
            {
                $response["status"]="no";
                $response["message"]="Something is Wrong";
            }
        }

    }
    else
    {
        $response["message"]="Something is Wrong";
    }
    echo json_encode($response);
?>