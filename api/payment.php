<?php 
    date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)
    include '../connection.php';
    $action=$_POST["action"];
    
    $response=array();

    
        if($action=='paymentdone')
        {
            $user_id=$_POST["user_id"];
            $razorpay_payment_id=$_POST["razorpay_payment_id"];
            $payment_amt=$_POST["payment_amt"];
            $payment_type=$_POST["payment_type"];
            $payment_status=$_POST["payment_status"];
            
            $result=mysqli_query($conn,"select * from tbl_user where user_id='$user_id'") or die(mysqli_error($conn));
            while($row=mysqli_fetch_assoc($result))
            {
                $user_old_balance = $row['user_balance'];
               
            }
            
             $user_new_balance = $user_old_balance + $payment_amt;
                     
            
            $date = date("Y-m-d");
            $result=mysqli_query($conn,"insert into tbl_payment(user_id,razorpay_payment_id,payment_amt,payment_type,payment_status) values('$user_id','$razorpay_payment_id','$payment_amt','$payment_type','$payment_status')") or die(mysqli_error($conn));
            $last_id = $conn->insert_id;
            
            $result1=mysqli_query($conn,"insert into tbl_user_balance_log(pay_id,payment_id,user_id,ubl_amount,ubl_user_balance,ubl_type,tbl_tilte,ubl_date,ubl_status) values('$razorpay_payment_id','$last_id','$user_id','$payment_amt','$user_new_balance','Credit','User Make Payment of Rs. $payment_amt','$date','1')") or die(mysqli_error($conn));
                if($result=true && $result1=true)
                {
                    
                    // $num = (double) $user_new_balance;
                    // $num = floatval('$user_new_balance');
                
                    $result=mysqli_query($conn,"update tbl_user set user_balance='$user_new_balance' where user_id='$user_id'") or die(mysqli_error($conn));
                    if($result=true)
                    {
                        $response["status"]="yes";
                        // $response["message"]="Payment of Rs.$payment_amt is successfully received";
                        $response["message"]="Payment received successfully";
                        
                        
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
        elseif($action=='paymentlist')
        {
            $user_id=$_POST["user_id"];
            $result=mysqli_query($conn,"select * from tbl_payment where user_id='$user_id'") or die(mysqli_error($conn));
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
        elseif($action=='show_user_balance_log')
        {
            $user_id=$_POST["user_id"];
            $result=mysqli_query($conn,"select * from tbl_user_balance_log where user_id='$user_id' and ubl_type='Credit'") or die(mysqli_error($conn));
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
        elseif($action=='show_user_order_log')
        {
            $user_id=$_POST["user_id"];
            $result=mysqli_query($conn,"select a.attribute_name,oc.*,p.* from tbl_order_calendar as oc left join tbl_product as p on oc.product_id=p.product_id left join tbl_attribute as a on a.attribute_id=p.attribute_id where user_id='$user_id' and oc_is_delivered='1'") or die(mysqli_error($conn));
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
        elseif($action=='add_user_balance')
        {
            $user_id=$_POST["user_id"];
            $deliveryboy_id=$_POST["deliveryboy_id"];
            $user_balance=$_POST["user_balance"];
            $selfie=$_POST["selfie"];
            
            $data = base64_decode($selfie);
            // $addrss = "DelSel";
            $image=rand(1111111,9999999).".png";
            file_put_contents("../images/deliveryboy/".$image,$data);
            
            $result=mysqli_query($conn,"select * from tbl_user where user_id='$user_id'") or die(mysqli_error($conn));
            while($row=mysqli_fetch_assoc($result))
            {
                $user_old_balance = $row['user_balance'];
               
            }
            
             $user_new_balance = $user_old_balance + $user_balance;
                     
            
            $date = date("Y-m-d");
            
            $result=mysqli_query($conn,"insert into tbl_payment(user_id,deliveryboy_id,deliveryboy_img,payment_amt,payment_type,payment_status) values('$user_id','$deliveryboy_id','$image','$user_balance','Offline','1')") or die(mysqli_error($conn));
            
            $result1=mysqli_query($conn,"insert into tbl_user_balance_log(user_id,ubl_amount,ubl_user_balance,ubl_type,tbl_tilte,ubl_date,ubl_status) values('$user_id','$user_balance','$user_new_balance','Credit','Delivery Boy Make Payment of Rs. $user_balance','$date','1')") or die(mysqli_error($conn));
                if($result=true && $result1=true)
                {
                
                    $resultWW=mysqli_query($conn,"update tbl_user set user_balance='$user_new_balance' where user_id='$user_id'") or die(mysqli_error($conn));
                    if($resultWW=true)
                    {
                        $response["status"]="yes";
                        $response["message"]="Payment received successfully";
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
            $response["message"]="Something is Wrong";
        }
    echo json_encode($response);
?>