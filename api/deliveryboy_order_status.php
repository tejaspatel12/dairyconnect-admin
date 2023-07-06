<?php 
    include '../connection.php';
    $action=$_POST["action"];
    
    $response=array();

    
        if($action=='not_delivered_qty')
        {
            $user_id=$_POST["user_id"];
            $oc_id=$_POST["oc_id"];
            $order_one_unit_price=$_POST["order_one_unit_price"];
            $order_qty=$_POST["order_qty"];
            $not_delivered_qty=$_POST["not_delivered_qty"];
            
            
            $final_qty = $order_qty - $not_delivered_qty;
            $final_total = $order_one_unit_price * $order_qty;
            
            $result=mysqli_query($conn,"select * from tbl_user where user_id='$user_id'");
           while($row=mysqli_fetch_array($result))
           {
               $user_balance = $row['user_balance'];
               $user_token = $row['user_token'];
           }  
           
            $resultq=mysqli_query($conn,"select product_name from tbl_product where oc_id='$oc_id'");
           while($rowq=mysqli_fetch_array($resultq))
           {
               $product_name = $rowq['product_name'];
           }  
           
           $new_balance = $user_balance - $final_total;

            $result1=mysqli_query($conn,"insert into tbl_user_balance_log(user_id,ubl_amount,ubl_user_balance,ubl_type,tbl_tilte,ubl_date,ubl_status) values('".$user_id."','$final_total','$new_balance','Debit','Delivery Boy Delivery Product Worth Of $final_total','$date','1')") or die(mysqli_error($conn));
            $result1=mysqli_query($conn,"insert into tbl_not_delivered(oc_id,user_id,nd_order_qty) values('$oc_id','$user_id','$order_qty')") or die(mysqli_error($conn));
            
            $result1=mysqli_query($conn,"update tbl_user set user_balance='$new_balance' where user_id='$user_id'") or die(mysqli_error($conn));
            
            $result=mysqli_query($conn,"update tbl_order_calendar set order_one_unit_price='$order_one_unit_price',delivered_qty='$final_qty',order_qty='$order_qty',order_total_amt='$final_total',not_delivered_qty='$not_delivered_qty', oc_notdelivered_issue='1',oc_is_delivered='1' where user_id='$user_id' and oc_id='$oc_id'") or die(mysqli_error($conn));
            if($result=true && $result1=true)
            {
                $response["status"]="yes";
                $response["message"]="Message";

            }
            else
            {
                $response["status"]="no";
                $response["message"]="Something is Wrong";
            }
        }
        else if($action=='delivered_qty')
        {
            $user_id=$_POST["user_id"];
            $oc_id=$_POST["oc_id"];
            $order_one_unit_price=$_POST["order_one_unit_price"];
            $order_qty=$_POST["order_qty"];
            
            $final_total = $order_one_unit_price * $order_qty;
            
            $date = date("Y-m-d");
            $result=mysqli_query($conn,"select * from tbl_user where user_id='$user_id'");
           while($row=mysqli_fetch_array($result))
           {
               $user_balance = $row['user_balance'];
               $user_token = $row['user_token'];
           }  
           
           $resultq=mysqli_query($conn,"select product_name from tbl_product where oc_id='$oc_id'");
           while($rowq=mysqli_fetch_array($resultq))
           {
               $product_name = $rowq['product_name'];
           }  
           
           $new_balance = $user_balance - $final_total;

            $result1=mysqli_query($conn,"insert into tbl_user_balance_log(user_id,ubl_amount,ubl_user_balance,ubl_type,tbl_tilte,ubl_date,ubl_status) values('".$user_id."','$final_total','$new_balance','Debit','Delivery Boy Delivery Product Worth Of $final_total','$date','1')") or die(mysqli_error($conn));
            
            $result1=mysqli_query($conn,"update tbl_user set user_balance='$new_balance' where user_id='$user_id'") or die(mysqli_error($conn));
            
            $result=mysqli_query($conn,"update tbl_order_calendar set order_one_unit_price='$order_one_unit_price',order_qty='$order_qty',order_total_amt='$final_total',oc_is_delivered='1' where user_id='$user_id' and oc_id='$oc_id'") or die(mysqli_error($conn));
            if($result=true && $result1=true)
            {
                $response["status"]="yes";
                $response["message"]="Message";
                
                define('API_ACCESS_KEY','AAAAs3-gmWY:APA91bEW0MnJrNFvN-4BtU55JxFf0fim1nheJL3_7eb1_iBmlwiS6YIvLvuJdPx0sFOJ2Ihk_r5jqu6hr44pUPue8Qn8HKwPLKqOlzX1NEqIy0dMrPbkK0vOUBfbVmHx_EYvhNDfptR8');

                    $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
                    
                    
                    $notification = [
                    //write title, description and so on
                        'title' => 'Order Delivered ',
                        'body' => 'Your '.$product_name.' is Delivered',
                        'icon' => $logo,
                        'sound' => 'mySound',
                    ];
                    
                    $extraNotificationData = ["message" => $notification,"moredata" =>'dd'];
                    
                    $fcmNotification = [
                    //'registration_ids' => $tokenList, //multple token array
                    // 'to'        =>'write token here', //single token
                    'to'        => $user_token, //single token
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
                      
                    $title = "Order Delivered";
                    $des = "Your $product_name is Delivered";
                    
                    $result=mysqli_query($conn,"insert into tbl_notification (user_id,notification_title,notification_des,notification_date)
                    values ('$user_id','$title','$des','$DATE')") or die(mysqli_error($conn));
                    
            }
            else
            {
                $response["status"]="no";
                $response["message"]="Something is Wrong";
            }
        }
        else if($action=='user_order_calendar_status')
        {
            $user_id=$_POST["user_id"];
            $date=$_POST["date"];

            $result=mysqli_query($conn,"update tbl_user_order_calendar set uoc_status='1' where user_id='$user_id' and uoc_date='$date'") or die(mysqli_error($conn));
            if($result=true)
            {
                $response["status"]="yes";
                $response["message"]="Message";
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