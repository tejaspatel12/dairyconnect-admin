<?php
    session_start();
    include 'connection.php';
    $title = "Invoice";
    $code = "invoice";
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
					
					<!--end breadcrumb-->
					<div class="user-profile-page">
						<div class="card radius-15">
							<div class="card-body">
                            
								<!--end row-->
								
                              
								<div class="tab-content mt-3">
									<div class="tab-pane fade show active" id="Experience">
										<div class="card shadow-none border mb-0 radius-15">
											<div class="card-body">
												<div class="d-sm-flex align-items-center mb-3">
													<h4 class="mb-0">Invoice</h4>
													
													<p class="mb-0 ml-sm-3 text-muted"></p> 

												</div>
											<form method="post" action="invoice/deliveryboy_invoice.php">
                                                <div class="row">
                                                    <div class="col-12 col-lg-12 border-right">
                                                        <div class="d-md-flex align-items-center">
                                                            <div class="ml-md-4 flex-grow-1" style="margin-top: 1rem;" >
															

																<div class="col-md-12 mb-3">
																	<label for="validationCustom01">Start Date</label>
																	<input type="date" name="txtsdate" class="form-control" required>
																	<input type="hidden" name="txtdelivery_boy" value="<?php echo $_REQUEST["delivery_boy"];?>" class="form-control" required>
																</div>

																<div class="col-md-12 mb-3">
																	<label for="validationCustom01">End Date</label>
																	<input type="date" name="txtedate" class="form-control" required>
																</div>

																<button type="submit" name="BtnDeliveryBoyInvoice" class="btn btn-primary m-1 px-5 radius-30">Continue</button>

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