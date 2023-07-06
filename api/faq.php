<?php 
    include '../connection.php';
    $action=$_POST["action"];
    
    $response=array();

    if($action=='show_faq')
    {
        $result=mysqli_query($conn,"select * from tbl_faq where faq_status='1'") or die(mysqli_error($conn));
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