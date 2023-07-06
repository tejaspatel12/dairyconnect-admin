<?php
    session_start();
    include 'connection.php';
    $title = "Order";
    $code = "order";
    $status = "1";
    $finalcutoff;
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

						if(isset($_REQUEST["user"], $_REQUEST["product"]))
							{
								$product = $_REQUEST["product"];
								$user = $_REQUEST["user"];

								// $resultuser=mysqli_query($conn,"select * from tbl_user where user_id='".$user."'");
								// while($rowuser=mysqli_fetch_array($resultuser))
								// {
								// 	$usertype = $rowuser["user_type"];
								// }
								$resultuser=mysqli_query($conn,"select * from tbl_time_slot as t left join tbl_deliveryboy as d on d.time_slot_id=t.time_slot_id left join tbl_user as u on d.deliveryboy_id=u.deliveryboy_id where u.user_id='$user'")or die(mysqli_error($conn));
								
								while($rowuser=mysqli_fetch_array($resultuser))
								{
									$usertype = $rowuser["user_type"];
									$cutoff_time = $rowuser["time_slot_cutoff_time"];
								}
								
								$result=mysqli_query($conn,"select * from tbl_product where product_id='".$product."'");
								while($row=mysqli_fetch_array($result))
								{
									$product_name = $row["product_name"];
									$order_amt = $usertype=="1"?$row["product_regular_price"]:$row["product_normal_price"];
									// $product_price = if($usertype=="1"){$row["product_name"];}else{$row["product_name"];}
								}
						}
					?>

					<?php
						if(isset($_REQUEST["BtnSaveOneday"]))
						{
							$order_qty=$_REQUEST["txtqty"];
							$start_date=$_REQUEST["txtdate"];
							// $cdate=$_REQUEST["current_date"];
							$order_instructions=$_REQUEST["txtinstruction"];
							$order_ring_bell=$_REQUEST["txtbell"];
							
							$total_one_amt = $order_amt * $order_qty;
							
							$finalcutoff = date('Y-m-d H:i:s', strtotime("$start_date $cutoff_time"));
							// echo $finalcutoff;
							
							if($cutoff_time == "14:00:00")
							{
								// $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  0 days'));
							}
							elseif($cutoff_time == "22:00:00")
							{
								$finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '-  1 days'));
							}
							else
							{
								
							}
							
					
								$result=mysqli_query($conn,"insert into tbl_order (user_id,product_id,attribute_id,start_date,order_instructions,order_ring_bell,delivery_schedule) 
								values ('$user','$product','2','$start_date','$order_instructions','$order_ring_bell','')") or die(mysqli_error($conn));
								if($result=true)
								{
									$order_id = $conn->insert_id;
				
									$result1=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_one_unit_price,order_total_amt,order_date,oc_cutoff_time,oc_date) 
										values ('$order_id','$product','$user','$order_qty','$order_amt','$total_one_amt','$start_date','".date('Y-m-d H:i:s', strtotime($finalcutoff))."','$start_date')") or die(mysqli_error($conn));
									
									if($result1=true)
									{?>
										<div class="alert alert-success" role="alert">
											<h4 class="alert-heading">Well done!</h4>
											<p><?php echo "Aww yeah. you successfully subscribe $product_name subscription with $qty quantity will deliver from $start_date."?></p>
											<hr>
											<p class="mb-0">
											   <?php echo "<script>window.location='user_detail.php?user=$user';</script>"; ?>
											</p>
										</div>

										
									<?php 
									}
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
                            if(isset($_REQUEST["user"], $_REQUEST["product"]))
                            {
								$user = $_REQUEST["user"];
                                $product = $_REQUEST["product"];

                                $resultuser=mysqli_query($conn,"select * from tbl_user where user_id='".$user."'");
                                while($rowuser=mysqli_fetch_array($resultuser))
                                {
                                    $usertype = $rowuser["user_type"];
                                }

                                $result=mysqli_query($conn,"select * from tbl_product where product_id='".$product."'");
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
                                <?php }}?>
								<!--end row-->
								<ul class="nav nav-pills">
									<li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#Experience"><span class="p-tab-name">One Time</span><i class='bx bx-donate-blood font-24 d-sm-none'></i></a>
									</li>
								</ul>

								<div class="tab-content mt-3">
									<div class="tab-pane fade show active" id="Experience">
										<div class="card shadow-none border mb-0 radius-15">
											<div class="card-body">
												<div class="d-sm-flex align-items-center mb-3">
													<h4 class="mb-0">One Time</h4>
													
													<p class="mb-0 ml-sm-3 text-muted"></p> 

												</div>

                                                <form method="post">
                                                <div class="row">
                                                    <div class="col-12 col-lg-12 border-right">
                                                        <div class="d-md-flex align-items-center">
                                                            <div class="ml-md-4 flex-grow-1" style="margin-top: 1rem;" >
																<div class="col-md-12 mb-3">
																	<label for="validationCustom01"><?php echo $title?> Quantity</label>
																	<input type="number" name="txtqty" class="form-control" required>
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
																	<input type="text" name="txtinstruction" class="form-control">
																</div>

																<div class="col-md-12 mb-3">
																	<label for="validationCustom01">Ring the bell or not?</label>
																	<select class="form-control" name="txtbell">
																		<option>Select</option>
																		<option value="1">Bell Ring On</option>
																		<option value="0">Bell Ring Off</option>
																	</select>
																
																</div>

																<button type="submit" name="BtnSaveOneday" class="btn btn-primary m-1 px-5 radius-30">Continue</button>

                                                            </div>
															</form>
                                                        </div>
                                                    </div>
                                                </div>
											</form>


											</div>
										</div>
									</div>
								</div>

                                

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