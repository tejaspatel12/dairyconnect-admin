<?php
    session_start();
    include 'connection.php';
    $title = "FAQ";
    $code = "faq";
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
									<li class="breadcrumb-item active" aria-current="page">DataTable</li>
								</ol>
							</nav>
						</div>
						<div class="ml-auto">
							<div class="btn-group">
								<button type="button" onclick="window.location='add_<?php echo $code;?>.php';" class="btn btn-primary">Add <?php echo $title;?>s</button>
							</div>
						</div>
					</div>

					<div class="modal fade text-left" id="danger" tabindex="-1" role="dialog" aria-labelledby="myModalLabel10"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header bg-danger white">
                          <h4 class="modal-title" id="myModalLabel10">Warning!</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form method="post">
                        <div class="modal-body">
                          <h5>Are you sure you want to delete?</h5>
                          <input type="hidden" id="deleteid" name="deleteid"/>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">No</button>
                          <button type="submit" name="btndelete" class="btn btn-outline-danger">Yes</button>
                        </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  

                    <?php
                        if(isset($_REQUEST['statusid']))
                        {
                                if($_REQUEST["val"]=="0")
                                {
                                    mysqli_query($conn,"update tbl_faq set faq_status='1' where faq_id='".$_REQUEST['statusid']."'");
                                }
                                else
                                {
                                    mysqli_query($conn,"update tbl_faq set faq_status='0' where faq_id='".$_REQUEST['statusid']."'");
                                }
                                echo "<script>window.location='$code.php';</script>";
                        }

                        if(isset($_REQUEST['btndelete']))
                        {
                        $result=mysqli_query($conn,"delete from tbl_faq where faq_id='".$_REQUEST['deleteid']."'") or die(mysqli_error($conn));
                        echo "<script>window.location='$code.php';</script>";
                        }
                    ?>

					<!--end breadcrumb-->
					<div class="card">
						<div class="card-body">
							<div class="card-title">
								<h4 class="mb-0"><?php echo $title; ?> DataTable</h4>
							</div>
							<hr/>
							<div class="table-responsive">
								<table id="example" class="table table-striped table-bordered" style="width:100%">
									<thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Question</th>
                                            <th>Answer</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
									</thead>
									<tbody>
                                        <?php
                                            $count=1;
                                            $result=mysqli_query($conn,"select * from tbl_faq");
                                            while($row=mysqli_fetch_array($result))
                                        {?>
                                            <tr>
                                                <td><?php echo $count++;?></td>
                                                <td><?php echo $row['faq_question'];?></td>
                                                <td><?php echo $row['faq_answer'];?></td>
                                                <?php if($row['faq_status']=="1")
                                                {?><td><button type="button" onclick="window.location='<?php echo $code?>.php?statusid=<?php echo $row['faq_id'];?>&val=<?php echo $row['faq_status'];?>';" name="btnno" class="btn btn-success btn-sm m-1">Active </button></td>
                                                <?php }else{
                                                    ?><td><button type="button" onclick="window.location='<?php echo $code?>.php?statusid=<?php echo $row['faq_id'];?>&val=<?php echo $row['faq_status'];?>';" class="btn btn-info btn-sm m-1" name="btnyes">Inactive</button></td>
                                                <?php }?>  
                                                <td>
                                                    <div class="d-flex">
                                                        <!--<button type="button" data-toggle="modal" data-target="#exampleModal7" data-id="<?php echo $row['faq_id'];?>" class="btn btn-outline-danger shadow btn-sm mr-1"><i class="fadeIn animated bx bx-trash-alt open-popup"></i> </button> -->
                                                        <button type="button" data-toggle="modal" data-target="#danger" data-id="<?php echo $row['faq_id'];?>"  class="btn btn-outline-danger shadow btn-sm mr-1 open-dialog"><i class="fadeIn animated bx bx-trash-alt"></i> </button> 
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } ?>
			
									</tbody>
									<tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Question</th>
                                            <th>Answer</th>
                                            <th>Status</th>
                                            <th>Action</th>
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
		</script>
	    <script>
        $(document).on('click','.open-dialog',function(){
            var id = $(this).attr('data-id');
            $('#deleteid').val(id);
        });
    </script>
	<!-- App JS -->
	<script src="assets/js/app.js"></script>
</body>

</html>