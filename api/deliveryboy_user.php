<?php 
    include '../connection.php';
    $action=$_POST["action"];
    
    $response=array();

        $deliveryboy_id=$_POST["deliveryboy_id"];
        
        $result=mysqli_query($conn,"select * from tbl_user as u left join tbl_area as a on u.area_id=a.area_id left join tbl_time_slot as ts on u.user_time=ts.time_slot_id where deliveryboy_id='$deliveryboy_id' ORDER BY sorting_no + 0 ASC") or die(mysqli_error($conn));
        
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
        
    echo json_encode($response);
?>