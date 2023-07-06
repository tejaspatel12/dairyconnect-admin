<?php 
    include '../connection.php';
    $action=$_POST["action"];
    
    $response=array();

    if($action=='show_app_setting')
    {
        $result=mysqli_query($conn,"select * from tbl_app_setting where app_id='1'") or die(mysqli_error($conn));
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
    }
    elseif($action=='show_application_terms_condition')
    {
        $result=mysqli_query($conn,"select app_terms_condition from tbl_app_setting where app_id='1'") or die(mysqli_error($conn));
        if(mysqli_num_rows($result)<=0)
        {
            
            $response["status"]="no";
            $response["error"]="No Data Available!";
        }
        else
        {
            while($row=mysqli_fetch_assoc($result))
            {
                // $response[]=$row;
                $response[]=array(
                    "app_terms_condition" => $row["app_terms_condition"], 
                );
            }
        }
    }
    else
    {
        $response["message"]="Something is Wrong";
    }
    echo json_encode($response);
?>