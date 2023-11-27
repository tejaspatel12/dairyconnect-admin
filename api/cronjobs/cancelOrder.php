<?php 
    date_default_timezone_set("Europe/London"); 
    include '../../connection.php';
    
    // $DATE = date("Y-m-d");
    $DATE = "2023-11-28";
    echo $DATE."<BR>";
    $i = 1;
    
    // $curdate = date("Y-m-d H:i:s");
    $curdate = "2023-11-28 05:00:00";

    echo $curdate."<BR>";
    
    $result=mysqli_query($conn,"select * from tbl_time_slot where time_slot_status='1'") or die(mysqli_error($conn));
    while($row=mysqli_fetch_assoc($result))
    {
        $array[] = $row["time_slot_cutoff_time"]; // for your $arr1 
    }
    
    $cutoff_1 = $array[0];
    $cutoff_2 = $array[1];
                
   $cf = $cutoff_1;
    $cs = $cutoff_2;

    $mor = "00:00:00";
    $morend = "16:59:59";
    
    $evn = "17:00:00";
    $evnend = "23:59:59";
    
    
    $first = date('Y-m-d H:i:s', strtotime("$DATE $mor"));
    $sec = date('Y-m-d H:i:s', strtotime("$DATE $morend"));
    
    $thr = date('Y-m-d H:i:s', strtotime("$DATE $evn"));
    $fur = date('Y-m-d H:i:s', strtotime("$DATE $evnend"));
    


    if(($first < $curdate) && ($curdate < $sec))
	{
		$cutoff = date('Y-m-d H:i:s', strtotime("$DATE $cf"));
		echo $day = "Morning";
		
		$newdate = $DATE;
		$type = $cf;

	}
	elseif(($thr < $curdate) && ($curdate < $fur))
	{
		$cutoff = date('Y-m-d H:i:s', strtotime("$DATE $cs"));
		echo $day = "Evening";
		
		$newdate = $DATE;
		
		$type = $cs;
	}
	else
	{}

    //code
    echo "<br><br>This is : ".$type."<br><br>";
    
    echo "New : $newdate<br><br>";
    
    $result=mysqli_query($conn,"select * from tbl_user_order_calendar where uoc_date='$newdate' and uoc_cutoff='$type'") or die(mysqli_error($conn));
    if(mysqli_num_rows($result)<=0)
    {
        echo "No Entry Found";
    }
    else
    {
        
        while($row=mysqli_fetch_assoc($result))
        {
           
            $user_id = $row["user_id"];
            echo "USER ID : ".$user_id."<BR>";
            
            $sqlaa = mysqli_query($conn,"select * from tbl_user where user_id='$user_id'");
            while($roww=mysqli_fetch_assoc($sqlaa))
            {
                $user_type = $roww["user_type"];
                $user_balance = $roww["user_balance"];
                $accept_nagative_balance = $roww["accept_nagative_balance"];
            }
            
            $total=0;
            $sqlp = mysqli_query($conn,"select * from tbl_order_calendar as oc left join tbl_product as p on oc.product_id=p.product_id where oc.user_id='".$user_id."' and oc.order_date='$newdate' and oc_cutoff_time='$cutoff'");
            while($row=mysqli_fetch_assoc($sqlp))
            {
                $row["product_name"];
                $newqty = $row["order_qty"];
                if($user_type=='1')
                {
                    $amt = $row["product_regular_price"];
                }
                else
                {
                    $amt = $row["product_normal_price"];
                }
                
                $totalqty = $newqty * $amt;
                $total += $totalqty++;
                // $totalqty = $row["order_qty"] * $row["product_normal_price"];
                // echo $totalqty++;
                
            }
            // echo "User :".$user_id." Total : ".$total."<br><br>";      

            if($accept_nagative_balance =='0') 
            {
                if($total > $user_balance)
                {
                    echo "User Balance : ".$user_balance." | "." Order Total : ".$total."<br>";
                    echo "<h3 style='color:red;'>Nagative Not Allow User ID : ".$user_id." AND uoc_date : ".$newdate."</h3><BR><BR>";
                
                    mysqli_query($conn,"update tbl_order_calendar set oc_is_delivered='3' where user_id='$user_id' and order_date='$newdate'") or die(mysqli_error($conn));
                
                    mysqli_query($conn,"delete from tbl_user_order_calendar where user_id='$user_id' and uoc_date='$newdate'") or die(mysqli_error($conn));
                
                    $resultq=mysqli_query($conn,"select * from tbl_notification where notification_date='$newdate' and user_id='$user_id'") or die(mysqli_error($conn));
                    
                    $title = "Order Cancel";
                    $des = "Insufficient Balance";
                    
                    if(mysqli_num_rows($resultq)<=0)
                    {
                        $resultq=mysqli_query($conn,"insert into tbl_notification (user_id,notification_title,notification_des,notification_date)
                        values ('$user_id','$title','$des','$newdate')") or die(mysqli_error($conn));
                    }
                    else
                    {
                        
                    }
                    echo "done";
                } 
                
            }
            else
            {
                
            }
            
        }
    }
?>