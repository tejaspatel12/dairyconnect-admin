<?php
    session_start();
    include 'connection.php';
    $title = "Category";
    $code = "category";
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
	<title>Edit <?php echo $title; ?> - <?php echo $webname;?></title>
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
									<li class="breadcrumb-item active" aria-current="page">Edit <?php echo $title; ?></li>
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
                        if(isset($_REQUEST["BtnUpdate$title"]))
                        {
                            if(!empty($_FILES["txtimage"]["name"]))
                            {
                                unlink($ADMIN_CATEGORY_IMG.$_REQUEST["oldimage"]);
                                $ext=pathinfo($_FILES["txtimage"]["name"],PATHINFO_EXTENSION);
                                $newname=rand(111111,999999).".".$ext;//1258.png
                                move_uploaded_file($_FILES["txtimage"]["tmp_name"],$ADMIN_CATEGORY_IMG.$newname);
                            }
                            else
                            {
                                $newname=$_REQUEST["oldimage"];
                            }
    
                            $category=$_REQUEST["category"];
    
                            $result=mysqli_query($conn,"update tbl_category set category_name='".$_REQUEST["txtcategory"]."',category_img='$newname' where category_id='$category' ") or die(mysqli_error($conn));
                            if($result=true)
                            {
                                ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="mdi mdi-check-all mr-2"></i> <strong>Well done!</strong> Category has Update.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                </div><?php
                                echo "<script>window.location='category.php';</script>";
                            }
                        }
                    ?>  
                
					<!--end breadcrumb-->
					<div class="card radius-15">
						<div class="card-body">
							<div class="card-title">
								<h4 class="mb-0">Edit <?php echo $title; ?></h4>
							</div>
							<hr/>
							<!-- <p>Custom styles</p> -->
                            <form method="post" enctype="multipart/form-data">
                            <?php
                            if(isset($_REQUEST["category"]))
                            {
                            
                                $result=mysqli_query($conn,"select * from tbl_category where category_id ='".$_REQUEST["category"]."'");
                                while($row=mysqli_fetch_array($result))
                                {
                                ?> 
								<div class="form-row">
									
                                    <div class="col-md-12 mb-3">
										<label for="validationCustom01"><?php echo $title; ?> Image (Size : 500 kb & Dimension 417*417)</label><BR>
                                        
                                        
                                          <input type="hidden" name="oldimage" value="<?php echo $row["category_img"];?>">
                                        <img src="<?php echo $ADMIN_CATEGORY_IMG.$row['category_img']?>" width="150px" height="150px">
                                        <input type='file' class="form-control" name="txtimage" accept=".png, .jpg, .jpeg" />
									</div>

                                    <div class="col-md-12 mb-3">
										<label for="validationCustom01"><?php echo $title; ?> Name</label>
										<input type="text" name="txtcategory" value="<?php echo $row['category_name'];?>" class="form-control" required>
									</div>

                                    
									
                                    
                                    <!-- <div class="col-md-6 mb-3">
										<label for="validationCustom01">First name</label>
										<input type="text" class="form-control" required>
									</div> -->
                                    
								
								</div>
								<?php }}?>
								<button class="btn btn-primary" type="submit" name="BtnUpdate<?php echo $title;?>">Save <?php echo $title; ?></button>
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