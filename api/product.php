<?php 
    include '../connection.php';
    $action=$_POST["action"];
    
    $response=array();

    if($action=='show_product1')
    {
        $user_id=$_POST["user_id"];
        // $result=mysqli_query($conn,"select * from tbl_product as p left join tbl_category as c on c.category_id=p.category_id left join tbl_attribute as a on a.attribute_id=p.attribute_id where p.product_status='1' order by product_sequence ASC LIMIT 5") or die(mysqli_error($conn));
           $result=mysqli_query($conn,"select * from tbl_product as p left join tbl_category as c on c.category_id=p.category_id left join tbl_attribute as a on a.attribute_id=p.attribute_id where p.product_status='1' order by product_sequence ASC") or die(mysqli_error($conn));

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
    }
    elseif($action=='show_product')
    {
        $user_id=$_POST["user_id"];
           $result=mysqli_query($conn,"select * from tbl_product as p left join tbl_category as c on c.category_id=p.category_id left join tbl_attribute as a on a.attribute_id=p.attribute_id where p.product_status='1' order by product_sequence ASC") or die(mysqli_error($conn));

        if(mysqli_num_rows($result)<=0)
        {
            
            $response["status"]="no";
            $response["error"]="No Data Available!";
        }
        else
        {
            while($row=mysqli_fetch_assoc($result))
            {
                $p_id=$row["product_id"];
                $resultorder=mysqli_query($conn,"select * from tbl_order where user_id='$user_id' and product_id='$p_id' and order_subscription_status!='2'") or die(mysqli_error($conn));
            
                if(mysqli_num_rows($resultorder)<=0)
                {
                    
                    $already = '0';
                }
                else
                {
                    $already = "1";
                }
                
                // $response[]=$row;
                $response[]=array(
                    "product_id" => $row["product_id"],
                    "category_id" => $row["category_id"],
                    "attribute_id" => $row["attribute_id"],
                    "product_type" => $row["product_type"],
                    "product_name" => $row["product_name"],
                    "product_image" => $row["product_image"],
                    "product_regular_price" => $row["product_regular_price"],
                    "product_normal_price" => $row["product_normal_price"],
                    "product_des" => $row["product_des"],
                    "product_att_value" => $row["product_att_value"],
                    "category_name" => $row["category_name"],
                    "attribute_id" => $row["attribute_id"],
                    "product_min_qty" => intval($row["product_min_qty"]),
                    "product_status" => $row["product_status"],
                    "featured_product" => $row["featured_product"],
                    "attribute_name" => $row["attribute_name"],
                    "product_att_value" => $row["product_att_value"],
                    "attribute_status" => $row["attribute_status"],
                    "product_already" => $already,
                    
                    
                    // "product_min_qty" => intval($row["product_min_qty"]),
                );
            }
        }
    }
    elseif($action=='category_product')
    {
        $category_id=$_POST["category_id"];
        $user_id=$_POST["user_id"];
        $result=mysqli_query($conn,"select * from tbl_product as p left join tbl_category as c on c.category_id=p.category_id left join tbl_attribute as a on a.attribute_id=p.attribute_id where p.category_id='$category_id' and p.product_status='1' order by product_sequence ASC") or die(mysqli_error($conn));
        if(mysqli_num_rows($result)<=0)
        {
            
            $response["status"]="no";
            $response["error"]="No Data Available!";
        }
        else
        {
            while($row=mysqli_fetch_assoc($result))
            {
                $p_id=$row["product_id"];
                $resultorder=mysqli_query($conn,"select * from tbl_order where user_id='$user_id' and product_id='$p_id' and order_subscription_status!='2'") or die(mysqli_error($conn));
            
                if(mysqli_num_rows($resultorder)<=0)
                {
                    
                    $already = '0';
                }
                else
                {
                    $already = "1";
                }
                
                // $response[]=$row;
                $response[]=array(
                    "product_id" => $row["product_id"],
                    "category_id" => $row["category_id"],
                    "attribute_id" => $row["attribute_id"],
                    "product_type" => $row["product_type"],
                    "product_name" => $row["product_name"],
                    "product_image" => $row["product_image"],
                    "product_regular_price" => $row["product_regular_price"],
                    "product_normal_price" => $row["product_normal_price"],
                    "product_des" => $row["product_des"],
                    "product_att_value" => $row["product_att_value"],
                    "category_name" => $row["category_name"],
                    "attribute_id" => $row["attribute_id"],
                    "product_min_qty" => intval($row["product_min_qty"]),
                    "product_status" => $row["product_status"],
                    "featured_product" => $row["featured_product"],
                    "attribute_name" => $row["attribute_name"],
                    "product_att_value" => $row["product_att_value"],
                    "attribute_status" => $row["attribute_status"],
                    "product_already" => $already,
                    
                    
                    // "product_min_qty" => intval($row["product_min_qty"]),
                );
                // $response[]=$row;
            }
        }
    }
    elseif($action=='get_product_detail')
    {
        $product_id=$_POST["product_id"];
        $result=mysqli_query($conn,"select * from tbl_product as p left join tbl_category as c on c.category_id=p.category_id left join tbl_attribute as a on a.attribute_id=p.attribute_id where p.product_id='$product_id'") or die(mysqli_error($conn));
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
                    "category_id" => $row["category_id"],
                    "category_name" => $row["category_name"],
                    "product_type" => $row["product_type"],
                    "attribute_id" => $row["attribute_id"],
                    "product_name" => $row["product_name"],
                    "product_image" => $row["product_image"],
                    "product_regular_price" => intval($row["product_regular_price"]),
                    "product_normal_price" => intval($row["product_normal_price"]),
                    "product_min_qty" => intval($row["product_min_qty"]),
                    // "product_price" => floatval($row["product_price"]),
                    // "product_price" => floatval($row["product_price"]),
                    "product_des" => $row["product_des"],
                    "product_status" => $row["product_status"],
                    "featured_product" => $row["featured_product"],
                    "attribute_name" => $row["attribute_name"],
                    "product_att_value" => $row["product_att_value"],
                    "attribute_status" => $row["attribute_status"],
                    );
            }
        }
    }
    elseif($action=='get_already_product_detail')
    {
        $product_id=$_POST["product_id"];
        $user_id=$_POST["user_id"];
        $result=mysqli_query($conn,"select * from tbl_product as p left join tbl_category as c on c.category_id=p.category_id left join tbl_attribute as a on a.attribute_id=p.attribute_id left join tbl_order as o on o.product_id=p.product_id left join tbl_delivery_schedule as ds on ds.order_id=o.order_id where p.product_id='$product_id' and o.user_id='$user_id'") or die(mysqli_error($conn));
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
                    "category_id" => $row["category_id"],
                    "category_name" => $row["category_name"],
                    "product_type" => $row["product_type"],
                    "attribute_id" => $row["attribute_id"],
                    "product_name" => $row["product_name"],
                    "product_image" => $row["product_image"],
                    "product_regular_price" => intval($row["product_regular_price"]),
                    "product_normal_price" => intval($row["product_normal_price"]),
                    "product_min_qty" => intval($row["product_min_qty"]),
                    // "product_price" => floatval($row["product_price"]),
                    // "product_price" => floatval($row["product_price"]),
                    "product_des" => $row["product_des"],
                    "product_status" => $row["product_status"],
                    "featured_product" => $row["featured_product"],
                    "attribute_name" => $row["attribute_name"],
                    "product_att_value" => $row["product_att_value"],
                    "attribute_status" => $row["attribute_status"],
                    "order_id" => $row["order_id"],
                    "ds_qty" => intval($row["ds_qty"]),
                    "ds_type" => $row["ds_type"],
                    "start_date" => $row["start_date"],
                    "ds_alt_diff" => $row["ds_alt_diff"],
                    "order_instructions" => $row["order_instructions"],
                    "order_ring_bell" => $row["order_ring_bell"],
                    );
            }
        }
    }
    else
    {
        $response["message"]="Something is Wrong";
    }
    echo json_encode($response);
?>