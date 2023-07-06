<?php 
    date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)
    include '../../connection.php';
    
    $DATE = date("Y-m-d");
    // $DATE = "2023-07-05";
    echo $DATE."<BR>";
    
    $i = 1;
    
    $curdate = date("Y-m-d H:i:s");
    // $curdate = "2023-07-05 05:00:00";

    echo $curdate."<BR>";
    
    $result=mysqli_query($conn,"select * from tbl_time_slot where time_slot_status='1'") or die(mysqli_error($conn));
    while($row=mysqli_fetch_assoc($result))
    {
        $array[] = $row["time_slot_cutoff_time"]; // for your $arr1 
    }
    
    $cutoff_1 = $array[0];
    $cutoff_2 = $array[1];
                
    // $cf = "09:00:00";
    // $cs = "17:00:00";
    
    $cf = $cutoff_1;
    $cs = $cutoff_2;
    
    // $cf = "09:00:00";
    // $cs = "17:00:00";

    // $mor = "00:00:00";
    // $morend = "16:59:59";
    
    // $evn = "17:00:00";
    // $evnend = "23:59:59";
    
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
// 		$cutoff = date('Y-m-d H:i:s', strtotime($cutoff. ' -  1 days')); 
		echo "$first | and | $sec<br><br>";
		echo $day = "Morning"."<br><br>";
		
		$newdate = $DATE;
		
		$type = $cf;

	}
	elseif(($thr < $curdate) && ($curdate < $fur))
	{
		$cutoff = date('Y-m-d H:i:s', strtotime("$DATE $cs"));
		echo "$thr | and | $fur<br><br>";
		echo $day = "Evening"."<br><br>";
		
		$newdate = $DATE;
		$type = $cs;

	}
	else
	{}



    $result=mysqli_query($conn,"select * from tbl_order_calendar where order_date='$newdate' and oc_cutoff_time='$cutoff' and order_qty>'0'") or die(mysqli_error($conn));
    if(mysqli_num_rows($result)<=0)
    {
        echo "No Entry Found";
    }
    else
    {
        
     
        while($row=mysqli_fetch_assoc($result))
        {
           echo $i."<br>";$i++;
           
            $user_id = $row["user_id"];
                
            $sql = mysqli_query($conn,"select * from tbl_user_order_calendar where user_id='".$user_id."' and uoc_date='$newdate'");
            if(mysqli_num_rows($sql)>0)
            {
                ?>
                <div class="alert alert-danger mb-2" role="alert">
                    <strong>Error!</strong> Duplicate User
                </div>

            <?php
            }
            else
            {
                                            
                $result1=mysqli_query($conn,"insert into tbl_user_order_calendar (user_id,uoc_date,uoc_cutoff) 
                values ('$user_id','$newdate','$type')") or die(mysqli_error($conn));
                
                if($result1=true)
                {
                    echo "Success";
                }
                else
                {
                    echo "False";
                }
            
            }
            
        }
    }
    
echo "<script>window.location='cancelOrder.php';</script>";
    
    

    
    
?>