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
                                unlink($ADMIN_PRODUCT_IMG.$_REQUEST["oldimage"]);
                                $ext=pathinfo($_FILES["txtimage"]["name"],PATHINFO_EXTENSION);
                                $newname=rand(111111,999999).".".$ext;//1258.png
                                move_uploaded_file($_FILES["txtimage"]["tmp_name"],$ADMIN_PRODUCT_IMG.$newname);
                            }
                            else
                            {
                                $newname=$_REQUEST["oldimage"];
                            }
    
                            $product=$_REQUEST["product"];
    
                            $result=mysqli_query($conn,"update tbl_product set product_name='".$_REQUEST["txtproduct"]."',
                            product_image='$newname',
                            category_id='".$_REQUEST["txtcategory"]."',
                            attribute_id='".$_REQUEST["txtattribute"]."',
                            product_regular_price='".$_REQUEST["txtrprice"]."',
                            product_normal_price='".$_REQUEST["txtnprice"]."',
                            product_type='".$_REQUEST["txttype"]."',
                            product_min_qty='".$_REQUEST["txtmqty"]."',
                            product_att_value='".$_REQUEST["txtattval"]."',
                            product_des='".$_REQUEST["txtdescription"]."' where product_id='$product' ") or die(mysqli_error($conn));
                            if($result=true)
                            {
                                ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="mdi mdi-check-all mr-2"></i> <strong>Well done!</strong> Category has Update.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                </div><?php
                                echo "<script>window.location='$code.php';</script>";
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
                            if(isset($_REQUEST["product"]))
                            {
                                $result1=mysqli_query($conn,"select * from tbl_category where category_status ='1'");
                                while($roww=mysqli_fetch_array($result1))
                                {
                                    $name = $roww['category_name'];
                                    $id = $roww['category_id'];
                                }
                                
                                $result1=mysqli_query($conn,"select * from tbl_attribute where attribute_status ='1'");
                                while($roww=mysqli_fetch_array($result1))
                                {
                                    $attribute_name = $roww['attribute_name'];
                                    $attribute_id = $roww['attribute_id'];
                                }
                                
                                $result=mysqli_query($conn,"select * from tbl_product where product_id ='".$_REQUEST["product"]."'");
                                while($row=mysqli_fetch_array($result))
                                {
                                ?> 
								<div class="form-row">
									
                                    <div class="col-md-12 mb-3">
										<label for="validationCustom01"><?php echo $title; ?> Image</label><BR>
                                        
                                        
                                          <input type="hidden" name="oldimage" value="<?php echo $row["product_image"];?>">
                                        <img src="<?php echo $ADMIN_PRODUCT_IMG.$row['product_image']?>" width="150px" height="150px">
                                        <input type='file' class="form-control" name="txtimage" accept=".png, .jpg, .jpeg" />
									</div>

                                    <div class="col-md-12 mb-3">
										<label for="validationCustom01"><?php echo $title; ?> Name</label>
										<input type="text" name="txtproduct" value="<?php echo $row['product_name'];?>" class="form-control" required>
									</div>

                                    <div class="col-md-12 mb-3">
										<label for="validationCustom01">Choose <?php echo $title;?> Category</label>
    										<select name="txtcategory" class="form-control">
                                                <?php
                                                $result1=mysqli_query($conn,"select * from tbl_category");
                                                while($row1=mysqli_fetch_array($result1))
                                                {?>
                                                   <option <?php if($row1['category_id']==$row["category_id"]) { ?> selected <?php } ?> value="<?php echo $row1['category_id'];?>"><?php echo $row1['category_name'];?></option>
                                                    
                                               <?php } ?>
                                         
                                            </select>
										<!-- <div class="valid-feedback">Looks good!</div> -->
									</div>

                                    <div class="col-md-6 mb-3">
										<label for="validationCustom01"><?php echo $title; ?> Attribute Value</label>
										<input type="number" name="txtattval" value="<?php echo $row['product_att_value'];?>" min="0"  class="form-control" required>
									</div>
									
                                    <div class="col-md-6 mb-3">
										<label for="validationCustom01">Choose <?php echo $title;?> Attribute</label>
										<select class="form-control" name="txtattribute">
                                                    <option <?php if($attribute_name=="$attribute_name"){?> selected <?php } ?> value="<?php echo $attribute_id;?>"><?php echo $attribute_name;?></option>
                                                    <?php
                                                    $result1=mysqli_query($conn,"select * from tbl_attribute");
                                                        while($row1=mysqli_fetch_array($result1))
                                                        {?>
                                                           <option <?php if($row1['attribute_id']==$row["attribute_id"]) { ?> selected <?php } ?> value="<?php echo $row1['attribute_id'];?>"><?php echo $row1['attribute_name'];?></option>
                                                        
                                                    <?php } ?>
                                                    
                                                    
                                                </select>
										<!-- <div class="valid-feedback">Looks good!</div> -->
									</div>

									
									<div class="col-md-12 mb-3">
										<label for="validationCustom01"><?php echo $title; ?> Description</label>
										
                                        <textarea rows="5" class="form-control" name="txtdescription"><?php echo $row['product_des'];?></textarea>
									</div>

                                    <div class="col-md-12 mb-3">
										<label for="validationCustom01"><?php echo $title; ?> Price Loyal Customer</label>
										<input type="number" name="txtrprice" value="<?php echo $row['product_regular_price'];?>" step="0.01" min="0"  class="form-control" required>
									</div>

                                    <div class="col-md-12 mb-3">
										<label for="validationCustom01"><?php echo $title; ?> Price Normal Customer</label>
										<input type="number" name="txtnprice" value="<?php echo $row['product_normal_price'];?>" step="0.01" min="0"  class="form-control" required>
										<!-- <div class="valid-feedback">Looks good!</div> -->
									</div>

                                    <div class="col-md-12 mb-3">
										<label for="validationCustom01">Choose <?php echo $title;?> Type</label>
										<select class="form-control" name="txttype">
                                        
                                            <option <?php if($row['product_type']=="1"){?> selected <?php } ?> value="<?php echo $row['product_type']?>">Subscription</option>
                                            <option <?php if($row['product_type']=="2"){?> selected <?php } ?> value="<?php echo $row['product_type']?>">One Time Purchase</option>
                                        </select>
									</div>
									
                                    <div class="col-md-12 mb-3">
										<label for="validationCustom01">Choose <?php echo $title;?> Minimum Quantity</label>
										<input type="number" name="txtmqty" value="<?php echo $row['product_min_qty'];?>" min="0"  class="form-control" required>
										
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