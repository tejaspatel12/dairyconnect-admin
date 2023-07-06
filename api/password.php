<?php 
    include '../connection.php';
    $action=$_POST["action"];
    
    $response=array();
    
    //AREA
    if($action=='user_change_password')
    {
        $oldcode=$_POST["oldcode"];
        $newcode=$_POST["newcode"];
        $confirm=$_POST["confirm"];
        $user_id=$_POST["user_id"];
        
       $result=mysqli_query($conn,"select * from tbl_user where user_id='$user_id' and user_password='$oldcode'") or die(mysqli_error($conn));
        if(mysqli_num_rows($result)<=0)
        {
            
            $response["status"]="password_wrong";
            $response["message"]="Current Password is Wrong";
        }
        else
        {
            $resultupdate=mysqli_query($conn,"update tbl_user set user_password='$confirm' where user_id='$user_id'") or die(mysqli_error($conn));
            if($resultupdate=true)
            {
                $response["status"]="yes";
                $response["message"]="Password Updated Successfully.";
                $response["password"]="Your New Password is $confirm";
            }
            else
            {
                $response["status"]="no";
                $response["message"]="Something is Wrong";
            }
        }
        
        // $result=mysqli_query($conn,"update tbl_area set area_name='$area_name',area_status='$area_status',area_image='$image' where area_id='$area_id'") or die(mysqli_error($conn));
        // if($result=true)
        // {
        //     $response["status"]="yes";
        //     $response["message"]="Successfully Update Area";
        // }
        // else
        // {
        //     $response["status"]="no";
        //     $response["message"]="Something is Wrong";
        // }
    }elseif($action=='user_set_new_password')
    {
        $newcode=$_POST["newcode"];
        $confirm=$_POST["confirm"];
        $user_id=$_POST["user_id"];
        
       $result=mysqli_query($conn,"select * from tbl_user where user_id='$user_id'") or die(mysqli_error($conn));
        if(mysqli_num_rows($result)<=0)
        {
            
            $response["status"]="password_wrong";
            $response["message"]="Current Password is Wrong";
        }
        else
        {
            $resultupdate=mysqli_query($conn,"update tbl_user set user_password='$confirm' where user_id='$user_id'") or die(mysqli_error($conn));
            if($resultupdate=true)
            {
                $response["status"]="yes";
                $response["message"]="Password Updated Successfully.";
                $response["password"]="Your New Password is $confirm";
            }
            else
            {
                $response["status"]="no";
                $response["message"]="Something is Wrong";
            }
        }
    }
    elseif($action=='show_all_area')
    {
       $result=mysqli_query($conn,"select * from tbl_area") or die(mysqli_error($conn));

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
    elseif($action=='method_area')
    {
        $area_status=$_POST["area_status"];
           $result=mysqli_query($conn,"select * from tbl_area where area_status='$area_status'") or die(mysqli_error($conn));

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
    elseif($action=='get_area')
    {
        $area_id=$_POST["area_id"];
        $result=mysqli_query($conn,"select * from tbl_area where area_id='$area_id'") or die(mysqli_error($conn));

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
    elseif($action=='update_area_with')
    {
        $area_id=$_POST["area_id"];
        $area_name=$_POST["area_name"];
        $area_image=$_POST["area_image"];
        $area_status=$_POST["area_status"];
        
        $data = base64_decode($area_image);
        $image=rand(111111,999999).".png";
        file_put_contents("../images/area/".$image,$data);
        
        $result=mysqli_query($conn,"update tbl_area set area_name='$area_name',area_status='$area_status',area_image='$image' where area_id='$area_id'") or die(mysqli_error($conn));
        if($result=true)
        {
            $response["status"]="yes";
            $response["message"]="Successfully Update Area";
        }
        else
        {
            $response["status"]="no";
            $response["message"]="Something is Wrong";
        }
    }
    elseif($action=='update_area_without')
    {
        $area_id=$_POST["area_id"];
        $area_name=$_POST["area_name"];
        $area_status=$_POST["area_status"];
        
        $result=mysqli_query($conn,"update tbl_area set area_name='$area_name',area_status='$area_status' where area_id='$area_id'") or die(mysqli_error($conn));
        if($result=true)
        {
            $response["status"]="yes";
            $response["message"]="Successfully Update Area";
        }
        else
        {
            $response["status"]="no";
            $response["message"]="Something is Wrong";
        }
    }
    elseif($action=='add_area')
    {
        $area_name=$_POST["area_name"];
        $area_image=$_POST["area_image"];
        $area_status=$_POST["area_status"];
        
        $data = base64_decode($area_image);
        $image=rand(111111,999999).".png";
        file_put_contents("../images/area/".$image,$data);
        
        $result=mysqli_query($conn,"insert into tbl_area(area_name,area_image,area_status) values('$area_name','$image','$area_status')") or die(mysqli_error($conn));
        // $result=mysqli_query($conn,"update tbl_area set area_name='$area_name',area_status='$area_status' where area_id='$area_id'") or die(mysqli_error($conn));
        if($result=true)
        {
            $response["status"]="yes";
            $response["message"]="Successfully Area Added";
        }
        else
        {
            $response["status"]="no";
            $response["message"]="Something is Wrong";
        }
    }
    elseif($action=='delete_area')
    {
        $area_id=$_POST["area_id"];
        $result=mysqli_query($conn,"delete from tbl_area where area_id='$area_id'") or die(mysqli_error($conn));
        if($result=true)
        {
            $response["status"]="yes";
            $response["message"]="Successfully Area Deleted";
        }
        else
        {
            $response["status"]="no";
            $response["message"]="Something is Wrong";
        }
    }
    
    //TIME SLOT
    elseif($action=='show_time_slot')
    {
       $result=mysqli_query($conn,"select * from tbl_time_slot") or die(mysqli_error($conn));

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
    elseif($action=='method_time_slot')
    {
        $time_slot_status=$_POST["time_slot_status"];
       $result=mysqli_query($conn,"select * from tbl_time_slot where time_slot_status='$time_slot_status'") or die(mysqli_error($conn));

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
    
    //DELIVERY BOY
    elseif($action=='show_deliveryboy')
    {
       $result=mysqli_query($conn,"select * from tbl_deliveryboy as d left join tbl_time_slot as t on t.time_slot_id=d.time_slot_id") or die(mysqli_error($conn));

        if(mysqli_num_rows($result)<=0)
        {
            
            $response["status"]="no";
            $response["error"]="No Data Available!";
        }
        else
        {
            while($row=mysqli_fetch_assoc($result))
            {
                // $result1=mysqli_query($conn,"select * from tbl_deliveryboy_area as da left join tbl_area as a on da.area_id=a.area_id where da.deliveryboy_id='$deliveryboy_id'") or die(mysqli_error($conn));
                // while($row1=mysqli_fetch_assoc($result1))
                // {
                //     $array[] = $row1["area_name"]; // for your $arr1 
                //     // echo $row1["area_name"]+"<BR>";
                // }
                
                $result1234=mysqli_query($conn,"select * from tbl_deliveryboy_area as da left join tbl_area as a on a.area_id=da.area_id where da.deliveryboy_id='".$row['deliveryboy_id']."'");
                $x = array();
                $i=1;
                while($row1234=mysqli_fetch_array($result1234))
                {
                    $x[$i] = $row1234["area_name"];
                    $i++;
                }
                
                $area_name_1 = $x["1"];
                $area_name_2 = $x["2"];
                $area_name_3 = $x["3"];
                $area_name_4 = $x["4"];
                
                $response[]=array(
                    "deliveryboy_id" => $row['deliveryboy_id'],
                    "deliveryboy_name" => $row["deliveryboy_name"],
                    "deliveryboy_email" => $row["deliveryboy_email"],
                    "deliveryboy_mobile" => $row["deliveryboy_mobile"],
                    "deliveryboy_password" => $row["deliveryboy_password"],
                    "deliveryboy_image" => $row["deliveryboy_image"],
                    "deliveryboy_status" => $row["deliveryboy_status"],
                    "is_deliveryboy_assign" => $row["is_deliveryboy_assign"],
                    "deliveryboy_registration_complete" => $row["deliveryboy_registration_complete"],
                    "time_slot_name" => $row["time_slot_name"],
                    "time_slot_cutoff_time" => $row["time_slot_cutoff_time"],
                    "time_slot_status" => $row["time_slot_status"],
                    
                    "area_name_1" => $area_name_1,
                    "area_name_2" => $area_name_2,
                    "area_name_3" => $area_name_3,
                    "area_name_4" => $area_name_4,

                    
                    // "product_min_qty" => intval($row["product_min_qty"]),
                );
                // $response[]=$row;
            }
        }
    }
    elseif($action=='method_deliveryboy')
    {
        $is_approve=$_POST["is_approve"];
       $result=mysqli_query($conn,"select * from tbl_deliveryboy where is_approve='$is_approve'") or die(mysqli_error($conn));

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
    
    //USER 
    elseif($action=='show_user')
    {
       $result=mysqli_query($conn,"select * from tbl_user as u left join tbl_area as a on a.area_id=u.area_id left join tbl_deliveryboy as d on d.deliveryboy_id=u.deliveryboy_id where u.registration_complete='1'") or die(mysqli_error($conn));

        if(mysqli_num_rows($result)<=0)
        {
            
            $response["status"]="no";
            $response["error"]="No Data Available!";
        }
        else
        {
            while($row=mysqli_fetch_assoc($result))
            {
                if($row["deliveryboy_id"]==null)
                {
                    $deliveryboy_id = "0";
                }
                else
                {
                   $deliveryboy_id = $row["deliveryboy_id"];
                }
                $response[]=array(
                    "user_id" => $row["user_id"],
                    "deliveryboy_id" => $deliveryboy_id,
                    "area_id" => $row["area_id"],
                    "user_first_name" => $row["user_first_name"],
                    "user_last_name" => $row["user_last_name"],
                    "user_email" => $row["user_email"],
                    "user_mobile_number" => $row["user_mobile_number"],
                    "user_password" => $row["user_password"],
                    "user_address" => $row["user_address"],
                    "user_balance" => $row["user_balance"],
                    "user_subscription_status" => $row["user_subscription_status"],
                    "accept_nagative_balance" => $row["accept_nagative_balance"],
                    "user_type" => $row["user_type"],
                    "user_status" => $row["user_status"],
                    "registration_complete" => $row["registration_complete"],
                    "area_name" => $row["area_name"],
                    "deliveryboy_name" => $row["deliveryboy_name"],

                    
                    // "product_min_qty" => intval($row["product_min_qty"]),
                );
                // $response[]=$row;
            }
        }
    }
    elseif($action=='method_user')
    {
       $user_status=$_POST["user_status"];
       $result=mysqli_query($conn,"select * from tbl_user where user_status='$user_status'") or die(mysqli_error($conn));

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
    
    //USER_ASIGN
    elseif($action=='area_deliveryboy')
    {
      $area_id=$_POST["area_id"];
      $result=mysqli_query($conn,"select * from tbl_deliveryboy as d left join tbl_deliveryboy_area as da on da.deliveryboy_id=d.deliveryboy_id where da.area_id='$area_id' group by d.deliveryboy_id") or die(mysqli_error($conn));

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
    
    
    //DELIVEY BOY
    elseif($action=='add_deliveryboy')
    {
        $deliveryboy_name=$_POST["deliveryboy_name"];
        $deliveryboy_email=$_POST["deliveryboy_email"];
        $deliveryboy_mobile=$_POST["deliveryboy_mobile"];
        $deliveryboy_password=$_POST["deliveryboy_password"];
        $deliveryboy_image=$_POST["deliveryboy_image"];
        $deliveryboy_status=$_POST["deliveryboy_status"];
        $time_slot_id=$_POST["time_slot_id"];
        

        $data = base64_decode($deliveryboy_image);
        $image= "DBoy_Pro_"+rand(111111,999999).".png";
        file_put_contents("../images/deliveryboy/".$image,$data);
        
        if($deliveryboy_image==null)
        {
        $result=mysqli_query($conn,"insert into tbl_deliveryboy(deliveryboy_name,deliveryboy_email,deliveryboy_mobile,deliveryboy_password,deliveryboy_status,deliveryboy_image,deliveryboy_registration_complete,time_slot_id) values('$deliveryboy_name','$deliveryboy_email','$deliveryboy_mobile','$deliveryboy_password','$deliveryboy_status','logo.png','1','$time_slot_id')") or die(mysqli_error($conn));
        }
        else
        {
            $result=mysqli_query($conn,"insert into tbl_deliveryboy(deliveryboy_name,deliveryboy_email,deliveryboy_mobile,deliveryboy_password,deliveryboy_status,deliveryboy_image,deliveryboy_registration_complete,time_slot_id) values('$deliveryboy_name','$deliveryboy_email','$deliveryboy_mobile','$deliveryboy_password','$deliveryboy_status','$image','1','$time_slot_id')") or die(mysqli_error($conn));
        }
        if($result=true)
        {
            $response["status"]="yes";
            $response["message"]="Successfully Deliveryboy Added";
        }
        else
        {
            $response["status"]="no";
            $response["message"]="Something is Wrong";
        }
    }
    elseif($action=='approve_deliveryboy')
    {
        $deliveryboy_id=$_POST["deliveryboy_id"];
        
        $result=mysqli_query($conn,"update tbl_deliveryboy set deliveryboy_status='1' where deliveryboy_id='$deliveryboy_id'") or die(mysqli_error($conn));
        if($result=true)
        {
            $response["status"]="yes";
            $response["message"]="Successfully Approve Delivery Boy";
        }
        else
        {
            $response["status"]="no";
            $response["message"]="Something is Wrong";
        }
    }
    elseif($action=='unapprove_deliveryboy')
    {
        $deliveryboy_id=$_POST["deliveryboy_id"];
        
        $result=mysqli_query($conn,"update tbl_deliveryboy set deliveryboy_status='2' where deliveryboy_id='$deliveryboy_id'") or die(mysqli_error($conn));
        if($result=true)
        {
            $response["status"]="yes";
            $response["message"]="Successfully Unapprove Delivery Boy";
        }
        else
        {
            $response["status"]="no";
            $response["message"]="Something is Wrong";
        }
    }
    elseif($action=='get_assign_area')
    {
      $deliveryboy_id=$_POST["deliveryboy_id"];
      $result=mysqli_query($conn,"select * from tbl_deliveryboy_area as da left join tbl_deliveryboy as d on da.deliveryboy_id=d.deliveryboy_id left join tbl_area as a on da.area_id=a.area_id where d.deliveryboy_id='$deliveryboy_id'") or die(mysqli_error($conn));

        if(mysqli_num_rows($result)<=0)
        {
            
            $response["status"]="no";
            $response["error"]="No Data Available!";
        }
        else
        {
            while($row=mysqli_fetch_assoc($result))
            {
                $response[]=array(
                    "area_id" => $row["area_id"],
                    "area_image" => $row["area_image"],
                    "area_name" => $row["area_name"],
                    "area_status" => $row["area_status"],
                );
            }
        }
    }
    elseif($action=='add_area_deliveryboy')
    {
        $deliveryboy_id=$_POST["deliveryboy_id"];
        $area_id=$_POST["area_id"];
        
        $result=mysqli_query($conn,"select * from tbl_deliveryboy_area where deliveryboy_id='$deliveryboy_id' and area_id='$area_id'") or die(mysqli_error($conn));
        if(mysqli_num_rows($result)<=0)
        {
            $result1=mysqli_query($conn,"insert into tbl_deliveryboy_area(deliveryboy_id,area_id,da_status) values('$deliveryboy_id','$area_id','1')") or die(mysqli_error($conn));
            if($result1=true)
            {
                $response["status"]="yes";
                $response["message"]="Successfully Assign Area to Deliveryboy";
            }
            else
            {
                $response["status"]="no";
                $response["message"]="Something is Wrong";
            }
        }
        else
        {
            $response["status"]="no";
            $response["message"]="Available data";
        }
    }
    
    
    
    
    
    else
    {
        $response["message"]="Something is Wrong";
    }
    echo json_encode($response);
?>