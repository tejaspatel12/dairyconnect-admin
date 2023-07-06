<?php 
    include '../connection.php';
    $action=$_POST["action"];
    
    $response=array();

    if($action=='show_country')
    {
        $result=mysqli_query($conn,"select * from tbl_country where country_status='1'") or die(mysqli_error($conn));
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
    elseif($action=='show_state')
    {
        $country_id=$_POST["country_id"];
        $result=mysqli_query($conn,"select * from tbl_state where country_id='$country_id' and state_status='1'") or die(mysqli_error($conn));
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
    elseif($action=='show_city')
    {
        $state_id=$_POST["state_id"];
        $result=mysqli_query($conn,"select * from tbl_city where state_id='$state_id' and city_status='1'") or die(mysqli_error($conn));
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
    elseif($action=='show_area')
    {
        $result=mysqli_query($conn,"select * from tbl_area where area_status='1'") or die(mysqli_error($conn));
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