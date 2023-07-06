<?php 
    include '../connection.php';
    $action=$_POST["action"];
    
    $response=array();
    
    //USER
    if($action=='deliveryboy_timeslot')
    {
        $result=mysqli_query($conn,"select * from tbl_time_slot where time_slot_status='1'") or die(mysqli_error($conn));
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
    elseif($action=='is_set_batch')
    {
        $user_id=$_POST["user_id"];
        $time=$_POST["time"];
        
        $timedata=mysqli_query($conn,"select * from tbl_time_slot where time_slot_name='$time'") or die(mysqli_error($conn));
        while($rowarea=mysqli_fetch_assoc($timedata))
        {
            $time_slot_id = $rowarea['time_slot_id'];
        }
        
        $result=mysqli_query($conn,"update tbl_user set user_time='$time_slot_id' where user_id='$user_id'") or die(mysqli_error($conn));
        if($result=true)
        {
            $response["status"]="yes";
            $response["message"]="Area Asign Successfully.";
            
            
        }
        else
        {
            $response["status"]="no";
            $response["message"]="Something is Wrong";
        }
                    
        
    }
    elseif($action=='add_user_deliveryboy')
    {
        $user_first_name=$_POST["user_first_name"];
        $user_last_name=$_POST["user_last_name"];
        $user_email=$_POST["user_email"];
        $user_pass=$_POST["user_pass"];
        $user_address=$_POST["user_address"];
        $user_mobile_number=$_POST["user_mobile_number"];
        $deliveryboy_id=$_POST["deliveryboy_id"];
        $delivery_time=$_POST["delivery_time"];
        $delivery_area=$_POST["delivery_area"];
        
        $areadata=mysqli_query($conn,"select * from tbl_area where area_name='$delivery_area'") or die(mysqli_error($conn));
        while($rowarea=mysqli_fetch_assoc($areadata))
        {
            $area_id = $rowarea['area_id'];
        }
        
        $timedata=mysqli_query($conn,"select * from tbl_time_slot where time_slot_name='$delivery_time'") or die(mysqli_error($conn));
        while($rowarea=mysqli_fetch_assoc($timedata))
        {
            $time_slot_id = $rowarea['time_slot_id'];
        }
        
       $resultq=mysqli_query($conn,"select * from tbl_user where user_mobile_number='$user_mobile_number'") or die(mysqli_error($conn));
        if(mysqli_num_rows($resultq)<=0)
        {
             $result1=mysqli_query($conn,"select * from tbl_deliveryboy_area where area_id='$area_id' and deliveryboy_id='$deliveryboy_id'") or die(mysqli_error($conn));
             if(mysqli_num_rows($result1)<=0)
            {
                $response["status"]="no";
                $response["message"]="Add Only Your Area User";
            }
            else
            {
                $result=mysqli_query($conn,"insert into tbl_user(user_first_name,user_last_name,user_email,user_mobile_number,user_password,user_address,registration_complete,area_id,deliveryboy_id,user_time) 
                values('$user_first_name','$user_last_name','$user_email','$user_mobile_number','$user_pass','$user_address','1','$area_id','$deliveryboy_id','$time_slot_id')") or die(mysqli_error($conn));
                if($result=true)
                {
                    $response["status"]="yes";
                    $response["message"]="Successfully User Added";
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
            $response["status"]="no";
            $response["message"]="User Available on this Mobile Number";
        }
        
    }
    elseif($action=='show_user_balance_log')
        {
            $user_id=$_POST["user_id"];
            $result=mysqli_query($conn,"select * from tbl_user_balance_log where user_id='$user_id' and ubl_type='Credit' order by ubl_date DESC") or die(mysqli_error($conn));
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
        elseif($action=='show_user_order_log')
        {
            $user_id=$_POST["user_id"];
            $result=mysqli_query($conn,"select a.attribute_name,oc.*,p.* from tbl_order_calendar as oc left join tbl_product as p on oc.product_id=p.product_id left join tbl_attribute as a on a.attribute_id=p.attribute_id where user_id='$user_id' and oc_is_delivered='1' order by oc.order_date DESC") or die(mysqli_error($conn));
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
        elseif($action=='show_user_balance')
        {
            $user_id=$_POST["user_id"];
            $result=mysqli_query($conn,"select user_balance,user_id from tbl_user where user_id='$user_id'") or die(mysqli_error($conn));
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
        elseif($action=='add_user_balance')
        {
            $user_id=$_POST["user_id"];
            $deliveryboy_id=$_POST["deliveryboy_id"];
            $payment_amt=$_POST["payment_amt"];
            $deliveryboy_img=$_POST["deliveryboy_img"];
            $payment_type="Cash Collect";
            $payment_status='1';
            
            $data = base64_decode($deliveryboy_img);
            $image=rand(111111,999999).".png";
            file_put_contents("../images/payment_deliveryboy/".$image,$data);
            
            $result=mysqli_query($conn,"select * from tbl_user where user_id='$user_id'") or die(mysqli_error($conn));
            while($row=mysqli_fetch_assoc($result))
            {
                $user_old_balance = $row['user_balance'];
               
            }
            
             $user_new_balance = $user_old_balance + $payment_amt;
                     
            
            $date = date("Y-m-d");
            $result=mysqli_query($conn,"insert into tbl_payment(user_id,deliveryboy_id,deliveryboy_img,payment_amt,payment_type,payment_status) values('$user_id','$deliveryboy_id','$image','$payment_amt','$payment_type','$payment_status')") or die(mysqli_error($conn));
            $last_id = $conn->insert_id;
            
            $result1=mysqli_query($conn,"insert into tbl_user_balance_log(user_id,payment_id,ubl_amount,ubl_user_balance,ubl_type,tbl_tilte,ubl_date,ubl_status) values('$user_id','$last_id','$payment_amt','$user_new_balance','Credit','Delivery Boy Collect Payment of Rs. $payment_amt','$date','1')") or die(mysqli_error($conn));
                if($result=true && $result1=true)
                {
                    
                    // $num = (double) $user_new_balance;
                    // $num = floatval('$user_new_balance');
                
                    $result=mysqli_query($conn,"update tbl_user set user_balance='$user_new_balance' where user_id='$user_id'") or die(mysqli_error($conn));
                    if($result=true)
                    {
                        $response["status"]="yes";
                        // $response["message"]="Payment of Rs.$payment_amt is successfully received";
                        $response["message"]="Payment received successfully";
                        
                        
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
        }
        elseif($action=='get_my_order')
        {
            $user_id=$_POST["user_id"];
            
            $result=mysqli_query($conn,"select * from tbl_order as o left join tbl_delivery_schedule as d on d.order_id=o.order_id left join tbl_product as p on p.product_id=o.product_id where o.user_id='$user_id' and o.delivery_schedule!='' and o.order_subscription_status!='2'") or die(mysqli_error($conn));
                if(mysqli_num_rows($result)>0)
                {
                    while($row=mysqli_fetch_assoc($result))
                    {
                        //data
                        $response[]=$row;
                        //data
                    }
                }
                else
                {
                    $response["status"]="no";
                    $response["message"]="Something is Wrong";
                }
        }
        elseif($action=='get_my_once_order')
        {
            $user_id=$_POST["user_id"];
            $newdateone = date("Y-m-d");
            $olddateone = date('Y-m-d', strtotime($newdateone. '+  30 days'));
            
            $result=mysqli_query($conn,"select * from tbl_order as o left join tbl_product as p on p.product_id=o.product_id left join tbl_order_calendar as oc on oc.order_id=o.order_id where o.order_subscription_status!='2' and o.user_id='$user_id' and o.delivery_schedule='' and oc.oc_is_delivered!='1' and oc.order_date between '$newdateone' and '$olddateone'") or die(mysqli_error($conn));
                if(mysqli_num_rows($result)>0)
                {
                    while($row=mysqli_fetch_assoc($result))
                    {
                        //data
                        $response[]=$row;
                        //data
                    }
                }
                else
                {
                    $response["status"]="no";
                    $response["message"]="Something is Wrong";
                }
        }
        elseif($action=='user_not_subscription_product')
        {
            $user_id=$_POST["user_id"];
            $result=mysqli_query($conn,"select * from tbl_product as p left join tbl_category as c on c.category_id=p.category_id left join tbl_attribute as a on a.attribute_id=p.attribute_id where p.product_status='1' and p.product_type='1' order by product_sequence ASC") or die(mysqli_error($conn));
    
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
                        
                        // $already = '0';
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
                        );
                    }
                    else
                    {
                        // $already = "1";
                    }
                    
                    // $response[]=$row;
                    
                }
            }
        }
        //onecorder
        elseif($action=='user_onec_product')
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
                    );
                    
                }
            }
        }
        
        //ADD ORDER
        elseif($action=='deliveryboy_order_everyday_subscription_product')
        {
            $user_id=$_POST["user_id"];
            $product_id=$_POST["product_id"];
            $product_name=$_POST["product_name"];
            $attribute_id=$_POST["attribute_id"];
            $cutoff_time=$_POST["cutoff_time"];
            $product_price=$_POST["product_price"];
            $delivery_schedule=$_POST["delivery_schedule"];
            $qty=$_POST["qty"];
            $start_date=$_POST["start_date"];
            
            $finalcutoff = date('Y-m-d H:i:s', strtotime("$start_date $cutoff_time"));
            
    
            $total = $product_price * $qty;
    
            $result1=mysqli_query($conn,"select * from tbl_user where user_id='$user_id'")or die(mysqli_error($conn));
            while($row=mysqli_fetch_assoc($result1))
            {
                $user_balance = $row['user_balance'];
                $accept_nagative_balance = $row['accept_nagative_balance'];
    
            }
    
            if(($accept_nagative_balance == '0') && ($total > $user_balance))
            {
                $response["status"]="insufficient_balance";
                $response["message"]="Insufficient Balance";
                $response["description"]="Please Recharge Your Wallet";
            }
            else
            {
                $result=mysqli_query($conn,"insert into tbl_order (user_id,product_id,attribute_id,start_date,order_ring_bell,delivery_schedule) 
                values ('$user_id','$product_id','$attribute_id','$start_date','0','$delivery_schedule')") or die(mysqli_error($conn));
                if($result=true)
                {
                    $order_id = $conn->insert_id;
        
                    $result2=mysqli_query($conn,"insert into tbl_delivery_schedule (order_id,ds_type,ds_qty) 
                    values ('$order_id','$delivery_schedule','$qty')") or die(mysqli_error($conn));
                    
                    $round = 15;
                    
                    for ($i = 0; $i <= $round; $i++){
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$qty','".date('Y-m-d', strtotime($start_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                    }
                    
        
                    if($result2=true && $result3=true)
                    {
                        $response["status"]="yes";
                        $response["message"]="Successfully Ordered";
                        $response["description"]="$product_name subscription with $qty quantity will start from $start_date for everyday.";
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
            }
            
    
            
        }
        //ADD ONEC ORDER
        elseif($action=='deliveryboy_order_onetime_product')
        {
            $user_id=$_POST["user_id"];
            $product_id=$_POST["product_id"];
            $attribute_id=$_POST["attribute_id"];
            $cutoff_time=$_POST["cutoff_time"];
            $order_amt=$_POST["order_amt"];
            $order_qty=$_POST["order_qty"];
            $start_date=$_POST["start_date"];
            $order_ring_bell='0';
            
            $total_one_amt = $order_amt * $order_qty;
            
            $finalcutoff = date('Y-m-d H:i:s', strtotime("$start_date $cutoff_time"));
      
            // $total = $product_price * $qty;
    
            $result1=mysqli_query($conn,"select * from tbl_user where user_id='$user_id'")or die(mysqli_error($conn));
            while($row=mysqli_fetch_assoc($result1))
            {
                $user_balance = $row['user_balance'];
                $accept_nagative_balance = $row['accept_nagative_balance'];
    
            }
    
            if(($accept_nagative_balance == '0') && ($total_one_amt > $user_balance))
            {
                $response["status"]="insufficient_balance";
                $response["message"]="Insufficient Balance";
                $response["description"]="Please Recharge Your Wallet";
            }
            else
            {
               $result=mysqli_query($conn,"insert into tbl_order (user_id,product_id,attribute_id,start_date,order_ring_bell) 
                values ('$user_id','$product_id','$attribute_id','$start_date','$order_ring_bell')") or die(mysqli_error($conn));
                if($result=true)
                {
                    $order_id = $conn->insert_id;
    
                    $result1=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_one_unit_price,order_total_amt,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$order_qty','$order_amt','$total_one_amt','$start_date','".date('Y-m-d H:i:s', strtotime($finalcutoff))."','$start_date')") or die(mysqli_error($conn));
                    
                    if($result1=true)
                    {
                        $response["status"]="yes";
                        $response["message"]="Successfully Ordered $finalcutoff"; 
                        $response["description"]="$product_name One Time Purchase with $qty quantity will delivered from $start_date.";
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
            }
            
    
                
        }
        

    
    
    
    else
    {
        $response["message"]="Something is Wrong";
    }
    echo json_encode($response);
?>