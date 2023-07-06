<?php
	session_start();
	include 'connection.php';
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
	
// 	$cf = "22:00:00";
// 	$cs = "14:00:00";


// 	$mor = "00:00:00";
// 	$morend = "13:59:59";
	
// 	$evn = "14:00:00";
// 	$evnend = "21:59:59";
	
// 	$next = "22:00:00";
// 	$nextend = "23:59:59";

	$cf = "09:00:00";
	$cs = "17:00:00";


	$mor = "00:00:00";
	$morend = "16:59:59";
	
	$evn = "17:00:00";
	$evnend = "23:59:59";
	
	$curdate = date("Y-m-d H:i:s");
	
	$first = date('Y-m-d H:i:s', strtotime("$date $mor"));
	$sec = date('Y-m-d H:i:s', strtotime("$date $morend"));
	
	
	$thr = date('Y-m-d H:i:s', strtotime("$date $evn"));
	$fur = date('Y-m-d H:i:s', strtotime("$date $evnend"));
	
	
	if(($first < $curdate) && ($curdate < $sec))
	{
		$time = 1;

	}
	elseif(($thr < $curdate) && ($curdate < $fur))
	{
		$time = 2;
	}
	else
	{}
	
?>

<div class="sidebar-wrapper" data-simplebar="true">
			<div class="sidebar-header">
				<div class="">
					<img src="assets/images/logo-icon.png" class="logo-icon-2" alt="" />
				</div>
				<div>
					<h4 class="logo-text">Dairy</h4>
				</div>
				<a href="javascript:;" class="toggle-btn ml-auto"> <i class="bx bx-menu"></i>
				</a>
			</div>
			<!--navigation-->
			<ul class="metismenu" id="menu">
				
                <li>
					<a href="index.php">
						<div class="parent-icon icon-color-1"><i class="bx bx-home-alt"></i>
						</div>
						<div class="menu-title">Dashboard</div>
					</a>
				</li>
				<li class="menu-label">Web Apps</li>


                <li>
					<a href="order_sheet.php?date=<?php echo $date?>&time=<?php echo $time?>">
						<div class="parent-icon icon-color-2"><i class="bx bx-shopping-bag"></i>
						</div>
						<div class="menu-title">Order Sheet</div>
					</a>
				</li>
                <li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon icon-color-3"><i class="bx bx-shopping-bag"></i>
						</div>
						<div class="menu-title">Order</div>
					</a>
					<ul>
						<li> <a href="subscription_order.php"><i class="bx bx-right-arrow-alt"></i>Subscription</a>
						</li>
						<li> <a href="one_time_order.php"><i class="bx bx-right-arrow-alt"></i>One Time</a>
						</li>
					</ul>
				</li>
				
				<li>
					<a href="time_slot.php">
						<div class="parent-icon icon-color-4"><i class="bx bx-time-five"></i>
						</div>
						<div class="menu-title">Time Slot</div>
					</a>
				</li>
				
				<li>
					<a href="area.php">
						<div class="parent-icon icon-color-5"><i class="bx bx-map"></i>
						</div>
						<div class="menu-title">Area</div>
					</a>
				</li>
				
				<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon icon-color-6"><i class="bx bx-spa"></i>
						</div>
						<div class="menu-title">Product</div>
					</a>
					<ul>
						<li> <a href="category.php"><i class="bx bx-right-arrow-alt"></i>Category</a>
						</li>
						<li> <a href="attribute.php"><i class="bx bx-right-arrow-alt"></i>Attribute</a>
						</li>
						<li> <a href="product.php"><i class="bx bx-right-arrow-alt"></i>Product</a>
						</li>
					</ul>
				</li>
				
				<!--<li>-->
				<!--	<a href="area.php">-->
				<!--		<div class="parent-icon icon-color-2"><i class="bx bx-time-five"></i>-->
				<!--		</div>-->
				<!--		<div class="menu-title">Location</div>-->
				<!--	</a>-->
				<!--</li>-->
				
				<li>
					<a href="banner.php">
						<div class="parent-icon icon-color-7"><i class="bx bx-image"></i>
						</div>
						<div class="menu-title">Banner</div>
					</a>
				</li>
				
				<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon icon-color-8"><i class="bx bx-user"></i>
						</div>
						<div class="menu-title">User</div>
					</a>
					<ul>
						<li> <a href="new_user.php"><i class="bx bx-right-arrow-alt"></i>New User</a>
						</li>
						<li> <a href="approve_user.php"><i class="bx bx-right-arrow-alt"></i>Approve User</a>
						</li>
						<li> <a href="unapprove_user.php"><i class="bx bx-right-arrow-alt"></i>Unapprove User</a>
						</li>
					</ul>
				</li>
				
				<li>
					<a href="recharge.php">
						<div class="parent-icon icon-color-9"><i class="fadeIn animated bx bx-rupee"></i>
						</div>
						<div class="menu-title">Recharge</div>
					</a>
				</li>
				
				
				<li>
					<a href="delivery_boy.php">
						<div class="parent-icon icon-color-10"><i class="bx bx-user"></i>
						</div>
						<div class="menu-title">Delivery Boy</div>
					</a>
				</li>
				
				<li>
					<a href="faq.php">
						<div class="parent-icon icon-color-11"><i class="bx bx-message-square-detail"></i>
						</div>
						<div class="menu-title">FAQ</div>
					</a>
				</li>
				
				<li>
					<a href="recharge_offer.php">
						<div class="parent-icon icon-color-12"><i class="bx bx-message-square-detail"></i>
						</div>
						<div class="menu-title">Recharge Offer</div>
					</a>
				</li>
				
				<!--<li>-->
				<!--	<a href="order.php">-->
				<!--		<div class="parent-icon icon-color-2"><i class="bx bx-message-square-detail"></i>-->
				<!--		</div>-->
				<!--		<div class="menu-title">Order</div>-->
				<!--	</a>-->
				<!--</li>-->
				
				<!--<li>-->
				<!--	<a href="user_detail.php?user=1">-->
				<!--		<div class="parent-icon icon-color-2"><i class="bx bx-message-square-detail"></i>-->
				<!--		</div>-->
				<!--		<div class="menu-title">User Detail</div>-->
				<!--	</a>-->
				<!--</li>-->
				
				
				<li class="menu-label">CronJob</li>
				<li>
					<a href="api/cronjobs/userOrderDate.php">
						<div class="parent-icon icon-color-2"><i class="bx bx-refresh"></i>
						</div>
						<div class="menu-title">CronJob</div>
					</a>
				</li>
				

				
			</ul>
			<!--end navigation-->
		</div>