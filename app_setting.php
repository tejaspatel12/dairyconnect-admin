<?php
    session_start();
    include 'connection.php';
    $title = "App Setting";
    $code = "app_setting";
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
                                if(!empty($_FILES["txtimg"]["name"]))
                                {
                                    unlink($ADMIN_MENU_IMG.$_REQUEST["oldimage"]);
                                    $ext=pathinfo($_FILES["txtimg"]["name"],PATHINFO_EXTENSION);
                                    $newname=rand(111111,999999).".".$ext;//1258.png
                                    move_uploaded_file($_FILES["txtimg"]["tmp_name"],$ADMIN_MORE_IMG.$newname);
                                }
                                else
                                {
                                    $newname=$_REQUEST["oldimg"];
                                }

                                if(!empty($_FILES["txtimage"]["name"]))
                                {
                                    unlink($ADMIN_MENU_IMG.$_REQUEST["oldfavimage"]);
                                    $ext=pathinfo($_FILES["txtimage"]["name"],PATHINFO_EXTENSION);
                                    $newfavname=rand(111111,999999).".".$ext;//1258.png
                                    move_uploaded_file($_FILES["txtimage"]["tmp_name"],$ADMIN_MORE_IMG.$newfavname);
                                }
                                else
                                {
                                    $newfavname=$_REQUEST["oldimage"];
                                }

                                $app_id='1';

                                $result=mysqli_query($conn,"update tbl_app_setting set app_otp='$newname',app_login='$newfavname' where app_id ='$app_id' ") or die(mysqli_error($conn));
                                if($result=true)
                                {
                                    ?>
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="mdi mdi-check-all mr-2"></i> <strong>Well done!</strong> App Setting has Update.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    </div><?php
                                    echo "<script>window.location='app_setting.php';</script>";
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
                             <?php
                            $web_id='1';
                            if(isset($web_id))
                            {
                                
                                $result=mysqli_query($conn,"select * from tbl_app_setting where app_id ='".$web_id."'");
                                while($row=mysqli_fetch_array($result))
                                {
                                ?> 
								<div class="form-row">
									
                                    <div class="col-md-12 mb-3">
										<label for="validationCustom01">Login Image</label><BR>
                                        
                                        
                                          <input type="hidden" name="oldimage" value="<?php echo $row["app_login"];?>">
                                        <img src="<?php echo $ADMIN_MORE_IMG.$row['app_login']?>" width="150px" height="150px">
                                        <input type='file' class="form-control" name="txtimage" accept=".png, .jpg, .jpeg" />
									</div>
									
									<div class="col-md-12 mb-3">
										<label for="validationCustom01">OTP Image</label><BR>
                                        
                                        
                                          <input type="hidden" name="oldimg" value="<?php echo $row["app_otp"];?>">
                                        <img src="<?php echo $ADMIN_MORE_IMG.$row['app_otp']?>" width="150px" height="150px">
                                        <input type='file' class="form-control" name="txtimg" accept=".png, .jpg, .jpeg" />
									</div>

                                    
                                    
								
								</div>
								<?php }}?>
								<button class="btn btn-primary" type="submit" name="BtnSave">Update <?php echo $title; ?></button>
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