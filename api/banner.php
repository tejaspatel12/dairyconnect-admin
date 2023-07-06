<?php 
    include '../connection.php';
    $action=$_POST["action"];
    
    $response=array();

    $result=mysqli_query($conn,"select * from tbl_banner") or die(mysqli_error($conn));
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