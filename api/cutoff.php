<?php 
    include '../connection.php';
    $action=$_POST["action"];
    
    $response=array();

    if($action=='get_cutoff')
    {
        $result=mysqli_query($conn,"select * from tbl_time_slot where time_slot_status='1'") or die(mysqli_error($conn));
        if(mysqli_num_rows($result)<=0)
        {
            
            $response["status"]="no";
            $response["error"]="No Data Available!";
        }
        else
        {
            $array = array();
            while($row=mysqli_fetch_assoc($result))
            {
                $array[] = $row["time_slot_cutoff_time"]; // for your $arr1 
                // $a = $row["time_slot_cutoff_time"];
            }
            // echo $a;
            // print_r($array);
            $response[]=array(
                "cutoff_1" => $array[0],
                "cutoff_2" => $array[1],
            );
            
        }
    }
    else
    {
        $response["message"]="Something is Wrong";
    }
    echo json_encode($response);
?>