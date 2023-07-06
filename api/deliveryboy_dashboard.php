<?php 
    include '../connection.php';
    $response=array();

    $deliveryboy_id=$_POST["deliveryboy_id"];
    $deliveryboy_time=$_POST["deliveryboy_time"];
    $date=$_POST["date"];
    $hr;
    
    $resulthr=mysqli_query($conn,"select * from tbl_time_slot where time_slot_name='$deliveryboy_time'")or die(mysqli_error($conn));
    while($row=mysqli_fetch_assoc($resulthr))
    {
     $hr = $row["time_slot_cutoff_time"];
    }
    
    
    $finaltime = $date." ".$hr;

    //CATEGORY CODE
    $result=mysqli_query($conn,"select * from tbl_order_calendar as oc left join tbl_user as u on u.user_id=oc.user_id where u.deliveryboy_id='$deliveryboy_id' and oc.order_date='$date' and oc.oc_cutoff_time='$finaltime' and oc.oc_is_delivered!='2' and oc.oc_is_delivered!='3' and oc.oc_is_delivered!='4'")or die(mysqli_error($conn));
    $allorder="all_order";
    $response[$allorder]=mysqli_num_rows($result);
    

    $result1=mysqli_query($conn,"select * from tbl_time_slot as t left join tbl_deliveryboy as d on d.time_slot_id=t.time_slot_id where d.deliveryboy_id='$deliveryboy_id'")or die(mysqli_error($conn));
    $timeslot="time_slot";
    while($row=mysqli_fetch_assoc($result1))
    {
        $response[$timeslot]= $row["time_slot_name"];
            
    }

    $result2=mysqli_query($conn,"select * from tbl_user where deliveryboy_id='$deliveryboy_id'")or die(mysqli_error($conn));
    $alluser="all_user";
    $response[$alluser]=mysqli_num_rows($result2);
    
    
    $result3=mysqli_query($conn,"select * from tbl_deliveryboy_area as a left join tbl_deliveryboy as d on d.deliveryboy_id=a.deliveryboy_id left join tbl_area as aa on a.area_id=aa.area_id where d.deliveryboy_id='$deliveryboy_id'")or die(mysqli_error($conn));
    $deliveryboy_area="deliveryboy_area";
    
    $x = array();
    $i=0;

    while($row=mysqli_fetch_assoc($result3))
    {
    $i++;
    
    $x[$i] = $row["area_name"];
            
    }
    $response[$deliveryboy_area]= $x;
    
    //   $result4=mysqli_query($conn,"select * from tbl_order_calendar as c left join tbl_user as u on c.user_id=u.user_id where u.deliveryboy_id='$deliveryboy_id' and c.order_date='$date' and oc_is_delivered!='2'")or die(mysqli_error($conn));
    
       $result4=mysqli_query($conn,"select * from tbl_order_calendar as c left join tbl_user as u on c.user_id=u.user_id where u.deliveryboy_id='$deliveryboy_id' and c.order_date='$date' and c.oc_cutoff_time='$finaltime' and oc_is_delivered!='3' and oc_is_delivered!='4'")or die(mysqli_error($conn));
    $total_pouch="total_pouch";
    while($row=mysqli_fetch_assoc($result4))
    {
        $total += $row["order_qty"]++;
    }
    $response[$total_pouch]= $total;
    
   $result5=mysqli_query($conn,"select deliveryboy_name from tbl_deliveryboy where deliveryboy_id='$deliveryboy_id'")or die(mysqli_error($conn));
    $deliveryboy_name="deliveryboy_name";
    while($row=mysqli_fetch_assoc($result5))
    {
        $dname = $row["deliveryboy_name"];
    }
    $response[$deliveryboy_name]= $dname;
    $response["final_time"]= $finaltime;
    
    
    echo json_encode($response);
?>