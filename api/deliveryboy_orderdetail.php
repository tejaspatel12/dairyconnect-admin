<?php 
    include '../connection.php';
    // $action=$_POST["action"];
    
    $response=array();

// if($action='user_orderdetail')
// {
    

        $deliveryboy_id=$_POST["deliveryboy_id"];
        $user_id=$_POST["user_id"];
        $date=$_POST["date"];
        
        $result=mysqli_query($conn,"select * from tbl_order_calendar as oc left join tbl_order as o on o.order_id=oc.order_id left join tbl_product as p on p.product_id=o.product_id left join tbl_user as u on u.user_id=oc.user_id left join tbl_attribute as a on a.attribute_id=p.attribute_id where u.deliveryboy_id='$deliveryboy_id' and u.user_id='$user_id' and oc.order_date='$date' and oc.oc_is_delivered!='2' and oc.oc_is_delivered!='3' and oc.oc_is_delivered!='4'") or die(mysqli_error($conn));
        
        if(mysqli_num_rows($result)<=0)
        {
            $response["status"]="no";
            $response["error"]="No Data Available!";
        }
        else
        {
            while($row=mysqli_fetch_assoc($result))
            {
                // $response[]=$row;
                $response[]=array(
                    "oc_id" => $row["oc_id"],
                    "order_id" => $row["order_id"],
                    "product_id" => $row["product_id"],
                    "attribute_name" => $row["attribute_name"],
                    "user_id" => $row["user_id"],
                    "order_qty" => $row["order_qty"],
                    "order_qty_int" => intval($row["order_qty"]),
                    "delivered_qty" => $row["delivered_qty"],
                    "not_delivered_qty" => $row["not_delivered_qty"],
                    "order_one_unit_price" => $row["order_one_unit_price"],
                    "order_total_amt" => $row["order_total_amt"],
                    "order_date" => $row["order_date"],
                    "oc_cutoff_time" => $row["oc_cutoff_time"],
                    "oc_date" => $row["oc_date"],
                    "oc_notdelivered_issue" => $row["oc_notdelivered_issue"],
                    "oc_is_delivered" => $row["oc_is_delivered"],
                    "oc_admin_approve" => $row["oc_admin_approve"],
                    "attribute_id" => $row["attribute_id"],
                    "start_date" => $row["start_date"],
                    "delivery_schedule" => $row["delivery_schedule"],
                    "order_instructions" => $row["order_instructions"],
                    "order_ring_bell" => $row["order_ring_bell"],
                    "order_subscription_status" => $row["order_subscription_status"],
                    "push_date" => $row["push_date"],
                    "resume_date" => $row["resume_date"],
                    "added_time" => $row["added_time"],
                    "category_id" => $row["category_id"],
                    "product_type" => $row["product_type"],
                    "product_name" => $row["product_name"],
                    "product_image" => $row["product_image"],
                    "product_regular_price" => $row["product_regular_price"],
                    "product_normal_price" => $row["product_normal_price"],
                    "product_des" => $row["product_des"],
                    "product_att_value" => $row["product_att_value"],
                    "product_min_qty" => $row["product_min_qty"],
                    "product_status" => $row["product_status"],
                    "product_sequence" => $row["product_sequence"],
                    "deliveryboy_id" => $row["deliveryboy_id"],
                    "user_time" => $row["user_time"],
                    "area_id" => $row["area_id"],
                    "area" => $row["area"],
                    "user_first_name" => $row["user_first_name"],
                    "user_last_name" => $row["user_last_name"],
                    "user_email" => $row["user_email"],
                    "user_mobile_number" => $row["user_mobile_number"],
                    "user_password" => $row["user_password"],
                    "user_address" => $row["user_address"],
                    "user_balance" => $row["user_balance"],
                    "user_subscription_status" => $row["user_subscription_status"],
                    "accept_nagative_balance" => $row["accept_nagative_balance"],
                    "user_type" => $row["user_type"],
                    "user_status" => $row["user_status"],
                    "sorting_no" => $row["sorting_no"],
                    "user_token" => $row["user_token"],
                    "registration_complete" => $row["registration_complete"],
                );
                
                // $response[]=array(
                //     "oc_id" => $row["oc_id"],
                //     "order_id" => $row["order_id"],
                //     "user_id" => $row["user_id"],
                //     "order_qty" => intval($row["order_qty"]),
                //     "product_id" => $row["product_id"],
                //     "attribute_id" => $row["attribute_id"],
                //     "product_name" => $row["product_name"],
                //     "product_image" => $row["product_image"],
                //     "product_des" => $row["product_des"],
                //     "product_status" => $row["product_status"],
                //     "product_regular_price" => $row["product_regular_price"],
                //     "product_normal_price" => $row["product_normal_price"],
                //     "user_type" => $row["user_type"],
                //     "oc_is_delivered" => $row["oc_is_delivered"],
                //     "order_subscription_status" => $row["order_subscription_status"],
                //     "user_balance" => $row["user_balance"],
                //     "added_time" => $row["added_time"],
                //     "order_ring_bell" => $row["order_ring_bell"],
                //     "order_instructions" => $row["order_instructions"],
                //     "delivery_schedule" => $row["delivery_schedule"],
                //     "start_date" => $row["start_date"],
                //     "attribute_value" => $row["attribute_value"],
                //     "attribute_status" => $row["attribute_status"],
                //     "attribute_name" => $row["attribute_name"],
                //     "product_status" => $row["product_status"],
                // );
            }
        }
    
// }else
// {
//     $response["status"]="no";
//     $response["error"]="No Data Available!";
// }
        
    echo json_encode($response);
?>