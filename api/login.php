<?php 
    date_default_timezone_set("Asia/Calcutta");
    include '../connection.php';
    $action=$_POST["action"];
    
    $response=array();

    if($action=='adminlogin')
        {
            $mobile_number=$_POST["mobile_number"];
            $password=$_POST["password"];

            $result=mysqli_query($conn,"select * from tbl_admin where username='$mobile_number' and password='$password'") or die(mysqli_error($conn));
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

                $result=mysqli_query($conn,"insert into tbl_user(user_mobile_number) values('$user_mobile_number')") or die(mysqli_error($conn));
                if($result=true)
                {
                    $user_id = $conn->insert_id;
                    
                    $response["status"]="yes";
                    $response["message"]="Successfully.. Mobile Number Inserted";
                    $response["user_id"]=$user_id;
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
                    if($registration_complete=='0')
                    {
                        $response["status"]="yes";
                        $response["message"]="Hellow, We Find You..";
                        $response["user_id"]=$user_id;	
                    }
                    else
                    {
                        $response["status"]="no";
                        $response["message"]="Mobile Number Already Registered.";
                    }	
                }

            }
        }
        elseif($action=='userregistersec')
        {
            $user_id=$_POST["user_id"];
            $user_first_name=$_POST["user_first_name"];
            $user_last_name=$_POST["user_last_name"];
            $user_email=$_POST["user_email"];
            $user_pass=$_POST["user_pass"];
            $user_address=$_POST["user_address"];
            $area_id=$_POST["area_id"];
            
            $result=mysqli_query($conn,"update tbl_user set user_first_name='$user_first_name',user_last_name='$user_last_name',user_email='$user_email',area_id='$area_id',user_address='$user_address',user_password='$user_pass',registration_complete='1' where user_id='$user_id'") or die(mysqli_error($conn));
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

        elseif($action=='userlogin')
        {
            $user_mobile_number=$_POST["user_mobile_number"];
            $user_password=$_POST["user_password"];
            $user_token=$_POST["user_token"];
            
            
            $result=mysqli_query($conn,"select * from tbl_user where user_mobile_number='$user_mobile_number' and user_password='$user_password'") or die(mysqli_error($conn));
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
                            if($registration_complete=='0')
                            {
                              $response["status"]="no";
                                $response["message"]="Please complete your registration first.."; 
                            }else{
                                
                                $response["status"]="yes";
                                $result=mysqli_query($conn,"update tbl_user set user_token='$user_token' where user_id='$user_id'") or die(mysqli_error($conn));
                                
                                $response["data"]=$row;
                                
                            }
                        
                       
                        
                        	
                    }
                
                }
                
        }
        elseif($action=='forgot_password')
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
                        
                            $user_id = $row['user_id'];
                            if($registration_complete=='0')
                            {
                              $response["status"]="no";
                              $response["message"]="Please complete your registration first.."; 
                            }else{
                                $user_token = $row['user_token'];
                                $user_first_name = $row['user_first_name'];
                                $user_last_name = $row['user_last_name'];
                                
                                $rand_pincode = rand(1111,9999);
                                
                                $response["status"]="yes";
                                $response["user_id"] = $row['user_id'];
                                $response["rand_pincode"] = $rand_pincode;
                                
                                define('API_ACCESS_KEY','AAAAQUidtpY:APA91bGUSAQVGqI9R0NjANZYUC96I_nv_pIc57k1_llth8PjTffyhkGLgSd0BqV162julWklFqX5MzWPeFV63x9s4F9TQpgW3NWUKy_OtzVZd4cBcrNASwCdEQKieNxVyLmsILe4YaJ6');
                        
                                $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
                                
                                
                                $notification = [
                                //write title, description and so on
                                    'title' => 'Hiii, '.$user_first_name.' '.$user_last_name.' You Trying to forgot your password',
                                    'body' => 'Your otp code is '.$rand_pincode.'',
                                    'icon' => $logo,
                                    'sound' => 'mySound',
                                ];
                                
                                $extraNotificationData = ["message" => $notification,"moredata" =>'dd'];
                                
                                $fcmNotification = [
                                //'registration_ids' => $tokenList, //multple token array
                                // 'to'        =>'write token here', //single token
                                'to'        => $user_token, //single token
                                // 'to'        => 'fwkjWwcTS0qUS9AY4p-CPo:APA91bEB1gEQZwcCi0vhXLSdpoB8dgux-fXOAVG6iEgBL0cfjsxu83NFJR88grGABh99b-j2E8wOYmBtydCZG0ziu_Q53ZSFtJl3g_Oy_Mu6n5fVsg3W4FFmDJaRT8ImHFS3WV8imrW7', //single token
                                'notification' => $notification,
                                'data' => $extraNotificationData
                                ];
                                
                                $headers = [
                                'Authorization: key=' . API_ACCESS_KEY,
                                'Content-Type: application/json'
                                ];
                                
                                
                                $ch = curl_init();
                                curl_setopt($ch, CURLOPT_URL,$fcmUrl);
                                curl_setopt($ch, CURLOPT_POST, true);
                                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
                                $result = curl_exec($ch);
                                curl_close($ch);
                                
                                $response["message"]="Hiii, $user_first_name $user_last_name, We Find Your Number..."; 
                                // $result=mysqli_query($conn,"update tbl_user set user_token='$user_token' where user_id='$user_id'") or die(mysqli_error($conn));
                                
                            }
                        
                       
                        
                        	
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