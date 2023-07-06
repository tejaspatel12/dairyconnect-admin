<?php 
    include '../connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!--  This file has been downloaded from bootdey.com @bootdey on twitter -->
    <!--  All snippets are MIT license http://bootdey.com/license -->
    <title>Invoice</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.1/dist/js/bootstrap.bundle.min.js"></script>
	<style>
      @media print { @page { margin: 0; } 
       body { margin: 1.6cm; } }
    </style>
    <style type="text/css">
        @media print {
            #myPrntbtn {
                display :  none;
            }
        }
    </style>
</head>
<body>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<?php 
    if(isset($_REQUEST["BtnDeliveryBoyInvoice"]))
    {

        $start_date=$_REQUEST["txtsdate"];
        $end_date=$_REQUEST["txtedate"];
        $deliveryboy_id=$_REQUEST["txtdelivery_boy"];
        
        // echo "Start Date : "."".$start_date."<br>";
        // echo "End Date : "."".$end_date."<br><br>";
        
        // $start_date=$_POST["start_date"];
        // $end_date=$_POST["end_date"];
        // $user_id=$_POST["end_date"];
        // $user_id="2";


    $result1=mysqli_query($conn,"select * from tbl_user as u left join tbl_area as a on u.area_id=a.area_id left join tbl_deliveryboy as d on u.deliveryboy_id=d.deliveryboy_id where u.deliveryboy_id ='$deliveryboy_id'")or die(mysqli_error($conn));
    while($row=mysqli_fetch_assoc($result1))
    {
        $name = $row['deliveryboy_first_name']." ".$row['deliveryboy_last_name'];
        $mobile_number = $row['deliveryboy_mobile_number'];
    }
?>
        
<div class="container">
   <div class="col-md-12">
      <div class="invoice">
         <!-- begin invoice-company -->
         <div class="invoice-company text-inverse f-w-600">
            <span class="pull-right hidden-print">
            <!--<a href="javascript:;" class="btn btn-sm btn-white m-b-10 p-l-5"><i class="fa fa-file t-plus-1 text-danger fa-fw fa-lg"></i> Export as PDF</a>-->
            <a href="javascript:;" onclick="window.print()" id="myPrntbtn" name="myPrntbtn" class="btn btn-sm btn-white m-b-10 p-l-5"><i class="fa fa-print t-plus-1 fa-fw fa-lg"></i> Print</a>
            </span>
            <div style="text-align: center;">DAIRY CONNECT</div>
         </div>
         <!-- end invoice-company -->
         <!-- begin invoice-header -->
         <div class="invoice-header">
            <div class="invoice-from">
               <small>from</small>
               <address class="m-t-5 m-b-5">
                  <strong class="text-inverse">DAIRY CONNECT</strong><br>
                  West Orchards Shopping Centre,<br>
                  Coventry CV1 1QX<br>
                  Phone: +44 7284027551<br>
               </address>
            </div>
            <div class="invoice-to">
               <small>Delivery Boy to,</small>
               <address class="m-t-5 m-b-5">
                  <strong class="text-inverse"><?php echo $name;?></strong><br>
                  <!--City, Zip Code<br>-->
                  Phone: <?php echo $mobile_number;?><br>
               </address>
            </div>
            <div class="invoice-date">
               <small>Invoice / <?php echo $start_date." to ".$end_date ?> period</small>
               <!--<div class="date text-inverse m-t-5">August 3,2012</div>-->
               <div class="invoice-detail">
                  #0000123DSS<br>
                  Services Product
               </div>
            </div>
         </div>
         <!-- end invoice-header -->
         <!-- begin invoice-content -->
         <div class="invoice-content">
            <!-- begin table-responsive -->
            <div class="table-responsive">
               <table class="table table-invoice">
                  <thead>
                     <tr>
                        <th width="10%">SR NO.</th>
                        <th class="text-left" width="10%">USER</th>
                        <th class="text-left" width="10%">PRODUCT NAME</th>
                        <th class="text-center" width="10%">QTY</th>
                        <!--<th class="text-center" width="10%">RATE</th>-->
                        <!--<th class="text-right" width="10%">SUB TOTAL</th>-->
                        <!--<th class="text-right" width="10%">USER BALANCE</th>-->
                        <th class="text-right" width="10%">TO COLLECT</th>
                        <th class="text-right" width="10%">COLLECTED</th>
                     </tr>
                  </thead>
                  <tbody>
                      <?php
                        $count=1;
                        $totalprice=0;
                        $result=mysqli_query($conn,"SELECT u.*,p.product_name,oc.product_id,oc.order_date,oc.order_one_unit_price,SUM( oc.order_qty ) as quantity,SUM( oc.order_total_amt ) as total from tbl_order_calendar as oc LEFT JOIN tbl_user as u ON oc.user_id=u.user_id left join tbl_deliveryboy as d on d.deliveryboy_id=u.deliveryboy_id left join tbl_product as p on p.product_id=oc.product_id where u.deliveryboy_id='$deliveryboy_id' and oc.order_date between '$start_date' and '$end_date' and oc.oc_is_delivered='1' and u.user_balance<'0.00' GROUP BY u.user_id");
                        while($row=mysqli_fetch_array($result))
                    {?>
                     <tr>
                         <td>
                           <?php echo $count++;?>
                        </td>
                        <td>
                           <b><?php echo $row['user_first_name']." ".$row['user_last_name']; ?></b>
                           <!--<small>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed id sagittis arcu.</small>-->
                        </td>
                        <td>
                           <span class="text-inverse"><?php echo $row['product_name']; ?></span><br>
                           <!--<small>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed id sagittis arcu.</small>-->
                        </td>
                        <td class="text-center"><?php echo $row['quantity']; ?></td>
                        <!--<td class="text-center">₹<?php echo $row['order_one_unit_price']; ?></td>-->
                        <!--<td class="text-center">₹<?php echo $row['total']; ?></td>-->
                        <!--<td class="text-center">₹<?php echo $row['user_balance']; ?></td>-->
                        <!--<?php $totalpaid = $row['total'];?>-->
                        <td class="text-center">₹<?php echo $totalpaid; ?></td>
                        <td class="text-left">₹ </td>
                        <?php $totalprice += $row['total']++?>
                     </tr>
                     <?php }?>
                     
                  </tbody>
               </table>
            </div>
            <!-- end table-responsive -->
            <!-- begin invoice-price -->
            <div class="invoice-price">
               
               <div class="invoice-price-right">
                  <small><h6 style="color:black">TOTAL</h4></small> <span class="f-w-600"><b style="color:black">₹<?php echo $totalprice;?></b></span>
               </div>
            </div>
            <!-- end invoice-price -->
         </div>
         <!-- end invoice-content -->
         <!-- begin invoice-note -->
         <!--<div class="invoice-note">-->
         <!--   <b style="color: black">Company's Bank Details</b><br><br>-->
         <!--   <p style="color: black">Name        : AXIS BANK<br>-->
         <!--   A/C. No     : 917020048688694<br>-->
         <!--   IFSC Code   : UTIB0001050<br>-->
         <!--   Branch      : MAGOB<br></p>-->
         <!--</div>-->
         
         
         <!-- end invoice-footer -->
      </div>
   </div>
</div>

<style type="text/css">
body{
    margin-top:20px;
    background:#eee;
}

.invoice {
    background: #fff;
    padding: 20px
}

.invoice-company {
    font-size: 20px
}

.invoice-header {
    margin: 0 -20px;
    background: #f0f3f4;
    padding: 20px
}

.invoice-date,
.invoice-from,
.invoice-to {
    display: table-cell;
    width: 1%
}

.invoice-from,
.invoice-to {
    padding-right: 20px
}

.invoice-date .date,
.invoice-from strong,
.invoice-to strong {
    font-size: 16px;
    font-weight: 600
}

.invoice-date {
    text-align: right;
    padding-left: 20px
}

.invoice-price {
    background: #f0f3f4;
    display: table;
    width: 100%
}

.invoice-price .invoice-price-left,
.invoice-price .invoice-price-right {
    display: table-cell;
    padding: 20px;
    font-size: 20px;
    font-weight: 600;
    width: 75%;
    position: relative;
    vertical-align: middle
}

.invoice-price .invoice-price-left .sub-price {
    display: table-cell;
    vertical-align: middle;
    padding: 0 20px
}

.invoice-price small {
    font-size: 12px;
    font-weight: 400;
    display: block
}

.invoice-price .invoice-price-row {
    display: table;
    float: left
}

.invoice-price .invoice-price-right {
    width: 25%;
    /*background: #2d353c;*/
    background: #ffffff;
    color: #fff;
    font-size: 28px;
    text-align: right;
    vertical-align: bottom;
    font-weight: 300
}

.invoice-price .invoice-price-right small {
    display: block;
    opacity: .6;
    position: absolute;
    top: 10px;
    left: 10px;
    font-size: 12px
}

.invoice-footer {
    border-top: 1px solid #ddd;
    padding-top: 10px;
    font-size: 10px
}

.invoice-note {
    color: #999;
    margin-top: 40px;
    font-size: 85%
}

.invoice>div:not(.invoice-footer) {
    margin-bottom: 20px
}

.btn.btn-white, .btn.btn-white.disabled, .btn.btn-white.disabled:focus, .btn.btn-white.disabled:hover, .btn.btn-white[disabled], .btn.btn-white[disabled]:focus, .btn.btn-white[disabled]:hover {
    color: #2d353c;
    background: #fff;
    border-color: #d9dfe3;
}
</style>

<script type="text/javascript">

</script>
<?php }?>
</body>
</html>