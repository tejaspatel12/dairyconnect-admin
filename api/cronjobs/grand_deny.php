<?php 
    date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)
    include '../../connection.php';
    
    $DATE = date("Y-m-d");
    $DATE = date('Y-m-d', strtotime($DATE. ' -  1 days')); 
    // $DATE = "2022-02-14";
    echo $DATE."<BR>";
    $i = 1;
    
    $curdate = date("Y-m-d H:i:s");
    $curdate = date('Y-m-d H:i:s', strtotime($curdate. ' -  1 days')); 
    // $curdate = "2022-02-14 16:00:00";    
    // $curdate = "2022-02-10 16:00:00";

    echo $curdate."<BR><BR>";
    
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
    
    
    $i = 0;
    if(($first < $curdate) && ($curdate < $sec))
    {
        echo "Morning"."<BR>";
        $cutoff = date('Y-m-d H:i:s', strtotime("$DATE $cf"));
        $cutoff = date('Y-m-d H:i:s', strtotime($cutoff. ' -  1 days')); 

        echo "DATE : ".$DATE."<br>";
        echo "Cuf-off : ".$cutoff."<br><br>";

        $result=mysqli_query($conn,"select * from tbl_order_calendar where order_date='$DATE' and oc_cutoff_time='$cutoff' and oc_notdelivered_issue='1'");
        // $countnumber = mysqli_num_rows($result);
        // echo "New :".$countnumber."<br>";
        $i = 0;
            if(mysqli_num_rows($result)<=0)
            {
                echo "No Entry Found";
            }
            else
            {
            

    
                while($row=mysqli_fetch_assoc($result))
                {
                    echo $i++;
                    $oc_id = $row['oc_id'];
                    $user_id = $row['user_id'];

                    $result=mysqli_query($conn,"update tbl_not_delivered set nd_complate='1' where user_id='$user_id' and oc_id='$oc_id'") or die(mysqli_error($conn));

                }
    
            }


        
    
    }
    elseif(($thr < $curdate) && ($curdate < $fur))
    {
        echo "Evening"."<BR>";
        echo "Under : $thr and $fur<br><br>";
        $cutoff = date('Y-m-d H:i:s', strtotime("$DATE $cs"));
        // $cutoff = date('Y-m-d H:i:s', strtotime($cutoff. ' -  1 days')); 

        echo "DATE : ".$DATE."<br>";
        echo "Cuf-off : ".$cutoff."<br><br>";
        
        $result=mysqli_query($conn,"select * from tbl_order_calendar where order_date='$DATE' and oc_cutoff_time='$cutoff' and oc_notdelivered_issue='1'");
        if(mysqli_num_rows($result)<=0)
        {
            echo "No Entry Found";
        }
        else
        {
            while($row=mysqli_fetch_assoc($result))
            {
                // echo $i++.'<br>';
                $oc_id = $row['oc_id'];
                $user_id = $row['user_id'];
                
    
                mysqli_query($conn,"update tbl_not_delivered set nd_complate='1' where user_id='".$user_id."' and oc_id='".$oc_id."'");
                
                
    
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

        $result=mysqli_query($conn,"select * from tbl_order_calendar as oc left join tbl_not_delivered as nd on nd.oc_id=oc.oc_id where oc.order_date='$DATE' and oc.oc_cutoff_time='$cutoff' and oc.oc_notdelivered_issue='1' and nd.nd_complate='0'");
        if(mysqli_num_rows($result)<=0)
        {
            echo "No Entry Found";
        }
        else
        {
        


            while($row=mysqli_fetch_assoc($result))
            {
                $oc_id = $row['oc_id'];
                $user_id = $row['user_id'];
                
                echo $user_id."<BR>";
                
                //AA cron job che but while loop ma data ni loop nay kartii....
                

                // $result=mysqli_query($conn,"update tbl_not_delivered set nd_complate='1' where user_id='$user_id' and oc_id='$oc_id'") or die(mysqli_error($conn));

            }

        }
        
    
    }
    else
    {

    }
    
    
    
    // function test($user_id,$oc_id)
    // {
    //     echo $user_id."<br>";
    //     $result=mysqli_query($conn,"update tbl_not_delivered set nd_complate='1' where user_id='$user_id' and oc_id='$oc_id'") or die(mysqli_error($conn));
    // }

    
    
?>