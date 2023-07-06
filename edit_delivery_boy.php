<?php
    session_start();
    include 'connection.php';
    $title = "Delivery Boy";
    $code = "delivery_boy";
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
    $date = date("Y-m-d");
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
						<div class="breadcrumb-title pr-3"><?php echo $title?> Profile</div>
						<div class="pl-3">
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb mb-0 p-0">
									<li class="breadcrumb-item"><a href="javascript:;"><i class='bx bx-home-alt'></i></a>
									</li>
									<li class="breadcrumb-item active" aria-current="page"><?php echo $title?> Profile</li>
								</ol>
							</nav>
						</div>
						<div class="ml-auto">
							<div class="btn-group">
								
							</div>
						</div>
					</div>
					<!--end breadcrumb-->
					<div class="user-profile-page">
						<div class="card radius-15">
							<div class="card-body">
							<?php
							    if(isset($_REQUEST['BtnUserSequence']))
                        {
                        // $seq = $_REQUEST['txtsequence'];
                        $id = $_REQUEST["delivery_boy"];
                        $result=mysqli_query($conn,"update tbl_user set sorting_no='".$_REQUEST['txtsequence']."' where user_id='".$_REQUEST['deleteid']."'");
                        echo "<script>window.location='edit_delivery_boy.php?delivery_boy=$id';</script>";
                        }
							?>
                            <?php
                            if(isset($_REQUEST["delivery_boy"]))
                            {
                                
                                $result1234=mysqli_query($conn,"select * from tbl_deliveryboy_area as da left join tbl_area as a on a.area_id=da.area_id where da.deliveryboy_id='".$_REQUEST["delivery_boy"]."'");
                                    $x = array();
                                    $i=1;
                                    while($row1234=mysqli_fetch_array($result1234))
                                    {
                                        $x[$i] = $row1234["area_name"];
                                        $i++;
                                    }
                                        
                                $result=mysqli_query($conn,"select * from tbl_deliveryboy where deliveryboy_id ='".$_REQUEST["delivery_boy"]."'");
                                while($row=mysqli_fetch_array($result))
                                {
                                ?> 
								<div class="row">
									<div class="col-12 col-lg-7 border-right">
										<div class="d-md-flex align-items-center">
											<div class="mb-md-0 mb-3">
												<!-- <img src="https://via.placeholder.com/110x110" class="rounded-circle shadow" width="130" height="130" alt="" /> -->
                                                <img src="images/logo.png" class="rounded-circle shadow" width="130" height="130" alt="" />
											</div>
											<div class="ml-md-4 flex-grow-1">
												<div class="d-flex align-items-center mb-1">
													<h4 class="mb-0"><?php echo $row["deliveryboy_first_name"]. " ".$row["deliveryboy_last_name"];?></h4>
												
												</div>
												
												<p class="text-primary"><i class='bx bx-phone'></i> <?php echo "+91".$row["deliveryboy_mobile_number"];?></p>
												
												
												
												<hr>
												<p><b>Area :</b></p>
												<?php
                                                    echo $x["1"]."<br>";
                                                    echo $x["2"]."<br>";
                                                    echo $x["3"]."<br>";
												?>
                                                    
												

											</div>
										</div>
									</div>
									<div class="col-12 col-lg-5">
										<table class="table table-sm table-borderless mt-md-0 mt-3">
											<tbody>
												<tr>
													<th>Number:</th>
													<td><?php echo "+91".$row["deliveryboy_mobile_number"];?>
													</td>
												</tr>
												<tr>
													<th>Email:</th>
													<td><?php echo $row["deliveryboy_email"];?></td>
												</tr>
												<!-- <tr>
													<th>Years experience:</th>
													<td>6</td>
												</tr> -->
											</tbody>
										</table>
										<div class="mb-3 mb-lg-0"> 
                                            <!-- <a href="javascript:;" class="btn btn-sm btn-link"><i class='bx bxl-github'></i></a> -->
											<a href="www.wa.me/<?php $row["deliveryboy_mobile_number"];?>" target="_blank" class="btn btn-sm btn-link"><i class='bx bxl-whatsapp'></i></a>
											<!-- <a href="javascript:;" class="btn btn-sm btn-link"><i class='bx bxl-facebook'></i></a>
											<a href="javascript:;" class="btn btn-sm btn-link"><i class='bx bxl-linkedin'></i></a>
											<a href="javascript:;" class="btn btn-sm btn-link"><i class='bx bxl-dribbble'></i></a>
											<a href="javascript:;" class="btn btn-sm btn-link"><i class='bx bxl-stack-overflow'></i></a> -->
										</div>
									</div>
								</div>
                                <?php }}?>
								<!--end row-->
								<ul class="nav nav-pills">
                                    <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#Experience"><span class="p-tab-name">Users</span><i class='bx bx-donate-blood font-24 d-sm-none'></i></a>
									</li>
									<li class="nav-item"> <a class="nav-link" id="profile-tab" data-toggle="tab" href="#Biography"><span class="p-tab-name">Today Orders</span><i class='bx bxs-user-rectangle font-24 d-sm-none'></i></a>
									</li>
									<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#Edit-Profile"><span class="p-tab-name">Edit Profile</span><i class='bx bx-message-edit font-24 d-sm-none'></i></a>
									</li>
									<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#Document"><span class="p-tab-name">Document</span><i class='bx bx-message-edit font-24 d-sm-none'></i></a>
									</li>
								</ul>
								<div class="tab-content mt-3">
                                	<div class="tab-pane fade show active" id="Experience">
                                    	<div class="card shadow-none border mb-0 radius-15">
											<div class="card-body">
												<div class="d-sm-flex align-items-center mb-3">
													<h4 class="mb-0">Users</h4>
													<!-- <p class="mb-0 ml-sm-3 text-muted">3 Job History</p> <a href="javascript:;" class="btn btn-primary ml-auto radius-10"><i class='bx bx-plus'></i> Add More</a> -->
												</div>

                                                <div class="table-responsive">
                                                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>User</th>
                                                                <th>Mobile Number</th>
                                                                <th>Area</th>
                                                                <th>Flat</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                if(isset($_REQUEST["delivery_boy"]))
                                                                {
                                                                    $count= 1;
                                                                    // $result=mysqli_query($conn,"select * from tbl_deliveryboy as d left join tbl_user as u on u.deliveryboy_id=d.deliveryboy_id left join tbl_order_calendar as oc on oc.user_id=u.user_id left join tbl_product as p on oc.product_id=p.product_id where d.deliveryboy_id ='".$_REQUEST["delivery_boy"]."'");
                                                                    $result=mysqli_query($conn,"select * from tbl_user as u left join tbl_area as a on u.area_id=a.area_id where deliveryboy_id ='".$_REQUEST["delivery_boy"]."' order by u.sorting_no + 0 asc");
                                                                    while($row=mysqli_fetch_array($result))
                                                                    {
                                                            ?> 
                                                            <tr>
                                                                    <td><?php echo $count++;?></td>
                                                                    <td title="<?php echo $row['user_id'];?> ">
                                                                        <?php echo $row['user_first_name']." ".$row['user_last_name'];?> 
                                                                    </td>
																	<td><?php echo "+91".$row['user_mobile_number'];?></td>
                                                                    <td><?php echo $row['area_name'];?></td>
                                                                    <td><?php echo $row['user_address'];?></td>
                                                                    
                                                        <td>
                                                            
                                                             <!-- Modal -->
                                                    <div class="modal fade" id="exampleModalCenter">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <form method="post">
                                                                    
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">User Sequence</h5>
                                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                                                    </button>
                                                                </div>
                                                                
                                                                <input type="hidden" id="deleteid" name="deleteid"/>
                                                                <div class="modal-body">
                                                                    <p>User Sequence (ex.1,2,3....)</p>
                                                                    <div class="form-group">
                        												<input type="number" name="txtsequence" class="form-control form-control-lg radius-30" />
                        											</div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                                                                    <button type="submit" name="BtnUserSequence" class="btn btn-primary">Save changes</button>
                                                                </div>

                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Modal -->
                                                    
                                                    
                                                            <div class="d-flex">
                                                               
                                                    <?php if($row['sorting_no']==NULL)
                                                    {?>
                                                    <button type="button" data-toggle="modal" data-target="#exampleModalCenter" data-id="<?php echo $row['user_id'];?>" class="btn btn-outline-primary shadow btn-sm mr-1 open-dialog"><i class="fadeIn animated bx bx-move-vertical"></i> </button>
                                                    <?php }else{?>
                                                    <button type="button" data-toggle="modal" data-target="#exampleModalCenter" data-id="<?php echo $row['user_id'];?>" class="btn btn-primary shadow btn-sm mr-1 open-dialog"><b style="color: white"><?php echo $row['sorting_no'];?></b></button>
                                                    <?php }?>  
                                                    </div>
                                                        </td>
                                                                   
                                                   
                                                            </tr>
                                                            <?php }}?>
                                
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
																<th>#</th>
                                                                <th>User</th>
                                                                <th>Mobile Number</th>
                                                                <th>Area</th>
                                                                <th>Flat</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>

											</div>
										</div>
									</div>
									<div class="tab-pane fade" id="Biography">
                                        <div class="card shadow-none border mb-0 radius-15">
											<div class="card-body">
												<div class="d-sm-flex align-items-center mb-3">
													<h4 class="mb-0">Orders Product</h4>
													<!-- <p class="mb-0 ml-sm-3 text-muted">3 Job History</p> <a href="javascript:;" class="btn btn-primary ml-auto radius-10"><i class='bx bx-plus'></i> Add More</a> -->
												</div>

                                                <div class="table-responsive">
                                                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>User</th>
                                                                <th>Area</th>
                                                                <th>Flat</th>
                                                                <th>Image</th>
                                                                <th>Product</th>
                                                                <th>Quantity</th>
                                                                <th>Date</th>
                                                                <th>Delivery Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                if(isset($_REQUEST["delivery_boy"]))
                                                                {
                                                                    $count= 1;
                                                                    // $result=mysqli_query($conn,"select * from tbl_deliveryboy as d left join tbl_user as u on u.deliveryboy_id=d.deliveryboy_id left join tbl_order_calendar as oc on oc.user_id=u.user_id left join tbl_product as p on oc.product_id=p.product_id where d.deliveryboy_id ='".$_REQUEST["delivery_boy"]."'");
                                                                    $result=mysqli_query($conn,"select * from tbl_order_calendar as oc left join tbl_product as p on p.product_id=oc.product_id left join tbl_user as u on u.user_id=oc.user_id left join tbl_deliveryboy as d on d.deliveryboy_id=u.deliveryboy_id left join tbl_area as a on a.area_id=u.area_id where d.deliveryboy_id ='".$_REQUEST["delivery_boy"]."' and oc.order_date='$date' order by oc.order_date ASC");
                                                                    while($row=mysqli_fetch_array($result))
                                                                    {
                                                            ?> 
                                                            <tr>
                                                                    <td><?php echo $count++;?></td>
                                                                    <td>
                                                                        <?php echo $row['user_first_name']." ".$row['user_last_name'];?><br>
                                                                        <?php echo "+91".$row['user_mobile_number'];?>
                                                                    </td>
                                                                    <td><?php echo $row['area_name'];?></td>
                                                                    <td><?php echo $row['user_address'];?></td>
                                                                    <td><img src="<?php echo $ADMIN_PRODUCT_IMG.$row['product_image'];?>" width="80" height="80"></td>
                                                                    <td><?php echo $row['product_name'];?></td>
                                                                    
                                                                    <td><?php echo $row['order_qty'];?></td>
                                                                    <td title="<?php echo $row['oc_cutoff_time']?>"><?php echo $row['order_date'];?></td>
                                                                    <td>
                                                                        <?php if($row["oc_is_delivered"]=='0')
                                                                        {

                                                                        }
                                                                        elseif($row["oc_is_delivered"]=='1')
                                                                        {?>
                                                                            Delivered
                                                                        <?php }?>
                                                                    </td>
                                                                    <?php $total += $row['order_qty']++;?>
                                                   
                                                            </tr>
                                                            <?php }}?>
                                
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>User</th>
                                                                <th>Area</th>
                                                                <th>Flat</th>
                                                                <th>Image</th>
                                                                <th>Product</th>
                                                                <th><?php echo $total;?></th>
                                                                <th>Date</th>
                                                                <th>Delivery Status</th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>

											</div>
										</div>
									</div>
                                    
									<?php
                                        if(isset($_REQUEST["delivery_boy"]))
                                        {
                                            $result=mysqli_query($conn,"select * from tbl_deliveryboy where deliveryboy_id ='".$_REQUEST["delivery_boy"]."'");
                                            while($row=mysqli_fetch_array($result))
                                            {
                                    ?> 
                                    <?php
                                        if(isset($_REQUEST["BtnUpdateDeliveryBoyProfile"]))
                                        {
                    
                                            $delivery_boy=$_REQUEST["delivery_boy"];
                                            
                                            $sql=mysqli_query($conn,"select * from tbl_deliveryboy where deliveryboy_mobile_number='".$_REQUEST["txtphone"]."' and deliveryboy_id!='$delivery_boy'");
                            if(mysqli_num_rows($sql)>0)
                            {
                                ?><div class="alert alert-danger mb-2" role="alert">
                                <strong>Error!</strong> Duplicate Mobile Number.
                              </div><?php
                            }
                            else
                            {
                                
                                            $result=mysqli_query($conn,"update tbl_deliveryboy set deliveryboy_first_name='".$_REQUEST["txtfname"]."',deliveryboy_last_name='".$_REQUEST["txtlname"]."',deliveryboy_email='".$_REQUEST["txtemail"]."',deliveryboy_mobile_number='".$_REQUEST["txtphone"]."' where deliveryboy_id='$delivery_boy'") or die(mysqli_error($conn));
                                            if($result=true)
                                            {
                                                ?>
                                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <i class="mdi mdi-check-all mr-2"></i> <strong>Well done!</strong> User has Update.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                                </div><?php
                                                // echo "<script>window.location='category.php';</script>";
                                                echo "<script>window.location='edit_delivery_boy.php?delivery_boy=$delivery_boy';</script>";
                                            }
                                        }
                                            
                                        }
                                    ?>  
                                    
									<div class="tab-pane fade" id="Edit-Profile">
									    <form method="post">
										<div class="card shadow-none border mb-0 radius-15">
											<div class="card-body">
												<div class="form-body">
													<div class="row">
														<div class="col-12 col-lg-12">
															<div class="form-row">
																<div class="form-group col-md-6">
																	<label>First Name</label>
																	<input type="text" name=txtfname value="<?php echo $row["deliveryboy_first_name"];?>" class="form-control">
																</div>
																<div class="form-group col-md-6">
																	<label>Last Name</label>
																	<input type="text" name=txtlname value="<?php echo $row["deliveryboy_last_name"];?>" class="form-control">
																</div>
															</div>
															<!-- <div class="form-group">
																<label>Password</label>
																<input type="password" value="1234560000" class="form-control">
															</div> -->
															<div class="form-group">
																<label>Email</label>
																<input type="text" name=txtemail value="<?php echo $row["deliveryboy_email"];?>" class="form-control">
															</div>
															<div class="form-group">
																<label>Phone</label>
																<input type="text" name=txtphone value="<?php echo $row["deliveryboy_mobile_number"];?>" class="form-control">
															</div>
                                                            
															<button type="submit" name="BtnUpdateDeliveryBoyProfile" class="btn btn-light-primary"><i class="fadeIn animated bx bx-edit"></i> Update</button>
															<!-- <div class="form-group">
																<label>Nation</label>
																<input type="text" value="Australia" class="form-control">
															</div> -->
														</div>
													</div>
												</div>
											</div>
										</div>
										</form>
									</div>
                                    <?php }}?>
									
									<?php
                                        if(isset($_REQUEST["delivery_boy"]))
                                        {
                                            $result=mysqli_query($conn,"select * from tbl_deliveryboy where deliveryboy_id ='".$_REQUEST["delivery_boy"]."'");
                                            while($row=mysqli_fetch_array($result))
                                            {
                                    ?> 
                                   
									<div class="tab-pane fade" id="Document">
										<div class="card shadow-none border mb-0 radius-15">
											<div class="card-body">
												<div class="form-body">
													<div class="row">
														<div class="col-12 col-lg-5 border-right">
															
															<div class="form-group">
																<label><?php echo $title;?> Driving Licence  / Aadhar Card Front Image</label><br>
																<img src="<?php echo $ADMIN_DELIVERYBOY_IMG.$row['deliveryboy_front_aadhar']?>" width="300px" height="200px">
																
																<a href="<?php echo $ADMIN_DELIVERYBOY_IMG.$row['deliveryboy_front_aadhar']?>" download><img src="assets/images/icons/download.png" width="50px" height="50px"></a>
															</div>
															
                                                            
														</div>
														<div class="col-12 col-lg-7">
                                                            
                                                            
															
															<div class="form-group">
																<label><?php echo $title;?> Driving Licence  / Aadhar Card Back Image</label><br>
																<img src="<?php echo $ADMIN_DELIVERYBOY_IMG.$row['deliveryboy_back_aadhar']?>" width="300px" height="200px">
																<a href="<?php echo $ADMIN_DELIVERYBOY_IMG.$row['deliveryboy_back_aadhar']?>" download><img src="assets/images/icons/download.png" width="50px" height="50px"></a>
															</div>
															
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
                                  
                                    <?php }}?>
								</div>
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

	<!--end switcher-->
	<!-- JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/popper.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<!--plugins-->
	<script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
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