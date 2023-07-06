<?php
    include '../connection.php';
    // $action=$_POST["action"];
    
    $response=array();

    $user_id=$_POST["user_id"];
    $sorting_no=$_POST["sorting_no"];

    $result=mysqli_query($conn,"update tbl_user set sorting_no='$sorting_no' where user_id='$user_id'") or die(mysqli_error($conn));
    if($result=true)
    {
        $response["status"]="yes";
        $response["message"]="Successfully Sequence Number";
    }
    else
    {
        $response["status"]="no";
        $response["message"]="Something is Wrong";
    }
            
    echo json_encode($response);
?>