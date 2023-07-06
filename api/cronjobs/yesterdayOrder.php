<?php 
    date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)
    include '../../connection.php';
    
    $DATE = date("Y-m-d");
    $DATE = date('Y-m-d', strtotime($DATE. ' -  1 days')); 
    // $DATE = "2022-02-01";
    echo $DATE."<BR>";
    $i = 1;
    
    $curdate = date("Y-m-d H:i:s");
    $curdate = date('Y-m-d H:i:s', strtotime($curdate. ' -  1 days')); 
    // $curdate = "2022-02-01 15:00:00";    
    // $curdate = "2022-01-31 22:00:00";

    echo $curdate."<BR>";
    
    $cf = "22:00:00";
    $cs = "14:00:00";

    $mor = "00:00:00";
    $morend = "13:59:59";
    
    $evn = "14:00:00";
    $evnend = "21:59:59";
    
    $next = "22:00:00";
    $nextend = "23:59:59";
    
    $nextday = date('Y-m-d', strtotime($DATE. ' +  1 days')); 
    
    $first = date('Y-m-d H:i:s', strtotime("$DATE $mor"));
    $sec = date('Y-m-d H:i:s', strtotime("$DATE $morend"));
    
    
    $thr = date('Y-m-d H:i:s', strtotime("$DATE $evn"));
    $fur = date('Y-m-d H:i:s', strtotime("$DATE $evnend"));
    
    $fiv = date('Y-m-d H:i:s', strtotime("$DATE $next"));
    $six = date('Y-m-d H:i:s', strtotime("$DATE $nextend"));


    // $first = date('Y-m-d H:i:s', strtotime("$DATE $cs"));


    // $sec = date('Y-m-d H:i:s', strtotime("$DATE $cf"));
    // $sec = date('Y-m-d H:i:s', strtotime($sec. ' -  1 days')); 
    
    echo "first : ".$first."<br>";
    echo "sec : ".$sec."<br>";
    
    $i = 0;
    if(($first < $curdate) && ($curdate < $sec))
    {
        echo "Morning"."<BR>";
        $cutoff = date('Y-m-d H:i:s', strtotime("$DATE $cf"));
        $cutoff = date('Y-m-d H:i:s', strtotime($cutoff. ' -  1 days')); 

        echo "DATE : ".$DATE."<br>";
        echo "Cuf-off : ".$cutoff."<br><br>";

        $result=mysqli_query($conn,"select * from tbl_order_calendar where order_date='$DATE' and oc_cutoff_time='$cutoff' and oc_is_delivered='0'") or die(mysqli_error($conn));
        $countnumber = mysqli_num_rows($result);
        echo "New :".$countnumber."<br>";


            if(mysqli_num_rows($result)<=0)
            {
                echo "No Entry Found";
            }
            else
            {
            

    
                while($row=mysqli_fetch_assoc($result))
                {

                // for ($x = 0; $x <= $countnumber; $x++) {

                //     echo "X ".$x."  Count : ".$countnumber."<br>";

                    $i++;
                    echo "Count : ".$i."<br><br>";
                    
                    $user_id = $row["user_id"];
                    $product_id = $row["product_id"];
                    $order_qty = $row["order_qty"];
                    $oc_id = $row["oc_id"];
                    echo $user_id."<br>";
                    
                    $sql = mysqli_query($conn,"select * from tbl_user where user_id='$user_id'");
                    while($roww=mysqli_fetch_assoc($sql))
                    {
                        $user_type = $roww["user_type"];
                        $user_balance = $roww["user_balance"];
                        $accept_nagative_balance = $roww["accept_nagative_balance"];
                    }
                    
                    $total=0;
                    $sql = mysqli_query($conn,"select * from tbl_product where product_id='$product_id'");
                    while($row=mysqli_fetch_assoc($sql))
                    {
                        echo $row["product_name"]." ";
                        if($user_type=='1')
                        {
                            echo "PRICE ".$amt = $row["product_regular_price"];
                        }
                        else
                        {
                            echo "PRICE ".$amt = $row["product_normal_price"];
                        }
                        
                        echo " Total : ".$totalqty = $order_qty * $amt."<BR>";
                        
                    }
                    $NEWBALANCE = $user_balance - $totalqty;
                    echo "User :".$user_id." Total : ".$total."<br><br>";
                    
                     mysqli_query($conn,"insert into tbl_user_balance_log(user_id,ubl_amount,ubl_user_balance,ubl_type,tbl_tilte,ubl_date,ubl_status) values('".$user_id."','$final_total','$NEWBALANCE','Debit','Delivery Boy Delivery Product Worth Of $final_total','$date','1')") or die(mysqli_error($conn));
                
                    mysqli_query($conn,"update tbl_order_calendar set order_one_unit_price='$amt',order_total_amt='$totalqty',oc_is_delivered='1' where oc_id='$oc_id' and user_id='$user_id' and order_date='$DATE'") or die(mysqli_error($conn));
                    mysqli_query($conn,"update tbl_user set user_balance='$NEWBALANCE' where user_id='$user_id'") or die(mysqli_error($conn));

                // }

                }
    
            }


        
    
    }
    elseif(($thr < $curdate) && ($curdate < $fur))
    {
        echo "Evening"."<BR>";
        $cutoff = date('Y-m-d H:i:s', strtotime("$DATE $cs"));
        // $cutoff = date('Y-m-d H:i:s', strtotime($cutoff. ' -  1 days')); 

        echo "DATE : ".$DATE."<br>";
        echo "Cuf-off : ".$cutoff."<br><br>";
        
        $result=mysqli_query($conn,"select * from tbl_order_calendar where order_date='$DATE' and oc_cutoff_time='$cutoff' and oc_is_delivered='0'") or die(mysqli_error($conn));
        if(mysqli_num_rows($result)<=0)
        {
            echo "No Entry Found";
        }
        else
        {
            
         
            while($row=mysqli_fetch_assoc($result))
            {
                
                $i++;
                echo "Count : ".$i."<br><br>";
               
                $user_id = $row["user_id"];
                $product_id = $row["product_id"];
                $order_qty = $row["order_qty"];
                $oc_id = $row["oc_id"];
                echo $user_id."<br>";
                
                $sql = mysqli_query($conn,"select * from tbl_user where user_id='$user_id'");
                while($roww=mysqli_fetch_assoc($sql))
                {
                    $user_type = $roww["user_type"];
                    $user_balance = $roww["user_balance"];
                    $accept_nagative_balance = $roww["accept_nagative_balance"];
                }
                
                $total=0;
                $sql = mysqli_query($conn,"select * from tbl_product where product_id='$product_id'");
                while($row=mysqli_fetch_assoc($sql))
                {
                    echo $row["product_name"]." ";
                    if($user_type=='1')
                    {
                        echo "PRICE ".$amt = $row["product_regular_price"];
                    }
                    else
                    {
                        echo "PRICE ".$amt = $row["product_normal_price"];
                    }
                    
                    echo " Total : ".$totalqty = $order_qty * $amt."<BR>";
                    
                }
                $NEWBALANCE = $user_balance - $totalqty;
                echo "User :".$user_id." Total : ".$total."<br><br>";
                
                mysqli_query($conn,"insert into tbl_user_balance_log(user_id,ubl_amount,ubl_user_balance,ubl_type,tbl_tilte,ubl_date,ubl_status) values('".$user_id."','$final_total','$NEWBALANCE','Debit','Delivery Boy Delivery Product Worth Of $final_total','$date','1')") or die(mysqli_error($conn));
                
                
                $result=mysqli_query($conn,"update tbl_order_calendar set order_one_unit_price='$amt',order_total_amt='$totalqty',oc_is_delivered='1' where oc_id='$oc_id' and user_id='$user_id' and order_date='$DATE'") or die(mysqli_error($conn));
                $result=mysqli_query($conn,"update tbl_user set user_balance='$NEWBALANCE' where user_id='$user_id'") or die(mysqli_error($conn));
                
                
                
            }
        }
        
    
    }
    elseif(($fiv < $curdate) && ($curdate < $six))
    {
        echo "Next Day Morning"."<BR>";
        $cutoff = date('Y-m-d H:i:s', strtotime("$DATE $cf"));
        // $cutoff = date('Y-m-d H:i:s', strtotime($cutoff. ' -  1 days')); 
        
        echo "DATE : ".$DATE."<br>";
        echo "Cuf-off : ".$cutoff."<br><br>";

        $result=mysqli_query($conn,"select * from tbl_order_calendar where order_date='$DATE' and oc_cutoff_time='$cutoff' and oc_is_delivered='0'") or die(mysqli_error($conn));
        if(mysqli_num_rows($result)<=0)
        {
            echo "No Entry Found";
        }
        else
        {
            
         
            while($row=mysqli_fetch_assoc($result))
            {
                $i++;
                echo "Count : ".$i."<br><br>";
                
                $user_id = $row["user_id"];
                $product_id = $row["product_id"];
                $order_qty = $row["order_qty"];
                $oc_id = $row["oc_id"];
                echo $user_id."<br>";
                
                $sql = mysqli_query($conn,"select * from tbl_user where user_id='$user_id'");
                while($roww=mysqli_fetch_assoc($sql))
                {
                    $user_type = $roww["user_type"];
                    $user_balance = $roww["user_balance"];
                    $accept_nagative_balance = $roww["accept_nagative_balance"];
                }
                
                $total=0;
                $sql = mysqli_query($conn,"select * from tbl_product where product_id='$product_id'");
                while($row=mysqli_fetch_assoc($sql))
                {
                    echo $row["product_name"]." ";
                    if($user_type=='1')
                    {
                        echo "PRICE ".$amt = $row["product_regular_price"];
                    }
                    else
                    {
                        echo "PRICE ".$amt = $row["product_normal_price"];
                    }
                    
                    echo " Total : ".$totalqty = $order_qty * $amt."<BR>";
                    
                }
                $NEWBALANCE = $user_balance - $totalqty;
                echo "User :".$user_id." Total : ".$total."<br><br>";
                
                mysqli_query($conn,"insert into tbl_user_balance_log(user_id,ubl_amount,ubl_user_balance,ubl_type,tbl_tilte,ubl_date,ubl_status) values('".$user_id."','$final_total','$NEWBALANCE','Debit','Delivery Boy Delivery Product Worth Of $final_total','$date','1')") or die(mysqli_error($conn));
                
                mysqli_query($conn,"update tbl_order_calendar set order_one_unit_price='$amt',order_total_amt='$totalqty',oc_is_delivered='1' where oc_id='$oc_id' and user_id='$user_id' and order_date='$DATE'") or die(mysqli_error($conn));
                mysqli_query($conn,"update tbl_user set user_balance='$NEWBALANCE' where user_id='$user_id'") or die(mysqli_error($conn));
                
                
            }
        }
        
    
    }
    else
    {

    }
    
    

    
    
?>