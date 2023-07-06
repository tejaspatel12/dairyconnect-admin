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
    $DATE = date("Y-m-d");
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" type="text/javascript"></script>
   
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
						<div class="breadcrumb-title pr-3">User Profile</div>
						<div class="pl-3">
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb mb-0 p-0">
									<li class="breadcrumb-item"><a href="javascript:;"><i class='bx bx-home-alt'></i></a>
									</li>
									<li class="breadcrumb-item active" aria-current="page">User Profile</li>
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
                            if(isset($_REQUEST["user"]))
                            {
								$user = $_REQUEST["user"];
                                $result=mysqli_query($conn,"select * from tbl_user as u left join tbl_area as a on a.area_id=u.area_id left join tbl_deliveryboy as d on d.deliveryboy_id=u.deliveryboy_id left join tbl_time_slot as ts on ts.time_slot_id=d.time_slot_id where u.user_id='".$_REQUEST["user"]."'");
                                while($row=mysqli_fetch_array($result))
                                {
                                ?> 
								<div class="row">
									<div class="col-12 col-lg-7 border-right">
										<div class="d-md-flex align-items-center">
											<div class="mb-md-0 mb-3">
												<!-- <img src="https://via.placeholder.com/110x110" class="rounded-circle shadow" width="130" height="130" alt="" /> -->
                                                <a href="#"><img src="images/man.png" class="rounded-circle shadow" width="130" height="130" alt="" /></a>
											</div>
											<div class="ml-md-4 flex-grow-1">
												<div class="d-flex align-items-center mb-1">
													<h4 class="mb-0"><?php echo $row["user_first_name"]. " ".$row["user_last_name"];?></h4>
													<p class="mb-0 ml-auto"><?php echo "£".$row["user_balance"];?></p>
												</div>
												<p class="mb-0 text-muted"><?php echo $row["area_name"];?></p>
												<p class="text-primary"><i class='bx bx-phone'></i> <?php echo "+44".$row["user_mobile_number"];?></p>
												<?php if($row["user_subscription_status"]=="1"){?><button type="button" class="btn btn-primary">Subscription Activate</button><?php }else{?><button type="button" class="btn btn-danger">Subscription Unactivate</button><?php }?>
												<?php if($row["user_type"]=="1"){?><button type="button" class="btn btn-outline-success ml-2">Loyal</button><?php }else{?><button type="button" class="btn btn-outline-secondary ml-2">Normal</button><?php }?>
												<?php if($row["accept_nagative_balance"]=="1"){?><button type="button" class="btn btn-outline-success ml-2">Negative Balance</button><?php }else{?><button type="button" class="btn btn-outline-secondary ml-2">Negative Balance</button><?php }?>
											</div>
										</div>
									</div>
									<div class="col-12 col-lg-5">
										<table class="table table-sm table-borderless mt-md-0 mt-3">
											<tbody>
												<tr>
													<th>Number:</th>
													<td><?php echo "+44".$row["user_mobile_number"];?>
													</td>
												</tr>
												<tr>
													<th>Email:</th>
													<td><?php echo $row["user_email"];?></td>
												</tr>
												<tr>
													<th>Address:</th>
													<td><?php echo $row["user_address"];?></td>
												</tr>
												<tr>
													<th>Deliveryboy Name:</th>
													<td><a href="edit_delivery_boy.php?delivery_boy=<?php echo $row['deliveryboy_id']?>"><?php echo $row["deliveryboy_first_name"]." ".$row["deliveryboy_last_name"];?></a></td>
												</tr>
												<tr>
													<th>Time Slot:</th>
													<?php $time_slot_cutoff_time = $row["time_slot_cutoff_time"];?>
													<td><?php echo $row["time_slot_name"];?></td>
												</tr>
												<tr>
													<th>Cut-Off Time:</th>
													<td><?php echo $row["time_slot_cutoff_time"];?></td>
												</tr>
												<!-- <tr>
													<th>Years experience:</th>
													<td>6</td>
												</tr> -->
											</tbody>
										</table>
										<!--<div class="mb-3 mb-lg-0"> -->
                                            <!-- <a href="javascript:;" class="btn btn-sm btn-link"><i class='bx bxl-github'></i></a> -->
											<!--<a href="javascript:;" class="btn btn-sm btn-link"><i class='bx bxl-whatsapp'></i></a>-->
											<!-- <a href="javascript:;" class="btn btn-sm btn-link"><i class='bx bxl-facebook'></i></a>
											<a href="javascript:;" class="btn btn-sm btn-link"><i class='bx bxl-linkedin'></i></a>
											<a href="javascript:;" class="btn btn-sm btn-link"><i class='bx bxl-dribbble'></i></a>
											<a href="javascript:;" class="btn btn-sm btn-link"><i class='bx bxl-stack-overflow'></i></a> -->
										<!--</div>-->
									</div>
								</div>
								
								<?php
                                    if(isset($_REQUEST["BtnPauseSubscription"]))
                                    {
                                        $push_date = $_REQUEST["txtpdate"];
                                        $resume_date = $_REQUEST["txtrdate"];
                                        
                                        if($resume_date=="")
                                        {
                                            $resume_date = date('Y-m-d', strtotime($push_date. ' +  365 days')); 
                                        }
                                        
                                        $result=mysqli_query($conn,"update tbl_order set order_subscription_status='0',push_date='$push_date' where user_id='$user' and order_id='".$_REQUEST['deleteid']."'") or die(mysqli_error($conn));
                                        
                                        $result1=mysqli_query($conn,"delete from tbl_order_calendar where order_id='".$_REQUEST['deleteid']."' and user_id='$user' and order_date between '$push_date' and '$resume_date'") or die(mysqli_error($conn));
                                       
                                        if($result=true && $result1=true)
                                        {
                                            echo "<script>window.location='user_detail.php?user=$user';</script>";
                                        }
                                        else
                                        {
                                            
                                        }
                                    }
                                ?>
                                
                                <?php
                                    if(isset($_REQUEST["BtnCancleSubscription"]))
                                    {
                                        $push_date = $_REQUEST["txtpdate"];
                                        $resume_date = date('Y-m-d', strtotime($push_date. ' +  365 days')); 
                                        $result=mysqli_query($conn,"update tbl_order set order_subscription_status='0',push_date='$push_date' where user_id='$user' and order_id='".$_REQUEST['deleteid']."'") or die(mysqli_error($conn));
                                        
                                        $result1=mysqli_query($conn,"delete from tbl_order_calendar where order_id='".$_REQUEST['deleteid']."' and user_id='$user' and order_date between '$push_date' and '$resume_date'") or die(mysqli_error($conn));
                                       
                                        if($result=true && $result1=true)
                                        {
                                            echo "<script>window.location='user_detail.php?user=$user';</script>";
                                        }
                                        else
                                        {
                                            
                                        }
                                    }
                                ?>
                                <?php
                                    if(isset($_REQUEST["BtnResumeSubscription"]))
                                    {
                                        $user_id=$_POST["user_id"];
                                        $order_id=$_POST["order_id"];
                                        $product_id=$_POST["product_id"];
                                        $product_name=$_POST["product_name"];
                                        $cutoff_time=$_POST["cutoff_time"];
                                        $qty=$_POST["qty"];
                                        $start_date=$_POST["start_date"];
                                        
                                        $finalcutoff = date('Y-m-d H:i:s', strtotime("$start_date $cutoff_time"));
                                                
                                        if($cutoff_time == "14:00:00")
                                        {
                                            // $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '+  0 days'));
                                        }
                                        elseif($cutoff_time == "22:00:00")
                                        {
                                            $finalcutoff = date('Y-m-d H:i:s', strtotime($finalcutoff. '-  1 days'));
                                        }
                                        else
                                        {
                                            
                                        }
                                        $lastdate = date('Y-m-d', strtotime($start_date. '+  365 days'));
                                        
                                        $result=mysqli_query($conn,"update tbl_order set order_subscription_status='1',push_date=NULL,resume_date=NULL where user_id='$user_id' and order_id='$order_id'") or die(mysqli_error($conn));
                                        
                                        $resultdel=mysqli_query($conn,"delete from tbl_order_calendar where order_id='$order_id' and user_id='$user_id' and oc_is_delivered='0' and order_date between '$start_date' and '$lastdate'") or die(mysqli_error($conn));
                                        
                                        $round = 15;
                                        $start_date;
                                        
                                        for ($i = 0; $i <= $round; $i+=1){
                                            
                                        $result3=mysqli_query($conn,"insert into tbl_order_calendar (order_id,product_id,user_id,order_qty,order_date,oc_cutoff_time,oc_date) 
                                        values ('$order_id','$product_id','$user_id','$qty','".date('Y-m-d', strtotime($start_date. ' +  '.$i.'days'))."','".date('Y-m-d H:i:s', strtotime($finalcutoff. ' +  '.$i.'days'))."','$start_date')") or die(mysqli_error($conn));
                                        }
                                                
                                
                                            if($result=true && $resultdel=true && $result3=true)
                                            {
                                                $response["status"]="yes";
                                                $response["message"]="Resume Successfully";
                                                // $response["description"]="$product_name subscription has been changed to $qty and will take into consideration from $start_date";
                                               $response["description"]="$product_name subscription has been resume to $qty quantity and will take into consideration from $start_date";
                                            }
                                            else
                                            {
                                                $response["status"]="no";
                                                $response["message"]="Something is Wrong";
                                            }
                                        
                                
                                    }
                                ?>
                    
								
								<!-- Modal -->
                        <div class="modal fade" id="PauseSubscription" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content radius-30">
                                    <div class="modal-header border-bottom-0">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">	<span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body p-5">
                                        <form method="post">
                                        <h3 class="text-center">Pause Subscription</h3>
                                        <input type="hidden" id="deleteid" name="deleteid"/>
                                        
                                        
                                        <div class="form-group">
                                            <input type="date" id="date_picker" name="txtpdate" value="" class="form-control form-control-lg radius-30" / require>
                                        </div>
                                        
                                        <div class="form-group">
                                            <input type="date" name="txtrdate" value="" class="form-control form-control-lg radius-30" />
                                        </div>
                                        
                                        <script language="javascript">
                                            var today = new Date();
                                            var dd = String(today.getDate()).padStart(2, '0');
                                            var mm = String(today.getMonth() + 1).padStart(2, '0');
                                            var yyyy = today.getFullYear();
                                    
                                            today = yyyy + '-' + mm + '-' + dd;
                                            $('#date_picker').attr('min',today);
                                        </script>
<!--time_slot_name-->
                                        
                                        
                                       <!-- <div class="form-group text-right my-4"> 
                                        </div>
                                        <div class="form-group">-->
		                                    <button type="submit" class="btn btn-primary radius-30 btn-lg btn-block" name="BtnPauseSubscription">Pause Subscription</button>
                                        </div>
                                        </form>
                                        
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    <!-- Button trigger modal -->
                    
                                <?php }}?>
								<!--end row-->
								<ul class="nav nav-pills">
									<li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#Experience"><span class="p-tab-name">Subscription Product</span><i class='bx bx-donate-blood font-24 d-sm-none'></i></a>
									</li>
									<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#Biography"><span class="p-tab-name">Orders</span><i class='bx bxs-user-rectangle font-24 d-sm-none'></i></a>
									</li>
									<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#Edit-Profile"><span class="p-tab-name">Edit Profile</span><i class='bx bx-message-edit font-24 d-sm-none'></i></a>
									</li>
									<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#Location"><span class="p-tab-name">Location</span><i class='bx bx-message-edit font-24 d-sm-none'></i></a>
									</li>
									<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#Balance"><span class="p-tab-name">Balance</span><i class='bx bx-message-edit font-24 d-sm-none'></i></a>
									</li>
									<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#Transaction"><span class="p-tab-name">Transaction</span><i class='bx bx-message-edit font-24 d-sm-none'></i></a>
									</li>
									<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#Detail-Invoice"><span class="p-tab-name">Detail Invoice</span><i class='bx bx-file font-24 d-sm-none'></i></a>
									</li>
								</ul>
								<div class="tab-content mt-3">
									<div class="tab-pane fade show active" id="Experience">
										<div class="card shadow-none border mb-0 radius-15">
											<div class="card-body">
												<div class="d-sm-flex align-items-center mb-3">
													<h4 class="mb-0">Subscription Product</h4>
													
													<p class="mb-0 ml-sm-3 text-muted"></p> 
													<a href="order_product.php?user_id=<?php echo $user;?>" class="btn btn-primary ml-auto radius-10"><i class='bx bx-plus'></i> Add More</a>
													<!-- Button trigger modal -->

														<!-- <button type="button" class="btn btn-primary radius-30 px-5 m-3" data-toggle="modal" data-target="#exampleModal8">Card Modal</button> -->

														<!-- Modal -->
														<!-- <div class="modal fade" id="exampleModal8" tabindex="-1" role="dialog" aria-hidden="true">
															<div class="modal-dialog modal-dialog-centered">
																<div class="modal-content">
																	<div class="">
																		<div class="card mb-0">
																			<img src="https://via.placeholder.com/800x500" class="card-img-top" alt="...">
																			<div class="card-body">
																				<h5 class="card-title">Card title</h5>
																				<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> 
																				<button type="button" onclick="window.location='order_product.php?user_id=<?php echo $user;?>&type=1';" class="btn btn-primary">Subscription Product</button>
																				<button type="button" onclick="window.location='order_product.php?user_id=<?php echo $user;?>&type=2';" class="btn btn-primary">Buy Once</button>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div> -->
													<!-- Button trigger modal -->
												</div>
                                                <?php
                                                if(isset($_REQUEST["user"]))
                                                {
													$user = $_REQUEST["user"];
                                                    $result=mysqli_query($conn,"select * from tbl_order as o left join tbl_product as p on p.product_id=o.product_id left join tbl_delivery_schedule as ds on ds.order_id=o.order_id where o.user_id ='".$_REQUEST["user"]."' and o.delivery_schedule!='' and o.order_subscription_status!='2'");
                                                    while($row=mysqli_fetch_array($result))
                                                    {
                                                ?> 
												<!--<a href="edit_subscription.php?order=<?php echo $row["order_id"];?>">-->
                                                <div class="media"> 
                                                    <!-- <i class='bx bxl-dribbble media-icons bg-dribbble'></i> -->
                                                    <img src="<?php echo $ADMIN_PRODUCT_IMG.$row['product_image'];?>" width="130" height="130" alt="" />
													<div class="media-body ml-3">
														<div class="row align-items-center">
															<div class="col-lg-4">
																<h5 class="mb-0"><?php echo $row['product_name'];?></h5>
																<!-- <p class="mb-0">Dribbble Inc</p> -->
															</div>
															<div class="col-lg-4">
																<h5 class="text-muted mb-0"><i class='bx bx-time'></i> <?php echo $row["ds_type"];?></h5>
															</div>
															<div class="col-lg-4">
																<h6 class="text-muted mb-0"><i class='bx bx-book-alt'></i>   
                                                                 <?php if($row["ds_qty"]=='')
                                                                {?>

                                                                    <?php if($row["ds_Sun"]=='0')
                                                                    {

                                                                    }
                                                                    else
                                                                    {?>
                                                                        Sun - <?php echo $row["ds_Sun"]." | ";?>
                                                                    <?php }?>

                                                                    <?php if($row["ds_Mon"]=='0')
                                                                    {

                                                                    }
                                                                    else
                                                                    {?>
                                                                        Mon - <?php echo $row["ds_Mon"]." | ";?>
                                                                    <?php }?>

                                                                    <?php if($row["ds_Tue"]=='0')
                                                                    {

                                                                    }
                                                                    else
                                                                    {?>
                                                                        Tue - <?php echo $row["ds_Tue"]." | ";?>
                                                                    <?php }?>

                                                                    <?php if($row["ds_Wed"]=='0')
                                                                    {

                                                                    }
                                                                    else
                                                                    {?>
                                                                        Wed - <?php echo $row["ds_Wed"]." | ";?>
                                                                    <?php }?>

                                                                    <?php if($row["ds_Thu"]=='0')
                                                                    {

                                                                    }
                                                                    else
                                                                    {?>
                                                                        Thu - <?php echo $row["ds_Thu"]." | ";?>
                                                                    <?php }?>

                                                                    <?php if($row["ds_Fri"]=='0')
                                                                    {

                                                                    }
                                                                    else
                                                                    {?>
                                                                        Fri - <?php echo $row["ds_Fri"]." | ";?>
                                                                    <?php }?>

                                                                    <?php if($row["ds_Sat"]=='0')
                                                                    {

                                                                    }
                                                                    else
                                                                    {?>
                                                                        Sat - <?php echo $row["ds_Sat"]." | ";?>
                                                                    <?php }?>

                                                                <?php }else
                                                                {
                                                                    echo $row["ds_qty"];
                                                                }?></h6>
															</div>
														</div>
														<form>
														<p class="mt-2">Order Instructions : <?php echo $row["order_instructions"];?></p>
														
														<?php if($row["order_ring_bell"]="1"){?>
															<button style="margin-right: 10px !important;" type="button" class="btn btn-light-primary"><i class="fadeIn animated bx bx-bell"></i></button>
														<?php }else{?>
															<button style="margin-right: 10px !important;" type="button" class="btn btn-light-primary"><i class="fadeIn animated bx bx-bell-off"></i></button>
														<?php }?>
														    
														    
													    <?php if($row["order_subscription_status"]=='1')
                                                                    {?>
                                                                        <button type="button" data-toggle="modal" data-target="#PauseSubscription" data-id="<?php echo $row['order_id'];?>" style="margin-right: 10px !important;" class="btn btn-light-danger open-dialog">Pause Subscription</button>
                                                                    <?php }
                                                                    else
                                                                    {?>
                                                                        <button type="button" onclick="window.location='resume_subscription.php?user=<?php echo $user?>&order=<?php echo $row['order_id']?>';" style="margin-right: 10px !important;" class="btn btn-light-success">Resume Subscription</button>
                                                                    <?php }?>
                                                                    
															    <button type="button" style="margin-right: 10px !important;" onclick="window.location='end_subscription.php?user=<?php echo $user;?>&order=<?php echo $row['order_id'];?>';" class="btn btn-light-danger">End Subscription</button>
															    
															                                                                        
															    <button type="button" style="margin-right: 10px !important;" onclick="window.location='edit_subscription.php?user=<?php echo $user;?>&order=<?php echo $row['order_id'];?>';" class="btn btn-light-primary"><i class="fadeIn animated bx bx-edit"></i> Edit Subscription</button>
															

														<hr/>
														</form>
													</div>
												</div>
												<!--</a>-->

                                                
                                                <?php }}?>

											</div>
										</div>
									</div>
									
                    
									<div class="tab-pane fade" id="Biography">
										<div class="card shadow-none border mb-0 radius-15">
											<div class="card-body">
												<div class="d-sm-flex align-items-center mb-3">
													<h4 class="mb-0">Orders</h4>
													<!-- <p class="mb-0 ml-sm-3 text-muted">3 Job History</p> <a href="javascript:;" class="btn btn-primary ml-auto radius-10"><i class='bx bx-plus'></i> Add More</a> -->
												</div>

                                                <div class="table-responsive">
                                                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Image</th>
                                                                <th>Product</th>
                                                                <th>Quantity</th>
                                                                <th>Date</th>
                                                                <th>Rate</th>
                                                                <th>Delivery Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                      
                                                        
                                                    <!-- Button trigger modal -->
                                                    <div class="modal fade" id="exampleModal7" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                          <div class="modal-content">
                                                            <div class="modal-header bg-danger white">
                                                              <h4 class="modal-title" id="myModalLabel10">Warning!</h4>
                                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                              </button>
                                                            </div>
                                                            <form method="post" action="action.php?order=<?php echo $_REQUEST['newid']?>&user=<?php echo $user?>">
                                                            <div class="modal-body">
                                                              <h5>Are you sure you want to delete?</h5>
									                            <input type="hidden" id="newid" name="newid"/>
                                                            </div>
                                                            <div class="modal-footer">
                                                              <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">No</button>
                                                              <button type="submit" name="BtnDeleteOrder" class="btn btn-outline-danger">Yes</button>
                                                            </div>
                                                            </form>
                                                          </div>
                                                        </div>
                                                  </div>
                                                    
                                                    <?php
                                                        // if(isset($_REQUEST["BtnOneQtyChange"]))
                                                        // {
                                                        //     $qty = $_REQUEST["txtqty"];
                                                        //     $result=mysqli_query($conn,"update tbl_order_calendar set order_qty='$qty' where oc_id='".$_REQUEST['newid']."'") or die(mysqli_error($conn));
                                                           
                                                        //     if($result=true)
                                                        //     {
                                                        //         echo "<script>window.location='user_detail.php?user=$user';</script>";
                                                        //     }
                                                        //     else
                                                        //     {
                                                                
                                                        //     }
                                                        // }
                                                        // if(isset($_REQUEST['btndelete']))
                                                        // {
                                                            
                                                        // $pid = $_REQUEST['newid'];	
                                                        // $result=mysqli_query($conn,"delete from tbl_order_calendar where oc_id='".$_REQUEST['newid']."'") or die(mysqli_error($conn));
                                                        // echo "<script>window.location='user_detail.php?user=$user';</script>";
                                                        // }
                                                    ?>
                                
                                                        <tbody>
                                                            <?php
                                                            $DATE;
                                                            $limito = date('Y-m-d', strtotime($DATE. '-  15 days'));
                                                            $limits = date('Y-m-d', strtotime($DATE. '+  15 days'));
                                                                    $count=1;
                                                                    //  order by oc.order_date asc
                                                                    $result=mysqli_query($conn,"select * from tbl_order_calendar as oc left join tbl_product as p on p.product_id=oc.product_id where user_id='$user' and oc.order_date between '$limito' and '$limits' order by oc.order_date asc");
                                                                    while($row=mysqli_fetch_array($result))
                                                                {?>
                                                    
                                                                <tr>
                                                                
                                                                    <td><?php echo $count++;?></td>
                                                                   
                                                                    
                                                                    <td><img src="<?php echo $ADMIN_PRODUCT_IMG.$row['product_image'];?>" width="80" height="80"></td>
                                                                    <td><?php echo $row['product_name'];?></td>
                                                                    
                                                                    
                                                                    <td><?php echo $row['order_qty'];?></td>
                                                                    <td title="<?php echo $row['oc_cutoff_time'];?>"><?php echo $row['order_date'];?></td>
                                                                    <td><?php echo $rate = $row["order_one_unit_price"] * $row['order_qty']?></td>
                                                                    <td>
                                                                        
                                                                        <?php if($row["oc_is_delivered"]=='0')
                                                                        {

                                                                        }
                                                                        elseif($row["oc_is_delivered"]=='1')
                                                                        {?>
                                                                            Delivered
                                                                        <?php }
                                                                        elseif($row["oc_is_delivered"]=='2')
                                                                        {?>
                                                                            Not Delivered
                                                                        <?php }
                                                                        elseif($row["oc_is_delivered"]=='3')
                                                                        {?>
                                                                            Cancel
                                                                            <p style="color: red">Insufficient Balance</p>
                                                                        <?php }
                                                                        elseif($row["oc_is_delivered"]=='4')
                                                                        {?>
                                                                            Order Cancel
                                                                            <p style="color: red">Minimum Order Value</p>
                                                                        <?php }elseif($row["oc_is_delivered"]=='5')
                                                                        {?>
                                                                            0 Qty
                                                                            <p style="color: red">0 QTY</p>
                                                                        <?php }?>
                                                                    </td>
                                                                    <td>
                                                                        <div class="d-flex">
                                                                           <!--<button type="button" data-toggle="modal" data-target="#EditOneDay" data-id="<?php echo $row['oc_id'];?>" class="btn btn-outline-primary shadow btn-sm mr-1"><i class="fadeIn animated bx bx-edit open-popup"></i> </button> -->
                                                    <?php if($row["oc_is_delivered"]=='1')
                                                    {?>
                                                    
                                                    <button type="button" onclick="window.location='update_one_order.php?order=<?php echo $row["oc_id"]?>&user=<?php echo $user?>';" class="btn btn-outline-success shadow btn-sm mr-1"><i class="fadeIn animated bx bx-edit"></i> </button> 
                                                    
                                                    <?php }else
                                                    {?>
                                                    
                                                    <button type="button" onclick="window.location='edit_one_order.php?order=<?php echo $row["oc_id"]?>&user=<?php echo $user?>';" class="btn btn-outline-primary shadow btn-sm mr-1"><i class="fadeIn animated bx bx-edit"></i> </button> 
                                                    
                                                    
                                                    <button type="button" onclick="window.location='delete_one_order.php?order=<?php echo $row["oc_id"]?>&user=<?php echo $user?>&date=<?php echo $row['order_date']?>';" class="btn btn-outline-danger shadow btn-sm mr-1"><i class="fadeIn animated bx bx-trash-alt open-popup"></i> </button> 
                                                    
                                                    <?php }?>
                                                                           
                                                                            
                                                                            <!--<button type="button" data-toggle="modal" data-target="#exampleModal7" data-id="<?php echo $row['oc_id'];?>" class="btn btn-outline-danger shadow btn-sm mr-1"><i class="fadeIn animated bx bx-trash-alt open-popup"></i> </button> -->
                                                                            
                                                                        </div>
                                                                    </td>
                                                   
                                                            
                                                            </tr>
                                                            <?php }?>
                                                            
                                                            
                                                            
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Image</th>
                                                                <th>Product</th>
                                                                <th>Quantity</th>
                                                                <th>Date</th>
                                                                <th>Rate</th>
                                                                <th>Delivery Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>

											</div>
										</div>
									</div>
									
                                    <?php
                                        if(isset($_REQUEST["user"]))
                                        {
                                            $result=mysqli_query($conn,"select * from tbl_user as u left join tbl_country as c on c.country_id=u.country_id left join tbl_state as s on s.state_id=u.state_id left join tbl_city as t on t.city_id=u.city_id left join tbl_area as a on a.area_id=u.area_id where u.user_id ='".$_REQUEST["user"]."'");
                                            while($row=mysqli_fetch_array($result))
                                            {
                                    ?> 
                                    <?php
                                        if(isset($_REQUEST["BtnUpdateUserProfile"]))
                                        {
                    
                                            $user=$_REQUEST["user"];
                                            
                                            $sql=mysqli_query($conn,"select * from tbl_user where user_mobile_number='".$_REQUEST["txtphone"]."' and user_id!='$user'");
                            if(mysqli_num_rows($sql)>0)
                            {
                                ?><div class="alert alert-danger mb-2" role="alert">
                                <strong>Error!</strong> Duplicate Mobile Number.
                              </div><?php
                            }
                            else
                            {
                    
                                            $result=mysqli_query($conn,"update tbl_user set user_first_name='".$_REQUEST["txtfname"]."',user_last_name='".$_REQUEST["txtlname"]."',user_email='".$_REQUEST["txtemail"]."',user_mobile_number='".$_REQUEST["txtphone"]."',user_address='".$_REQUEST["txtaddress"]."',area_id='".$_REQUEST["txtarea"]."' where user_id='$user'") or die(mysqli_error($conn));
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
                                                echo "<script>window.location='user_detail.php?user=$user';</script>";
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
														<div class="col-12 col-lg-5 border-right">
															<div class="form-row">
																<div class="form-group col-md-6">
																	<label>First Name</label>
																	<input type="text" name=txtfname value="<?php echo $row["user_first_name"];?>" class="form-control">
																</div>
																<div class="form-group col-md-6">
																	<label>Last Name</label>
																	<input type="text" name=txtlname value="<?php echo $row["user_last_name"];?>" class="form-control">
																</div>
															</div>
															<!-- <div class="form-group">
																<label>Password</label>
																<input type="password" value="1234560000" class="form-control">
															</div> -->
															<div class="form-group">
																<label>Email</label>
																<input type="text" name=txtemail value="<?php echo $row["user_email"];?>" class="form-control">
															</div>
															<div class="form-group">
																<label>Phone</label>
																<input type="text" name=txtphone value="<?php echo $row["user_mobile_number"];?>" class="form-control">
															</div>
															<div class="form-group">
																<label>Address</label>
																<input type="text" name=txtaddress value="<?php echo $row["user_address"];?>" class="form-control">
															</div>
                                                            
															<!-- <div class="form-group">
																<label>Nation</label>
																<input type="text" value="Australia" class="form-control">
															</div> -->
														</div>
														<div class="col-12 col-lg-7">
                                                            <div class="form-group">
																<label>Balance</label>
																<input type="number" value="<?php echo $row["user_balance"];?>" class="form-control" readonly>
															</div>
                                                            

															<div class="form-row">
																<div class="form-group col-md-6">
																	<label>Contry</label>
																	<input type="text" value="<?php echo $row["country_name"];?>" class="form-control" readonly>
																</div>
																<div class="form-group col-md-6">
																	<label>State</label>
																	<input type="text" value="<?php echo $row["state_name"];?>" class="form-control" readonly>
																</div>
															</div>
															<div class="form-row">
                                                                <div class="form-group col-md-6">
																	<label>City</label>
																    <input type="text" name=txtcityname value="<?php echo $row["city_name"];?>" class="form-control" readonly>
																</div>
                                                                <div class="form-group col-md-6">
																	<label>Area</label>
																	
																	<select class="form-control" name="txtarea">
																	    <option value="<?php echo $row['area_id'];?>"><?php echo $row['area_name'];?></option>
                            											<?php
                            												$result=mysqli_query($conn,"select * from tbl_area where city_id='147'");
                            												while($rowq=mysqli_fetch_array($result))
                            											{?>
                            											    <option value="<?php echo $rowq['area_id'];?>"><?php echo $rowq['area_name'];?></option>
                            											<?php }?>
                            										</select>
										
																</div>
																
																
															</div>
															<button type="submit" name="BtnUpdateUserProfile" class="btn btn-light-primary"><i class="fadeIn animated bx bx-edit"></i> Update</button>
															
															</div>
													</div>
												</div>
											</div>
										</div>
										</form>
									</div>
                                    <?php }}?>
                                    
                                    <?php
                                        if(isset($_REQUEST["user"]))
                                        {
                                            $result=mysqli_query($conn,"select * from tbl_user where user_id ='".$_REQUEST["user"]."'");
                                            while($row=mysqli_fetch_array($result))
                                            {
                                    ?> 
                                    <div class="tab-pane fade" id="Location">
										<div class="card shadow-none border mb-0 radius-15">
											<div class="card-body">
												<div class="d-sm-flex align-items-center mb-3">
													<h4 class="mb-0">Location</h4>
													<!-- <p class="mb-0 ml-sm-3 text-muted">3 Job History</p> <a href="javascript:;" class="btn btn-primary ml-auto radius-10"><i class='bx bx-plus'></i> Add More</a> -->
												</div>
												<?php 
												// LatLng(31.31, 29.289999999999992)
												    $latlong = $row["user_latlng"];
												    $latlong = ltrim($latlong, 'LatLng(');
												    $latlong = ltrim($latlong, ')');
												    echo $latlong;
												?>
												<!--<H1><a href="https://www.google.com/maps/search/?api=AIzaSyAQfo7QS7ZPiUdTiXTHgGmtmOA7k1FTUKE&query=$latlong">Link</a></H1>-->
												<H2><a href="https://maps.google.com/?q=<?php echo $latlong?>" target="_blank">Map Link</a></H2>

           <!--                                     <div class="card">-->
           <!--         								<div class="card-header"></div>-->
           <!--         								<div class="card-body">-->
           <!--         								        <div class="col-md-12 p-3">-->
           <!--                                                     <div id="map_canvas" style="width: auto; height: 400px;">-->
           <!--                                                     </div>-->
           <!--                                                     <div class="col-md-12">-->
           <!--                                                         <div class="container row p-3">-->
           <!--                                                             <div class="col-6">-->
           <!--                                                                 <div class="form-group">-->
           <!--                                                                     <label for="latitude">Latitude</label>-->
                                                                                <!-- This is location for Myanmar -->
           <!--                                                                     <input id="txtLat" type="text" style="color:red" value="28.47399" />-->
           <!--                                                                 </div>-->
           <!--                                                             </div>-->
           <!--                                                             <div class="col-6">-->
           <!--                                                                 <div class="form-group">-->
           <!--                                                                     <label for="longitude">Longitude</label>-->
                                                                                <!-- This is location for Myanmar -->
           <!--                                                                     <input id="txtLng" type="text" style="color:red" value="77.026489" />-->
           <!--                                                                 </div>-->
           <!--                                                             </div>-->
           <!--                                                         </div>-->
           <!--                                                     </div>-->
           <!--         								</div>-->
           <!--         							</div>-->

											<!--</div>-->
										</div>
									</div>
									
									
									
								</div>
								
								<?php 
								    if(isset($_REQUEST['BtnUserBalance']))
                                    {
                                        $oldbalance = $row['user_balance'];
                                        $nbalance = $_REQUEST['txtbalance'];
                                        $newbalance = $oldbalance + $nbalance;
                                        
                                        $date = date("Y-m-d");
                                        $result1=mysqli_query($conn,"insert into tbl_user_balance_log(user_id,ubl_amount,ubl_user_balance,ubl_type,tbl_tilte,ubl_date,ubl_status) values('".$user."','$nbalance','$newbalance','Credit','Admin Add Balance of Rs. $nbalance','$date','1')") or die(mysqli_error($conn));
                                        
                                        $result=mysqli_query($conn,"update tbl_user set user_balance='".$newbalance."' where user_id='".$user."'");
                                        // echo "<script>window.location='$code.php';</script>";
                                        
                                        echo "<script>window.location='user_detail.php?user=$user';</script>";
                                    }
								?>
								
								<!-- Modal -->
                                    <div class="modal fade" id="balance">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <form method="post">
                                                    
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Add Balance</h5>
                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                                    </button>
                                                </div>
                                                
                                                <input type="hidden" id="balanceid" name="balanceid"/>
                                                <div class="modal-body">
                                                    <p>User Current Balance : <a><?php echo $row['user_balance'];?></a></p>
                                                    <div class="form-group">
        												<input type="number" name="txtbalance" class="form-control form-control-lg radius-30" step="any" min="-100000" />
        											</div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                                                    <button type="submit" name="BtnUserBalance" class="btn btn-primary">Add Balance</button>
                                                </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal -->
								
								    <?php }}?>
								    
								    
                                                    
                                                    
								<div class="tab-pane fade" id="Balance">
										<div class="card shadow-none border mb-0 radius-15">
											<div class="card-body">
												<div class="d-sm-flex align-items-center mb-3">
													<h4 class="mb-0">Balance Log</h4>
													
													<!--<a href="order_product.php?user_id=<?php echo $user;?>" class="btn btn-primary ml-auto radius-10"><i class='bx bx-plus'></i> Add Balance</a>-->
													<!--<button type="button" data-toggle="modal" data-target="#balance" data-id="<?php echo $user;?>"  class="btn btn-primary ml-auto open-balance"><i class="fadeIn animated bx bx-plus"></i> Add Balance</button> -->
													<!-- <p class="mb-0 ml-sm-3 text-muted">3 Job History</p> <a href="javascript:;" class="btn btn-primary ml-auto radius-10"><i class='bx bx-plus'></i> Add More</a> -->
												</div>

                                                <div class="table-responsive">
                                                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Title</th>
                                                                <th>Type</th>
                                                                <th>Amount</th>
                                                                <th>User Balance</th>
                                                                <th>Date</th>
                                                            </tr>
                                                        </thead>
                                                      
                                
                                                        <tbody>
                                                            <?php
                                                                if(isset($_REQUEST["user"]))
                                                                {
                                                                    $count=1;
                                                                    $result=mysqli_query($conn,"select * from tbl_user_balance_log where ubl_type='Debit' and user_id='".$user."' order by ubl_id DESC");
                                                                    while($row=mysqli_fetch_array($result))
                                                                    {
                                                            ?> 
                                                            
                                                            
                                                            <tr>
                                                                    
                                                                    
                                                                    <td><?php echo $count++;?></td>
                                                                    <td><?php echo $row['tbl_tilte'];?></td>
                                                                    <td><?php echo $row['ubl_type'];?></td>
                                                                    <td>
                                                                        <?php echo $row['ubl_amount'];?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $row['ubl_user_balance'];?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $row['ubl_date'];?>
                                                                    </td>
                                                                    
                                                   
                                                            </tr>
                                                            <?php }}?>
                                
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Title</th>
                                                                <th>Type</th>
                                                                <th>Amount</th>
                                                                <th>User Balance</th>
                                                                <th>Date</th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>

											</div>
										</div>
									</div>
									
								<div class="tab-pane fade" id="Transaction">
										<div class="card shadow-none border mb-0 radius-15">
											<div class="card-body">
												<div class="d-sm-flex align-items-center mb-3">
													<h4 class="mb-0">Transaction Log</h4>
													
													<!--<a href="order_product.php?user_id=<?php echo $user;?>" class="btn btn-primary ml-auto radius-10"><i class='bx bx-plus'></i> Add Balance</a>-->
													<button type="button" data-toggle="modal" data-target="#balance" data-id="<?php echo $user;?>"  class="btn btn-primary ml-auto open-balance"><i class="fadeIn animated bx bx-plus"></i> Add Balance</button> 
													<!-- <p class="mb-0 ml-sm-3 text-muted">3 Job History</p> <a href="javascript:;" class="btn btn-primary ml-auto radius-10"><i class='bx bx-plus'></i> Add More</a> -->
												</div>

                                                <div class="table-responsive">
                                                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Title</th>
                                                                <th>Type</th>
                                                                <th>Payment ID</th>
                                                                <th>Amount</th>
                                                                <th>User Balance</th>
                                                                <th>Date</th>
                                                            </tr>
                                                        </thead>
                                                      
                                
                                                        <tbody>
                                                            <?php
                                                                if(isset($_REQUEST["user"]))
                                                                {
                                                                    $count=1;
                                                                    $result=mysqli_query($conn,"select * from tbl_user_balance_log where ubl_type='Credit' and user_id='".$user."' order by ubl_id DESC");
                                                                    while($row=mysqli_fetch_array($result))
                                                                    {
                                                            ?> 
                                                            
                                                            
                                                            <tr>
                                                                    
                                                                    
                                                                    <td><?php echo $count++;?></td>
                                                                    <td><?php echo $row['tbl_tilte'];?></td>
                                                                    <td><?php echo $row['ubl_type'];?></td>
                                                                    <td><?php
                                                                        if($row['pay_id']==NULL)
                                                                        {?>
                                                                        Admin Added
                                                                        <?php }
                                                                        else
                                                                        {?>
                                                                            
                                                                        <?php echo $row['pay_id'];?>
                                                                        <?php }
                                                                    ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $row['ubl_amount'];?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $row['ubl_user_balance'];?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $row['ubl_date'];?>
                                                                    </td>
                                                                    
                                                   
                                                            </tr>
                                                            <?php }}?>
                                
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Title</th>
                                                                <th>Type</th>
                                                                <th>Payment ID</th>
                                                                <th>Amount</th>
                                                                <th>User Balance</th>
                                                                <th>Date</th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>

											</div>
										</div>
									</div>
								
								    <div class="tab-pane fade" id="Detail-Invoice">
									    <form method="post" action="invoice/user_detail_invoice.php">
										<div class="card shadow-none border mb-0 radius-15">
											<div class="card-body">
												<div class="form-body">
													<div class="row">
														<div class="col-12 col-lg-5">
															<div class="form-group">
																<label>Start Date</label>
																<input type="date" name="txtsdate" class="form-control">
																<input type="hidden" name="txtuser" value='<?php echo $_REQUEST["user"]?>' class="form-control">
															</div>
															
															
															

														</div>
														<div class="col-12 col-lg-7">
                                                            <div class="form-group">
																<label>End Date</label>
																<input type="date" name="txtedate" class="form-control">
															</div>
                                                            

															<button type="submit" name="BtnShowDetailInvoice" class="btn btn-light-primary"><i class="fadeIn animated bx bx-show"></i> Detail Invoice</button>
															</div>
													</div>
												</div>
											</div>
										</div>
										</form>
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
	
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAQfo7QS7ZPiUdTiXTHgGmtmOA7k1FTUKE"></script>
    <script type="text/javascript">
        function initialize() {
            // Creating map object
            var map = new google.maps.Map(document.getElementById('map_canvas'), {
                zoom: 12,
                center: new google.maps.LatLng(28.47399, 77.026489),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });
            // creates a draggable marker to the given coords
            var vMarker = new google.maps.Marker({
                position: new google.maps.LatLng(28.47399, 77.026489),
                draggable: true
            });
            // adds a listener to the marker
            // gets the coords when drag event ends
            // then updates the input with the new coords
            google.maps.event.addListener(vMarker, 'dragend', function (evt) {
                $("#txtLat").val(evt.latLng.lat().toFixed(6));
                $("#txtLng").val(evt.latLng.lng().toFixed(6));
                map.panTo(evt.latLng);
            });
            // centers the map on markers coords
            map.setCenter(vMarker.position);
            // adds the marker on the map
            vMarker.setMap(map);
        }
    </script>

<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>        
<!-- Please Insert Your Map API here -->
<!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCad3igTwLyPF_HT3PEgWUJAZQFIwvfGNE"></script>-->
<!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC1JUR90mY1UEDxLP03eAnMwAbG-wdujHk"></script>-->
<!-- AIzaSyCad3igTwLyPF_HT3PEgWUJAZQFIwvfGNE -->
    <script type="text/javascript" src="gmap-drag.js"></script>
    <script>
        $(document).on('click','.open-dialog',function(){
            var id = $(this).attr('data-id');
            $('#deleteid').val(id);
        });
    </script>
    <script>
        $(document).on('click','.open-popup',function(){
            var id = $(this).attr('new-data-id');
            $('#newid').val(id);
        });
    </script>
    <script>
        $(document).on('click','.open-balance',function(){
            var id = $(this).attr('data-id');
            $('#balanceid').val(id);
        });
    </script>
    
</body>

</html>