<?php 
    include '../connection.php';
    $action=$_POST["action"];
    
    $response=array();

    if($action=='adminlogin')
        {
            $mobile_number=$_POST["mobile_number"];
            $password=$_POST["password"];

            $result=mysqli_query($conn,"select * from tbl_admin where mobile_number='$mobile_number' and password='$password'") or die(mysqli_error($conn));
            if(mysqli_num_rows($result)<=0)
            {
                
                $response["status"]="no";
                $response["error"]="No Data Available!";
            }
            else
            {
                while($row=mysqli_fetch_assoc($result))
                {
                    $response["status"]="yes";
                    $response["data"]=$row;
                    // mysqli_query($conn,"update tbl_user set token='$token' where mobile_numbers='$mobile_numbers'");
                }
            
            }
        }
        elseif($action=='userregister')
        {
            $user_mobile_number=$_POST["user_mobile_number"];

            $resultuser=mysqli_query($conn,"select * from tbl_user where user_mobile_number='$user_mobile_number'") or die(mysqli_error($conn));
            if(mysqli_num_rows($resultuser)<=0)
            {
                
                $userotp = random_int(100000, 999999);
                $result=mysqli_query($conn,"insert into tbl_user(user_mobile_number,user_otp) values('$user_mobile_number','$userotp')") or die(mysqli_error($conn));
                if($result=true)
                {
                    $user_id = $conn->insert_id;
                    $sms = "http://api.ask4sms.com/sms/1/text/query?username=GIRORGANIC&password=Girorganic@123&from=GROGNC&to=91$user_mobile_number&text=$userotp%20is%20your%20verification%20code%20for%20Gir%20Organic%20app&indiaDltContentTemplateId=1207163284885053993&indiaDltPrincipalEntityId=1201162297097138491";
                        
                    $output = file($sms);
                    
                    $response["status"]="yes";
                    $response["message"]="We send you OTP on $user_mobile_number";
                    $response["user_id"]=$user_id;
                    $response["userotp"]=$userotp;
                       
                }
                else
                {
                    $response["status"]="no";
                    $response["message"]="Something is Wrong";
                }	
            }
            else
            {
                while($row=mysqli_fetch_assoc($resultuser))
                {
                    $registration_complete = $row['registration_complete'];
                    $user_id = $row['user_id'];
                    $userotp = $row['user_otp'];
                    
                    if($registration_complete=='0')
                    {
                        $sms = "http://api.ask4sms.com/sms/1/text/query?username=GIRORGANIC&password=Girorganic@123&from=GROGNC&to=91$user_mobile_number&text=$userotp%20is%20your%20verification%20code%20for%20Gir%20Organic%20app&indiaDltContentTemplateId=1207163284885053993&indiaDltPrincipalEntityId=1201162297097138491";
                        
                        $output = file($sms);
                    
                        $response["status"]="yes";
                        $response["message"]="We send you OTP on $user_mobile_number";
                        $response["user_id"]=$user_id;
                        $response["userotp"]=$userotp;
                        
                    }
                    else
                    {
                        $response["status"]="no";
                        $response["message"]="Mobile Number Already Registered.";
                    }	
                }

            }
        }
        elseif($action=='userotpregister')
        {
            // $last_id=$_POST["last_id"];
            $user_id=$_POST["user_id"];
            $otp=$_POST["otp"];
            
            $result=mysqli_query($conn,"select * from tbl_user where user_otp='$otp' and user_id='$user_id'") or die(mysqli_error($conn));
            if(mysqli_num_rows($result)<=0)
            {
                $response["status"]="no";
                $response["message"]="Opps! Wrong OTP you enter!";
            }
            else
            {
                $response["status"]="yes";
                $response["message"]="Successfully authenticated with otp!";
            }
        }
        elseif($action=='userregistersec')
        {
            $user_id=$_POST["user_id"];
            $user_first_name=$_POST["user_first_name"];
            $user_last_name=$_POST["user_last_name"];
            $user_email=$_POST["user_email"];
            $country_id=$_POST["country_id"];
            $state_id=$_POST["state_id"];
            $city_id=$_POST["city_id"];
            $area_id=$_POST["area_id"];
            $area=$_POST["area"];
            
            $result=mysqli_query($conn,"update tbl_user set user_first_name='$user_first_name',user_last_name='$user_last_name',user_email='$user_email',country_id='$country_id',state_id='$state_id',city_id='$city_id',area_id='$area_id',area='$area' where user_id='$user_id'") or die(mysqli_error($conn));
            if($result=true)
            {
                $response["status"]="yes";
                $response["message"]="Successfully Inserted";
            }
            else
            {
                $response["status"]="no";
                $response["message"]="Something is Wrong";
            }
        }
        elseif($action=='userregisterthread')
        {
            $user_id=$_POST["user_id"];
            $user_address=$_POST["user_address"];
            $user_latlng=$_POST["user_latlng"];
            
            $result=mysqli_query($conn,"update tbl_user set user_address='$user_address',user_latlng='$user_latlng',registration_complete='1' where user_id='$user_id'") or die(mysqli_error($conn));
            if($result=true)
            {
                // $response["status"]="yes";
                // // $response["message"]="Successfully Inserted";
                // $response["data"]=$row;
                
                $result=mysqli_query($conn,"select * from tbl_user where user_id='$user_id'") or die(mysqli_error($conn));
                if(mysqli_num_rows($result)<=0)
                {
                    $response["status"]="no";
                    $response["message"]="Opps! Wrong OTP you enter!";
                }
                else
                {
                    while($row=mysqli_fetch_assoc($result))
                    {
                        $response["status"]="yes";
                        $response["data"]=$row;
                    }
                }
            }
            else
            {
                $response["status"]="no";
                $response["message"]="Something is Wrong";
            }
        }

        elseif($action=='userlogin')
        {
            $user_mobile_number=$_POST["user_mobile_number"];

            $result=mysqli_query($conn,"select * from tbl_user where user_mobile_number='$user_mobile_number'") or die(mysqli_error($conn));
            if(mysqli_num_rows($result)<=0)
            {
                
                $response["status"]="no";
                $response["message"]="No account registered under provided mobile number, please create a new account";
            }
            else
            {
                while($row=mysqli_fetch_assoc($result))
                {
                    $registration_complete = $row['registration_complete'];
                    $user_id = $row['user_id'];
                    $userotp = $row['user_otp'];
                    
                    if($registration_complete=='0')
                    {
                      $response["status"]="no";
                        $response["message"]="Please complete your registration first.."; 
                    }else{
                        
                    $sms = "http://api.ask4sms.com/sms/1/text/query?username=GIRORGANIC&password=Girorganic@123&from=GROGNC&to=91$user_mobile_number&text=$userotp%20is%20your%20verification%20code%20for%20Gir%20Organic%20app&indiaDltContentTemplateId=1207163284885053993&indiaDltPrincipalEntityId=1201162297097138491";
                    
                    $output = file($sms);
                        
                    $response["status"]="yes";
                    $response["message"]="We send you OTP on this number";
                    $response["user_id"]=$user_id;
                    $response["userotp"]=$userotp;
                    
                    }
                   
                    
                    	
                }
            
            }
        }
        elseif($action=='resendotp')
        {
            $user_id=$_POST["user_id"];
            $user_mobile_number=$_POST["user_mobile_number"];
            
            $resultuser=mysqli_query($conn,"select * from tbl_user where user_mobile_number='$user_mobile_number'") or die(mysqli_error($conn));
            while($row=mysqli_fetch_assoc($resultuser))
            {
                $userotp = $row['user_otp'];
            
        
                $sms = "http://api.ask4sms.com/sms/1/text/query?username=GIRORGANIC&password=Girorganic@123&from=GROGNC&to=91$user_mobile_number&text=$userotp%20is%20your%20verification%20code%20for%20Gir%20Organic%20app&indiaDltContentTemplateId=1207163284885053993&indiaDltPrincipalEntityId=1201162297097138491";
            
                $output = file($sms);
                
                $response["status"]="yes";
                $response["message"]="We send you OTP on this number";
                $response["user_id"]=$user_id;
                $response["userotp"]=$userotp;
            }
            
        }
        elseif($action=='userotplogin')
        {
            // $last_id=$_POST["last_id"];
            $user_id=$_POST["user_id"];
            $otp=$_POST["otp"];
            $user_token=$_POST["user_token"];
            
            $result=mysqli_query($conn,"select * from tbl_user where user_otp='$otp' and user_id='$user_id'") or die(mysqli_error($conn));
            if(mysqli_num_rows($result)<=0)
            {
                $response["status"]="no";
                $response["message"]="Opps! Wrong OTP you enter!";
            }
            else
            {
                while($row=mysqli_fetch_assoc($result))
                {
                    $response["status"]="yes";
                    $result=mysqli_query($conn,"update tbl_user set user_token='$user_token' where user_id='$user_id'") or die(mysqli_error($conn));
                    $response["data"]=$row;
                }
            }
        }
        elseif($action=='deliveryboylogin')
        {
            $deliveryboy_mobile=$_POST["deliveryboy_mobile"];
            $deliveryboy_password=$_POST["deliveryboy_password"];

            $result=mysqli_query($conn,"select * from tbl_deliveryboy where deliveryboy_mobile='$deliveryboy_mobile' and deliveryboy_password='$deliveryboy_password'") or die(mysqli_error($conn));
            if(mysqli_num_rows($result)<=0)
            {
                
                $response["status"]="no";
                $response["message"]="This Mobile number is not register yet!";
            }
            else
            {
                while($row=mysqli_fetch_assoc($result))
                {

                    if($row['is_approve']=='1')
                    {
                        $response["status"]="yes";
                        $response["data"]=$row;
                        // mysqli_query($conn,"update tbl_user set token='$token' where mobile_numbers='$mobile_numbers'");
                    }
                    else if($row['is_approve']=='2')
                    {
                        $response["status"]="no";
                        $response["message"]="Admin reject your request!";
                    }
                    else
                    {                
                        $response["status"]="no";
                        $response["message"]="Admin isn't approve you yet!";
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