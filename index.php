<?php
	session_start();
	include 'connection.php';
	$Code = "Home";
	if(!isset($_SESSION["admin_id"]))
	{
		echo "<script>window.location='login.php';</script>";
	}
	$cat_res=mysqli_query($conn,"select * from tbl_admin where admin_id='".$_SESSION["admin_id"]."'");
	$cat_arr=array();
	while($row=mysqli_fetch_assoc($cat_res)){
		$cat_arr[]=$row;	
	}
	
	

	$date = date("Y-m-d");
    // $date = "2022-12-01";
	
	$cf = "09:00:00";
	$cs = "17:00:00";


	$mor = "00:00:00";
	$morend = "16:59:59";
	
	$evn = "17:00:00";
	$evnend = "23:59:59";

	$curdate = date("Y-m-d H:i:s");
    // $curdate = "2022-12-01 05:00:00";
	
	$first = date('Y-m-d H:i:s', strtotime("$date $mor"));
	$sec = date('Y-m-d H:i:s', strtotime("$date $morend"));
	
	
	$thr = date('Y-m-d H:i:s', strtotime("$date $evn"));
	$fur = date('Y-m-d H:i:s', strtotime("$date $evnend"));
	
	
	if(($first < $curdate) && ($curdate < $sec))
	{
		$time = 1;
		$cutoff = date('Y-m-d H:i:s', strtotime("$date $cf"));
		$day = "Morning";
		
		$newdate = $date;

	}
	elseif(($thr < $curdate) && ($curdate < $fur))
	{
		$time = 2;
		$cutoff = date('Y-m-d H:i:s', strtotime("$date $cs"));
		$day = "Evening";
		
		$newdate = $date;
	}
	else
	{}
	
// 	if($day="Next Morning")
//     {
        
//     } 
//     else
//     {
//         $newdate = $date;
        
//     }
	
?>
		<!DOCTYPE html>
		<html lang="en">

		<head>
			<!-- Required meta tags -->
			<meta charset="utf-8" />
			<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
			<title><?php echo $Code; ?> - <?php echo $webname;?></title>
			<!--favicon-->
			<link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" />
			<!-- Vector CSS -->
			<link href="assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
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
							<div class="row">
								<div class="col-12 col-lg-3">
									<div class="card radius-15 bg-voilet">
										<div class="card-body">
											<div class="d-flex align-items-center">
												<div>
													<h2 class="mb-0 text-white">
														<?php
															$result=mysqli_query($conn,"select oc_id from tbl_order_calendar where oc_is_delivered='1' and order_date='$newdate'");
															echo mysqli_num_rows($result);
														?> 
													<i class='bx bxs-up-arrow-alt font-14 text-white'></i> </h2>
												</div>
												<div class="ml-auto font-35 text-white"><i class="bx bx-cart-alt"></i>
												</div>
											</div>
											<div class="d-flex align-items-center">
												<div>
													<p class="mb-0 text-white">Item Delivered</p>
												</div>
												<div class="ml-auto font-14 text-white"></div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-12 col-lg-3">
									<div class="card radius-15 bg-primary-blue">
										<div class="card-body">
											<div class="d-flex align-items-center">
												<div>
													<h2 class="mb-0 text-white">0 <i class='bx bxs-down-arrow-alt font-14 text-white'></i> </h2>
												</div>
												<div class="ml-auto font-35 text-white"><i class="bx bx-support"></i>
												</div>
											</div>
											<div class="d-flex align-items-center">
												<div>
													<p class="mb-0 text-white">Refund Requests</p>
												</div>
												<div class="ml-auto font-14 text-white"></div>
											</div>
										</div>
									</div>
								</div>

								

								<div class="col-12 col-lg-3">
								    <a href="not_delivered.php?date=<?php echo $newdate?>&time=<?php echo $time?>">
									<div class="card radius-15 bg-rose">
										<div class="card-body">
											<div class="d-flex align-items-center">
												<div>
													<h2 class="mb-0 text-white">
														
														<?php
															$result=mysqli_query($conn,"select order_id from tbl_order_calendar where order_date='$newdate' and oc_notdelivered_issue='1'");
															echo mysqli_num_rows($result);
														?> 
														<i class='bx bxs-up-arrow-alt font-14 text-white'></i> </h2>
												</div>
												<div class="ml-auto font-35 text-white"><i class="bx bx-tachometer"></i>
												</div>
											</div>
											<div class="d-flex align-items-center">
												<div>
													<p class="mb-0 text-white">Not Delivered</p>
												</div>
												<div class="ml-auto font-14 text-white"></div>
											</div>
										</div>
									</div>
									</a>
								</div>
								<div class="col-12 col-lg-3">
								    <a href="new_user.php">
									<div class="card radius-15 bg-sunset">
										<div class="card-body">
											<div class="d-flex align-items-center">
												<div>
													<h2 class="mb-0 text-white">
														<?php
															$result=mysqli_query($conn,"select user_id from tbl_user where registration_complete='1' and user_status='0'");
															echo mysqli_num_rows($result);
														?> 
													<i class='bx bxs-up-arrow-alt font-14 text-white'></i> </h2>
												</div>
												<div class="ml-auto font-35 text-white"><i class="bx bx-user"></i>
												</div>
											</div>
											<div class="d-flex align-items-center">
												<div>
													<p class="mb-0 text-white">New Users</p>
												</div>
												<div class="ml-auto font-14 text-white"></div>
											</div>
										</div>
									</div>
									</a>
								</div>
							</div>
							
							
							<div class="row">
								<div class="col-12 col-lg-3">
								    <a href="add_user.php">
									<div class="card radius-15 bg-sunset">
										<div class="card-body">
											<div class="d-flex align-items-center">
												<div>
													<h2 class="mb-0 text-white">
													
													<i class='bx bxs-up-arrow-alt font-14 text-white'></i> </h2>
												</div>
												<div class="ml-auto font-35 text-white"><i class="bx bx-user"></i>
												</div>
											</div>
											<div class="d-flex align-items-center">
												<div>
													<p class="mb-0 text-white">Add User</p>
												</div>
												<div class="ml-auto font-14 text-white"></div>
											</div>
										</div>
									</div>
									</a>
								</div>
								<div class="col-12 col-lg-3">
								    <a href="add_delivery_boy.php">
									<div class="card radius-15 bg-rose">
										<div class="card-body">
											<div class="d-flex align-items-center">
												<div>
												</div>
												<div class="ml-auto font-35 text-white"><i class="bx bx-user"></i>
												</div>
											</div>
											<div class="d-flex align-items-center">
												<div>
													<p class="mb-0 text-white">Add Delivery Boy</p>
												</div>
												<div class="ml-auto font-14 text-white"></div>
											</div>
										</div>
									</div>
									</a>
								</div>

								
							</div>
							
							<!--end row-->

							<!--end row-->
							
                            <div class="card radius-15">
                                <div class="card-header border-bottom-0">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <h5 class="mb-0"><?php echo $newdate." ".$day?> Orders</h5>
                                            <p class="mb-0" style="color:red"><?php echo "Cut-Off Time : ".$cutoff ?></p>
                                        </div>
                                        <div class="ml-auto">
                                            <button type="button" class="btn btn-white radius-15">View More</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Photo</th>
                                                    <th>Product Name</th>
                                                    <th>Qty</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $count=1;
                                                    
                                                    
                                                    $result=mysqli_query($conn,"SELECT o.*, p.*, SUM( o.order_qty ) as quantity FROM  `tbl_order_calendar` o JOIN tbl_product p ON p.product_id = o.product_id where o.order_date='$newdate' and o.oc_cutoff_time='$cutoff' and o.oc_is_delivered!='3' and o.oc_is_delivered!='4' GROUP BY p.product_id");
                                                
                                                    while($row=mysqli_fetch_array($result))
                                                {?>

    
                                                <tr>
                                                    <td>
                                                        <div class="product-img bg-transparent border">
                                                            <img src="<?php echo $ADMIN_PRODUCT_IMG.$row['product_image'];?>" width="35" alt="">
                                                        </div>
                                                    </td>
                                                    <td><?php echo $row['product_name'];?></td>

                                                    <td>
                                                    
                                                        <?php echo  $row["quantity"];?>

                                                    </td>
                                                    <td>
                                                        <!--<a href='index.php?BtnShowQty=<?php echo $row["product_id"];?>' class="btn btn-sm btn-light-primary radius-10">Show Quntity</a>-->
                                                        <a href='order.php?product_id=<?php echo $row["product_id"];?>&date=<?php echo $newdate;?>&time=<?php echo $time;?>' class="btn btn-sm btn-light-success radius-10">Show Order</a>
                                                    </td>
                                                </tr>
                                                
                                                <?php }?>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


							<!--end row-->

							<!--end row-->


                            <div class="card radius-15">
								<div class="card-header border-bottom-0">
									<div class="d-flex align-items-center">
										<div>
											<h5 class="mb-0"><?php echo $day?> Delivery Boy Inventory</h5>
										</div>
									</div>
								</div>
								<div class="card-body p-0">
									<div class="table-responsive">
										<table class="table mb-0">
											<thead>
												<tr>
													<th>Delivery Boy Name</th>
													<th>Inventory</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
											    <?php
													$count=1;
													
												// 	SELECT * from tbl_deliveryboy as d left join tbl_user as u on u.deliveryboy_id=d.deliveryboy_id left join tbl_order_calendar as oc on oc.user_id=u.user_id left join tbl_product as p on p.product_id=oc.product_id where oc.order_date='2022-02-11' GROUP BY d.deliveryboy_id;
												
												    // SELECT o.*, p.*, SUM( o.order_qty ) as quantity FROM  `tbl_order_calendar` o left join tbl_user as u on u.user_id=o.user_id left join tbl_deliveryboy as d on d.deliveryboy_id=u.deliveryboy_id where o.order_date='$date' and o.oc_cutoff_time='$cutoff' and o.oc_is_delivered!='3' and o.oc_is_delivered!='4' GROUP BY d.deliveryboy_id
        													
													$result=mysqli_query($conn,"SELECT d.*,oc.*,p.*,SUM( oc.order_qty ) as quantity from tbl_deliveryboy as d left join tbl_user as u on u.deliveryboy_id=d.deliveryboy_id left join tbl_order_calendar as oc on oc.user_id=u.user_id left join tbl_product as p on p.product_id=oc.product_id where oc.order_date='$newdate' and oc.oc_cutoff_time='$cutoff' and oc.oc_is_delivered!='3' and oc.oc_is_delivered!='4' GROUP BY d.deliveryboy_id");
													
												// 	GROUP BY d.deliveryboy_id
        												
													while($row=mysqli_fetch_array($result))
												    {?>
        												
												<tr>
													<td><?php echo $row['deliveryboy_name'] ?></td>
													<td><?php echo $row['quantity'];?> </td>
													<td>
                                                        <a href='deliveryboy_inventory.php?deliveryboy=<?php echo $row["deliveryboy_id"];?>&date=<?php echo $newdate;?>&time=<?php echo $time;?>' class="btn btn-sm btn-light-success radius-10">Show Order</a>
                                                    </td>
												</tr>
												<?php }?>
												
											</tbody>
										</table>
									</div>
								</div>
							</div>
							
							
							
							
							
							<div class="row">
						<div class="col-12 col-lg-2">
						    <a href="http://nooranidairyfarm.activeapp.in/assets/app/userapp.apk" target="_blank">
							<div class="card radius-15 bg-info">
								<div class="card-body text-center">
									<div class="widgets-icons mx-auto rounded-circle bg-white"><i class="bx bx-download"></i>
									</div>
									<br>
									<!--<h4 class="mb-0 font-weight-bold mt-3 text-white">User App</h4>-->
									<p class="mb-0 text-white">User App</p>
								</div>
							</div>
							</a>
						</div>
						<div class="col-12 col-lg-2">
						    
						    <a href="http://nooranidairyfarm.activeapp.in/assets/app/deliveryboy.apk" target="_blank">
							<div class="card radius-15 bg-wall">
								<div class="card-body text-center">
									<div class="widgets-icons mx-auto bg-white rounded-circle"><i class="bx bx-download"></i>
									</div>
									<br>
									<!--<h4 class="mb-0 font-weight-bold mt-3 text-white">574</h4>-->
									<p class="mb-0 text-white">Delivery boy</p>
								</div>
							</div>
						</div>
						</a>
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
				<?php include 'footer.php';?>
				<!-- end footer -->
			</div>
			<!--start switcher-->
			<div class="switcher-wrapper">
				<div class="switcher-btn"> <i class='bx bx-cog bx-spin'></i>
				</div>
				<div class="switcher-body">
					<h5 class="mb-0 text-uppercase">Theme Customizer</h5>
					<hr/>
					<h6 class="mb-0">Theme Styles</h6>
					<hr/>
					<div class="d-flex align-items-center justify-content-between">
						<div class="custom-control custom-radio">
							<input type="radio" id="darkmode" name="customRadio" class="custom-control-input">
							<label class="custom-control-label" for="darkmode">Dark Mode</label>
						</div>
						<div class="custom-control custom-radio">
							<input type="radio" id="lightmode" name="customRadio" checked class="custom-control-input">
							<label class="custom-control-label" for="lightmode">Light Mode</label>
						</div>
					</div>
					<hr/>
					<div class="custom-control custom-switch">
						<input type="checkbox" class="custom-control-input" id="DarkSidebar">
						<label class="custom-control-label" for="DarkSidebar">Dark Sidebar</label>
					</div>
					<hr/>
					<div class="custom-control custom-switch">
						<input type="checkbox" class="custom-control-input" id="ColorLessIcons">
						<label class="custom-control-label" for="ColorLessIcons">Color Less Icons</label>
					</div>
				</div>
			</div>
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
			<!-- Vector map JavaScript -->
			<script src="assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js"></script>
			<script src="assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js"></script>
			<script src="assets/plugins/vectormap/jquery-jvectormap-in-mill.js"></script>
			<script src="assets/plugins/vectormap/jquery-jvectormap-us-aea-en.js"></script>
			<script src="assets/plugins/vectormap/jquery-jvectormap-uk-mill-en.js"></script>
			<script src="assets/plugins/vectormap/jquery-jvectormap-au-mill.js"></script>
			<script src="assets/plugins/apexcharts-bundle/js/apexcharts.min.js"></script>
			<script src="assets/js/index2.js"></script>
			<!-- App JS -->
			<script src="assets/js/app.js"></script>
		</body>

		</html>