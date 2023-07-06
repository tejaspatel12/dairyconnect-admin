<?php 
    date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)
    include '../connection.php';    


    
    $action=$_POST["action"];
    $finalcutoff;
    
    $response=array();



    if($action=='order_everyday_subscription_product')
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
        $order_instructions=$_POST["order_instructions"];
        $order_ring_bell=$_POST["order_ring_bell"];
        
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
            $result=mysqli_query($conn,"insert into tbl_order (user_id,product_id,attribute_id,start_date,order_instructions,order_ring_bell,delivery_schedule) 
            values ('$user_id','$product_id','$attribute_id','$start_date','$order_instructions','$order_ring_bell','$delivery_schedule')") or die(mysqli_error($conn));
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
    elseif($action=='order_alternateday_subscription_product')
    {
        $user_id=$_POST["user_id"];
        $product_id=$_POST["product_id"];
        $product_name=$_POST["product_name"];
        $attribute_id=$_POST["attribute_id"];
        $cutoff_time=$_POST["cutoff_time"];
        $product_price=$_POST["product_price"];
        $delivery_schedule=$_POST["delivery_schedule"];
        $ds_alt_diff=$_POST["ds_alt_diff"];
        $qty=$_POST["qty"];
        $start_date=$_POST["start_date"];
        $order_instructions=$_POST["order_instructions"];
        $order_ring_bell=$_POST["order_ring_bell"];
        
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
            $result=mysqli_query($conn,"insert into tbl_order (user_id,product_id,attribute_id,start_date,order_instructions,order_ring_bell,delivery_schedule) 
            values ('$user_id','$product_id','$attribute_id','$start_date','$order_instructions','$order_ring_bell','$delivery_schedule')") or die(mysqli_error($conn));
            if($result=true)
            {
                $order_id = $conn->insert_id;
    
                $result2=mysqli_query($conn,"insert into tbl_delivery_schedule (order_id,ds_type,ds_qty,ds_alt_diff) 
                values ('$order_id','$delivery_schedule','$qty','$ds_alt_diff')") or die(mysqli_error($conn));
                
                // $round = 15;
                $start_date;
                
                if($ds_alt_diff=="Every 2nd Day")
                {
                    $round = 30;
                    for ($i = 0; $i <= $round; $i+=2){
                    
                    $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                    values ('$order_id','$product_id','$user_id','$qty','".date('Y-m-d', strtotime($start_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                    }
                }
                elseif($ds_alt_diff=="Every 3rd Day")
                {
                    $round = 45;
                    for ($i = 0; $i < $round; $i+=3){
                    
                    $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                    values ('$order_id','$product_id','$user_id','$qty','".date('Y-m-d', strtotime($start_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                    }
                }
                elseif($ds_alt_diff=="Every 4th Day")
                {
                    $round = 60;
                    for ($i = 0; $i < $round; $i+=4){
                    
                    $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                    values ('$order_id','$product_id','$user_id','$qty','".date('Y-m-d', strtotime($start_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                    }
                }
                else{}
    
    
                if($result2=true && $result3=true)
                {
                    $response["status"]="yes";
                    $response["message"]="Successfully Ordered";
                    $response["description"]="$product_name subscription with $qty quantity will start from $start_date for $ds_alt_diff.";
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



        
        
        
        
        //end else
    }
    elseif($action=='order_customize_subscription_product')
    {
        $user_id=$_POST["user_id"];
        $product_id=$_POST["product_id"];
        $product_name=$_POST["product_name"];
        $attribute_id=$_POST["attribute_id"];
        $cutoff_time=$_POST["cutoff_time"];
        $product_price=$_POST["product_price"];
        $delivery_schedule=$_POST["delivery_schedule"];
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
            $result=mysqli_query($conn,"insert into tbl_order (user_id,product_id,attribute_id,start_date,order_instructions,order_ring_bell,delivery_schedule) 
            values ('$user_id','$product_id','$attribute_id','$start_date','$order_instructions','$order_ring_bell','$delivery_schedule')") or die(mysqli_error($conn));
            if($result=true)
            {
                $order_id = $conn->insert_id;
    
                $result2=mysqli_query($conn,"insert into tbl_delivery_schedule (order_id,ds_type,ds_Sun,ds_Mon,ds_Tue,ds_Wed,ds_Thu,ds_Fri,ds_Sat) 
                values ('$order_id','$delivery_schedule','$ds_Sun','$ds_Mon','$ds_Tue','$ds_Wed','$ds_Thu','$ds_Fri','$ds_Sat')") or die(mysqli_error($conn));
                
                $round = 10;
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
                
    
                if($result2=true)
                {
                    $response["status"]="yes";
                    $response["message"]="Successfully Ordered";
                    // $response["description"]="$product_name subscription will start from $start_date for Customize.";
                    $response["description"]="Your Customize order for $product_name has successfully placed.";
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
    elseif($action=='get_already_order')
    {
        $user_id=$_POST["user_id"];
        $product_id=$_POST["product_id"];
        
        $result=mysqli_query($conn,"select * from tbl_order as o left join tbl_delivery_schedule as d on d.order_id=o.order_id left join tbl_user as u on u.user_id=o.user_id left join tbl_product as p on p.product_id=o.product_id where o.product_id='$product_id' and o.user_id='$user_id' and o.delivery_schedule!='' and o.order_subscription_status!='2'") or die(mysqli_error($conn));
            if(mysqli_num_rows($result)>0)
            {
                $response["status"]="available";
                while($row=mysqli_fetch_assoc($result))
                {
                    $response[]=array(
                        "product_id" => $row["product_id"],
                        "product_type" => $row["product_type"],
                        "product_regular_price" => intval($row["product_regular_price"]),
                        "product_normal_price" => intval($row["product_normal_price"]),
                        "order_id" => $row["order_id"],
                        "ds_type" => $row["ds_type"],
                        "ds_qty" => intval($row["ds_qty"]),
                        "ds_alt_diff" => $row["ds_alt_diff"],
                        "ds_Sun" => intval($row["ds_Sun"]),
                        "ds_Mon" => intval($row["ds_Mon"]),
                        "ds_Tue" => intval($row["ds_Tue"]),
                        "ds_Wed" => intval($row["ds_Wed"]),
                        "ds_Thu" => intval($row["ds_Thu"]),
                        "ds_Fri" => intval($row["ds_Fri"]),
                        "ds_Sat" => intval($row["ds_Sat"]),
                        "start_date" => $row["start_date"],
                        "order_instructions" => $row["order_instructions"],
                        "order_ring_bell" => $row["order_ring_bell"],
                        );
                }
            }
            else
            {
                $response["status"]="not_available";
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
    elseif($action=='pushsubscription')
    {
        $user_id=$_POST["user_id"];
        $order_id=$_POST["order_id"];
        $is_Resume=$_POST["is_Resume"];
        $push_date=$_POST["push_date"];
        $resume_date=$_POST["resume_date"];
        
        if($is_Resume=="1")
        {
            $result=mysqli_query($conn,"update tbl_order set order_subscription_status='0',push_date='$push_date',resume_date='$resume_date' where user_id='$user_id' and order_id='$order_id'") or die(mysqli_error($conn));
            
            // $result1=mysqli_query($conn,"delete from tbl_order_calendar where user_id='$user_id' and order_id='$order_id' and order_date between '$push_date' and '$is_Resume'") or die(mysqli_error($conn));
            
             $result1=mysqli_query($conn,"delete from tbl_order_calendar where order_id='$order_id' and user_id='$user_id' and order_date between '$push_date' and '$resume_date'") or die(mysqli_error($conn));
            
            if($result=true && $result1)
            {
                $response["status"]="yes";
                $response["message"]="Successfully Pushed";
            }
            else
            {
                $response["status"]="no";
                $response["message"]="Something is Wrong";
            }
        }
        else
        {
            $resume_date = date('Y-m-d', strtotime($push_date. ' +  365 days')); 
            $result=mysqli_query($conn,"update tbl_order set order_subscription_status='0',push_date='$push_date' where user_id='$user_id' and order_id='$order_id'") or die(mysqli_error($conn));
            
           $result1=mysqli_query($conn,"delete from tbl_order_calendar where order_id='$order_id' and user_id='$user_id' and order_date between '$push_date' and '$resume_date'") or die(mysqli_error($conn));
           
            if($result=true && $result1=true)
            {
                $response["status"]="yes";
                $response["message"]="Successfully Pushed";
            }
            else
            {
                $response["status"]="no";
                $response["message"]="Something is Wrong";
            }
        }

    }
    // elseif($action=='resumesubscription')
    // {
    //     $user_id=$_POST["user_id"];
    //     $order_id=$_POST["order_id"];
    //     $resume_date=$_POST["resume_date"];
        
    //     $result=mysqli_query($conn,"update tbl_order set order_subscription_status='1',resume_date='$resume_date' where user_id='$user_id' and order_id='$order_id'") or die(mysqli_error($conn));
    //     if($result=true)
    //     {
    //         $response["status"]="yes";
    //         $response["message"]="Successfully Resume";
    //     }
    //     else
    //     {
    //         $response["status"]="no";
    //         $response["message"]="Something is Wrong";
    //     }
        

    // }
    elseif($action=='stopsubscription')
    {
        $user_id=$_POST["user_id"];
        $order_id=$_POST["order_id"];
        $time=$_POST["time"];
        $resume_date = date('Y-m-d', strtotime($time. ' +  365 days')); 
        $result=mysqli_query($conn,"update tbl_order set push_date='$time',order_subscription_status='2' where user_id='$user_id' and order_id='$order_id'") or die(mysqli_error($conn));
        
        $result=mysqli_query($conn,"delete from tbl_order_calendar where order_id='$order_id' and user_id='$user_id' and order_date between '$time' and '$resume_date'") or die(mysqli_error($conn));
        // $result=mysqli_query($conn,"update tbl_order_calendar set oc_is_delivered='2' where user_id='$user_id' and order_id='$order_id' and oc_is_delivered='0'") or die(mysqli_error($conn));
        if($result=true)
        {
            $response["status"]="yes";
            $response["message"]="Successfully Stop Subscription";
        }
        else
        {
            $response["status"]="no";
            $response["message"]="Something is Wrong";
        }
        

    }
    elseif($action=='cancelorder')
    {
        $user_id=$_POST["user_id"];
        $order_id=$_POST["order_id"];
        $time=$_POST["time"];
        
        $result=mysqli_query($conn,"update tbl_order set push_date='$time',order_subscription_status='2' where user_id='$user_id' and order_id='$order_id'") or die(mysqli_error($conn));
        
        $result=mysqli_query($conn,"update tbl_order_calendar set oc_is_delivered='2' where user_id='$user_id' and order_id='$order_id' and oc_is_delivered='0'") or die(mysqli_error($conn));
        if($result=true)
        {
            $response["status"]="yes";
            $response["message"]="Successfully Cancle Order";
        }
        else
        {
            $response["status"]="no";
            $response["message"]="Something is Wrong";
        }
        

    }
    
    elseif($action=='cancel_calendar_order')
    {
        $user_id=$_POST["user_id"];
        $order_id=$_POST["order_id"];
        $time=$_POST["time"];
        
        $result=mysqli_query($conn,"delete from tbl_order_calendar where user_id='$user_id' and order_id='$order_id' and order_date='$time' and oc_is_delivered='0'") or die(mysqli_error($conn));
        if($result=true)
        {
            $response["status"]="yes";
            $response["message"]="Successfully Cancle Order";
        }
        else
        {
            $response["status"]="no";
            $response["message"]="Something is Wrong";
        }
        

    }
    
    //UPDATE
    
    
    else
    {
        $response["message"]="Something is Wrong";
    }
    echo json_encode($response);
?>