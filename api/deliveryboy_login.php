<?php 
    include '../connection.php';
    $action=$_POST["action"];
    
    $response=array();

        if($action=='deliveryboyregister')
        {
            $deliveryboy_mobile_number=$_POST["deliveryboy_mobile_number"];

            $resultuser=mysqli_query($conn,"select * from tbl_deliveryboy where deliveryboy_mobile_number='$deliveryboy_mobile_number'") or die(mysqli_error($conn));
            if(mysqli_num_rows($resultuser)<=0)
            {

                $result=mysqli_query($conn,"insert into tbl_deliveryboy(deliveryboy_mobile_number) values('$deliveryboy_mobile_number')") or die(mysqli_error($conn));
                if($result=true)
                {
                    $deliveryboy_id = $conn->insert_id;
                    $userotp = random_int(100000, 999999);
                    
                        // $sms = "http://api.ask4sms.com/sms/1/text/query?username=GIRORGANIC&password=Girorganic@123&from=GROGNC&to=91$deliveryboy_mobile_number&text=$userotp%20is%20your%20verification%20code%20for%20Gir%20Organic%20app&indiaDltContentTemplateId=1207163284885053993&indiaDltPrincipalEntityId=1201162297097138491";
                        
                        $sms = "http://api.ask4sms.com/sms/1/text/query?username=GIRORGANIC&password=Girorganic@123&from=GROGNC&to=91$deliveryboy_mobile_number&text=$userotp%20is%20your%20OTP%20for%20GirOrganic.%20Do%20not%20share%20this%20OTP%20with%20anyone.&indiaDltContentTemplateId=1207163799180176519&indiaDltPrincipalEntityId=1201162297097138491";
                        
                        $output = file($sms);
                        
                        $result1=mysqli_query($conn,"insert into tbl_deliveryboy_otp(deliveryboy_id,deliveryboy_otp) values('$deliveryboy_id','$userotp')") or die(mysqli_error($conn));
                        if($result1=true)
                        {
                            $response["status"]="yes";
                            $response["message"]="We send you OTP on this number";
                            $last_id = $conn->insert_id;
                            $response["last_id"]=$last_id;
                            $response["deliveryboy_id"]=$deliveryboy_id;
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
                    $response["status"]="no";
                    $response["message"]="Something is Wrong";
                }	
            }
            else
            {
                while($row=mysqli_fetch_assoc($resultuser))
                {
                    $deliveryboy_registration_complete = $row['deliveryboy_registration_complete'];
                    $deliveryboy_id = $row['deliveryboy_id'];
                    if($deliveryboy_registration_complete=='0')
                    {
                        
                    $userotp = random_int(100000, 999999);
                    
                    // $sms = "http://api.ask4sms.com/sms/1/text/query?username=GIRORGANIC&password=Girorganic@123&from=GROGNC&to=91$deliveryboy_mobile_number&text=$userotp%20is%20your%20verification%20code%20for%20Gir%20Organic%20app&indiaDltContentTemplateId=1207163284885053993&indiaDltPrincipalEntityId=1201162297097138491";
                    
                    $sms = "http://api.ask4sms.com/sms/1/text/query?username=GIRORGANIC&password=Girorganic@123&from=GROGNC&to=91$deliveryboy_mobile_number&text=$userotp%20is%20your%20OTP%20for%20GirOrganic.%20Do%20not%20share%20this%20OTP%20with%20anyone.&indiaDltContentTemplateId=1207163799180176519&indiaDltPrincipalEntityId=1201162297097138491";
                        
                        $output = file($sms);
                        
                        $result1=mysqli_query($conn,"insert into tbl_deliveryboy_otp(deliveryboy_id,deliveryboy_otp) values('$deliveryboy_id','$userotp')") or die(mysqli_error($conn));
                        if($result1=true)
                        {
                            $response["status"]="yes";
                            $response["message"]="We send you OTP on this number";
                            $last_id = $conn->insert_id;
                            $response["last_id"]=$last_id;
                            $response["deliveryboy_id"]=$deliveryboy_id;
                            $response["deliveryboy_otp"]=$userotp;
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
                        $response["message"]="Mobile Number Already Registered.";
                    }	
                }

            }
        }
        elseif($action=='deliveryboyotpregister')
        {
            $last_id=$_POST["last_id"];
            $deliveryboy_id=$_POST["deliveryboy_id"];
            $otp=$_POST["otp"];
            
            $result=mysqli_query($conn,"select * from tbl_deliveryboy_otp as o left join tbl_deliveryboy as d on o.deliveryboy_id=d.deliveryboy_id where deliveryboy_otp_id='$last_id' and deliveryboy_otp='$otp'") or die(mysqli_error($conn));
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
        elseif($action=='deliveryboyregistersec')
        {
            $deliveryboy_id=$_POST["deliveryboy_id"];
            $deliveryboy_first_name=$_POST["deliveryboy_first_name"];
            $deliveryboy_last_name=$_POST["deliveryboy_last_name"];
            $deliveryboy_email=$_POST["deliveryboy_email"];
            
            $result=mysqli_query($conn,"update tbl_deliveryboy set deliveryboy_first_name='$deliveryboy_first_name',deliveryboy_last_name='$deliveryboy_last_name',deliveryboy_email='$deliveryboy_email' where deliveryboy_id='$deliveryboy_id'") or die(mysqli_error($conn));
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
        elseif($action=='adharfront')
        {
            $deliveryboy_id=$_POST["deliveryboy_id"];
            $adhar_front_img=$_POST["adhar_front_img"];
            
            $data = base64_decode($adhar_front_img);
            $image=rand(111111,999999).".png";
            file_put_contents("../images/deliveryboy/".$image,$data);
            
            $result=mysqli_query($conn,"update tbl_deliveryboy set deliveryboy_front_aadhar='$image' where deliveryboy_id='$deliveryboy_id'") or die(mysqli_error($conn));
            if($result=true)
            {
                $response["status"]="yes";
                $response["message"]="Successfully Upload Adhar Front Image";
            }
            else
            {
                $response["status"]="no";
                $response["message"]="Something is Wrong";
            }
        }
        elseif($action=='adharback')
        {
            $deliveryboy_id=$_POST["deliveryboy_id"];
            $adhar_back_img=$_POST["adhar_back_img"];
            
            $data = base64_decode($adhar_back_img);
            $image=rand(1111111,9999999).".png";
            file_put_contents("../images/deliveryboy/".$image,$data);
            
            $result=mysqli_query($conn,"update tbl_deliveryboy set deliveryboy_back_aadhar='$image' where deliveryboy_id='$deliveryboy_id'") or die(mysqli_error($conn));
            if($result=true)
            {
                $response["status"]="yes";
                $response["message"]="Successfully Upload Adhar Back Image";
            }
            else
            {
                $response["status"]="no";
                $response["message"]="Something is Wrong";
            }
        }
        // elseif($action=='licensefront')
        // {
        //     $deliveryboy_id=$_POST["deliveryboy_id"];
        //     $license_front_img=$_POST["license_front_img"];
            
        //     $data = base64_decode($license_front_img);
        //     $image=rand(11111111,99999999).".png";
        //     file_put_contents("../images/deliveryboy/".$image,$data);
            
        //     $result=mysqli_query($conn,"update tbl_deliveryboy set deliveryboy_front_licence='$image' where deliveryboy_id='$deliveryboy_id'") or die(mysqli_error($conn));
        //     if($result=true)
        //     {
        //         $response["status"]="yes";
        //         $response["message"]="Successfully Upload Licence Front Image";
        //     }
        //     else
        //     {
        //         $response["status"]="no";
        //         $response["message"]="Something is Wrong";
        //     }
        // }
        // elseif($action=='licenseback')
        // {
        //     $deliveryboy_id=$_POST["deliveryboy_id"];
        //     $license_back_img=$_POST["license_back_img"];
            
        //     $data = base64_decode($license_back_img);
        //     $image=rand(111111111,999999999).".png";
        //     file_put_contents("../images/deliveryboy/".$image,$data);
            
        //     $result=mysqli_query($conn,"update tbl_deliveryboy set deliveryboy_back_licence='$image' where deliveryboy_id='$deliveryboy_id'") or die(mysqli_error($conn));
        //     if($result=true)
        //     {
        //         $response["status"]="yes";
        //         $response["message"]="Successfully Upload Licence Back Image";
        //     }
        //     else
        //     {
        //         $response["status"]="no";
        //         $response["message"]="Something is Wrong";
        //     }
        // }
        elseif($action=='deliveryboycomplateregister')
        {
            $deliveryboy_id=$_POST["deliveryboy_id"];
            
            $result=mysqli_query($conn,"update tbl_deliveryboy set deliveryboy_registration_complete='1' where deliveryboy_id='$deliveryboy_id'") or die(mysqli_error($conn));
            if($result=true)
            {
                $response["status"]="yes";
                $response["message"]="Successfully Account Created";
            }
            else
            {
                $response["status"]="no";
                $response["message"]="Something is Wrong";
            }
        }
        
        elseif($action=='deliveryboylogin')
        {
            $deliveryboy_mobile=$_POST["deliveryboy_mobile"];
            $deliveryboy_password=$_POST["deliveryboy_password"];
            
                
                $result=mysqli_query($conn,"select * from tbl_deliveryboy where deliveryboy_mobile='$deliveryboy_mobile' and deliveryboy_password='$deliveryboy_password'") or die(mysqli_error($conn));
                if(mysqli_num_rows($result)<=0)
                {
                    // echo $deliveryboy_mobile;
                    $response["status"]="no";
                    $response["message"]="No account registered under provided mobile number, please create a new account";
                }
                else
                {
                    while($row=mysqli_fetch_assoc($result))
                    {
                        $deliveryboy_registration_complete = $row['deliveryboy_registration_complete'];
                        $deliveryboy_status = $row['deliveryboy_status'];
                        $deliveryboy_name = $row['deliveryboy_name'];
                        $deliveryboy_id = $row['deliveryboy_id'];
                        if($deliveryboy_registration_complete=='0')
                        {
                           $response["status"]="no";
                            $response["message"]="Please complete your registration first.."; 
                        }
                        elseif($deliveryboy_status=='0')
                        {
                            $response["status"]="no";
                            $response["message"]="Admin Not Approve you yet..."; 
                        }
                        else{
                        
                            $response["status"]="yes";
                            $response["message"]="Hellow...$deliveryboy_name."; 
                            $response["data"]=$row;
                            
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