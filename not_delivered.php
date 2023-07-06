<?php
    session_start();
    include 'connection.php';
    $title = "Order";
    $code = "order";
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
    $no = "0";
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
									<li class="breadcrumb-item active" aria-current="page"><?php echo $title;?> DataTable</li>
								</ol>
							</nav>
						</div>
						
						<!-- Modal -->
    					<div class="modal fade" id="exampleModal6" tabindex="-1" role="dialog" aria-hidden="true">
    						<div class="modal-dialog modal-dialog-centered">
    							<div class="modal-content radius-30">
    								<div class="modal-header border-bottom-0">
    									<button type="button" class="close" data-dismiss="modal" aria-label="Close">	<span aria-hidden="true">&times;</span>
    									</button>
    								</div>
    								<div class="modal-body p-5">
    									<form method="get" action="not_delivered.php?date=<?php $_REQUEST["date"]?>&time=<?php $_REQUEST["time"]?>">
    									<h3 class="text-center">Date</h3>
    									
    									<div class="form-group">
    										<input type="date" name="date" class="form-control form-control-lg radius-30">
    									</div>
    									<div class="form-group">
    										<select class="form-control form-control-lg radius-30" name="time">
                                                                        <option>select</option>
                                                                        <option value="1">Morning Batch</option>
                                                                        <option value="2">Evening Batch</option>
                                                                    </select>
    									</div>
    									<!-- <div class="form-group">
    										<input type="text" name="txtbalance" value="" class="form-control form-control-lg radius-30" />
    									</div> -->
    									
    									
    									<div class="form-group text-right my-4"> 
    									</div>
    									<div class="form-group">
    										<button type="submit" class="btn btn-primary radius-30 btn-lg btn-block">Check</button>
    									</div>
    									</form>
    									
    									
    								</div>
    							</div>
    						</div>
    					</div>
					<!-- Modal -->
					
						<div class="ml-auto">
							<div class="btn-group">
								<!-- <button type="button" class="btn btn-primary">Settings</button> -->
								<button type="button" data-toggle="modal" data-target="#exampleModal6" class="btn btn-primary" style="margin-right: 10px;">Filter Date</button>
							</div>
						</div>
					</div>
					<!--end breadcrumb-->
					<?php
                        if(isset($_REQUEST['statusid']))
                        {
                            $date = $_REQUEST["date"];
                            $time = $_REQUEST["time"];

                                if($_REQUEST["val"]=="1")
                                {
                                    
                                    $resultq=mysqli_query($conn,"select user_id from tbl_order_calendar where oc_id='".$_REQUEST["statusid"]."'");
                                    while($rowq=mysqli_fetch_array($resultq))
                                    {
                                        $user_id = $rowq['user_id'];
                                    }
                                    
                                    $resultq=mysqli_query($conn,"select user_balance from tbl_user where user_id='".$user_id."'");
                                    while($rowq=mysqli_fetch_array($resultq))
                                    {
                                        $balance = $rowq['user_balance'];
                                    }
                                
                                    $result=mysqli_query($conn,"select * from tbl_order_calendar as oc left join tbl_not_delivered as nd on oc.oc_id=nd.oc_id where oc.oc_id='".$_REQUEST['statusid']."'");
                                    
                                       while($row=mysqli_fetch_array($result))
                                       {
                                           $order_one_unit_price = $row['order_one_unit_price'];
                                           $order_qty = $row['order_qty'];
                                           $delivered_qty = $row['delivered_qty'];
                                           $not_delivered_qty = $row['not_delivered_qty'];
                                           $final_total = $order_one_unit_price * $delivered_qty;
                                       } 
                                    $totalqty = $delivered_qty + $not_delivered_qty;
                                       
                                $oldtotal =  $totalqty * $order_one_unit_price;
                                $removebalance = $balance + $oldtotal;
                                
                                
                                $result=mysqli_query($conn,"update tbl_user set user_balance='".$removebalance."' where user_id='".$user_id."'") or die(mysqli_error($conn));
                                
                                $resultb=mysqli_query($conn,"select user_balance from tbl_user where user_id ='".$user_id."'");
                                while($rowb=mysqli_fetch_array($resultb))
                                {
                                    $newbalance = $rowb['user_balance'];
                                }
                                
                                $total =  $delivered_qty * $order_one_unit_price;
                                $addbalance = $newbalance - $total;

                                if($delivered_qty=='0')
                                {       
                                    mysqli_query($conn,"update tbl_order_calendar set order_qty='$delivered_qty',order_total_amt='$final_total',oc_admin_approve='1',oc_is_delivered='5' where oc_id='".$_REQUEST['statusid']."'");
                                }
                                else
                                {
                                    $result1=mysqli_query($conn,"update tbl_user set user_balance='".$addbalance."' where user_id='".$user_id."'") or die(mysqli_error($conn));
                                        
                                    mysqli_query($conn,"update tbl_order_calendar set order_qty='$delivered_qty',order_total_amt='$final_total',oc_admin_approve='1' where oc_id='".$_REQUEST['statusid']."'");
                                }

                                echo "<script>window.location='not_delivered.php?date=$date&time=$time';</script>";
                                
                                }
                                elseif($_REQUEST["val"]=="2")
                                {
                                    $resultq=mysqli_query($conn,"select user_id from tbl_order_calendar where oc_id='".$_REQUEST["statusid"]."'");
                                    while($rowq=mysqli_fetch_array($resultq))
                                    {
                                        $user_id = $rowq['user_id'];
                                    }
                                    
                                    $resultq=mysqli_query($conn,"select user_balance from tbl_user where user_id='".$user_id."'");
                                    while($rowq=mysqli_fetch_array($resultq))
                                    {
                                        $balance = $rowq['user_balance'];
                                    }
                                    
                                    $result=mysqli_query($conn,"select * from tbl_order_calendar as oc left join tbl_not_delivered as nd on oc.oc_id=nd.oc_id where oc.oc_id='".$_REQUEST['statusid']."'");
                                       while($row=mysqli_fetch_array($result))
                                       {
                                           $old_qty = $row['nd_order_qty']; 
                                           $order_one_unit_price = $row['order_one_unit_price'];
                                           $order_qty = $row['order_qty'];
                                           $delivered_qty = $row['delivered_qty'];
                                           $not_delivered_qty = $row['not_delivered_qty'];
                                           $final_total = $order_one_unit_price * $old_qty;
                                       }  
                                       
                                   $totalqty = $delivered_qty + $not_delivered_qty;
                                   
                                    $oldtotal =  $order_qty * $order_one_unit_price;
                                    $removebalance = $balance + $oldtotal;
                                    
                                    
                                    $result=mysqli_query($conn,"update tbl_user set user_balance='".$removebalance."' where user_id='".$user_id."'") or die(mysqli_error($conn));
                                    
                                    $resultb=mysqli_query($conn,"select user_balance from tbl_user where user_id ='".$user_id."'");
                                    while($rowb=mysqli_fetch_array($resultb))
                                    {
                                        $newbalance = $rowb['user_balance'];
                                    }
                                    
                                    $total =  $totalqty * $order_one_unit_price;
                                    $addbalance = $newbalance - $total;
                                    
                                    $result1=mysqli_query($conn,"update tbl_user set user_balance='".$addbalance."' where user_id='".$user_id."'") or die(mysqli_error($conn));
                                
                                       
                                    mysqli_query($conn,"update tbl_order_calendar set order_total_amt='$final_total',order_qty='$old_qty',oc_admin_approve='2',oc_is_delivered='1' where oc_id='".$_REQUEST['statusid']."'");

                                    echo "<script>window.location='not_delivered.php?date=$date&time=$time';</script>";
                                }
                                else
                                {
                                    
                                }
                                    
                                
            
                        }
                    ?>
                    
					<div class="card">
						<div class="card-body">
							<div class="card-title">
								<h4 class="mb-0">Not Delivered</h4>
							</div>
							<hr/>
							<div class="table-responsive">
								<table id="example" class="table table-striped table-bordered" style="width:100%">
									<thead>
										<tr>
                                            <th>#</th>
                                            <th>Product</th>
                                            <th>User</th>
                                            <th>Delivery Boy</th>
                                            <th>Area</th>
                                            <th>Date</th>
                                            <th>Quantity</th>
                                            <th>Delivered</th>
                                            <th>Not Delivered</th>
                                            <th>Action</th>
										</tr>
									</thead>
									<tbody>
                                        <?php
                                        $count = 1;
                                            if(isset($_REQUEST["product_id"], $_REQUEST["date"]))
                                            {
                                                $result=mysqli_query($conn,"select * from tbl_order_calendar as oc left join tbl_product as p on p.product_id=oc.product_id left join tbl_user as u on u.user_id=oc.user_id left join tbl_area as a on a.area_id=u.area_id where oc.product_id='".$_REQUEST["product_id"]."' and oc.order_date='".$_REQUEST["date"]."'");
                                            }  
                                            elseif(isset($_REQUEST["date"], $_REQUEST["time"]))
                                            {
                                                $cf = "22:00:00";
                                                $cs = "14:00:00";
                                                
                                                $date = $_REQUEST["date"];
                                                $time = $_REQUEST["time"];
                                                if($time == '1')
                                                {
                                                    $cutoff = date('Y-m-d H:i:s', strtotime("$date $cf"));
						                            $cutoff = date('Y-m-d H:i:s', strtotime($cutoff. ' -  1 days')); 
                                                }
                                                else
                                                {
                                                    $cutoff = date('Y-m-d H:i:s', strtotime("$date $cs"));
                                                }
                                                
                                                // $date = $_REQUEST["txttype"];
                                                
                                                $result=mysqli_query($conn,"select * from tbl_order_calendar as oc left join tbl_product as p on p.product_id=oc.product_id left join tbl_user as u on u.user_id=oc.user_id left join tbl_area as a on a.area_id=u.area_id left join tbl_deliveryboy as d on u.deliveryboy_id=d.deliveryboy_id left join tbl_not_delivered as nd on nd.oc_id=oc.oc_id where oc.oc_notdelivered_issue='1' and oc.order_date='$date' and oc.oc_cutoff_time='$cutoff'");
                                            }
                                            else
                                            {  
                                                $result=mysqli_query($conn,"select * from tbl_order_calendar as oc left join tbl_product as p on p.product_id=oc.product_id left join tbl_user as u on u.user_id=oc.user_id left join tbl_area as a on a.area_id=u.area_id left join tbl_deliveryboy as d on u.deliveryboy_id=d.deliveryboy_id left join tbl_not_delivered as nd on nd.oc_id=oc.oc_id where oc.oc_notdelivered_issue='1' and oc.order_date='$date'");
                                            }
                                            while($row=mysqli_fetch_array($result))
                                        {?>
										<tr>
                                                <td><?php echo $count++;?></td>
                                                <td><a href="update_one_order.php?order=<?php echo $row["oc_id"]?>&user=<?php echo $row["user_id"]?>"><?php echo $row['product_name'];?></a></td>
                                                <td><a href="user_detail.php?user=<?php echo $row['user_id']?>">
                                                    <?php echo $row['user_first_name']." ".$row['user_last_name'];?><br>
                                                    <h6 style="color: #2f4cdd"><?php echo "+91".$row['user_mobile_number'];?></h6>
                                                    </a>
                                                </td>
                                                 <td>
                                                     <a href="edit_delivery_boy.php?delivery_boy=<?php echo $row['deliveryboy_id']?>">
                                                    <?php echo $row['deliveryboy_first_name']." ".$row['deliveryboy_last_name'];?><br>
                                                    <h6 style="color: #2f4cdd"><?php echo "+91".$row['deliveryboy_mobile_number'];?></h6>
                                                    </a>
                                                </td>
                                                <td><?php echo $row['area_name'];?></td>
                                                <td><?php echo $row['order_date'];?></td>
                                               

                                                <td><?php echo $row['nd_order_qty'];?></td>
                                                <td><?php echo $row['delivered_qty'];?></td>
                                                <td><?php echo $row['not_delivered_qty'];?></td>   
                                                
                                                <?php if($row['nd_complate']=="0"){?>
                                                <td>
                                                    <?php if($row['oc_admin_approve']=='0'){?>
                                                        <button type="button" onclick="window.location='not_delivered.php?statusid=<?php echo $row['oc_id'];?>&val=1&date=<?php echo $date?>&time=<?php echo $time?>';" name="btnno" class="btn btn-success btn-sm m-1">Grant </button>
                                                        <button type="button" onclick="window.location='not_delivered.php?statusid=<?php echo $row['oc_id'];?>&val=2&date=<?php echo $date?>&time=<?php echo $time?>';" name="btnno" class="btn btn-danger btn-sm m-1">Deny </button>
                                                    <?php }elseif($row['oc_admin_approve']=='1'){?>
                                                        <button type="button" onclick="window.location='not_delivered.php?statusid=<?php echo $row['oc_id'];?>&val=1&date=<?php echo $date?>&time=<?php echo $time?>';" name="btnno" class="btn btn-light-success btn-sm m-1">Grant </button>
                                                        <button type="button" onclick="window.location='not_delivered.php?statusid=<?php echo $row['oc_id'];?>&val=2&date=<?php echo $date?>&time=<?php echo $time?>';" name="btnno" class="btn btn-danger btn-sm m-1">Deny </button>
                                                    <?php }elseif($row['oc_admin_approve']=='2'){?>
                                                        <button type="button" onclick="window.location='not_delivered.php?statusid=<?php echo $row['oc_id'];?>&val=1&date=<?php echo $date?>&time=<?php echo $time?>';" name="btnno" class="btn btn-success btn-sm m-1">Grant </button>
                                                        <button type="button" onclick="window.location='not_delivered.php?statusid=<?php echo $row['oc_id'];?>&val=2&date=<?php echo $date?>&time=<?php echo $time?>';" name="btnno" class="btn btn-light-danger btn-sm m-1">Deny </button>
                                                    <?php }else{}?>
                                                </td>  <?php }else{?> 
                                                <td>
                                                    Grand Option is Remove Now...<br>
                                                    You Change it with in 24 Hr after Delivery
                                                </td>
                                                
                                                <?php }?>
										</tr>
										<?php }?>
			
									</tbody>
									<tfoot>
										<tr>
                                            <th>#</th>
                                            <th>Product</th>
                                            <th>User</th>
                                            <th>Delivery Boy</th>
                                            <th>Area</th>
                                            <th>Date</th>
                                            <th>Quantity</th>
                                            <th>Delivered</th>
                                            <th>Not Delivered</th>
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
	<!-- App JS -->
	<script src="assets/js/app.js"></script>
</body>

</html>