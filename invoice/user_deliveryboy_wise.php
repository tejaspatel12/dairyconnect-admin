<?php 
    include '../connection.php';
?>
<?php 
    if(isset($_REQUEST["BtnShowInvoice"]))
    {

        $start_date=$_REQUEST["txtsdate"];
        $end_date=$_REQUEST["txtedate"];
        $delivery_boy=$_REQUEST["txtdelivery_boy"];
        
        // $start_date=$_POST["start_date"];
        // $end_date=$_POST["end_date"];
        // $user_id=$_POST["end_date"];
        // $user_id="2";


    $result1=mysqli_query($conn,"select * from tbl_user as u left join tbl_area as a on u.area_id=a.area_id where deliveryboy_id ='".$delivery_boy."'")or die(mysqli_error($conn));
    while($row=mysqli_fetch_assoc($result1))
    {
        $username = $row['user_first_name']." ".$row['user_last_name'];
        $user_address = $row['user_address'];
        $user_mobile_number = $row['user_mobile_number'];
        $user_id = $row['user_id'];
        ?>
        
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!--  This file has been downloaded from bootdey.com @bootdey on twitter -->
    <!--  All snippets are MIT license http://bootdey.com/license -->
    <title>User Detail Invoice</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
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
<body>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

        
        
        <div class="container">
           <div class="col-md-12">
              <div class="invoice">
                 <!-- begin invoice-company -->
                 <div class="invoice-company text-inverse f-w-600">
                    <span class="pull-right hidden-print">
                    <!--<a href="javascript:;" class="btn btn-sm btn-white m-b-10 p-l-5"><i class="fa fa-file t-plus-1 text-danger fa-fw fa-lg"></i> Export as PDF</a>-->
                    <a href="javascript:;" onclick="window.print()" id="myPrntbtn" name="myPrntbtn" class="btn btn-sm btn-white m-b-10 p-l-5"><i class="fa fa-print t-plus-1 fa-fw fa-lg"></i> Print</a>
                    </span>
                    <div style="text-align: center;">M POONAM NATURAL</div>
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
                       <small>to</small>
                       <address class="m-t-5 m-b-5">
                          <strong class="text-inverse"><?php echo $username;?></strong><br>
                          <?php echo $user_address;?><br>
                          <!--City, Zip Code<br>-->
                          Phone: <?php echo $user_mobile_number;?><br>
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
                                <th>SR NO.</th>
                                <th class="text-center" width="10%">PRODUCT NAME</th>
                                <th class="text-center" width="10%">QTY</th>
                                <th class="text-center" width="10%">RATE</th>
                                <th class="text-right" width="20%">DATE</th>
                                <th class="text-right" width="20%">SUB TOTAL</th>
                             </tr>
                          </thead>
                          <tbody>
                              <?php
                                $count=1;
                                $totalprice=0;
                                $result=mysqli_query($conn,"SELECT * from tbl_order_calendar as oc left join tbl_product as p on oc.product_id=p.product_id WHERE oc.user_id='$user_id' and oc.order_date BETWEEN '$start_date' AND '$end_date' and oc.oc_is_delivered='1'");
                                while($row=mysqli_fetch_array($result))
                            {?>
                             <tr>
                                 <td>
                                   <?php echo $count++;?>
                                </td>
                                <td>
                                   <span class="text-inverse"><?php echo $row['product_name']?></span><br>
                                   <!--<small>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed id sagittis arcu.</small>-->
                                </td>
                                <td class="text-center"><?php echo $row['order_qty']?></td>
                                <td class="text-center">₹<?php echo $row['order_one_unit_price']?></td>
                                <td class="text-right"><?php echo $row['order_date']?></td>
                                <?php $new = $row['order_qty'] * $row['order_one_unit_price']?>
                                <td class="text-right">₹<?php echo $new;?></td>
                                <?php $totalprice += $new++?>
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
                          <!-- end invoice-content -->
                 <!-- begin invoice-note -->
                 <!--<div class="invoice-note">-->
                 <!--   <b style="color: black">Company's Bank Details</b><br><br>-->
                 <!--   <p style="color: black">Name        : AXIS BANK<br>-->
                 <!--   A/C. No     : 917020048688694<br>-->
                 <!--   IFSC Code   : UTIB0001050<br>-->
                 <!--   Branch      : MAGOB<br></p>-->
                 <!--</div>-->
                 <div class="invoice-note">
                    <b style="color: black">Company's Bank Details</b><br><br>
                    <p style="color: black">Payee Name        : DAIRY CONNECT<br>
                    A/C. No     : 4111 1111<br>
                    Sort Code   : ABCD12345<br><br></p>
                 </div>
                 <!-- end invoice-note -->
                 <!-- begin invoice-note -->
                 <div class="invoice-note">
                    <a style="color: black">* Make all cheques payable to DAIRY CONNECT<br>
                    * Payment is due within 10 days<br>
                    * If you have any questions concerning this invoice, contact  [+44 7384027551]</a>
                 </div>
                 <!-- end invoice-note -->
                 
                 <!-- end invoice-footer -->
              </div>
           </div>
        </div>

        <?php
    }
?>
        

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

</body>
</html>
<?php }?>