<?php 
    include '../connection.php';
    $action=$_POST["action"];
    
    $response=array();

    if($action=='get_user')
    {
        $user_id=$_POST["user_id"];
        $result=mysqli_query($conn,"select * from tbl_user where user_id='$user_id'") or die(mysqli_error($conn));
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
    elseif($action=='show_user_balance')
    {
        $user_id=$_POST["user_id"];
        $result=mysqli_query($conn,"select user_balance from tbl_user where user_id='$user_id'") or die(mysqli_error($conn));
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
    else
    {
        $response["message"]="Something is Wrong";
    }
    echo json_encode($response);
?>