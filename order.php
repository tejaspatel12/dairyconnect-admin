<?php
    session_start();
    include 'connection.php';
    $title = "Order";
    $code = "order";
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
	<!--Data Tables -->
	<link href="assets/plugins/datatable/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
	<link href="assets/plugins/datatable/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css">
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
					<div class="page-breadcrumb d-none d-md-flex align-items-center mb-3">
						<div class="breadcrumb-title pr-3">Tables</div>
						<div class="pl-3">
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb mb-0 p-0">
									<li class="breadcrumb-item"><a href="javascript:;"><i class='bx bx-home-alt'></i></a>
									</li>
									<li class="breadcrumb-item active" aria-current="page"><?php echo $title;?> DataTable</li>
								</ol>
							</nav>
						</div>
						<div class="ml-auto">
							<div class="btn-group">
								<!-- <button type="button" class="btn btn-primary">Settings</button> -->
							</div>
						</div>
					</div>
					<!--end breadcrumb-->
					<div class="card">
						<div class="card-body">
							<div class="card-title">
								<h4 class="mb-0">DataTable Example</h4>
							</div>
							<hr/>
							<div class="table-responsive">
								<table id="example" class="table table-striped table-bordered" style="width:100%">
									<thead>
										<tr>
                                            <th>#</th>
                                            <th>User</th>
                                            <th>Deliveryboy</th>
                                            <th>Area</th>
                                            <th>Flat</th>
                                            <th>Product</th>
                                            <th>Date</th>
                                            <th>Quantity</th>
										</tr>
									</thead>
									<tbody>
							    
                                        <?php
                                        $count = 1;
                                        if(isset($_REQUEST["product_id"], $_REQUEST["date"], $_REQUEST["time"]))
                                        {
                            //                 $cf = "22:00:00";
                    					   // $cs = "14:00:00";
                    					    
            					    	    $cf = "09:00:00";
	                                        $cs = "17:00:00";
                    					
                    					    $date = $_REQUEST["date"];
                    					    $product_id = $_REQUEST["product_id"];
                    					    $time = $_REQUEST["time"];
                							 
                							 if($time == '1')
                							 {
                							    $cutoff = date('Y-m-d H:i:s', strtotime("$date $cf"));
                							 //   $cutoff = date('Y-m-d H:i:s', strtotime($cutoff. ' -  1 days')); 
                							 }
                							 elseif($time == '2')
                							 {
                							    $cutoff = date('Y-m-d H:i:s', strtotime("$date $cs"));
                							 }
                							 
                							 //echo " cutoff : ".$cutoff;
                							    
            							    
                                                $result=mysqli_query($conn,"select * from tbl_order_calendar as oc left join tbl_product as p on p.product_id=oc.product_id left join tbl_user as u on u.user_id=oc.user_id left join tbl_area as a on a.area_id=u.area_id left join tbl_deliveryboy as del on del.deliveryboy_id=u.deliveryboy_id where oc.product_id='$product_id' and oc.order_date='$date' and oc.oc_cutoff_time='$cutoff' and oc.oc_is_delivered!='3' and oc.oc_is_delivered!='4'");
                                            } 
                                            while($row=mysqli_fetch_array($result))
                                        {?>
										<tr>
                                                <td><?php echo $count++;?></td>
                                                <td><a href="user_detail.php?user=<?php echo $row['user_id']?>">
                                                    <?php echo $row['user_first_name']." ".$row['user_last_name'];?><br>
                                                    <h6 style="color: #2f4cdd"><?php echo "+91".$row['user_mobile_number'];?></h6></a>
                                                </td>
                                                <td><a href="edit_delivery_boy.php?delivery_boy=<?php echo $row['deliveryboy_id']?>">
                                                    <?php echo $row['deliveryboy_name'];?><br>
                                                    <h6 style="color: #2f4cdd"><?php echo "+91".$row['deliveryboy_mobile'];?></h6></a>
                                                </td>
                                                <td><?php echo $row['area_name'];?></td>
                                                <td><?php echo $row['user_address'];?></td>
                                                <td><?php echo $row['product_name'];?></td>
                                                <td><?php echo $row['order_date'];?></td>
                                               

                                                <td><?php echo $row['order_qty'];?></td>
										</tr>
										<?php }?>
			
									</tbody>
									<tfoot>
										<tr>
                                            <th>#</th>
                                            <th>User</th>
                                            <th>Deliveryboy</th>
                                            <th>Area</th>
                                            <th>Flat</th>
                                            <th>Product</th>
                                            <th>Date</th>
                                            <th>Quantity</th>
										</tr>
									</tfoot>
								</table>
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
	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script src="assets/js/popper.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<!--plugins-->
	<script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
	<!--Data Tables js-->
	<script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
	<script>
		$(document).ready(function () {
			//Default data table
			$('#example').DataTable();
			var table = $('#example2').DataTable({
				lengthChange: false,
				buttons: ['copy', 'excel', 'pdf', 'print', 'colvis']
			});
			table.buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
		});
	</script>
	<!-- App JS -->
	<script src="assets/js/app.js"></script>
</body>

</html>