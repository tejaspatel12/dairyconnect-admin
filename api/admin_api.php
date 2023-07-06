<?php 
    include '../connection.php';
    $action=$_POST["action"];
    
    $response=array();
    
    
    //DASHBOARD
    if($action=='admin_today_order')
    {
        $result=mysqli_query($conn,"SELECT p.product_image,p.product_id,p.product_name, SUM( o.order_qty ) as quantity FROM  `tbl_order_calendar` o JOIN tbl_product p ON p.product_id = o.product_id where o.order_date='$newdate' and o.oc_cutoff_time='$cutoff' and o.oc_is_delivered!='3' and o.oc_is_delivered!='4' GROUP BY p.product_id");
        if(mysqli_num_rows($result)<=0)
        {
            
            $response["status"]="no";
            $response["error"]="No Data Available!";
        }
        else
        {
            while($row=mysqli_fetch_assoc($result))
            {
                // $response[]=$row;
                $response[]=array(
                    "product_image" => $row['product_image'],
                    "product_image_path" => "http://nooranidairyfarm.activeapp.in/images/product/".$row['product_image'],
                    "product_id" => $row["product_id"],
                    "product_name" => $row["product_name"],
                    "quantity" => $row["quantity"],
                    "date" => $newdate,
                    "time" => $time,
                );
            }
        }
        
    }
    elseif($action=='admin_today_order_detail')
    {
        $product_id=$_POST["product_id"];
        $selected_date=$_POST["selected_date"];
        $selected_time=$_POST["selected_time"];
        
        if($selected_time == '1')
    	 {
    	    $cutoff = date('Y-m-d H:i:s', strtotime("$selected_date $cf"));
    	 //   $cutoff = date('Y-m-d H:i:s', strtotime($cutoff. ' -  1 days')); 
    	 }
    	 elseif($selected_time == '2')
    	 {
    	    $cutoff = date('Y-m-d H:i:s', strtotime("$selected_date $cs"));
    	 }
                							 
        $result=mysqli_query($conn,"select u.user_id,u.user_first_name,u.user_last_name,u.user_mobile_number,u.user_address,u.user_time,del.deliveryboy_id,del.deliveryboy_name,del.deliveryboy_mobile,a.area_id,a.area_name,p.product_name,oc.* from tbl_order_calendar as oc left join tbl_product as p on p.product_id=oc.product_id left join tbl_user as u on u.user_id=oc.user_id left join tbl_area as a on a.area_id=u.area_id left join tbl_deliveryboy as del on del.deliveryboy_id=u.deliveryboy_id where oc.product_id='$product_id' and oc.order_date='$selected_date' and oc.oc_cutoff_time='$cutoff' and oc.oc_is_delivered!='3' and oc.oc_is_delivered!='4'");
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
    elseif($action=='admin_today_deliveryboy_inventory')
    {
        $result=mysqli_query($conn,"SELECT d.deliveryboy_id,d.deliveryboy_name,d.deliveryboy_image,oc.order_date,oc.oc_cutoff_time,oc.oc_is_delivered,p.product_id,SUM( oc.order_qty ) as quantity from tbl_deliveryboy as d left join tbl_user as u on u.deliveryboy_id=d.deliveryboy_id left join tbl_order_calendar as oc on oc.user_id=u.user_id left join tbl_product as p on p.product_id=oc.product_id where oc.order_date='$newdate' and oc.oc_cutoff_time='$cutoff' and oc.oc_is_delivered!='3' and oc.oc_is_delivered!='4' GROUP BY d.deliveryboy_id");
        if(mysqli_num_rows($result)<=0)
        {
            
            $response["status"]="no";
            $response["error"]="No Data Available!";
        }
        else
        {
            while($row=mysqli_fetch_assoc($result))
            {
                // $response[]=$row;
                $response[]=array(
                    "deliveryboy_name" => $row['deliveryboy_name'],
                    "deliveryboy_image" => "http://nooranidairyfarm.activeapp.in/images/deliveryboy/".$row['deliveryboy_image'],
                    "deliveryboy_id" => $row['deliveryboy_id'],
                    "quantity" => $row["quantity"],
                    "date" => $newdate,
                    "time" => $time,
                );
            }
        }
        
    }
    elseif($action=='admin_today_deliveryboy_inventory_detail')
    {
        $deliveryboy_id=$_POST["deliveryboy_id"];
        $selected_date=$_POST["selected_date"];
        $selected_time=$_POST["selected_time"];
        
        if($selected_time == '1')
    	 {
    	    $cutoff = date('Y-m-d H:i:s', strtotime("$selected_date $cf"));
    	 //   $cutoff = date('Y-m-d H:i:s', strtotime($cutoff. ' -  1 days')); 
    	 }
    	 elseif($selected_time == '2')
    	 {
    	    $cutoff = date('Y-m-d H:i:s', strtotime("$selected_date $cs"));
    	 }
    	 
        $result=mysqli_query($conn,"SELECT o.order_date,o.oc_cutoff_time,o.oc_is_delivered,u.deliveryboy_id, p.product_id,p.product_name,p.product_image, SUM( o.order_qty ) as quantity
                                                FROM  `tbl_order_calendar` o JOIN 
                                                      tbl_product p
                                                      ON p.product_id = o.product_id left join tbl_user as u on u.user_id=o.user_id where o.order_date='$selected_date' and u.deliveryboy_id='$deliveryboy_id' and oc_cutoff_time='$cutoff' and o.oc_is_delivered!='3' and o.oc_is_delivered!='4'
                                                GROUP BY p.product_id");
        if(mysqli_num_rows($result)<=0)
        {
            
            $response["status"]="no";
            $response["error"]="No Data Available!";
        }
        else
        {
            while($row=mysqli_fetch_assoc($result))
            {
                // $response[]=$row;
                $response[]=array(
                    "product_image" => $row['product_image'],
                    "product_image_path" => "http://nooranidairyfarm.activeapp.in/images/product/".$row['product_image'],
                    "product_id" => $row["product_id"],
                    "product_name" => $row["product_name"],
                    "quantity" => $row["quantity"],
                    "date" => $newdate,
                    "time" => $time,
                );
            }
        }
        
    }
    elseif($action=='admin_today_deliveryboy_inventory_product')
    {
        $deliveryboy_id=$_POST["deliveryboy_id"];
        $product_id=$_POST["product_id"];
        $selected_date=$_POST["selected_date"];
        $selected_time=$_POST["selected_time"];
        
        if($selected_time == '1')
    	 {
    	    $cutoff = date('Y-m-d H:i:s', strtotime("$selected_date $cf"));
    	 //   $cutoff = date('Y-m-d H:i:s', strtotime($cutoff. ' -  1 days')); 
    	 }
    	 elseif($selected_time == '2')
    	 {
    	    $cutoff = date('Y-m-d H:i:s', strtotime("$selected_date $cs"));
    	 }
    	 
        $result=mysqli_query($conn,"SELECT u.user_id,u.user_first_name,u.user_last_name,u.user_mobile_number,u.user_address,u.user_time,d.deliveryboy_id,d.deliveryboy_name,d.deliveryboy_mobile,a.area_id,a.area_name,p.product_name,o.* FROM  `tbl_order_calendar` o JOIN 
                                                      tbl_product p
                                                      ON p.product_id = o.product_id left join tbl_user as u on u.user_id=o.user_id left join tbl_deliveryboy as d on d.deliveryboy_id=u.deliveryboy_id left join tbl_area as a on a.area_id=u.area_id where o.order_date='$date' and u.deliveryboy_id='$deliveryboy_id' and oc_cutoff_time='$cutoff' and o.product_id='$product_id' and o.oc_is_delivered!='3' and o.oc_is_delivered!='4'");
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
                // $response[]=array(
                //     "product_image" => $row['product_image'],
                //     "product_image_path" => "http://nooranidairyfarm.activeapp.in/images/product/".$row['product_image'],
                //     "product_id" => $row["product_id"],
                //     "product_name" => $row["product_name"],
                //     "quantity" => $row["quantity"],
                //     "date" => $newdate,
                //     "time" => $time,
                // );
            }
        }
        
    }
    //SHEET
    
    elseif($action=='admin_order_sheet')
    {
        $newdate=$_POST["order_sheet_date"];
        $selected_time=$_POST["order_sheet_cutoff"];
          
        if($selected_time == '1')
    	 {
    	    $cutoff = date('Y-m-d H:i:s', strtotime("$newdate $cf"));
    	 //   $cutoff = date('Y-m-d H:i:s', strtotime($cutoff. ' -  1 days')); 
    	 }
    	 elseif($selected_time == '2')
    	 {
    	    $cutoff = date('Y-m-d H:i:s', strtotime("$newdate $cs"));
    	 }
    	 
        $result=mysqli_query($conn,"SELECT p.product_image,p.product_id,p.product_name, SUM( o.order_qty ) as quantity FROM  `tbl_order_calendar` o JOIN tbl_product p ON p.product_id = o.product_id where o.order_date='$newdate' and o.oc_cutoff_time='$cutoff' and o.oc_is_delivered!='3' and o.oc_is_delivered!='4' GROUP BY p.product_id");
        if(mysqli_num_rows($result)<=0)
        {
            
            $response["status"]="no";
            $response["error"]="No Data Available!";
        }
        else
        {
            while($row=mysqli_fetch_assoc($result))
            {
                // $response[]=$row;
                $response[]=array(
                    "product_image" => $row['product_image'],
                    "product_image_path" => "http://nooranidairyfarm.activeapp.in/images/product/".$row['product_image'],
                    "product_id" => $row["product_id"],
                    "product_name" => $row["product_name"],
                    "quantity" => $row["quantity"],
                    "date" => $newdate,
                    "time" => $time,
                );
            }
        }
        
    }
    
    elseif($action=='admin_deliveryboy_inventory_sheet')
    {
        $newdate=$_POST["order_sheet_date"];
        $selected_time=$_POST["order_sheet_cutoff"];
                
        if($selected_time == '1')
    	 {
    	    $cutoff = date('Y-m-d H:i:s', strtotime("$newdate $cf"));
    	 //   $cutoff = date('Y-m-d H:i:s', strtotime($cutoff. ' -  1 days')); 
    	 }
    	 elseif($selected_time == '2')
    	 {
    	    $cutoff = date('Y-m-d H:i:s', strtotime("$newdate $cs"));
    	 }
    	 
        $result=mysqli_query($conn,"SELECT d.deliveryboy_id,d.deliveryboy_name,d.deliveryboy_image,oc.order_date,oc.oc_cutoff_time,oc.oc_is_delivered,p.product_id,SUM( oc.order_qty ) as quantity from tbl_deliveryboy as d left join tbl_user as u on u.deliveryboy_id=d.deliveryboy_id left join tbl_order_calendar as oc on oc.user_id=u.user_id left join tbl_product as p on p.product_id=oc.product_id where oc.order_date='$newdate' and oc.oc_cutoff_time='$cutoff' and oc.oc_is_delivered!='3' and oc.oc_is_delivered!='4' GROUP BY d.deliveryboy_id");
        if(mysqli_num_rows($result)<=0)
        {
            
            $response["status"]="no";
            $response["error"]="No Data Available!";
        }
        else
        {
            while($row=mysqli_fetch_assoc($result))
            {
                // $response[]=$row;
                $response[]=array(
                    "deliveryboy_name" => $row['deliveryboy_name'],
                    "deliveryboy_image" => "http://nooranidairyfarm.activeapp.in/images/deliveryboy/".$row['deliveryboy_image'],
                    "deliveryboy_id" => $row['deliveryboy_id'],
                    "quantity" => $row["quantity"],
                    "date" => $newdate,
                    "time" => $time,
                );
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
    //AREA
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
    elseif($action=='time_slot')
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
    
    
    //slider
    elseif($action=='get_slider')
    {
       $result=mysqli_query($conn,"select * from tbl_banner") or die(mysqli_error($conn));

        if(mysqli_num_rows($result)<=0)
        {
            
            $response["status"]="no";
            $response["error"]="No Data Available!";
        }
        else
        {
            while($row=mysqli_fetch_assoc($result))
            {
                // $response[]=$row;
                $response[]=array(
                    "banner_id" => $row['banner_id'],
                    "banner_img_path" => "http://nooranidairyfarm.activeapp.in/".$ADMIN_SLIDER_IMG.$row['banner_img'],
                    "banner_img" => $row["banner_img"],
                    "banner_status" => $row["banner_status"],
                );
            }
        }
    }
    elseif($action=='add_slider')
    {
        $slider_img=$_POST["slider_img"];
        $slider_status=$_POST["slider_status"];
        
        $data = base64_decode($slider_img);
        $image=rand(111111,999999).".png";
        file_put_contents("../images/slider/".$image,$data);
        
        $result=mysqli_query($conn,"insert into tbl_banner(banner_img,banner_status) values('$image','$slider_status')") or die(mysqli_error($conn));
        // $result=mysqli_query($conn,"update tbl_area set area_name='$area_name',area_status='$area_status' where area_id='$area_id'") or die(mysqli_error($conn));
        if($result=true)
        {
            $response["status"]="yes";
            $response["message"]="Successfully Slider Added";
        }
        else
        {
            $response["status"]="no";
            $response["message"]="Something is Wrong";
        }
    }
    elseif($action=='delete_slider')
    {
        $area_id=$_POST["slider_id"];
        $result=mysqli_query($conn,"delete from tbl_banner where banner_id='$area_id'") or die(mysqli_error($conn));
        if($result=true)
        {
            $response["status"]="yes";
            $response["message"]="Successfully Slider Deleted";
        }
        else
        {
            $response["status"]="no";
            $response["message"]="Something is Wrong";
        }
    }
    
    //CATEGORY
    elseif($action=='show_category')
    {
       $result=mysqli_query($conn,"select * from tbl_category") or die(mysqli_error($conn));

        if(mysqli_num_rows($result)<=0)
        {
            
            $response["status"]="no";
            $response["error"]="No Data Available!";
        }
        else
        {
            while($row=mysqli_fetch_assoc($result))
            {
                // $response[]=$row;
                $response[]=array(
                    "category_id" => $row['category_id'],
                    "category_img_path" => "http://nooranidairyfarm.activeapp.in/".$ADMIN_CATEGORY_IMG.$row['category_img'],
                    "category_img" => $row["category_img"],
                    "category_name" => $row["category_name"],
                    "category_sequence" => $row["category_sequence"],
                    "category_status" => $row["category_status"],
                );
            }
        }
    }
    elseif($action=='method_category')
    {
       $category_status=$_POST["category_status"];
       $result=mysqli_query($conn,"select * from tbl_category where category_status='$category_status'") or die(mysqli_error($conn));

        if(mysqli_num_rows($result)<=0)
        {
            
            $response["status"]="no";
            $response["error"]="No Data Available!";
        }
        else
        {
            while($row=mysqli_fetch_assoc($result))
            {
                // $response[]=$row;
                $response[]=array(
                    "category_id" => $row['category_id'],
                    "category_img_path" => "http://nooranidairyfarm.activeapp.in/".$ADMIN_CATEGORY_IMG.$row['category_img'],
                    "category_img" => $row["category_img"],
                    "category_name" => $row["category_name"],
                    "category_sequence" => $row["category_sequence"],
                    "category_status" => $row["category_status"],
                );
            }
        }
    }
    elseif($action=='get_category')
    {
        $category_id=$_POST["category_id"];
        $result=mysqli_query($conn,"select * from tbl_category where category_id='$category_id'") or die(mysqli_error($conn));

        if(mysqli_num_rows($result)<=0)
        {
            
            $response["status"]="no";
            $response["error"]="No Data Available!";
        }
        else
        {
            while($row=mysqli_fetch_assoc($result))
            {
                // $response[]=$row;
                 $response[]=array(
                    "category_id" => $row['category_id'],
                    "category_img_path" => "http://nooranidairyfarm.activeapp.in/".$ADMIN_CATEGORY_IMG.$row['category_img'],
                    "category_img" => $row["category_img"],
                    "category_name" => $row["category_name"],
                    "category_sequence" => $row["category_sequence"],
                    "category_status" => $row["category_status"],
                );
            }
        }
    }
    elseif($action=='add_category')
    {
        $category_name=$_POST["category_name"];
        $category_img=$_POST["category_img"];
        $category_status=$_POST["category_status"];
        
        $data = base64_decode($category_img);
        $image=rand(111111,999999).".png";
        file_put_contents("../images/category/".$image,$data);
        
        $result=mysqli_query($conn,"insert into tbl_category(category_name,category_img,category_status) values('$category_name','$image','$slider_status')") or die(mysqli_error($conn));
        // $result=mysqli_query($conn,"update tbl_area set area_name='$area_name',area_status='$area_status' where area_id='$area_id'") or die(mysqli_error($conn));
        if($result=true)
        {
            $response["status"]="yes";
            $response["message"]="Successfully Category Added";
        }
        else
        {
            $response["status"]="no";
            $response["message"]="Something is Wrong";
        }
    }
    elseif($action=='delete_category')
    {
        $category_id=$_POST["category_id"];
        $result=mysqli_query($conn,"select * from tbl_product where category_id='$category_id'") or die(mysqli_error($conn));
        if(mysqli_num_rows($result)<=0)
        {
            $result=mysqli_query($conn,"delete from tbl_category where category_id='$category_id'") or die(mysqli_error($conn));
            if($result=true)
            {
                $response["status"]="yes";
                $response["message"]="Successfully Category Deleted";
            }
            else
            {
                $response["status"]="no";
                $response["message"]="Something is Wrong";
            }
            $response["status"]="no";
            $response["message"]="Something is Wrong";
        }
        else
        {
            $response["status"]="no";
            $response["message"]="Category Contain Product... So You Can not Delete it.";
        }
        
    }
    elseif($action=='active_category')
    {
        $category_id=$_POST["category_id"];
        $category_status=$_POST["category_status"];
        
        if($category_status=="1")
        {
            $category_status = "0";
        }
        else
        {
             $category_status = "1";
        }
        
        $result=mysqli_query($conn,"update tbl_category set category_status='$category_status' where category_id='$category_id'") or die(mysqli_error($conn));
        if($result=true)
        {
            $response["status"]="yes";
            $response["message"]="Successfully Update Category";
        }
        else
        {
            $response["status"]="no";
            $response["message"]="Something is Wrong";
        }
    }
    elseif($action=='update_category_with')
    {
        $category_id=$_POST["category_id"];
        $category_name=$_POST["category_name"];
        $category_img=$_POST["category_img"];
        $category_status=$_POST["category_status"];
        
        $data = base64_decode($category_img);
        $image=rand(111111,999999).".png";
        file_put_contents("../images/category/".$image,$data);
        
        $result=mysqli_query($conn,"update tbl_category set category_name='$category_name',category_status='$category_status',category_img='$image' where category_id='$category_id'") or die(mysqli_error($conn));
        if($result=true)
        {
            $response["status"]="yes";
            $response["message"]="Successfully Update Category";
        }
        else
        {
            $response["status"]="no";
            $response["message"]="Something is Wrong";
        }
    }
    elseif($action=='update_category_without')
    {
        $category_id=$_POST["category_id"];
        $category_name=$_POST["category_name"];
        $category_status=$_POST["category_status"];
        
        $result=mysqli_query($conn,"update tbl_category set category_name='$category_name',category_status='$category_status' where category_id='$category_id'") or die(mysqli_error($conn));
        if($result=true)
        {
            $response["status"]="yes";
            $response["message"]="Successfully Update Category";
        }
        else
        {
            $response["status"]="no";
            $response["message"]="Something is Wrong";
        }
    }
    
    //CATEGORY
    elseif($action=='show_attribute')
    {
       $result=mysqli_query($conn,"select * from tbl_attribute") or die(mysqli_error($conn));

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
    elseif($action=='method_attribute')
    {
       $attribute_status=$_POST["attribute_status"];
       $result=mysqli_query($conn,"select * from tbl_attribute where attribute_status='$attribute_status'") or die(mysqli_error($conn));

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
    elseif($action=='active_attribute')
    {
        $attribute_id=$_POST["attribute_id"];
        $attribute_status=$_POST["attribute_status"];
        
        if($attribute_status=="1")
        {
            $attribute_status = "0";
        }
        else
        {
             $attribute_status = "1";
        }
        
        $result=mysqli_query($conn,"update tbl_attribute set attribute_status='$attribute_status' where attribute_id='$attribute_id'") or die(mysqli_error($conn));
        if($result=true)
        {
            $response["status"]="yes";
            $response["message"]="Successfully Update Attribute";
        }
        else
        {
            $response["status"]="no";
            $response["message"]="Something is Wrong";
        }
    }
    elseif($action=='get_attribute')
    {
        $attribute_id=$_POST["attribute_id"];
        $result=mysqli_query($conn,"select * from tbl_attribute where attribute_id='$attribute_id'") or die(mysqli_error($conn));

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
    elseif($action=='update_attribute')
    {
        $attribute_id=$_POST["attribute_id"];
        $attribute_name=$_POST["attribute_name"];
        $attribute_status=$_POST["attribute_status"];
        
        $result=mysqli_query($conn,"update tbl_attribute set attribute_name='$attribute_name',attribute_status='$attribute_status' where attribute_id='$attribute_id'") or die(mysqli_error($conn));
        if($result=true)
        {
            $response["status"]="yes";
            $response["message"]="Successfully Update Attribute";
        }
        else
        {
            $response["status"]="no";
            $response["message"]="Something is Wrong";
        }
    }
    
    
    //PRODUCT
    elseif($action=='show_product')
    {
       $result=mysqli_query($conn,"select p.*,a.attribute_id,a.attribute_name,c.category_name from tbl_product as p left join tbl_attribute as a on a.attribute_id=p.attribute_id left join tbl_category as c on c.category_id=p.category_id") or die(mysqli_error($conn));

        if(mysqli_num_rows($result)<=0)
        {
            
            $response["status"]="no";
            $response["error"]="No Data Available!";
        }
        else
        {
            while($row=mysqli_fetch_assoc($result))
            {
                // $response[]=$row;
                $response[]=array(
                    "product_id" => $row['product_id'],
                    "product_image_path" => "http://nooranidairyfarm.activeapp.in/".$ADMIN_PRODUCT_IMG.$row['product_image'],
                    "product_image" => $row["product_image"],
                    "product_name" => $row["product_name"],
                    "product_price" => $row["product_normal_price"],
                    "product_att_value" => $row["product_att_value"],
                    "attribute_name" => $row["attribute_name"],
                    "category_name" => $row["category_name"],
                    "product_sequence" => $row["product_sequence"],
                );
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
                    "user_time" => $row["user_time"],

                    
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
    
    // assign_user
    elseif($action=='assign_user')
    {
        $user_id=$_POST["user_id"];
        $deliveryboy_id=$_POST["deliveryboy_id"];
        
        $result=mysqli_query($conn,"update tbl_user set deliveryboy_id='$deliveryboy_id' where user_id='$user_id'") or die(mysqli_error($conn));
        if($result=true)
        {
            $response["status"]="yes";
            $response["message"]="Successfully Assign User";
        }
        else
        {
            $response["status"]="no";
            $response["message"]="Something is Wrong";
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
    
    //RECHARGE
    
    elseif($action=='show_recharge')
    {
       $result=mysqli_query($conn,"select p.*,u.user_first_name,u.user_last_name,u.user_mobile_number,u.user_time,d.deliveryboy_name,d.deliveryboy_mobile from tbl_payment as p left join tbl_user as u on u.user_id=p.user_id left join tbl_deliveryboy as d on d.deliveryboy_id=u.deliveryboy_id left join tbl_area as a on u.area_id=a.area_id ORDER BY p.payment_time DESC") or die(mysqli_error($conn));

        if(mysqli_num_rows($result)<=0)
        {
            
            $response["status"]="no";
            $response["error"]="No Data Available!";
        }
        else
        {
            while($row=mysqli_fetch_assoc($result))
            {
                // $response[]=$row;
                $response[]=array(
                    "payment_id" => $row['payment_id'],
                    "user_id" => $row['user_id'],
                    "deliveryboy_id" => $row['deliveryboy_id'],
                    "deliveryboy_img" => $row['deliveryboy_img'],
                    "deliveryboy_img_path" => "http://nooranidairyfarm.activeapp.in/images/payment_deliveryboy/".$row['deliveryboy_img'],
                    "razorpay_payment_id" => $row['razorpay_payment_id'],
                    "payment_amt" => $row['payment_amt'],
                    "payment_type" => $row['payment_type'],
                    "payment_status" => $row['payment_status'],
                    "payment_time" => $row['payment_time'],
                    "user_first_name" => $row['user_first_name'],
                    "user_last_name" => $row['user_last_name'],
                    "user_mobile_number" => $row["user_mobile_number"],
                    "deliveryboy_name" => $row["deliveryboy_name"],
                    "deliveryboy_mobile" => $row["deliveryboy_mobile"],
                );
            }
        }
    }
    
    
    
    
    
    else
    {
        $response["message"]="Something is Wrong";
    }
    echo json_encode($response);
?>