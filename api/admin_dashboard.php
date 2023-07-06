<?php 
    include '../connection.php';
    $response=array();
    $action=$_POST["action"];

    //CATEGORY CODE
    $response["order_date"]= $newdate;
    $response["cutoff"]= $cutoff;
    $response["order_day"]= $day;
    if($action=='admin_dashboard')
    {
        $result=mysqli_query($conn,"select * from tbl_user where user_status='1'")or die(mysqli_error($conn));
        $alluser="all_user";
        $response[$alluser]=mysqli_num_rows($result);
        
        $result1=mysqli_query($conn,"select * from tbl_area where area_status='1'")or die(mysqli_error($conn));
        $allarea="all_area";
        $response[$allarea]=mysqli_num_rows($result1);
            
        $result2=mysqli_query($conn,"select * from tbl_category where category_status='1'")or die(mysqli_error($conn));
        $all_category="all_category";
        $response[$all_category]=mysqli_num_rows($result2);
        
        $result3=mysqli_query($conn,"select * from tbl_deliveryboy where deliveryboy_status='1'")or die(mysqli_error($conn));
        $all_deliveryboy="all_deliveryboy";
        $response[$all_deliveryboy]=mysqli_num_rows($result3);
        
        $result4=mysqli_query($conn,"select * from tbl_time_slot where time_slot_status='1'")or die(mysqli_error($conn));
        $all_time_slot="all_time_slot";
        $response[$all_time_slot]=mysqli_num_rows($result4);
    }
    elseif($action=='admin_area')
    {
        $result=mysqli_query($conn,"select * from tbl_area")or die(mysqli_error($conn));
        $all_area="all_area";
        $response[$all_area]=mysqli_num_rows($result);
        
        $result1=mysqli_query($conn,"select * from tbl_area where area_status='1'")or die(mysqli_error($conn));
        $active_area="active_area";
        $response[$active_area]=mysqli_num_rows($result1);
            
        $result2=mysqli_query($conn,"select * from tbl_area where area_status='0'")or die(mysqli_error($conn));
        $inactive_area="inactive_area";
        $response[$inactive_area]=mysqli_num_rows($result2);
    }
    elseif($action=='admin_time_slot')
    {
        $result=mysqli_query($conn,"select * from tbl_time_slot")or die(mysqli_error($conn));
        $all_time_slot="all_time_slot";
        $response[$all_time_slot]=mysqli_num_rows($result);
        
        $result1=mysqli_query($conn,"select * from tbl_time_slot where time_slot_status='1'")or die(mysqli_error($conn));
        $active_time_slot="active_time_slot";
        $response[$active_time_slot]=mysqli_num_rows($result1);
            
        $result2=mysqli_query($conn,"select * from tbl_time_slot where time_slot_status='0'")or die(mysqli_error($conn));
        $inactive_time_slot="inactive_time_slot";
        $response[$inactive_time_slot]=mysqli_num_rows($result2);
    }
    elseif($action=='admin_deliveryboy')
    {
        $result=mysqli_query($conn,"select * from tbl_deliveryboy")or die(mysqli_error($conn));
        $all_deliveryboy="all_deliveryboy";
        $response[$all_deliveryboy]=mysqli_num_rows($result);
        
        $result1=mysqli_query($conn,"select * from tbl_deliveryboy where deliveryboy_status='1'")or die(mysqli_error($conn));
        $approve_deliveryboy="approve_deliveryboy";
        $response[$approve_deliveryboy]=mysqli_num_rows($result1);
            
        $result2=mysqli_query($conn,"select * from tbl_deliveryboy where deliveryboy_status='0'")or die(mysqli_error($conn));
        $disapprove_deliveryboy="disapprove_deliveryboy";
        $response[$disapprove_deliveryboy]=mysqli_num_rows($result2);
        
         $result3=mysqli_query($conn,"select * from tbl_deliveryboy where deliveryboy_status='1' and is_deliveryboy_assign='0'")or die(mysqli_error($conn));
        $new_deliveryboy="new_deliveryboy";
        $response[$new_deliveryboy]=mysqli_num_rows($result3);
    }
    elseif($action=='admin_user')
    {
        $result=mysqli_query($conn,"select * from tbl_user")or die(mysqli_error($conn));
        $all_user="all_user";
        $response[$all_user]=mysqli_num_rows($result);
        
        $result1=mysqli_query($conn,"select * from tbl_user where user_status='1'")or die(mysqli_error($conn));
        $active_user="active_user";
        $response[$active_user]=mysqli_num_rows($result1);
            
        $result2=mysqli_query($conn,"select * from tbl_user where user_status='0'")or die(mysqli_error($conn));
        $active_user="active_user";
        $response[$active_user]=mysqli_num_rows($result2);
    }
    
    
    
    else
    {
        $response["message"]="Something is Wrong";
    }
        
        echo json_encode($response);
?>