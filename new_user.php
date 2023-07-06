<?php
    session_start();
    include 'connection.php';
    $title = "User";
    $code = "user";
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


                    <?php
                        if(isset($_REQUEST['statusid']))
                        {
                                if($_REQUEST["val"]=="0")
                                {
                                    mysqli_query($conn,"update tbl_user set user_status='1' where user_id='".$_REQUEST['statusid']."'");
                                }
                                else
                                {
                                    mysqli_query($conn,"update tbl_user set user_status='0' where user_id='".$_REQUEST['statusid']."'");
                                }
                                echo "<script>window.location='new_user.php';</script>";
                        }
                        
                        if(isset($_REQUEST['nbalid']))
                        {
                                if($_REQUEST["val"]=="0")
                                {
                                    mysqli_query($conn,"update tbl_user set accept_nagative_balance='1' where user_id='".$_REQUEST['nbalid']."'");
                                }
                                else
                                {
                                    mysqli_query($conn,"update tbl_user set accept_nagative_balance='0' where user_id='".$_REQUEST['nbalid']."'");
                                }
                                echo "<script>window.location='new_user.php';</script>";
                        }

                        if(isset($_REQUEST['btndelete']))
                        {
                        $result=mysqli_query($conn,"delete from tbl_user where user_id='".$_REQUEST['deleteid']."'") or die(mysqli_error($conn));
                        echo "<script>window.location='new_user.php';</script>";
                        }

                        if(isset($_REQUEST['BtnUserTypeUpdate']))
                        {
                            mysqli_query($conn,"update tbl_user set user_type='".$_REQUEST['txttype']."' where user_id='".$_REQUEST['deleteid']."'");
                            echo "<script>window.location='new_user.php';</script>";
                        }

                        if(isset($_REQUEST['BtnUserStatusUpdate']))
                        {
							mysqli_query($conn,"update tbl_user set user_status='".$_REQUEST['txtstatus']."' where user_id='".$_REQUEST['deleteid']."'");
							echo "<script>window.location='new_user.php';</script>";
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
                                            <th width="10%">Name</th>
                                            <th width="10%">Mobile Number</th>
                                            <th width="10%">Area</th>
                                            <th width="10%">Flat</th>
                                            <th width="10%">Balance</th>
                                            <th width="10%">Status</th>
                                            <th width="10%">Action</th>
                                        </tr>
									</thead>
									<tbody>
                                            <?php
                                                    $count=1;
                                                    $result=mysqli_query($conn,"select * from tbl_user as u left join tbl_area as a on a.area_id=u.area_id where u.registration_complete='1' and u.user_status='0'");
                                                    while($row=mysqli_fetch_array($result))
                                                {?>
                                                    <tr>
                                                        <td><?php echo $count++;?></td>
                                                        <td><?php echo $row['user_first_name']." ".$row['user_last_name'];?></td>
                                                        <td><?php echo $row['user_mobile_number'];?></td>
                                                        <td>
                                                            
                                                            <?php if($row['area_id']=="0")
                                                            {?>
                                                                <button type="button" class="btn btn-success btn-sm m-1"><?php echo $row['area'];?> </button><br>
                                                                <h6 id="heading">New</h6>
                                                            <?php }
                                                            else
                                                            {
                                                                echo $row['area_name'];
                                                            } ?>
                                                        </td>
                                                        <td><?php echo $row['user_address'];?></td>
                                                        
                                                        <td><?php echo $row['user_balance'];?></td>
                                                        
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="exampleModal7" tabindex="-1" role="dialog" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content radius-30">
                                                                    <div class="modal-header border-bottom-0">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">	<span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body p-5">
                                                                        <form method="post">
                                                                        <h3 class="text-center">User Status</h3>
                                                                        <input type="hidden" id="deleteid" name="deleteid"/>
                                                                        
                                                                        <div class="form-group">
                                                                            <select class="form-control form-control-lg radius-30" name="txtstatus">
                                                                                <option>Select Status</option>
                                                                                <option value="1">Approve</option>
                                                                                <option value="2">Unapprove</option>
                                                                            </select>
                                                                        </div>
                                                                        <!-- <div class="form-group">
                                                                            <input type="text" name="txtbalance" value="" class="form-control form-control-lg radius-30" />
                                                                        </div>
                                                                        
                                                                        
                                                                        <div class="form-group text-right my-4"> 
                                                                        </div>
                                                                        <div class="form-group">-->
										                                    <button type="submit" class="btn btn-primary radius-30 btn-lg btn-block" name="BtnUserStatusUpdate">Update</button>
                                                                        </div>
                                                                        </form>
                                                                        
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Button trigger modal -->


                                                        <td><button type="button" data-toggle="modal" data-target="#exampleModal7" data-id="<?php echo $row['user_id'];?>" class="btn btn-info btn-sm m-1 open-dialog" name="btnyes">New</button></td>
                                                       
                                                        
                                                        

                                                        <td>
                                                        
                                                            <div class="d-flex">
                                                               
                                                                
                                                                <button type="button" onclick="window.location='<?php echo $code;?>_detail.php?<?php echo $code;?>=<?php echo $row['user_id'];?>';" class="btn btn-outline-primary shadow btn-sm mr-1"><i class="fadeIn animated bx bx-show-alt"></i> </button> 
                                                            </div>
                                                        </td>

                                                    </tr>
                                                <?php } ?>
			
									</tbody>
									<tfoot>
										<tr>
                                            <th>#</th>
                                            <th width="10%">Name</th>
                                            <th width="10%">Mobile Number</th>
                                            <th width="10%">Area</th>
                                            <th width="10%">Flat</th>
                                            <th width="10%">Balance</th>
                                            <th width="10%">Status</th>
                                            <th width="10%">Action</th>
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
	    <script>
        $(document).on('click','.open-dialog',function(){
            var id = $(this).attr('data-id');
            $('#deleteid').val(id);
        });
    </script>
</body>

</html>