<?php
    session_start();
    include 'connection.php';
    $title = "Product";
    $code = "product";
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
	<script src="https://cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script>
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
                        if(isset($_REQUEST["BtnSave$title"]))
                        {
                                $ext=pathinfo($_FILES["txtimg"]["name"],PATHINFO_EXTENSION);
                                $newname=rand(111111,999999).".".$ext;
                                // $newname = "Girorganic" + $newname;
                                move_uploaded_file($_FILES["txtimg"]["tmp_name"],$ADMIN_PRODUCT_IMG.$newname);

                                $result=mysqli_query($conn,"insert into tbl_product (category_id,attribute_id,product_type,product_name,product_image,product_regular_price,product_normal_price,product_des,product_att_value,product_min_qty,product_status) 
                                values ('".$_REQUEST['txtcategory']."','".$_REQUEST['txtattribute']."','".$_REQUEST['txttype']."','".$_REQUEST['txtproduct']."','".$newname."','".$_REQUEST['txtrprice']."','".$_REQUEST["txtnprice"]."','".$_REQUEST['txtdescription']."','".$_REQUEST['txtattval']."','".$_REQUEST['txtmqty']."','1')") or die(mysqli_error($conn));
                                if($result=true)
                                {   
                                    ?><div class="alert alert-success mb-2" role="alert">
                                    <strong>Well done!</strong> <?php $title; ?> has successfully added.
                                    </div><?php
                                        echo "<script>window.location='$code.php';</script>";
                                }
                                else
                                {
                                    echo Error;
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
										<label for="validationCustom01"><?php echo $title; ?> Image (Size : 500 kb & Dimension 417*417)</label>
                                        <input type='file' class="form-control" name="txtimg" accept=".png, .jpg, .jpeg" />
										<!-- <div class="valid-feedback">Looks good!</div> -->
									</div>

                                    <div class="col-md-12 mb-3">
										<label for="validationCustom01"><?php echo $title; ?> Name</label>
										<input type="text" name="txtproduct" class="form-control" required>
										<!-- <div class="valid-feedback">Looks good!</div> -->
									</div>

                                    <div class="col-md-12 mb-3">
										<label for="validationCustom01">Choose <?php echo $title;?> Category</label>
										<select class="form-control" name="txtcategory">
                                                    <option>Select</option>
                                                    <?php
                                                        $result=mysqli_query($conn,"select * from tbl_category where category_status='1'");
                                                        while($row=mysqli_fetch_array($result))
                                                        {
                                                    ?> 
                                                        <option value="<?php echo $row["category_id"];?>"><?php echo $row["category_name"];?></option>
                                                    <?php }?>
                                                </select>
										<!-- <div class="valid-feedback">Looks good!</div> -->
									</div>
									
									<div class="col-md-6 mb-3">
										<label for="validationCustom01">Choose Attribute Value</label>
										<input type="number" name="txtattval" class="form-control" min="0" required>
										<!-- <div class="valid-feedback">Looks good!</div> -->
									</div>
									
                                    <div class="col-md-6 mb-3">
										<label for="validationCustom01">Choose <?php echo $title;?> Attribute</label>
										<select class="form-control" name="txtattribute">
                                                    <option>Select</option>
                                                    <?php
                                                        $result=mysqli_query($conn,"select * from tbl_attribute where attribute_status='1'");
                                                        while($row=mysqli_fetch_array($result))
                                                        {
                                                    ?> 
                                                        <option value="<?php echo $row["attribute_id"];?>"><?php echo $row["attribute_name"];?></option>
                                                    <?php }?>
                                                </select>
										<!-- <div class="valid-feedback">Looks good!</div> -->
									</div>

									
									<div class="col-md-12 mb-3">
										<label for="validationCustom01"><?php echo $title; ?> Description</label>
										
                                        <textarea rows="5" class="form-control" name="txtdescription"></textarea>
										<!-- <div class="valid-feedback">Looks good!</div> -->
									</div>

                                    <div class="col-md-12 mb-3">
										<label for="validationCustom01"><?php echo $title; ?> Price Loyal Customer</label>
										<input type="number" name="txtrprice" class="form-control" step="0.01" min="0" required>
										<!-- <div class="valid-feedback">Looks good!</div> -->
									</div>

                                    <div class="col-md-12 mb-3">
										<label for="validationCustom01"><?php echo $title; ?> Price Normal Customer</label>
										<input type="number" name="txtnprice" class="form-control" step="0.01" min="0" required>
										<!-- <div class="valid-feedback">Looks good!</div> -->
									</div>

                                    <div class="col-md-12 mb-3">
										<label for="validationCustom01">Choose <?php echo $title;?> Type</label>
										<select class="form-control" name="txttype">
                                            <option>Select</option>
                                            <option value="1">Subscription</option>
                                            <option value="2">One Time Purchase</option>
                                        </select>
									</div>
									
                                    <div class="col-md-12 mb-3">
										<label for="validationCustom01">Choose <?php echo $title;?> Minimum Quantity</label>
										<input type="number" name="txtmqty" class="form-control" min="0" required>
									</div>
									
                                    
                                    <!-- <div class="col-md-6 mb-3">
										<label for="validationCustom01">First name</label>
										<input type="text" class="form-control" required>
									</div> -->
                                    
								
								</div>
							
								<button class="btn btn-primary" type="submit" name="BtnSave<?php echo $title;?>">Save <?php echo $title; ?></button>
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
	<script>
        CKEDITOR.replace( 'txtdescription' );
    </script>
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