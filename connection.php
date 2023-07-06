<?php
date_default_timezone_set("Europe/London"); 
    $conn=mysqli_connect("localhost","activrm2_7047CEM","Active4u.","activrm2_7047CEM") or die(mysqli_error($conn));

    //ADMIN
    
    $webname = "Admin Farm";
    
    $ADMIN_PRODUCT_IMG = "images/product/";
    $ADMIN_CATEGORY_IMG = "images/category/";  
    $ADMIN_DELIVERYBOY_IMG = "images/deliveryboy/";   
    $ADMIN_MORE_IMG = "images/more/";       
    $ADMIN_DELIVERYBOY_CASH_IMG = "images/payment_deliveryboy/";
    
    $ADMIN_SLIDER_IMG = "images/slider/";  

    $ADMIN_SUBCATEGORY_IMG = "images/subcategory/";
    $ADMIN_CATALOGUE_IMG = "images/catalogue/";
    $ADMIN_CATALOGUE_PDF = "images/catalogue/pdf/";
    $ADMIN_SERVICE_IMG = "images/service/";
    $ADMIN_MEDIA_IMG = "images/media/";
    $ADMIN_SLIDER_IMG = "images/slider/";
    $ADMIN_GALLERY_IMG  = "images/gallery/";
    $ADMIN_BLOG_IMG  = "images/blog/";
    $ADMIN_MENU_IMG  = "images/logo/";
    
    //FUNCATION ASSETES
	$date = date("Y-m-d");
    // $date = "2022-12-05";
	
	$cf = "09:00:00";
	$cs = "17:00:00";


	$mor = "00:00:00";
	$morend = "16:59:59";
	
	$evn = "17:00:00";
	$evnend = "23:59:59";

	$curdate = date("Y-m-d H:i:s");
    // $curdate = "2022-12-05 19:00:00";
	
	$first = date('Y-m-d H:i:s', strtotime("$date $mor"));
	$sec = date('Y-m-d H:i:s', strtotime("$date $morend"));
	
	
	$thr = date('Y-m-d H:i:s', strtotime("$date $evn"));
	$fur = date('Y-m-d H:i:s', strtotime("$date $evnend"));
	
	
	if(($first < $curdate) && ($curdate < $sec))
	{
		$time = 1;
		$cutoff = date('Y-m-d H:i:s', strtotime("$date $cf"));
		$day = "Morning";
		
		$newdate = $date;

	}
	elseif(($thr < $curdate) && ($curdate < $fur))
	{
		$time = 2;
		$cutoff = date('Y-m-d H:i:s', strtotime("$date $cs"));
		$day = "Evening";
		
		$newdate = $date;
	}
	else
	{}
    //FUNCATION ASSETES

?>