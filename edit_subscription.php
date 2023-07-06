<?php
    session_start();
    include 'connection.php';
    $title = "Subscription";
    $code = "subscription";
    $status = "1";
	if(!isset($_SESSION["admin_id"]))
	{
		echo "<script>window.location='login.php';</script>";
	}
	$cat_res=mysqli_query($conn,"select * from tbl_admin where admin_id='".$_SESSION["admin_id"]."'");
    $cat_arr=array();
    while($row=mysqli_fetch_assoc($cat_res)){
        $cat_arr[]=$row;	
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<title><?php echo $title; ?> - <?php echo $webname;?></title>
	<!--favicon-->
	<link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" />
	<!--plugins-->
	<link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
	<link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
	<link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
	<!-- loader-->
	<link href="assets/css/pace.min.css" rel="stylesheet" />
	<script src="assets/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<!-- Icons CSS -->
	<link rel="stylesheet" href="assets/css/icons.css" />
	<!-- App CSS -->
	<link rel="stylesheet" href="assets/css/app.css" />
	<link rel="stylesheet" href="assets/css/dark-sidebar.css" />
	<link rel="stylesheet" href="assets/css/dark-theme.css" />
</head>

<body>
	<!-- wrapper -->
	<div class="wrapper">
		<!--sidebar-wrapper-->
		<?php include 'sidebar.php';?>
		<!--end sidebar-wrapper-->
		<!--header-->
		<?php include 'header.php';?>
		<!--end header-->
		<!--page-wrapper-->
		<div class="page-wrapper">
			<!--page-content-wrapper-->
			<div class="page-content-wrapper">
				<div class="page-content">
					<!--breadcrumb-->
					<?php

						if(isset($_REQUEST["user"], $_REQUEST["order"]))
							{
								$order = $_REQUEST["order"];
								$user = $_REQUEST["user"];

								$resultuser=mysqli_query($conn,"select * from tbl_user where user_id='".$user."'");
								while($rowuser=mysqli_fetch_array($resultuser))
								{
									$usertype = $rowuser["user_type"];
								}
								
								$result=mysqli_query($conn,"select * from tbl_order as o left join tbl_product as p on o.product_id=p.product_id where o.order_id='".$order."'");
								while($row=mysqli_fetch_array($result))
								{
									$product_name = $row["product_name"];
									$product_id = $row["product_id"];
									$product_price = $usertype=="1"?$row["product_regular_price"]:$row["product_normal_price"];
									// $product_price = if($usertype=="1"){$row["product_name"];}else{$row["product_name"];}
								}
						}
					?>
					
					<?php 
						if(isset($_REQUEST["BtnUpdateEveryday"]))
                        {
							// $user=$_POST["user_id"];
							// $product=$_POST["product_id"];
							// $product_name=$_POST["product_name"];
							// $product_price=$_POST["product_price"];
							$delivery_schedule="Everyday";
							$qty=$_REQUEST["txtqty"];
							$start_date=$_REQUEST["txtdate"];
							// $cdate=$_REQUEST["current_date"];
							$order_instructions=$_REQUEST["txtinstruction"];
							$order_ring_bell=$_REQUEST["txtbell"];

							// date_format($start_date,"Y-m-d");
							$start_date = date("Y-m-d", strtotime($start_date));
							
									
							$result=mysqli_query($conn,"select * from tbl_time_slot as t left join tbl_deliveryboy as d on d.time_slot_id=t.time_slot_id left join tbl_user as u on d.deliveryboy_id=u.deliveryboy_id where u.user_id='$user'")or die(mysqli_error($conn));
							$cutofftime;
							while($row=mysqli_fetch_assoc($result))
							{
								$cutofftime= $row["time_slot_cutoff_time"];
									
							}
							$finalcutoff = date('Y-m-d H:i:s', strtotime("$start_date $cutofftime"));
							// echo $finalcutoff;
							
					        $lastdate = date('Y-m-d', strtotime($start_date. '+  120 days'));
        
                             $result=mysqli_query($conn,"update tbl_order_calendar set order_qty='$qty' where user_id='$user' and order_id='$order' and order_date between '$start_date' and '$lastdate'") or die(mysqli_error($conn));
            
                             $result1=mysqli_query($conn,"update tbl_delivery_schedule set ds_qty='$qty' where order_id='$order'") or die(mysqli_error($conn));
                             
                            //  $round = 15;
                            
                            // for ($i = 0; $i <= $round; $i+=1){
                                
                            // $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                            // values ('$order','$product_id','$user','$qty','".date('Y-m-d', strtotime($start_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                            // }
                            
                            if($result1=true && $resultdel=true && $result3=true)
							{?>
								<div class="alert alert-success" role="alert">
									<h4 class="alert-heading">Well done!</h4>
									<p><?php echo "Aww yeah you successfully subscribe $product_name; subscription with $qty; quantity will start from $start_date for $ds_alt_diff."?></p>
									<hr>
									<p class="mb-0">
									    <?php echo "<script>window.location='user_detail.php?user=$user';</script>"; ?>
									</p>
								</div>

								
							<?php }
							else
							{
								echo "error";
							}
                            // user_detail.php?user=<?php echo $user;
							
							
						}

						if(isset($_REQUEST["BtnUpdateAlernate"]))
						{
							
							$delivery_schedule="Alternate Day";
							$ds_alt_diff1=$_REQUEST["txtaltday"];
							$qty=$_REQUEST["txtqty"];
							$start_date=$_REQUEST["txtdate"];
							// $cdate=$_REQUEST["current_date"];
							$order_instructions=$_REQUEST["txtinstruction"];
							$order_ring_bell=$_REQUEST["txtbell"];
							
							$result=mysqli_query($conn,"select * from tbl_time_slot as t left join tbl_deliveryboy as d on d.time_slot_id=t.time_slot_id left join tbl_user as u on d.deliveryboy_id=u.deliveryboy_id where u.user_id='$user'")or die(mysqli_error($conn));
							$cutofftime;
							while($row=mysqli_fetch_assoc($result))
							{
								$cutofftime= $row["time_slot_cutoff_time"];
									
							}
							
							$finalcutoff = date('Y-m-d H:i:s', strtotime("$start_date $cutofftime"));
							$lastdate = date('Y-m-d', strtotime($start_date. '+  365 days'));
							
							if($ds_alt_diff1 == "Every 2nd Day")
                            {
                                $result1=mysqli_query($conn,"update tbl_delivery_schedule set ds_qty='$qty',ds_alt_diff='$ds_alt_diff' where order_id='$order'") or die(mysqli_error($conn));
                                
                                $resultdel=mysqli_query($conn,"delete from tbl_order_calendar where order_id='$order' and user_id='$user' and oc_is_delivered='0' and order_date between '$start_date' and '$lastdate'") or die(mysqli_error($conn));
                                
                                $round = 30;
                                $start_date;
                                
                                for ($i = 0; $i <= $round; $i+=2){
                                    
                                $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                                values ('$order','$product_id','$user','$qty','".date('Y-m-d', strtotime($start_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                                }
                                
                            }
                            elseif($ds_alt_diff1 == "Every 3rd Day")
                            {
                                $result1=mysqli_query($conn,"update tbl_delivery_schedule set ds_qty='$qty',ds_alt_diff='$ds_alt_diff' where order_id='$order'") or die(mysqli_error($conn));
                                
                                $resultdel=mysqli_query($conn,"delete from tbl_order_calendar where order_id='$order' and user_id='$user' and oc_is_delivered='0' and order_date between '$start_date' and '$lastdate'") or die(mysqli_error($conn));
                                
                                $round = 45;
                                $start_date;
                                
                                for ($i = 0; $i < $round; $i+=3){
                                    
                                    $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                                    values ('$order_id','$product_id','$user_id','$qty','".date('Y-m-d', strtotime($start_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                                    }
                            }
                            elseif($ds_alt_diff1 == "Every 4th Day")
                            {
                                $result1=mysqli_query($conn,"update tbl_delivery_schedule set ds_qty='$qty',ds_alt_diff='$ds_alt_diff' where order_id='$order'") or die(mysqli_error($conn));
                                
                                $resultdel=mysqli_query($conn,"delete from tbl_order_calendar where order_id='$order' and user_id='$user' and oc_is_delivered='0' and order_date between '$start_date' and '$lastdate'") or die(mysqli_error($conn));
                                
                                $round = 60;
                                $start_date;
                                
                                for ($i = 0; $i < $round; $i+=4){
                                    
                                    $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                                    values ('$order','$product_id','$user','$qty','".date('Y-m-d', strtotime($start_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                                    }
                                
                            }
                            else{}
                            if($result1=true && $resultdel=true && $result3=true)
							{?>
								<div class="alert alert-success" role="alert">
									<h4 class="alert-heading">Well done!</h4>
									<p><?php echo "Aww yeah you successfully subscribe $product_name; subscription with $qty; quantity will start from $start_date for $ds_alt_diff."?></p>
									<hr>
									<p class="mb-0">
									    <?php echo "<script>window.location='user_detail.php?user=$user';</script>"; ?>
									</p>
								</div>

								
							<?php }
							else
							{
								echo "error";
							}
							
							
							//end else
						}

						if(isset($_REQUEST["BtnUpdateCustomize"]))
						{
							$delivery_schedule="Customize";
							$ds_Sun=$_REQUEST["txtSun"];
							$ds_Mon=$_REQUEST["txtMon"];
							$ds_Tue=$_REQUEST["txtTue"];
							$ds_Wed=$_REQUEST["txtWed"];
							$ds_Thu=$_REQUEST["txtThu"];
							$ds_Fri=$_REQUEST["txtFri"];
							$ds_Sat=$_REQUEST["txtSat"];
							$start_date=$_REQUEST["txtdate"];
							// $cdate=$_REQUEST["current_date"];
							$order_instructions=$_REQUEST["txtinstruction"];
							$order_ring_bell=$_REQUEST["txtbell"];
							
							$result=mysqli_query($conn,"select * from tbl_time_slot as t left join tbl_deliveryboy as d on d.time_slot_id=t.time_slot_id left join tbl_user as u on d.deliveryboy_id=u.deliveryboy_id where u.user_id='$user'")or die(mysqli_error($conn));
							$cutofftime;
							while($row=mysqli_fetch_assoc($result))
							{
								$cutofftime= $row["time_slot_cutoff_time"];
									
							}
							
							$finalcutoff = date('Y-m-d H:i:s', strtotime("$start_date $cutofftime"));
							
							$result=mysqli_query($conn,"insert into tbl_order (user_id,product_id,attribute_id,start_date,order_instructions,order_ring_bell,delivery_schedule) 
								values ('$user','$product','2','$start_date','$order_instructions','$order_ring_bell','$delivery_schedule')") or die(mysqli_error($conn));
								if($result=true)
								{
									$order_id = $conn->insert_id;
						
									$result2=mysqli_query($conn,"insert into tbl_delivery_schedule (order_id,ds_type,ds_Sun,ds_Mon,ds_Tue,ds_Wed,ds_Thu,ds_Fri,ds_Sat) 
									values ('$order_id','$delivery_schedule','$ds_Sun','$ds_Mon','$ds_Tue','$ds_Wed','$ds_Thu','$ds_Fri','$ds_Sat')") or die(mysqli_error($conn));
									
									$round = 100;
									$start_date;
									$finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
									
									// echo $new_date = date('D', strtotime($start_date));
									
									if($new_date = date('D', strtotime($start_date))=='Mon')
									{
										if($ds_Mon!="0")
										{
											for ($i = 0; $i <= $round; $i+=7){
											$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Mon','".date('Y-m-d', strtotime($start_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
										if($ds_Tue!="0")
										{
											$Tus_date = date('Y-m-d', strtotime($start_date. ' +  1 days'));
											$finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
											for ($i = 0; $i <= $round; $i+=7){
											
											$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Tue','".date('Y-m-d', strtotime($Tus_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
										if($ds_Wed!="0")
										{
											$Wed_date = date('Y-m-d', strtotime($start_date. ' +  2 days'));
											$finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
											
											for ($i = 0; $i <= $round; $i+=7){
											$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Wed','".date('Y-m-d', strtotime($Wed_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
										if($ds_Thu!="0")
										{
											for ($i = 0; $i <= $round; $i+=7){
											$Tus_date = date('Y-m-d', strtotime($start_date. ' +  3 days'));
											$finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
											
											$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Thu','".date('Y-m-d', strtotime($Tus_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
										if($ds_Fri!="0")
										{
											$Fri_date = date('Y-m-d', strtotime($start_date. ' +  4 days'));
											$finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
											
											for ($i = 0; $i <= $round; $i+=7){
											
											$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Fri','".date('Y-m-d', strtotime($Fri_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
										if($ds_Sat!="0")
										{
											$Sat_date = date('Y-m-d', strtotime($start_date. ' +  5 days'));
											$finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
											
											for ($i = 0; $i <= $round; $i+=7){
											
											$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Sat','".date('Y-m-d', strtotime($Sat_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
										if($ds_Sun!="0")
										{
											$Sun_date = date('Y-m-d', strtotime($start_date. ' +  6 days'));
											$finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
											
											for ($i = 0; $i <= $round; $i+=7){
											
											$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Sun','".date('Y-m-d', strtotime($Sun_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
									}
									
									//
									
									// $new_date = date('Y-m-d', strtotime($start_date. ' +  1 days'));
									
									elseif($new_date = date('D', strtotime($start_date))=='Thu')
									{
										
										if($ds_Tue!="0")
										{
											
											for ($i = 0; $i <= $round; $i+=7){
											
											$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Tue','".date('Y-m-d', strtotime($start_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
										if($ds_Wed!="0")
										{
											$Wed_date = date('Y-m-d', strtotime($start_date. ' +  1 days'));
											$finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
											for ($i = 0; $i <= $round; $i+=7){
											$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Wed','".date('Y-m-d', strtotime($Wed_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
										if($ds_Thu!="0")
										{
											$Tus_date = date('Y-m-d', strtotime($start_date. ' +  2 days'));
											$finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
											for ($i = 0; $i <= $round; $i+=7){
											$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Thu','".date('Y-m-d', strtotime($Tus_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
										if($ds_Fri!="0")
										{
											$Fri_date = date('Y-m-d', strtotime($start_date. ' +  3 days'));
											$finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
											for ($i = 0; $i <= $round; $i+=7){
											
											$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Fri','".date('Y-m-d', strtotime($Fri_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
										if($ds_Sat!="0")
										{
											$Sat_date = date('Y-m-d', strtotime($start_date. ' +  4 days'));
											$finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
											for ($i = 0; $i <= $round; $i+=7){
											
											$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Sat','".date('Y-m-d', strtotime($Sat_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
										if($ds_Sun!="0")
										{
											$Sun_date = date('Y-m-d', strtotime($start_date. ' +  5 days'));
											$finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
											for ($i = 0; $i <= $round; $i+=7){
											
											$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Sun','".date('Y-m-d', strtotime($Sun_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
										if($ds_Mon!="0")
										{
											$Mon_date = date('Y-m-d', strtotime($start_date. ' +  6 days'));
											$finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
											for ($i = 0; $i <= $round; $i+=7){
											$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Mon','".date('Y-m-d', strtotime($Mon_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
									}
									
									// $new_date = date('Y-m-d', strtotime($start_date. ' +  1 days')); 
									
									elseif($new_date = date('D', strtotime($start_date))=='Wed')
									{
										
										if($ds_Wed!="0")
										{
											// $Wed_date = date('Y-m-d', strtotime($start_date. ' +  2 days'));
											for ($i = 0; $i <= $round; $i+=7){
											$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Wed','".date('Y-m-d', strtotime($start_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
										if($ds_Thu!="0")
										{
											for ($i = 0; $i <= $round; $i+=7){
											$Tus_date = date('Y-m-d', strtotime($start_date. ' +  1 days'));
											$finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
											$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Thu','".date('Y-m-d', strtotime($Tus_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
										if($ds_Fri!="0")
										{
											$Fri_date = date('Y-m-d', strtotime($start_date. ' +  2 days'));
											$finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
											for ($i = 0; $i <= $round; $i+=7){
											
											$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Fri','".date('Y-m-d', strtotime($Fri_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
										if($ds_Sat!="0")
										{
											$Sat_date = date('Y-m-d', strtotime($start_date. ' +  3 days'));
											$finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
											for ($i = 0; $i <= $round; $i+=7){
											
											$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Sat','".date('Y-m-d', strtotime($Sat_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
										if($ds_Sun!="0")
										{
											$Sun_date = date('Y-m-d', strtotime($start_date. ' +  4 days'));
											$finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
											for ($i = 0; $i <= $round; $i+=7){
												$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Sun','".date('Y-m-d', strtotime($Sun_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
										if($ds_Mon!="0")
										{
											$Mon_date = date('Y-m-d', strtotime($start_date. ' +  5 days'));
											$finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
											for ($i = 0; $i <= $round; $i+=7){
											$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Mon','".date('Y-m-d', strtotime($Mon_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
										if($ds_Tue!="0")
										{
											$Tus_date = date('Y-m-d', strtotime($start_date. ' +  6 days'));
											$finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
											for ($i = 0; $i <= $round; $i+=7){
											$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Tue','".date('Y-m-d', strtotime($Tus_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
									}
									
									// $new_date = date('Y-m-d', strtotime($start_date. ' +  1 days'));
									
									if($new_date = date('D', strtotime($start_date))=='Thu')
									{
										
										if($ds_Thu!="0")
										{
											// $Tus_date = date('Y-m-d', strtotime($start_date. ' +  3 days'));
											for ($i = 0; $i <= $round; $i+=7){
											$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Thu','".date('Y-m-d', strtotime($start_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
										if($ds_Fri!="0")
										{
											$Fri_date = date('Y-m-d', strtotime($start_date. ' +  1 days'));
											$finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
											for ($i = 0; $i <= $round; $i+=7){
											
											$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Fri','".date('Y-m-d', strtotime($Fri_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
										if($ds_Sat!="0")
										{
											$Sat_date = date('Y-m-d', strtotime($start_date. ' +  2 days'));
											$finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
											for ($i = 0; $i <= $round; $i+=7){
											
											$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Sat','".date('Y-m-d', strtotime($Sat_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
										if($ds_Sun!="0")
										{
											$Sun_date = date('Y-m-d', strtotime($start_date. ' +  3 days'));
											$finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
											for ($i = 0; $i <= $round; $i+=7){
											
											$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Sun','".date('Y-m-d', strtotime($Sun_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
										if($ds_Mon!="0")
										{
											$Mon_date = date('Y-m-d', strtotime($start_date. ' +  4 days'));
											$finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
											for ($i = 0; $i <= $round; $i+=7){
											$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Mon','".date('Y-m-d', strtotime($Mon_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
										if($ds_Tue!="0")
										{
											$Tus_date = date('Y-m-d', strtotime($start_date. ' +  5 days'));
											$finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
											for ($i = 0; $i <= $round; $i+=7){
											
											$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Tue','".date('Y-m-d', strtotime($Tus_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
										if($ds_Wed!="0")
										{
											$Wed_date = date('Y-m-d', strtotime($start_date. ' +  6 days'));
											$finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
											for ($i = 0; $i <= $round; $i+=7){
											$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Wed','".date('Y-m-d', strtotime($Wed_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
									}
									
									// $new_date = date('Y-m-d', strtotime($start_date. ' +  1 days'));
									
									if($new_date = date('D', strtotime($start_date))=='Fri')
									{
										
										if($ds_Fri!="0")
										{
											// $Fri_date = date('Y-m-d', strtotime($start_date. ' +  4 days'));
											for ($i = 0; $i <= $round; $i+=7){
											
											$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Fri','".date('Y-m-d', strtotime($start_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
										if($ds_Sat!="0")
										{
											$Sat_date = date('Y-m-d', strtotime($start_date. ' +  1 days'));
											$finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
											for ($i = 0; $i <= $round; $i+=7){
											
											$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Sat','".date('Y-m-d', strtotime($Sat_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
										if($ds_Sun!="0")
										{
											$Sun_date = date('Y-m-d', strtotime($start_date. ' +  2 days'));
											$finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
											for ($i = 0; $i <= $round; $i+=7){
											
											$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Sun','".date('Y-m-d', strtotime($Sun_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
										if($ds_Mon!="0")
										{
											$Mon_date = date('Y-m-d', strtotime($start_date. ' +  3 days'));
											$finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
											for ($i = 0; $i <= $round; $i+=7){
											$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Mon','".date('Y-m-d', strtotime($Mon_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
										if($ds_Tue!="0")
										{
											$Tus_date = date('Y-m-d', strtotime($start_date. ' +  4 days'));
											$finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
											for ($i = 0; $i <= $round; $i+=7){
											
											$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Tue','".date('Y-m-d', strtotime($Tus_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
										if($ds_Wed!="0")
										{
											$Wed_date = date('Y-m-d', strtotime($start_date. ' +  5 days'));
											$finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
											for ($i = 0; $i <= $round; $i+=7){
											$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Wed','".date('Y-m-d', strtotime($Wed_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
										if($ds_Thu!="0")
										{
											for ($i = 0; $i <= $round; $i+=7){
											$Tus_date = date('Y-m-d', strtotime($start_date. ' +  6 days'));
											$finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
										$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Thu','".date('Y-m-d', strtotime($Tus_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
									}
									
									// $new_date = date('Y-m-d', strtotime($start_date. ' +  1 days'));
									
									if($new_date = date('D', strtotime($start_date))=='Sat')
									{
										
										if($ds_Sat!="0")
										{
											// $Sat_date = date('Y-m-d', strtotime($start_date. ' +  5 days'));
											for ($i = 0; $i <= $round; $i+=7){
											
											$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Sat','".date('Y-m-d', strtotime($start_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
										if($ds_Sun!="0")
										{
											$Sun_date = date('Y-m-d', strtotime($start_date. ' +  1 days'));
											$finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
											for ($i = 0; $i <= $round; $i+=7){
											
											$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Sun','".date('Y-m-d', strtotime($Sun_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
										if($ds_Mon!="0")
										{
											$Mon_date = date('Y-m-d', strtotime($start_date. ' +  2 days'));
											$finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
											for ($i = 0; $i <= $round; $i+=7){
											$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Mon','".date('Y-m-d', strtotime($Mon_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
										if($ds_Tue!="0")
										{
											$Tus_date = date('Y-m-d', strtotime($start_date. ' +  3 days'));
											$finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
											for ($i = 0; $i <= $round; $i+=7){
											
											$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Tue','".date('Y-m-d', strtotime($Tus_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
										if($ds_Wed!="0")
										{
											$Wed_date = date('Y-m-d', strtotime($start_date. ' +  4 days'));
											$finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
											for ($i = 0; $i <= $round; $i+=7){
											$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Wed','".date('Y-m-d', strtotime($Wed_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
										if($ds_Thu!="0")
										{
											for ($i = 0; $i <= $round; $i+=7){
											$Tus_date = date('Y-m-d', strtotime($start_date. ' +  5 days'));
											$finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
											$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date)  
											values ('$order_id','$product','$user','$ds_Thu','".date('Y-m-d', strtotime($Tus_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
										if($ds_Fri!="0")
										{
											$Fri_date = date('Y-m-d', strtotime($start_date. ' +  6 days'));
											$finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
											for ($i = 0; $i <= $round; $i+=7){
										
											$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Fri','".date('Y-m-d', strtotime($Fri_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
										
									}
									
									if($new_date = date('D', strtotime($start_date))=='Sun')
									{
										
										
										if($ds_Sun!="0")
										{
											// $Sun_date = date('Y-m-d', strtotime($start_date. ' +  1 days'));
											for ($i = 0; $i <= $round; $i+=7){
											
											$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Sun','".date('Y-m-d', strtotime($Sun_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
										if($ds_Mon!="0")
										{
											$Mon_date = date('Y-m-d', strtotime($start_date. ' +  1 days'));
											$finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
											for ($i = 0; $i <= $round; $i+=7){
											$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Mon','".date('Y-m-d', strtotime($Mon_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
										if($ds_Tue!="0")
										{
											$Tus_date = date('Y-m-d', strtotime($start_date. ' +  2 days'));
											$finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
											for ($i = 0; $i <= $round; $i+=7){
											
											$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Tue','".date('Y-m-d', strtotime($Tus_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
										if($ds_Wed!="0")
										{
											$Wed_date = date('Y-m-d', strtotime($start_date. ' +  3 days'));
											$finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
											for ($i = 0; $i <= $round; $i+=7){
											$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Wed','".date('Y-m-d', strtotime($Wed_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
										if($ds_Thu!="0")
										{
											for ($i = 0; $i <= $round; $i+=7){
											$Tus_date = date('Y-m-d', strtotime($start_date. ' +  4 days'));
											$finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
											$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Thu','".date('Y-m-d', strtotime($Tus_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
										if($ds_Fri!="0")
										{
											$Fri_date = date('Y-m-d', strtotime($start_date. ' +  5 days'));
											$finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
											for ($i = 0; $i <= $round; $i+=7){
											
											$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Fri','".date('Y-m-d', strtotime($Fri_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
										if($ds_Sat!="0")
										{
											$Sat_date = date('Y-m-d', strtotime($start_date. ' +  6 days'));
											$finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  1 days'));
											for ($i = 0; $i <= $round; $i+=7){
											
											$result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
											values ('$order_id','$product','$user','$ds_Sat','".date('Y-m-d', strtotime($Sat_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
											}
										}
										
									}
									
						
									if($result2=true)
									{
										?>
										<div class="alert alert-success" role="alert">
											<h4 class="alert-heading">Well done!</h4>
											<p><?php echo "Aww yeah you successfully subscribe $product_name subscription will start from $start_date for Customize."?></p>
											<hr>
											<p class="mb-0">
											<button type="button" onclick="window.location='index.php';" class="btn btn-outline-primary m-1 radius-30 px-5"><i class="bx bx-home mr-1"></i>Go to Dashboard</button>
												<button type="button" onclick="window.location='user_detail.php?user=<?php echo $user;?>';" class="btn btn-outline-primary m-1 radius-30 px-5"><i class="bx bx-user mr-1"></i>Go to User Detail</button>
											</p>
										</div>

										
									<?php }
									else
									{
										echo "error";
									}
								}
								else
								{
									echo "error";
								}
							

						}
					?>
					<!--end breadcrumb-->
					<div class="user-profile-page">
						<div class="card radius-15">
							<div class="card-body">
                            <?php
                            if(isset($_REQUEST["user"], $_REQUEST["order"]))
                            {
								$user = $_REQUEST["user"];
                                $order = $_REQUEST["order"];
                                
                                
								$result=mysqli_query($conn,"select * from tbl_order as o left join tbl_product as p on o.product_id=p.product_id left join tbl_delivery_schedule as ds on ds.order_id=o.order_id where o.order_id='".$order."'");
                                while($row=mysqli_fetch_array($result))
                                {
                                ?> 
								<div class="row">
									<div class="col-12 col-lg-12 border-right">
										<div class="d-md-flex align-items-center">
											<div class="mb-md-0 mb-3">
												<!-- <img src="https://via.placeholder.com/110x110" class="rounded-circle shadow" width="130" height="130" alt="" /> -->
                                                <img src="<?php echo $ADMIN_PRODUCT_IMG.$row['product_image'];?>" class="shadow" width="130" height="130" alt="" />
											</div>
											<div class="ml-md-4 flex-grow-1">
												<div class="d-flex align-items-center mb-1">
													<h4 class="mb-0"><?php echo $row['product_name'];?></h4>
												</div>

                                                <?php if($usertype=='1')
                                                {?>
												    <p class="text-primary"><?php echo "₹".$row["product_regular_price"];?></p>
                                                <?php } 
                                                else
                                                {?>
                                                    <p class="text-primary"><?php echo "₹".$row["product_normal_price"];?></p>
                                                <?php }?>

												<!-- <p class="mb-0 text-muted"><?php echo $row["product_normal_price"];?></p> -->
												<button type="button" class="btn btn-primary">Subscription</button>

                                                <br>

                                                <p style="margin-top: 1rem;" class="mb-10 text-muted"><?php echo $row["product_des"];?></p>

											</div>
										</div>
									</div>
								</div>
                                <br>
								<!--end row-->
								<ul class="nav nav-pills">
									<?php if($row["delivery_schedule"]=="Everyday"){?><li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#Experience"><span class="p-tab-name">Everyday</span><i class='bx bx-donate-blood font-24 d-sm-none'></i></a>
									</li><?php }elseif($row["delivery_schedule"]=="Alternate Day"){?>
									<li class="nav-item"> <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#Biography"><span class="p-tab-name">Alernate Day</span><i class='bx bxs-user-rectangle font-24 d-sm-none'></i></a>
									</li><?php }elseif($row["delivery_schedule"]=="Customize"){?>
									<li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#Edit-Profile"><span class="p-tab-name">Customize</span><i class='bx bx-message-edit font-24 d-sm-none'></i></a>
									</li><?php }?>
								</ul>
								
                                
                              
								<div class="tab-content mt-3">
								    
									<?php if($row["delivery_schedule"]=="Everyday"){?><div class="tab-pane fade show active" id="Experience">
										<div class="card shadow-none border mb-0 radius-15">
											<div class="card-body">
												<div class="d-sm-flex align-items-center mb-3">
													<h4 class="mb-0">Everyday</h4>
													
													<p class="mb-0 ml-sm-3 text-muted"></p> 

												</div>

											<form method="post">
                                                <div class="row">
                                                    <div class="col-12 col-lg-12 border-right">
                                                        <div class="d-md-flex align-items-center">
                                                            <div class="ml-md-4 flex-grow-1" style="margin-top: 1rem;" >
																<div class="col-md-12 mb-3">
																	<label for="validationCustom01"><?php echo $title?> Quantity</label>
																	<input type="number" name="txtqty" value="<?php echo $row['ds_qty'];?>" class="form-control" required>
																	<!-- <button type="button" class="btn btn-light-primary m-1"><i class="fadeIn animated bx bx-minus"></i></button>
																	<button type="button" class="btn btn-outline-primary m-1 px-5"><?php echo $eveqty;?></button>
																	<button type="submit" name="select" value="select" onclick="<?php $eveqty++ ?>" class="btn btn-light-primary m-1"><i class="fadeIn animated bx bx-plus"></i></button> -->
																</div>

																<div class="col-md-12 mb-3">
																	<label for="validationCustom01">Start Date</label>
																	<input type="date" name="txtdate" class="form-control" required>
																</div>

																<div class="col-md-12 mb-3">
																	<label for="validationCustom01">Instruction For Delivery Boy</label>
																	<input type="text" name="txtinstruction" class="form-control" value="<?php echo $row['order_instructions'];?>">
																</div>

																<div class="col-md-12 mb-3">
																	<label for="validationCustom01">Ring the bell or not?</label>
																	<select class="form-control" name="txtbell">
																		<!--<option>Select</option>-->
																		
																		<option <?php if($row['order_ring_bell']=="1"){?> selected <?php } ?> value="<?php echo $row['order_ring_bell']?>">Bell Ring On</option>
                                                                        <option <?php if($row['order_ring_bell']=="0"){?> selected <?php } ?> value="<?php echo $row['order_ring_bell']?>">Bell Ring Off</option>
                                                                        
																	</select>
																
																</div>

																<button type="submit" name="BtnUpdateEveryday" class="btn btn-primary m-1 px-5 radius-30">Continue</button>

                                                            </div>
															</form>
                                                        </div>
                                                    </div>
                                                </div>
											</form>


											</div>
										</div>
									</div><?php }?>
									
									<?php if($row["delivery_schedule"]=="Alternate Day"){?><div class="tab-pane fade show active" id="Biography">
                                        <div class="card shadow-none border mb-0 radius-15">
											<div class="card-body">
												<div class="d-sm-flex align-items-center mb-3">
													<h4 class="mb-0">Alernate Day</h4>
													
													<p class="mb-0 ml-sm-3 text-muted"></p> <br>
													
												</div>

												<form method="post">
                                                <div class="row">
                                                    <div class="col-12 col-lg-12 border-right">
                                                        <div class="d-md-flex align-items-center">
                                                            
                                                            <div class="ml-md-4 flex-grow-1" style="margin-top: 1rem;" >

															<div class="col-md-12 mb-3">
																<label for="validationCustom01">Alernate Day</label>
																<select class="form-control" name="txtaltday">
																	<!--<option>Select</option>-->
																	
																		<option <?php if($row['ds_alt_diff']=="Every 2nd Day"){?> selected <?php } ?> value="<?php echo $row['ds_alt_diff']?>">Every 2nd Day</option>
                                                                        <option <?php if($row['ds_alt_diff']=="Every 3rd Day"){?> selected <?php } ?> value="<?php echo $row['ds_alt_diff']?>">Every 3rd Day</option>
                                                                        <option <?php if($row['ds_alt_diff']=="Every 4th Day"){?> selected <?php } ?> value="<?php echo $row['ds_alt_diff']?>">Every 4th Day</option>
                                                                    
																</select>
															</div>

                                                            <div class="col-md-12 mb-3">
																<label for="validationCustom01"><?php echo $title?> Quantity</label>
																<input type="number" name="txtqty" class="form-control" value="<?php echo $row['ds_qty'];?>" required>
                                                                <!-- <button type="button" class="btn btn-light-primary m-1"><i class="fadeIn animated bx bx-minus"></i></button>
                                                                <button type="button" class="btn btn-outline-primary m-1 px-5"><?php echo $eveqty;?></button>
                                                                <button type="submit" name="select" value="select" onclick="<?php $eveqty++ ?>" class="btn btn-light-primary m-1"><i class="fadeIn animated bx bx-plus"></i></button> -->
                                                            </div>

															<div class="col-md-12 mb-3">
																<label for="validationCustom01">Start Date</label>
																<input type="date" name="txtdate" class="form-control" required>
															</div>

															<div class="col-md-12 mb-3">
																<label for="validationCustom01">Instruction For Delivery Boy</label>
																<input type="text" name="txtinstruction" class="form-control" value="<?php echo $row['order_instructions'];?>">
															</div>

															<div class="col-md-12 mb-3">
																<label for="validationCustom01">Ring the bell or not?</label>
																<select class="form-control" name="txtbell">
																    <option <?php if($row['order_ring_bell']=="1"){?> selected <?php } ?> value="<?php echo $row['order_ring_bell']?>">Bell Ring On</option>
                                                                    <option <?php if($row['order_ring_bell']=="0"){?> selected <?php } ?> value="<?php echo $row['order_ring_bell']?>">Bell Ring Off</option>
																</select>
															</div>

															<button type="submit" name="BtnUpdateAlernate" class="btn btn-primary m-1 px-5 radius-30">Continue</button>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
												</form>


											</div>
										</div>
									</div><?php }?>
                             
									<?php if($row["delivery_schedule"]=="Customize"){?><div class="tab-pane fade show active" id="Edit-Profile">
                                        <div class="card shadow-none border mb-0 radius-15">
											<div class="card-body">
												<div class="d-sm-flex align-items-center mb-3">
													<h4 class="mb-0">Customize</h4>
													
													<p class="mb-0 ml-sm-3 text-muted"></p> 
													
												</div>
												<form method="post">
                                                <div class="row">
                                                    <div class="col-12 col-lg-12 border-right">
                                                        <div class="d-md-flex align-items-center">
                                                            
                                                            <div class="ml-md-4 flex-grow-1" style="margin-top: 1rem;" >

															<div class="col-md-12 mb-3">
																<label for="validationCustom01">Sun <?php echo $title?> Quantity</label>
																<input type="number" name="txtSun" class="form-control" value="<?php echo $row['ds_Sun'];?>"  required>
                                                                <!-- <button type="button" class="btn btn-light-primary m-1"><i class="fadeIn animated bx bx-minus"></i></button>
                                                                <button type="button" class="btn btn-outline-primary m-1 px-5"><?php echo $eveqty;?></button>
                                                                <button type="submit" name="select" value="select" onclick="<?php $eveqty++ ?>" class="btn btn-light-primary m-1"><i class="fadeIn animated bx bx-plus"></i></button> -->
                                                            </div>
															<div class="col-md-12 mb-3">
																<label for="validationCustom01">Mon <?php echo $title?> Quantity</label>
																<input type="number" name="txtMon" class="form-control" value="<?php echo $row['ds_Mon'];?>" required>
                                                                <!-- <button type="button" class="btn btn-light-primary m-1"><i class="fadeIn animated bx bx-minus"></i></button>
                                                                <button type="button" class="btn btn-outline-primary m-1 px-5"><?php echo $eveqty;?></button>
                                                                <button type="submit" name="select" value="select" onclick="<?php $eveqty++ ?>" class="btn btn-light-primary m-1"><i class="fadeIn animated bx bx-plus"></i></button> -->
                                                            </div>
															<div class="col-md-12 mb-3">
																<label for="validationCustom01">Tue <?php echo $title?> Quantity</label>
																<input type="number" name="txtTue" class="form-control" value="<?php echo $row['ds_Tue'];?>" required>
                                                                <!-- <button type="button" class="btn btn-light-primary m-1"><i class="fadeIn animated bx bx-minus"></i></button>
                                                                <button type="button" class="btn btn-outline-primary m-1 px-5"><?php echo $eveqty;?></button>
                                                                <button type="submit" name="select" value="select" onclick="<?php $eveqty++ ?>" class="btn btn-light-primary m-1"><i class="fadeIn animated bx bx-plus"></i></button> -->
                                                            </div>
															<div class="col-md-12 mb-3">
																<label for="validationCustom01">Wed <?php echo $title?> Quantity</label>
																<input type="number" name="txtWed" class="form-control" value="<?php echo $row['ds_Wed'];?>" required>
                                                                <!-- <button type="button" class="btn btn-light-primary m-1"><i class="fadeIn animated bx bx-minus"></i></button>
                                                                <button type="button" class="btn btn-outline-primary m-1 px-5"><?php echo $eveqty;?></button>
                                                                <button type="submit" name="select" value="select" onclick="<?php $eveqty++ ?>" class="btn btn-light-primary m-1"><i class="fadeIn animated bx bx-plus"></i></button> -->
                                                            </div>
															<div class="col-md-12 mb-3">
																<label for="validationCustom01">Thu <?php echo $title?> Quantity</label>
																<input type="number" name="txtThu" class="form-control" value="<?php echo $row['ds_Thu'];?>" required>
                                                                <!-- <button type="button" class="btn btn-light-primary m-1"><i class="fadeIn animated bx bx-minus"></i></button>
                                                                <button type="button" class="btn btn-outline-primary m-1 px-5"><?php echo $eveqty;?></button>
                                                                <button type="submit" name="select" value="select" onclick="<?php $eveqty++ ?>" class="btn btn-light-primary m-1"><i class="fadeIn animated bx bx-plus"></i></button> -->
                                                            </div>
															<div class="col-md-12 mb-3">
																<label for="validationCustom01">Fri <?php echo $title?> Quantity</label>
																<input type="number" name="txtFri" class="form-control" value="<?php echo $row['ds_Fri'];?>" required>
                                                                <!-- <button type="button" class="btn btn-light-primary m-1"><i class="fadeIn animated bx bx-minus"></i></button>
                                                                <button type="button" class="btn btn-outline-primary m-1 px-5"><?php echo $eveqty;?></button>
                                                                <button type="submit" name="select" value="select" onclick="<?php $eveqty++ ?>" class="btn btn-light-primary m-1"><i class="fadeIn animated bx bx-plus"></i></button> -->
                                                            </div>
															<div class="col-md-12 mb-3">
																<label for="validationCustom01">Sat <?php echo $title?> Quantity</label>
																<input type="number" name="txtSat" class="form-control" value="<?php echo $row['ds_Sat'];?>" required>
                                                                <!-- <button type="button" class="btn btn-light-primary m-1"><i class="fadeIn animated bx bx-minus"></i></button>
                                                                <button type="button" class="btn btn-outline-primary m-1 px-5"><?php echo $eveqty;?></button>
                                                                <button type="submit" name="select" value="select" onclick="<?php $eveqty++ ?>" class="btn btn-light-primary m-1"><i class="fadeIn animated bx bx-plus"></i></button> -->
                                                            </div>

                                                            

															<div class="col-md-12 mb-3">
																<label for="validationCustom01">Start Date</label>
																<input type="date" name="txtdate" class="form-control" required>
															</div>

															<div class="col-md-12 mb-3">
																<label for="validationCustom01">Instruction For Delivery Boy</label>
																<input type="text" name="txtinstruction" class="form-control" value="<?php echo $row['order_instructions'];?>">
															</div>

															<div class="col-md-12 mb-3">
																<label for="validationCustom01">Ring the bell or not?</label>
																<select class="form-control" name="txtbell">
																	<option <?php if($row['order_ring_bell']=="1"){?> selected <?php } ?> value="<?php echo $row['order_ring_bell']?>">Bell Ring On</option>
                                                                    <option <?php if($row['order_ring_bell']=="0"){?> selected <?php } ?> value="<?php echo $row['order_ring_bell']?>">Bell Ring Off</option>
																</select>
															
															</div>

															<button type="submit" name="BtnSaveCustomize"class="btn btn-primary m-1 px-5 radius-30">Continue</button>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
												</form>

                                                
                                                

											</div>
										</div>
									</div><?php }?>
								</div>
								
								<?php }}?>

                                

							</div>
						</div>
					</div>
				</div>
			</div>
			<!--end page-content-wrapper-->
		</div>
		<!--end page-wrapper-->
		<!--start overlay-->
		<div class="overlay toggle-btn-mobile"></div>
		<!--end overlay-->
		<!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
		<!--End Back To Top Button-->
		<!--footer -->
		<?php include 'footer.php'?>
		<!-- end footer -->
	</div>
	<!-- end wrapper -->
	<!--start switcher-->

	<!--end switcher-->
	<!-- JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/popper.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<!--plugins-->
	<script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
	<!-- App JS -->
	<script src="assets/js/app.js"></script>
</body>

</html>