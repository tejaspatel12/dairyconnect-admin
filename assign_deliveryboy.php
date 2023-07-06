<?php
    session_start();
    include 'connection.php';
    $title = "Assign Delivery Boy";
    $code = "assign_deliveryboy";
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
	<title><?php echo $title; ?> - Bootstrap4 Admin Template</title>
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
								$AreaArr = $_POST['area'];
										foreach($AreaArr as $key => $value)
										{
											$result1=mysqli_query($conn,"insert into tbl_deliveryboy_area (deliveryboy_id,area_id)  			
											values ('".$_REQUEST["delivery_boy"]."','".$value."')") or die(mysqli_error($conn));
										}
										
								if($result1=true)
								{   
									$result=mysqli_query($conn,"update tbl_deliveryboy set is_deliveryboy_assign='1' where deliveryboy_id='".$_REQUEST["delivery_boy"]."'") or die(mysqli_error($conn));
									
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

							<table id="dynamic_field">
								<div class="form-row">
									
                                    <div class="col-md-6 mb-3">
										<label>Assign Area</label>
										<select class="form-control" name="area[]" id="area_id">
											<option>Select Area</option>
											   <?php
                                                $result=mysqli_query($conn,"select * from tbl_area");
                                                while($row=mysqli_fetch_array($result))
                                                {?> 
            											<option value="<?php echo $row["area_id"];?>"><?php echo $row["area_name"];?></option>
            											
                                            <?php }?>
										</select>
									</div>
                                    <div class="col-md-6 mb-3">
										<label></label>
										<button class="btn btn-primary" type="button" name="add" id="add">Add More</button>
									</div>
								</div>
								</table>
							
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

	<script>  
 $(document).ready(function(){  
      var i=1;  
      $('#add').click(function(){  
           i++;  
		   var area_id_html=jQuery('#area_id').html(); 
        //    $('#dynamic_field').append('<div id="row'+i+'" class="form-row"><div class="form-group mb-3 pb-3"><label class="font-w600">Assign Area</label><select class="form-control default-select solid" name="area[]">'+area_id_html+'</select></div> <div class="col-md-3 mb-5"><label></label><button class="btn btn-danger btn_remove" type="button" name="remove" id="'+i+'">X</button></div></div>');  
		   $('#dynamic_field').append('<div id="row'+i+'" class="form-row"><div class="col-md-6 mb-3"><label>Assign Area</label><select class="form-control" name="area[]">'+area_id_html+'</select></div><div class="col-md-3 mb-5"><label></label><button class="btn btn-danger btn_remove" type="button" name="remove" id="'+i+'">X</button></div></div>');  
      });  
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  
      $('#submit').click(function(){            
           $.ajax({  
                url:"name.php",  
                method:"POST",  
                data:$('#add_name').serialize(),  
                success:function(data)  
                {  
                     alert(data);  
                     $('#add_name')[0].reset();  
                }  
           });  
      });  
 });  
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