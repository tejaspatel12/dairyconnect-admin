<?php 
    include '../connection.php';
    $response=array();

    $user_id=$_POST["user_id"];
    $timeslot="time_slot";
    $cutofftime="cutoff_time";
    $utype="user_type";
    $user_status="user_status";
    $user_balance="user_balance";
    $u_balance="u_balance";
    $min_balance="min_balance";
    
    $cutoff_1="cutoff_1";
    $cutoff_2="cutoff_2";
    $balance="200";
    $nagative_balance="accept_nagative_balance";
    //CATEGORY CODE
    
        $resultcutoff=mysqli_query($conn,"select * from tbl_time_slot where time_slot_status='1'") or die(mysqli_error($conn));
        if(mysqli_num_rows($resultcutoff)<=0)
        {
            
            $response["status"]="no";
            $response["error"]="No Data Available!";
        }
        else
        {
            $array = array();
            while($row=mysqli_fetch_assoc($resultcutoff))
            {
                $array[] = $row["time_slot_cutoff_time"];
            }
            
            
        }
        
        $result1=mysqli_query($conn,"select * from tbl_user as u left join tbl_time_slot as ts on ts.time_slot_id=u.user_time where u.user_id='$user_id'")or die(mysqli_error($conn));
        if(mysqli_num_rows($result1)<=0)
        {
            
            $response["status"]="no";
            $response["user_status"]="No";
        }
        else
        {
            while($row=mysqli_fetch_assoc($result1))
            {
                $type = $row["user_type"];
                if($row["deliveryboy_id"]=='0')
                {
                    $response[$timeslot]= "No";
                    $response["user_first_name"]= $row["user_first_name"];
                    $response["user_last_name"]= $row["user_last_name"];
                    $response["user_mobile_number"]= $row["user_mobile_number"];
                    $response[$user_status]= $row["user_status"];
                    $response[$user_balance]= $row["user_balance"];
                    $response[$nagative_balance]= $row["accept_nagative_balance"];
                    $response[$min_balance]= $balance;
                    $response[$utype]= $type;
                    $response["user_time"]= "0";
                    $response[$cutoff_1]= $array[0];
                    $response[$cutoff_2]= $array[1];   
                }
                elseif($row["user_time"]=='0')
                {
                    $response[$timeslot]= "No";
                    $response["user_first_name"]= $row["user_first_name"];
                    $response["user_last_name"]= $row["user_last_name"];
                    $response["user_mobile_number"]= $row["user_mobile_number"];
                    $response[$user_status]= $row["user_status"];
                    $response[$user_balance]= $row["user_balance"];
                    $response[$nagative_balance]= $row["accept_nagative_balance"];
                    $response[$min_balance]= $balance;
                    $response["user_time"]= "0";
                    $response[$utype]= $type;
                    $response[$cutoff_1]= $array[0];
                    $response[$cutoff_2]= $array[1];   
                }
                else
                {
                    // $resultcutoff=mysqli_query($conn,"select * from tbl_time_slot where time_slot_id='".$row["user_time"]."'") or die(mysqli_error($conn));
                    // if(mysqli_num_rows($resultcutoff)<=0)
                    // {

                    // }
                    // else
                    // {
                    //     $s_name = $row["time_slot_name"];
                    //     $s_time = $row["time_slot_cutoff_time"];
                    // }
                    
                    $response[$timeslot]= $row["time_slot_name"];
                    $response[$cutofftime]= $row["time_slot_cutoff_time"];
                    $response[$user_status]= $row["user_status"];
                    $response[$user_balance]= $row["user_balance"];
                    $response[$nagative_balance]= $row["accept_nagative_balance"];
                    $response["user_first_name"]= $row["user_first_name"];
                    $response["user_last_name"]= $row["user_last_name"];
                    $response["user_subscription_status"]= $row["user_subscription_status"];
                    $response["user_mobile_number"]= $row["user_mobile_number"];
                    $response[$min_balance]= $balance;
                    $response[$utype]= $type;
                    $response["user_time"]= $row["user_time"];
                    $response[$cutoff_1]= $array[0];
                    $response[$cutoff_2]= $array[1];   
                }
                    
            }
        }
 

        
    


    
    echo json_encode($response);
?>