<?php
include 'connection.php';

	if(isset($_REQUEST["user"], $_REQUEST["order"]))
	{
		    
		    
            $user = $_REQUEST["user"];
            $order = $_REQUEST["order"];
            $start_date = date("Y-m-d");
            $ds_type;
		    
		    $result=mysqli_query($conn,"select * from tbl_order as o left join tbl_delivery_schedule as ds on ds.order_id=o.order_id where o.order_id ='".$order."'");
            while($row=mysqli_fetch_array($result))
            {
                $ds_type = $row['ds_type'];
                $ds_alt_diff = $row['ds_alt_diff'];
                $product_id = $row['product_id'];
                $ds_qty = $row['ds_qty'];
                $ds_Sun = $row['ds_Sun'];
                $ds_Mon = $row['ds_Mon'];
                $ds_Tue = $row['ds_Tue'];
                $ds_Wed = $row['ds_Wed'];
                $ds_Thu = $row['ds_Thu'];
                $ds_Fri = $row['ds_Fri'];
                $ds_Sat = $row['ds_Sat'];
            }
            echo "This is "+$ds_type;
            
            $resultuser=mysqli_query($conn,"select * from tbl_time_slot as t left join tbl_deliveryboy as d on d.time_slot_id=t.time_slot_id left join tbl_user as u on d.deliveryboy_id=u.deliveryboy_id where u.user_id='$user'")or die(mysqli_error($conn));
								
			while($rowuser=mysqli_fetch_array($resultuser))
			{
				$usertype = $rowuser["user_type"];
				$cutoff_time = $rowuser["time_slot_cutoff_time"];
			}
			
			$curdate = date("Y-m-d H:i:s");
			$finalcutoff = date('Y-m-d H:i:s', strtotime("$start_date $cutoff_time"));
			if($curdate > $finalcutoff)
            {
                $start_date;
            }
            else
            {
                $start_date = date('Y-m-d', strtotime($start_date. ' +  1 days')); 
            }
            
            
            
            if($ds_type == "Everyday")
            {	
                $resume_date = date('Y-m-d', strtotime($start_date. ' +  365 days')); 
                $result=mysqli_query($conn,"update tbl_order set push_date=NULL,order_subscription_status='1' where user_id='$user' and order_id='$order'") or die(mysqli_error($conn));
                
                $result1=mysqli_query($conn,"delete from tbl_order_calendar where order_id='$order' and user_id='$user' and order_date between '$start_date' and '$resume_date'") or die(mysqli_error($conn));
                
                $round = 15;
                for ($i = 0; $i <= $round; $i+=1){
            
                    $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                    values ('$order','$product_id','$user','$ds_qty','".date('Y-m-d', strtotime($start_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                }
        
                if($result=true && $result1=true && $result3=true)
                {	
                    echo "<script>window.location='user_detail.php?user=$user';</script>";
                }
                else
                {	
                    echo "<script>window.location='user_detail.php?user=$user';</script>";
                }
            }
            
            //code//
            
            //code//
            
            
            if($ds_type == "Alternate Day")
            {	
                
                $ala_date = date('Y-m-d', strtotime($start_date. ' +  365 days')); 
        
                $result=mysqli_query($conn,"update tbl_order set order_subscription_status='1',push_date=NULL,resume_date=NULL where user_id='$user' and order_id='$order'") or die(mysqli_error($conn));
        
                $resultdel=mysqli_query($conn,"delete from tbl_order_calendar where order_id='$order' and user_id='$user' and oc_is_delivered='0' and order_date between '$start_date' and '$ala_date'") or die(mysqli_error($conn));
                
                    if($ds_alt_diff == "Every 2nd Day")
                    {
        
                        $round = 30;
                        
                        for ($i = 0; $i <= $round; $i+=2){
                            
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order','$product_id','$user','$ds_qty','".date('Y-m-d', strtotime($start_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                        
                    }
                    elseif($ds_alt_diff == "Every 3rd Day")
                    {
                        $round = 45;
                        $start_date;
                        
                        for ($i = 0; $i < $round; $i+=3){
                            
                            $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                            values ('$order','$product_id','$user','$ds_qty','".date('Y-m-d', strtotime($start_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                            }
                    }
                    elseif($ds_alt_diff == "Every 4th Day")
                    {
                        $round = 60;
                        $start_date;
                        
                        for ($i = 0; $i < $round; $i+=4){
                            
                            $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                            values ('$order','$product_id','$user','$ds_qty','".date('Y-m-d', strtotime($start_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                            }
                        
                    }
                
                
                if($result=true && $resultdel=true && $result3=true)
                {	
                    echo "<script>window.location='user_detail.php?user=$user';</script>";
                }
                else
                {	
                    echo "<script>window.location='user_detail.php?user=$user';</script>";
                }
            }
            
            
            //code//
            
            //code//
            
            
            if($ds_type == "Customize")
            {	
                $ala_date = date('Y-m-d', strtotime($start_date. ' +  365 days')); 
                $result=mysqli_query($conn,"update tbl_order set order_subscription_status='1',push_date=NULL,resume_date=NULL where user_id='$user' and order_id='$order'") or die(mysqli_error($conn));
            
                $resultdel=mysqli_query($conn,"delete from tbl_order_calendar where order_id='$order' and user_id='$user' and oc_is_delivered='0' and order_date between '$start_date' and '$ala_date'") or die(mysqli_error($conn));
                
                $round = 15;
                
                if($new_date = date('D', strtotime($start_date))=='Mon')
                {
                    // echo "Mon";
                    if($ds_Mon!="0")
                    {
                        for ($i = 0; $i <= $round; $i+=7){
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order','$product_id','$user','$ds_Mon','".date('Y-m-d', strtotime($start_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Tue!="0")
                    {
                        $Tus_date = date('Y-m-d', strtotime($start_date. ' +  1 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order','$product_id','$user','$ds_Tue','".date('Y-m-d', strtotime($Tus_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Wed!="0")
                    {
                        $Wed_date = date('Y-m-d', strtotime($start_date. ' +  2 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        
                        for ($i = 0; $i <= $round; $i+=7){
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order','$product_id','$user','$ds_Wed','".date('Y-m-d', strtotime($Wed_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Thu!="0")
                    {
                        for ($i = 0; $i <= $round; $i+=7){
                        $Tus_date = date('Y-m-d', strtotime($start_date. ' +  3 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order','$product_id','$user','$ds_Thu','".date('Y-m-d', strtotime($Tus_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Fri!="0")
                    {
                        $Fri_date = date('Y-m-d', strtotime($start_date. ' +  4 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        
                        for ($i = 0; $i <= $round; $i+=7){
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order','$product_id','$user','$ds_Fri','".date('Y-m-d', strtotime($Fri_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Sat!="0")
                    {
                        $Sat_date = date('Y-m-d', strtotime($start_date. ' +  5 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        
                        for ($i = 0; $i <= $round; $i+=7){
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order','$product_id','$user','$ds_Sat','".date('Y-m-d', strtotime($Sat_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Sun!="0")
                    {
                        $Sun_date = date('Y-m-d', strtotime($start_date. ' +  6 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        
                        for ($i = 0; $i <= $round; $i+=7){
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order','$product_id','$user','$ds_Sun','".date('Y-m-d', strtotime($Sun_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
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
                        values ('$order','$product_id','$user','$ds_Tue','".date('Y-m-d', strtotime($start_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Wed!="0")
                    {
                        $Wed_date = date('Y-m-d', strtotime($start_date. ' +  1 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order','$product_id','$user','$ds_Wed','".date('Y-m-d', strtotime($Wed_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Thu!="0")
                    {
                        $Tus_date = date('Y-m-d', strtotime($start_date. ' +  2 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order','$product_id','$user','$ds_Thu','".date('Y-m-d', strtotime($Tus_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Fri!="0")
                    {
                        $Fri_date = date('Y-m-d', strtotime($start_date. ' +  3 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order','$product_id','$user','$ds_Fri','".date('Y-m-d', strtotime($Fri_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Sat!="0")
                    {
                        $Sat_date = date('Y-m-d', strtotime($start_date. ' +  4 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order','$product_id','$user','$ds_Sat','".date('Y-m-d', strtotime($Sat_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Sun!="0")
                    {
                        $Sun_date = date('Y-m-d', strtotime($start_date. ' +  5 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order','$product_id','$user','$ds_Sun','".date('Y-m-d', strtotime($Sun_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Mon!="0")
                    {
                        $Mon_date = date('Y-m-d', strtotime($start_date. ' +  6 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order','$product_id','$user','$ds_Mon','".date('Y-m-d', strtotime($Mon_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
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
                        values ('$order','$product_id','$user','$ds_Wed','".date('Y-m-d', strtotime($start_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Thu!="0")
                    {
                        for ($i = 0; $i <= $round; $i+=7){
                        $Tus_date = date('Y-m-d', strtotime($start_date. ' +  1 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order','$product_id','$user','$ds_Thu','".date('Y-m-d', strtotime($Tus_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Fri!="0")
                    {
                        $Fri_date = date('Y-m-d', strtotime($start_date. ' +  2 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order','$product_id','$user','$ds_Fri','".date('Y-m-d', strtotime($Fri_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Sat!="0")
                    {
                        $Sat_date = date('Y-m-d', strtotime($start_date. ' +  3 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order','$product_id','$user','$ds_Sat','".date('Y-m-d', strtotime($Sat_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Sun!="0")
                    {
                        $Sun_date = date('Y-m-d', strtotime($start_date. ' +  4 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                            $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order','$product_id','$user','$ds_Sun','".date('Y-m-d', strtotime($Sun_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Mon!="0")
                    {
                        $Mon_date = date('Y-m-d', strtotime($start_date. ' +  5 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order','$product_id','$user','$ds_Mon','".date('Y-m-d', strtotime($Mon_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Tue!="0")
                    {
                        $Tus_date = date('Y-m-d', strtotime($start_date. ' +  6 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order','$product_id','$user','$ds_Tue','".date('Y-m-d', strtotime($Tus_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
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
                        values ('$order','$product_id','$user','$ds_Thu','".date('Y-m-d', strtotime($start_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Fri!="0")
                    {
                        $Fri_date = date('Y-m-d', strtotime($start_date. ' +  1 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order','$product_id','$user','$ds_Fri','".date('Y-m-d', strtotime($Fri_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Sat!="0")
                    {
                        $Sat_date = date('Y-m-d', strtotime($start_date. ' +  2 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order','$product_id','$user','$ds_Sat','".date('Y-m-d', strtotime($Sat_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Sun!="0")
                    {
                        $Sun_date = date('Y-m-d', strtotime($start_date. ' +  3 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order','$product_id','$user','$ds_Sun','".date('Y-m-d', strtotime($Sun_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Mon!="0")
                    {
                        $Mon_date = date('Y-m-d', strtotime($start_date. ' +  4 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order','$product_id','$user','$ds_Mon','".date('Y-m-d', strtotime($Mon_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Tue!="0")
                    {
                        $Tus_date = date('Y-m-d', strtotime($start_date. ' +  5 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order','$product_id','$user','$ds_Tue','".date('Y-m-d', strtotime($Tus_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Wed!="0")
                    {
                        $Wed_date = date('Y-m-d', strtotime($start_date. ' +  6 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order','$product_id','$user','$ds_Wed','".date('Y-m-d', strtotime($Wed_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
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
                        values ('$order','$product_id','$user','$ds_Fri','".date('Y-m-d', strtotime($start_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Sat!="0")
                    {
                        $Sat_date = date('Y-m-d', strtotime($start_date. ' +  1 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order','$product_id','$user','$ds_Sat','".date('Y-m-d', strtotime($Sat_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Sun!="0")
                    {
                        $Sun_date = date('Y-m-d', strtotime($start_date. ' +  2 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order','$product_id','$user','$ds_Sun','".date('Y-m-d', strtotime($Sun_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Mon!="0")
                    {
                        $Mon_date = date('Y-m-d', strtotime($start_date. ' +  3 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order','$product_id','$user','$ds_Mon','".date('Y-m-d', strtotime($Mon_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Tue!="0")
                    {
                        $Tus_date = date('Y-m-d', strtotime($start_date. ' +  4 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order','$product_id','$user','$ds_Tue','".date('Y-m-d', strtotime($Tus_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Wed!="0")
                    {
                        $Wed_date = date('Y-m-d', strtotime($start_date. ' +  5 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order','$product_id','$user','$ds_Wed','".date('Y-m-d', strtotime($Wed_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Thu!="0")
                    {
                        for ($i = 0; $i <= $round; $i+=7){
                        $Tus_date = date('Y-m-d', strtotime($start_date. ' +  6 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                    $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order','$product_id','$user','$ds_Thu','".date('Y-m-d', strtotime($Tus_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
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
                        values ('$order','$product_id','$user','$ds_Sat','".date('Y-m-d', strtotime($start_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Sun!="0")
                    {
                        $Sun_date = date('Y-m-d', strtotime($start_date. ' +  1 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order','$product_id','$user','$ds_Sun','".date('Y-m-d', strtotime($Sun_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Mon!="0")
                    {
                        $Mon_date = date('Y-m-d', strtotime($start_date. ' +  2 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order','$product_id','$user','$ds_Mon','".date('Y-m-d', strtotime($Mon_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Tue!="0")
                    {
                        $Tus_date = date('Y-m-d', strtotime($start_date. ' +  3 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order','$product_id','$user','$ds_Tue','".date('Y-m-d', strtotime($Tus_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Wed!="0")
                    {
                        $Wed_date = date('Y-m-d', strtotime($start_date. ' +  4 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order','$product_id','$user','$ds_Wed','".date('Y-m-d', strtotime($Wed_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Thu!="0")
                    {
                        for ($i = 0; $i <= $round; $i+=7){
                        $Tus_date = date('Y-m-d', strtotime($start_date. ' +  5 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date)  
                        values ('$order','$product_id','$user','$ds_Thu','".date('Y-m-d', strtotime($Tus_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Fri!="0")
                    {
                        $Fri_date = date('Y-m-d', strtotime($start_date. ' +  6 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                    
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order','$product_id','$user','$ds_Fri','".date('Y-m-d', strtotime($Fri_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
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
                        values ('$order','$product_id','$user','$ds_Sun','".date('Y-m-d', strtotime($Sun_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Mon!="0")
                    {
                        $Mon_date = date('Y-m-d', strtotime($start_date. ' +  1 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order','$product_id','$user','$ds_Mon','".date('Y-m-d', strtotime($Mon_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Tue!="0")
                    {
                        $Tus_date = date('Y-m-d', strtotime($start_date. ' +  2 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order','$product_id','$user','$ds_Tue','".date('Y-m-d', strtotime($Tus_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Wed!="0")
                    {
                        $Wed_date = date('Y-m-d', strtotime($start_date. ' +  3 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order','$product_id','$user','$ds_Wed','".date('Y-m-d', strtotime($Wed_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Thu!="0")
                    {
                        for ($i = 0; $i <= $round; $i+=7){
                        $Tus_date = date('Y-m-d', strtotime($start_date. ' +  4 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order','$product_id','$user','$ds_Thu','".date('Y-m-d', strtotime($Tus_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Fri!="0")
                    {
                        $Fri_date = date('Y-m-d', strtotime($start_date. ' +  5 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order','$product_id','$user','$ds_Fri','".date('Y-m-d', strtotime($Fri_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    if($ds_Sat!="0")
                    {
                        $Sat_date = date('Y-m-d', strtotime($start_date. ' +  6 days'));
                        $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
                        for ($i = 0; $i <= $round; $i+=7){
                        
                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                        values ('$order','$product_id','$user','$ds_Sat','".date('Y-m-d', strtotime($Sat_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                        }
                    }
                    
                }
                
                
        
                if($result=true && $result3=true)
                {	
                    echo "<script>window.location='user_detail.php?user=$user';</script>";
                }
                else
                {	
                    echo "<script>window.location='user_detail.php?user=$user';</script>";
                }
            }
            else
            {
                
            }
            
        
        
	}
?>