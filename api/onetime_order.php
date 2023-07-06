<?php 
    include '../connection.php';
    $action=$_POST["action"];
    
    $response=array();
    
    if($action=='order_onetime_product')
    {
        $user_id=$_POST["user_id"];
        $product_id=$_POST["product_id"];
        $attribute_id=$_POST["attribute_id"];
        $cutoff_time=$_POST["cutoff_time"];
        $order_amt=$_POST["order_amt"];
        $order_qty=$_POST["order_qty"];
        $start_date=$_POST["start_date"];
        $order_instructions=$_POST["order_instructions"];
        $order_ring_bell=$_POST["order_ring_bell"];
        
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
           $result=mysqli_query($conn,"insert into tbl_order (user_id,product_id,attribute_id,start_date,order_instructions,order_ring_bell) 
            values ('$user_id','$product_id','$attribute_id','$start_date','$order_instructions','$order_ring_bell')") or die(mysqli_error($conn));
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