<?php 
    include '../connection.php';
    $action=$_POST["action"];
    
    $response=array();

    if($action=='dashboard_recharge_offer')
    {
        $result1=mysqli_query($conn,"select ro_id from tbl_recharge_offer where ro_status='1'")or die(mysqli_error($conn));
        $allroffer="all_recharge_offer";
        $response[$allroffer]=mysqli_num_rows($result1);
    }
    elseif($action=='recharge_offer')
    {
        $user_id=$_POST["user_id"];
        
        $result1=mysqli_query($conn,"select * from tbl_user where user_id='$user_id'")or die(mysqli_error($conn));
        while($row=mysqli_fetch_assoc($result1))
        {
            $user_balance = $row['user_balance'];
            $accept_nagative_balance = $row['accept_nagative_balance'];

        }
        // echo "user_balance : ".$user_balance;

        if($user_balance < "0.00")
        {
            $response["status"]="no";
            $response["error"]="No Data Available!";
        }
        else
        {
            $result=mysqli_query($conn,"select * from tbl_recharge_offer where ro_status='1'") or die(mysqli_error($conn));
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
        
        
    }
    else
    {
        $response["message"]="Something is Wrong";
    }
    echo json_encode($response);
?>