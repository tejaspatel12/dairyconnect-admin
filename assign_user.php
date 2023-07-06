<?php
    session_start();
    include 'connection.php';
    $title = "Assign User";
    $code = "assign_user";
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
									<li class="breadcrumb-item active" aria-current="page"><?php echo $title; ?></li>
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
                                $result=mysqli_query($conn,"update tbl_user set deliveryboy_id='".$_REQUEST["txtdel"]."' where user_id='".$_REQUEST["user"]."'") or die(mysqli_error($conn));
                                if($result=true)
                                {   
                                    ?><div class="alert alert-success mb-2" role="alert">
                                    <strong>Well done!</strong> <?php $title; ?> has successfully added.
                                    </div><?php
                                        echo "<script>window.location='approve_user.php';</script>";
                                }
                                else
                                {
                                    echo Error;
                                }
                        }
                    ?>
                    
                    <?php
                        if(isset($_REQUEST["user"]))
                        {
                            $result=mysqli_query($conn,"select area_id from tbl_user where user_id='".$_REQUEST["user"]."'");
                            while($row=mysqli_fetch_array($result))
                            {
                                $area = $row['area_id'];
                            }
                                                            
                                         
                        }
                    ?>
                
					<!--end breadcrumb-->
					<div class="card radius-15">
						<div class="card-body">
							<div class="card-title">
								<h4 class="mb-0"><?php echo $title; ?></h4>
							</div>
							<hr/>
							<!-- <p>Custom styles</p> -->
                            <form method="post" enctype="multipart/form-data">
                                
								<div class="form-row">
									
                                    <div class="col-md-12 mb-3">
										<label>Assign User</label>
										<select class="form-control" name="txtdel">
											<option>Select</option>
											   <?php
                                                $result=mysqli_query($conn,"select * from tbl_deliveryboy as d left join tbl_deliveryboy_area as da on da.deliveryboy_id=d.deliveryboy_id where d.is_deliveryboy_assign='1' and d.deliveryboy_status='1' and d.deliveryboy_registration_complete='1' and da.area_id='".$area."'");
                                                while($row=mysqli_fetch_array($result))
                                                {
                                                            ?> 
                                                                <option value="<?php echo $row["deliveryboy_id"];?>"><?php echo $row["deliveryboy_name"];?></option>
                                                <?php }?>
										</select>
									</div>
                                    
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

</body>

</html>