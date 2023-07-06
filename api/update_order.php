<?php 
    include '../connection.php';
    $action=$_POST["action"];
    
    $response=array();

    
    
    //UPDATE
    if($action=='update_order_everyday_subscription_product')
    {
        $user_id=$_POST["user_id"];
        $order_id=$_POST["order_id"];
        $product_name=$_POST["product_name"];
        $product_price=$_POST["product_price"];
        $cutoff_time=$_POST["cutoff_time"];
        $qty=$_POST["qty"];
        $start_date=$_POST["start_date"];
        $order_instructions=$_POST["order_instructions"];
        $order_ring_bell=$_POST["order_ring_bell"];
        
        $lastdate = date('Y-m-d', strtotime($start_date. '+  120 days'));
        
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
        
        // $result=mysqli_query($conn,"update tbl_order_calendar set order_qty='$qty' where user_id='$user_id' and order_id='$order_id' and order_date BETWEEN $start_date AND $lastdate") or die(mysqli_error($conn));
        
        $result=mysqli_query($conn,"update tbl_order_calendar set order_qty='$qty' where user_id='$user_id' and order_id='$order_id' and order_date between '$start_date' and '$lastdate'") or die(mysqli_error($conn));
            
            $result1=mysqli_query($conn,"update tbl_delivery_schedule set ds_qty='$qty' where order_id='$order_id'") or die(mysqli_error($conn));
            
            if($result=true && $result1=true)
            {
                $response["status"]="yes";
                $response["message"]="Update Successfully";
                // $response["description"]="$product_name subscription has been changed to $qty and will take into consideration from $start_date";
               $response["description"]="$product_name subscription has been changed to $qty and will take into consideration from $start_date";
            }
            else
            {
                $response["status"]="no";
                $response["message"]="Something is Wrong";
            }
            
        }
        

    }
    elseif($action=='update_order_alternateday_subscription_product')
    {
        $user_id=$_POST["user_id"];
        $order_id=$_POST["order_id"];
        $product_id=$_POST["product_id"];
        $cutoff_time=$_POST["cutoff_time"];
        $product_name=$_POST["product_name"];
        $product_price=$_POST["product_price"];
        $delivery_schedule=$_POST["delivery_schedule"];
        $ds_alt_diff=$_POST["ds_alt_diff"];
        $qty=$_POST["qty"];
        $start_date=$_POST["start_date"];
        $order_instructions=$_POST["order_instructions"];
        $order_ring_bell=$_POST["order_ring_bell"];
        
        $finalcutoff = date('Y-m-d H:i:s', strtotime("$start_date $cutoff_time"));
                
        if($cutoff_time == "14:00:00")
        {
            // $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  0 days'));
        }
        elseif($cutoff_time == "22:00:00")
        {
            $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '-  1 days'));
        }
        else
        {
            
        }
        $ala_date = date('Y-m-d', strtotime($start_date. ' +  60 days'));
        
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
            $result=mysqli_query($conn,"select ds_alt_diff from tbl_delivery_schedule where order_id='$order_id'")or die(mysqli_error($conn));
            while($row=mysqli_fetch_assoc($result))
            {
                $old_ds_alt_diff= $row["ds_alt_diff"];
            }
            
            // if($old_ds_alt_diff == $ds_alt_diff)
            // {
            //     $result1=mysqli_query($conn,"update tbl_delivery_schedule set ds_qty='$qty' where order_id='$order_id'") or die(mysqli_error($conn));
                
                
            //     $result=mysqli_query($conn,"update tbl_order_calendar set order_qty='$qty' where user_id='$user_id' and order_id='$order_id' and oc_is_delivered='0'") or die(mysqli_error($conn));
            // }
            
            if($ds_alt_diff == "Every 2nd Day")
            {
                $result1=mysqli_query($conn,"update tbl_delivery_schedule set ds_qty='$qty',ds_alt_diff='$ds_alt_diff' where order_id='$order_id'") or die(mysqli_error($conn));
                
                $resultdel=mysqli_query($conn,"delete from tbl_order_calendar where order_id='$order_id' and user_id='$user_id' and oc_is_delivered='0' and order_date between '$start_date' and '$ala_date'") or die(mysqli_error($conn));
                
                $round = 30;
                $start_date;
                
                for ($i = 0; $i <= $round; $i+=2){
                    
                $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                values ('$order_id','$product_id','$user_id','$qty','".date('Y-m-d', strtotime($start_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                }
                
            }
            elseif($ds_alt_diff == "Every 3rd Day")
            {
                $result1=mysqli_query($conn,"update tbl_delivery_schedule set ds_qty='$qty',ds_alt_diff='$ds_alt_diff' where order_id='$order_id'") or die(mysqli_error($conn));
                
                $resultdel=mysqli_query($conn,"delete from tbl_order_calendar where order_id='$order_id' and user_id='$user_id' and oc_is_delivered='0' and order_date between '$start_date' and '$ala_date'") or die(mysqli_error($conn));
                
                $round = 45;
                $start_date;
                
                for ($i = 0; $i < $round; $i+=3){
                    
                    $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                    values ('$order_id','$product_id','$user_id','$qty','".date('Y-m-d', strtotime($start_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                    }
            }
            elseif($ds_alt_diff == "Every 4th Day")
            {
                $result1=mysqli_query($conn,"update tbl_delivery_schedule set ds_qty='$qty',ds_alt_diff='$ds_alt_diff' where order_id='$order_id'") or die(mysqli_error($conn));
                
                $resultdel=mysqli_query($conn,"delete from tbl_order_calendar where order_id='$order_id' and user_id='$user_id' and oc_is_delivered='0' and order_date between '$start_date' and '$ala_date'") or die(mysqli_error($conn));
                
                $round = 60;
                $start_date;
                
                for ($i = 0; $i < $round; $i+=4){
                    
                    $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                    values ('$order_id','$product_id','$user_id','$qty','".date('Y-m-d', strtotime($start_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                    }
                
            }
            
             if($result3=true)
            {
                $response["status"]="yes";
                $response["message"]="Successfully Ordered";
                // $response["description"]="$product_name subscription has been changed to $qty and will take into consideration from $start_date.";
               $response["description"]="$product_name subscription has been changed to $ds_alt_diff with quantity $qty. Changes will be considered from next delivery";
            }
            else
            {
                $response["status"]="no";
                $response["message"]="Something is Wrong";
            }
            
        }
        
        //new
        
        

    }
    elseif($action=='update_order_customize_subscription_product')
    {
        $user_id=$_POST["user_id"];
        $order_id=$_POST["order_id"];
        $product_id=$_POST["product_id"];
        $cutoff_time=$_POST["cutoff_time"];
        $product_name=$_POST["product_name"];
        $delivery_schedule=$_POST["delivery_schedule"];
        $product_price=$_POST["product_price"];
        $ds_Sun=$_POST["ds_Sun"];
        $ds_Mon=$_POST["ds_Mon"];
        $ds_Tue=$_POST["ds_Tue"];
        $ds_Wed=$_POST["ds_Wed"];
        $ds_Thu=$_POST["ds_Thu"];
        $ds_Fri=$_POST["ds_Fri"];
        $ds_Sat=$_POST["ds_Sat"];
        $start_date=$_POST["start_date"];
        $order_instructions=$_POST["order_instructions"];
        $order_ring_bell=$_POST["order_ring_bell"];
        
        $finalcutoff = date('Y-m-d H:i:s', strtotime("$start_date $cutoff_time"));
                
        if($cutoff_time == "14:00:00")
        {
            // $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  0 days'));
        }
        elseif($cutoff_time == "22:00:00")
        {
            $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '-  1 days'));
        }
        else
        {
            
        }
        
        $ala_date = date('Y-m-d', strtotime($start_date. ' +  60 days')); 
        
        if($new_date = date('D', strtotime($start_date))=='Mon')
        {
            $qty = $ds_Mon;
        }
        elseif($new_date = date('D', strtotime($start_date))=='Tue')
        {
            $qty = $ds_Tue;
        }
        elseif($new_date = date('D', strtotime($start_date))=='Wed')
        {
            $qty = $ds_Wed;
        }
        elseif($new_date = date('D', strtotime($start_date))=='Thu')
        {
            $qty = $ds_Thu;
        }
        elseif($new_date = date('D', strtotime($start_date))=='Fri')
        {
            $qty = $ds_Fri;
        }
        elseif($new_date = date('D', strtotime($start_date))=='Sat')
        {
            $qty = $ds_Sat;
        }
        elseif($new_date = date('D', strtotime($start_date))=='Sun')
        {
            $qty = $ds_Sun;
        }
        else{}
        
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
            $result1=mysqli_query($conn,"UPDATE `tbl_delivery_schedule` SET ds_Sun='$ds_Sun',ds_Mon='$ds_Mon',ds_Tue='$ds_Tue',ds_Wed='$ds_Wed',ds_Thu='$ds_Thu',ds_Fri='$ds_Fri',ds_Sat='$ds_Sat' where order_id='$order_id'") or die(mysqli_error($conn));
                
                // UPDATE `tbl_delivery_schedule` SET `ds_Sun`='1' WHERE `order_id`='146'
                $resultdel=mysqli_query($conn,"delete from tbl_order_calendar where order_id='$order_id' and user_id='$user_id' and oc_is_delivered='0' and order_date between '$start_date' and '$ala_date'") or die(mysqli_error($conn));
                $round = 105;
                $start_date;
                
                if($new_date = date('D', strtotime($start_date))=='Mon')
                {
                    // echo "Mon";
                    if($ds_Mon!="0")
                    {
                        for ($i = 0; $i <= $round; $i+=7){
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Mon','".date('Y-m-d', strtotime($start_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Tue!="0")
                    {
                        $Tus_date = date('Y-m-d', strtotime($start_date. ' +  1 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Tue','".date('Y-m-d', strtotime($Tus_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Wed!="0")
                    {
                        $Wed_date = date('Y-m-d', strtotime($start_date. ' +  2 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        
                        for ($i = 0; $i <= $round; $i+=7){
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Wed','".date('Y-m-d', strtotime($Wed_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Thu!="0")
                    {
                        for ($i = 0; $i <= $round; $i+=7){
                        $Tus_date = date('Y-m-d', strtotime($start_date. ' +  3 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Thu','".date('Y-m-d', strtotime($Tus_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Fri!="0")
                    {
                        $Fri_date = date('Y-m-d', strtotime($start_date. ' +  4 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        
                        for ($i = 0; $i <= $round; $i+=7){
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Fri','".date('Y-m-d', strtotime($Fri_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Sat!="0")
                    {
                        $Sat_date = date('Y-m-d', strtotime($start_date. ' +  5 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        
                        for ($i = 0; $i <= $round; $i+=7){
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Sat','".date('Y-m-d', strtotime($Sat_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Sun!="0")
                    {
                        $Sun_date = date('Y-m-d', strtotime($start_date. ' +  6 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        
                        for ($i = 0; $i <= $round; $i+=7){
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Sun','".date('Y-m-d', strtotime($Sun_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                }
                
                //
                
                // $new_date = date('Y-m-d', strtotime($start_date. ' +  1 days'));
                
                elseif($new_date = date('D', strtotime($start_date))=='Tue')
                {
                    // echo "Tue";
                    if($ds_Tue!="0")
                    {
                        
                        for ($i = 0; $i <= $round; $i+=7){
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Tue','".date('Y-m-d', strtotime($start_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Wed!="0")
                    {
                        $Wed_date = date('Y-m-d', strtotime($start_date. ' +  1 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Wed','".date('Y-m-d', strtotime($Wed_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Thu!="0")
                    {
                        $Tus_date = date('Y-m-d', strtotime($start_date. ' +  2 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Thu','".date('Y-m-d', strtotime($Tus_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Fri!="0")
                    {
                        $Fri_date = date('Y-m-d', strtotime($start_date. ' +  3 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Fri','".date('Y-m-d', strtotime($Fri_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Sat!="0")
                    {
                        $Sat_date = date('Y-m-d', strtotime($start_date. ' +  4 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Sat','".date('Y-m-d', strtotime($Sat_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Sun!="0")
                    {
                        $Sun_date = date('Y-m-d', strtotime($start_date. ' +  5 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Sun','".date('Y-m-d', strtotime($Sun_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Mon!="0")
                    {
                        $Mon_date = date('Y-m-d', strtotime($start_date. ' +  6 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Mon','".date('Y-m-d', strtotime($Mon_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                }
                
                // $new_date = date('Y-m-d', strtotime($start_date. ' +  1 days')); 
                
                elseif($new_date = date('D', strtotime($start_date))=='Wed')
                {
                    // echo "Wed";
                    
                    if($ds_Wed!="0")
                    {
                        // $Wed_date = date('Y-m-d', strtotime($start_date. ' +  2 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Wed','".date('Y-m-d', strtotime($start_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Thu!="0")
                    {
                        for ($i = 0; $i <= $round; $i+=7){
                        $Tus_date = date('Y-m-d', strtotime($start_date. ' +  1 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Thu','".date('Y-m-d', strtotime($Tus_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Fri!="0")
                    {
                        $Fri_date = date('Y-m-d', strtotime($start_date. ' +  2 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Fri','".date('Y-m-d', strtotime($Fri_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Sat!="0")
                    {
                        $Sat_date = date('Y-m-d', strtotime($start_date. ' +  3 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Sat','".date('Y-m-d', strtotime($Sat_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Sun!="0")
                    {
                        $Sun_date = date('Y-m-d', strtotime($start_date. ' +  4 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                            $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Sun','".date('Y-m-d', strtotime($Sun_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Mon!="0")
                    {
                        $Mon_date = date('Y-m-d', strtotime($start_date. ' +  5 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Mon','".date('Y-m-d', strtotime($Mon_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Tue!="0")
                    {
                        $Tus_date = date('Y-m-d', strtotime($start_date. ' +  6 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Tue','".date('Y-m-d', strtotime($Tus_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                }
                
                // $new_date = date('Y-m-d', strtotime($start_date. ' +  1 days'));
                
                if($new_date = date('D', strtotime($start_date))=='Thu')
                {
                    // echo "Thu";
                    if($ds_Thu!="0")
                    {
                        // $Tus_date = date('Y-m-d', strtotime($start_date. ' +  3 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Thu','".date('Y-m-d', strtotime($start_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Fri!="0")
                    {
                        $Fri_date = date('Y-m-d', strtotime($start_date. ' +  1 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Fri','".date('Y-m-d', strtotime($Fri_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Sat!="0")
                    {
                        $Sat_date = date('Y-m-d', strtotime($start_date. ' +  2 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Sat','".date('Y-m-d', strtotime($Sat_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Sun!="0")
                    {
                        $Sun_date = date('Y-m-d', strtotime($start_date. ' +  3 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Sun','".date('Y-m-d', strtotime($Sun_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Mon!="0")
                    {
                        $Mon_date = date('Y-m-d', strtotime($start_date. ' +  4 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Mon','".date('Y-m-d', strtotime($Mon_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Tue!="0")
                    {
                        $Tus_date = date('Y-m-d', strtotime($start_date. ' +  5 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Tue','".date('Y-m-d', strtotime($Tus_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Wed!="0")
                    {
                        $Wed_date = date('Y-m-d', strtotime($start_date. ' +  6 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Wed','".date('Y-m-d', strtotime($Wed_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                }
                
                // $new_date = date('Y-m-d', strtotime($start_date. ' +  1 days'));
                
                if($new_date = date('D', strtotime($start_date))=='Fri')
                {
                    // echo "Fri";
                    if($ds_Fri!="0")
                    {
                        // $Fri_date = date('Y-m-d', strtotime($start_date. ' +  4 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Fri','".date('Y-m-d', strtotime($start_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Sat!="0")
                    {
                        $Sat_date = date('Y-m-d', strtotime($start_date. ' +  1 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Sat','".date('Y-m-d', strtotime($Sat_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Sun!="0")
                    {
                        $Sun_date = date('Y-m-d', strtotime($start_date. ' +  2 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Sun','".date('Y-m-d', strtotime($Sun_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Mon!="0")
                    {
                        $Mon_date = date('Y-m-d', strtotime($start_date. ' +  3 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Mon','".date('Y-m-d', strtotime($Mon_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Tue!="0")
                    {
                        $Tus_date = date('Y-m-d', strtotime($start_date. ' +  4 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Tue','".date('Y-m-d', strtotime($Tus_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Wed!="0")
                    {
                        $Wed_date = date('Y-m-d', strtotime($start_date. ' +  5 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Wed','".date('Y-m-d', strtotime($Wed_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Thu!="0")
                    {
                        for ($i = 0; $i <= $round; $i+=7){
                        $Tus_date = date('Y-m-d', strtotime($start_date. ' +  6 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                    $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Thu','".date('Y-m-d', strtotime($Tus_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                }
                
                // $new_date = date('Y-m-d', strtotime($start_date. ' +  1 days'));
                
                if($new_date = date('D', strtotime($start_date))=='Sat')
                {
                    // echo "Sat";
                    if($ds_Sat!="0")
                    {
                        // $Sat_date = date('Y-m-d', strtotime($start_date. ' +  5 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Sat','".date('Y-m-d', strtotime($start_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Sun!="0")
                    {
                        $Sun_date = date('Y-m-d', strtotime($start_date. ' +  1 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Sun','".date('Y-m-d', strtotime($Sun_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Mon!="0")
                    {
                        $Mon_date = date('Y-m-d', strtotime($start_date. ' +  2 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Mon','".date('Y-m-d', strtotime($Mon_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Tue!="0")
                    {
                        $Tus_date = date('Y-m-d', strtotime($start_date. ' +  3 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Tue','".date('Y-m-d', strtotime($Tus_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Wed!="0")
                    {
                        $Wed_date = date('Y-m-d', strtotime($start_date. ' +  4 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Wed','".date('Y-m-d', strtotime($Wed_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Thu!="0")
                    {
                        for ($i = 0; $i <= $round; $i+=7){
                        $Tus_date = date('Y-m-d', strtotime($start_date. ' +  5 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date)  
                        values ('$order_id','$product_id','$user_id','$ds_Thu','".date('Y-m-d', strtotime($Tus_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Fri!="0")
                    {
                        $Fri_date = date('Y-m-d', strtotime($start_date. ' +  6 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                    
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Fri','".date('Y-m-d', strtotime($Fri_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    
                }
                
                if($new_date = date('D', strtotime($start_date))=='Sun')
                {
                    // echo "Sun";
                    
                    if($ds_Sun!="0")
                    {
                        // $Sun_date = date('Y-m-d', strtotime($start_date. ' +  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Sun','".date('Y-m-d', strtotime($Sun_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Mon!="0")
                    {
                        $Mon_date = date('Y-m-d', strtotime($start_date. ' +  1 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Mon','".date('Y-m-d', strtotime($Mon_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Tue!="0")
                    {
                        $Tus_date = date('Y-m-d', strtotime($start_date. ' +  2 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Tue','".date('Y-m-d', strtotime($Tus_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Wed!="0")
                    {
                        $Wed_date = date('Y-m-d', strtotime($start_date. ' +  3 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Wed','".date('Y-m-d', strtotime($Wed_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Thu!="0")
                    {
                        for ($i = 0; $i <= $round; $i+=7){
                        $Tus_date = date('Y-m-d', strtotime($start_date. ' +  4 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Thu','".date('Y-m-d', strtotime($Tus_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Fri!="0")
                    {
                        $Fri_date = date('Y-m-d', strtotime($start_date. ' +  5 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Fri','".date('Y-m-d', strtotime($Fri_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Sat!="0")
                    {
                        $Sat_date = date('Y-m-d', strtotime($start_date. ' +  6 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order_id','$product_id','$user_id','$ds_Sat','".date('Y-m-d', strtotime($Sat_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    
                }
                

                if($result1=true && $resultdel=true)
                {
                    $response["status"]="yes";
                    $response["message"]="Successfully Ordered.";
                    $response["description"]="$product_name subscription has been changed and will take into consideration from $start_date.";
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