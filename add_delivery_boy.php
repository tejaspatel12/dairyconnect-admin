<?php
    session_start();
    include 'connection.php';
    $title = "Delivery Boy";
    $code = "delivery_boy";
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
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
					<div class="page-breadcrumb d-none d-md-flex align-items-center mb-3">
						<!-- <div class="breadcrumb-title pr-3">Forms</div> -->
						<div class="pl-3">
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb mb-0 p-0">
									<li class="breadcrumb-item"><a href="javascript:;"><i class='bx bx-home-alt'></i></a>
									</li>
									<li class="breadcrumb-item active" aria-current="page">Add <?php echo $title; ?></li>
								</ol>
							</nav>
						</div>
						<div class="ml-auto">
							<div class="btn-group">
								<!-- <button type="button" class="btn btn-primary"><?php echo $title; ?></button> -->
							</div>
						</div>
					</div>
					
                    <?php
                        if(isset($_REQUEST["BtnSave"]))
                        {
                            $sql=mysqli_query($conn,"select * from tbl_deliveryboy where deliveryboy_mobile_number='".$_REQUEST["txtnumber"]."'");
                            if(mysqli_num_rows($sql)>0)
                            {
                                ?><div class="alert alert-danger mb-2" role="alert">
                                <strong>Error!</strong> Duplicate Mobile Number.
                              </div><?php
                            }
                            else
                            {
                                
                                
                                
                                $result=mysqli_query($conn,"insert into tbl_deliveryboy (deliveryboy_name,deliveryboy_email,deliveryboy_mobile,deliveryboy_password,deliveryboy_status,deliveryboy_registration_complete) 
                                values ('".$_REQUEST['txtfname']."','".$_REQUEST['txtemail']."','".$_REQUEST['txtnumber']."','".$_REQUEST['txtpass']."','1','1')") or die(mysqli_error($conn));
                                if($result=true)
                                {   
                                    ?><div class="alert alert-success mb-2" role="alert">
                                    <strong>Well done!</strong> <?php $title; ?> has successfully added.
                                    </div><?php
                                        echo "<script>window.location='delivery_boy.php';</script>";
                                }
                                else
                                {
                                    echo Error;
                                }
                                                        
                            }
                        }
                    ?>
                
					<!--end breadcrumb-->
					<div class="card radius-15">
						<div class="card-body">
							<div class="card-title">
								<h4 class="mb-0">Add <?php echo $title; ?></h4>
							</div>
							<hr/>
							<!-- <p>Custom styles</p> -->
                            <form method="post" enctype="multipart/form-data">
								<div class="form-row">

                                    <div class="col-md-12 mb-3">
										<label for="validationCustom01"><?php echo $title; ?> Name</label>
										<input type="text" name="txtfname" class="form-control" required>
										<!-- <div class="valid-feedback">Looks good!</div> -->
									</div>
									
									<div class="col-md-12 mb-3">
										<label for="validationCustom01"><?php echo $title; ?> Email</label>
										<input type="text" name="txtemail" class="form-control">
										<!-- <div class="valid-feedback">Looks good!</div> -->
									</div>
									
									<div class="col-md-12 mb-3">
										<label for="validationCustom01"><?php echo $title; ?> Mobile Number</label>
										<input type="number" name="txtnumber" class="form-control" maxlength="10" required>
										<!-- <div class="valid-feedback">Looks good!</div> -->
									</div>
									
									<div class="col-md-12 mb-3">
										<label for="validationCustom01"><?php echo $title; ?> Password</label>
										<input type="password" name="txtpass" class="form-control" required>
										<!-- <div class="valid-feedback">Looks good!</div> -->
									</div>
									
									
								
                                    
									
                                    
                                    <!-- <div class="col-md-6 mb-3">
										<label for="validationCustom01">First name</label>
										<input type="text" class="form-control" required>
									</div> -->
                                    
								
								</div>
							
								<button class="btn btn-primary" type="submit" name="BtnSave">Save <?php echo $title; ?></button>
							</form>

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
		<?php include 'footer.php';?>
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
	<script src="assets/js/bs-custom-file-input.min.js"></script>
	<!--plugins-->
	<script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
	<!-- App JS -->
	<script src="assets/js/app.js"></script>
	
	
                <!-- This file is must for ajex data -->
            <!-- This file is must for ajex data -->
        <!-- This file is must for ajex data -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <!-- This file is must for ajex data -->
            <!-- This file is must for ajex data -->
                <!-- This file is must for ajex data -->
                
	<script>
        function loadstatecountrywise(country_id)
        {
            $.ajax('loadstate.php', {
                type: 'POST',  
                data: { id: country_id},
                success: function (data, status, xhr) {
                $('#state').html(data);
                },
                error: function (jqXhr, textStatus, errorMessage) {
                }
            });
        }  

        function loadcitystatewise(state_id)
        {
            $.ajax('loadcity.php', {
                type: 'POST',  
                data: { id: state_id},
                success: function (data, status, xhr) {
                $('#city').html(data);
                },
                error: function (jqXhr, textStatus, errorMessage) {
                }
            });
        }  

        function loadareacitywise(city_id)
        {
            $.ajax('loadarea.php', {
                type: 'POST',  
                data: { id: city_id},
                success: function (data, status, xhr) {
                $('#area').html(data);
                },
                error: function (jqXhr, textStatus, errorMessage) {
                }
            });
        }  
    </script>

	
	<script>
	(function($) {
	 
		var table = $('#example5').DataTable({
			searching: false,
			paging:true,
			select: false,
			//info: false,         
			lengthChange:false 
			
		});
		$('#example tbody').on('click', 'tr', function () {
			var data = table.row( this ).data();
			
		});
	   
	})(jQuery);
	</script>
</body>

</html>