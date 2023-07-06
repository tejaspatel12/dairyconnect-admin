<?php
    session_start();
    include '../connection.php';


    if(isset($_REQUEST["BtnAdminInvoice"]))
    {

        $start_date=$_REQUEST["txtsdate"];
        $end_date=$_REQUEST["txtedate"];
        $user_id=$_REQUEST["txtuser"];
        // $start_date=$_POST["start_date"];
        // $end_date=$_POST["end_date"];
        // $user_id=$_POST["end_date"];
        // $user_id="2";


    $result1=mysqli_query($conn,"select * from tbl_user where user_id='$user_id'")or die(mysqli_error($conn));
    while($row=mysqli_fetch_assoc($result1))
    {
        $username = $row['user_first_name']+" "+$row['user_last_name'];
        $address = $row['user_address'];
    }
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta charset="utf-8"/>
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
      <link rel="stylesheet" href="base.min.css"/>
      <link rel="stylesheet" href="fancy.min.css"/>
      <link rel="stylesheet" href="main.css"/>
      <script src="compatibility.min.js"></script>
      <script src="theViewer.min.js"></script>
      <script>
         try{
         theViewer.defaultViewer = new theViewer.Viewer({});
         }catch(e){}
      </script>
      <title></title>
   </head>
   <body>
      <div id="sidebar">
         <div id="outline"></div>
      </div>
      <div id="page-container">
         <div id="pf1" class="pf w0 h0" data-page-no="1">
            <div class="pc pc1 w0 h0">
               <img class="bi x0 y0 w0 h1" alt="" src="bg1.png"/>
               <?php
                    $result=mysqli_query($conn,"SELECT p.*,oc.user_id,oc.order_date,COUNT(oc.order_id) as order_qty from tbl_product as p LEFT JOIN tbl_order_calendar as oc ON oc.product_id=p.product_id where oc.user_id='$user_id' and oc.order_date between '$start_date' and '$end_date' GROUP BY p.product_id");
                    while($row=mysqli_fetch_array($result))
                {?>
               <div class="t m0 x1 h2 y1 ff1 fs0 fc0 sc0 ls0 ws0">1<span class="_ _0"> </span><?php echo $row['product_name']?><span class="ff2"> -<span class="_ _1"> </span></span>0%<span class="_ _3"> </span><?php echo $row['order_qty']?> QTY<span class="_ _4"> </span><span class="ff2">85<span class="_ _5"> </span>0.00<span class="_ _6"> </span></span><?php echo $row['order_total_amt']?></div>
               <?php }?>

               <div class="t m0 x2 h3 y2 ff1 fs1 fc0 sc0 ls0 ws0">M POONAM NATURAL</div>
               <div class="t m0 x3 h4 y3 ff2 fs2 fc0 sc0 ls0 ws0">132,POONAM FARM, NEAR VIDHYAMANGAL SCHOOL, NAVIPARDI, KAMREJ, SURAT</div>
               <div class="t m0 x4 h4 y4 ff2 fs2 fc0 sc0 ls0 ws0">Tel/M  : 9825449149</div>
               <div class="t m0 x5 h5 y5 ff1 fs3 fc0 sc0 ls0 ws0">INVOICE</div>
               <div class="t m0 x6 h6 y6 ff2 fs0 fc0 sc0 ls0 ws0">[ ] Original</div>
               <div class="t m0 x7 h4 y7 ff2 fs2 fc0 sc0 ls0 ws0">To ,</div>
               <div class="t m0 x7 h7 y8 ff1 fs2 fc0 sc0 ls0 ws0"><?php echo $username;?></div>
               <div class="t m0 x7 h4 y9 ff2 fs2 fc0 sc0 ls0 ws0">Address : <?php echo mb_strimwidth("$address", 0, 40,"");?></div>
               <div class="t m0 x7 h4 ya ff2 fs2 fc0 sc0 ls0 ws0">CIRCLE  SURAT</div>
               <div class="t m0 x7 h7 yb ff2 fs2 fc0 sc0 ls0 ws0">State : <span class="ff1">Gujarat</span>   State Code : <span class="ff1">24</span>     Tel/M : <span class="ff1">8758567766</span></div>
               <div class="t m0 x8 h4 yc ff2 fs2 fc0 sc0 ls0 ws0">Invoice No.</div>
               <div class="t m0 x9 h8 yd ff3 fs4 fc0 sc0 ls0 ws0">:</div>
               <div class="t m0 xa h7 yc ff1 fs2 fc0 sc0 ls0 ws0">2139</div>
               <div class="t m0 x8 h4 ye ff2 fs2 fc0 sc0 ls0 ws0">Date</div>
               <div class="t m0 x9 h8 yf ff3 fs4 fc0 sc0 ls0 ws0">:</div>
               <div class="t m0 xa h7 ye ff1 fs2 fc0 sc0 ls0 ws0"><?php echo date("d-m-Y")?></div>
               <div class="t m0 x8 h4 y10 ff2 fs2 fc0 sc0 ls0 ws0">BILLING</div>
               <div class="t m0 x8 h4 y11 ff2 fs2 fc0 sc0 ls0 ws0">MONTH</div>
               <div class="t m0 x9 h8 y12 ff3 fs4 fc0 sc0 ls0 ws0">:</div>
               <div class="t m0 xb h6 y13 ff2 fs0 fc0 sc0 ls0 ws0">SR</div>
               <div class="t m0 xc h4 y14 ff2 fs2 fc0 sc0 ls0 ws0">Description Of Goods<span class="_ _7"> </span>HSN/SAC<span class="_ _8"> </span>GST<span class="_ _9"> </span>Quantity<span class="_ _7"> </span>Rate<span class="_ _a"> </span>Disc.(%)<span class="_ _b"> </span>Sub Total</div>
               <div class="t m0 xd h7 y15 ff1 fs2 fc0 sc0 ls0 ws0">TOTAL<span class="_ _c"> </span>47.5</div>
               <div class="t m0 xe h7 y16 ff1 fs2 fc0 sc0 ls0 ws0">Company&apos;s Bank Details</div>
               <div class="t m0 xe h6 y17 ff2 fs0 fc0 sc0 ls0 ws0">Name</div>
               <div class="t m0 xf h7 y18 ff1 fs2 fc0 sc0 ls0 ws0">:<span class="_ _d"> </span><span class="ff2">AXIS BANK</span></div>
               <div class="t m0 xe h6 y19 ff2 fs0 fc0 sc0 ls0 ws0">A/C. No</div>
               <div class="t m0 xf h7 y1a ff1 fs2 fc0 sc0 ls0 ws0">:<span class="_ _d"> </span><span class="ff2">917020048688694</span></div>
               <div class="t m0 xe h6 y1b ff2 fs0 fc0 sc0 ls0 ws0">IFSC Code</div>
               <div class="t m0 xf h7 y1c ff1 fs2 fc0 sc0 ls0 ws0">:<span class="_ _d"> </span><span class="ff2">UTIB0001050</span></div>
               <div class="t m0 xe h6 y1d ff2 fs0 fc0 sc0 ls0 ws0">Branch</div>
               <div class="t m0 xf h7 y1e ff1 fs2 fc0 sc0 ls0 ws0">:<span class="_ _d"> </span><span class="ff2">MAGOB</span></div>
               <div class="t m0 x10 h4 y1f ff2 fs2 fc0 sc0 ls0 ws0">Sub Total</div>
               <div class="t m0 x11 h9 y20 ff1 fs5 fc0 sc0 ls0 ws0">4037.50</div>
               <div class="t m0 x12 h7 y21 ff2 fs2 fc0 sc0 ls0 ws0">CGST(0.0%)<span class="_ _e"> </span><span class="ff1">0.00</span></div>
               <div class="t m0 x12 h7 y22 ff2 fs2 fc0 sc0 ls0 ws0">SGST(0.0%)<span class="_ _e"> </span><span class="ff1">0.00</span></div>
               <div class="t m0 x12 h7 y23 ff2 fs2 fc0 sc0 ls0 ws0">IGST(0.0%)<span class="_ _e"> </span><span class="ff1">0.00</span></div>
               <div class="t m0 x10 h4 y24 ff2 fs2 fc0 sc0 ls0 ws0">Round Off</div>
               <div class="t m0 x13 h9 y25 ff1 fs5 fc0 sc0 ls0 ws0">0.00</div>
               <div class="t m0 x14 h4 y26 ff2 fs2 fc0 sc0 ls0 ws0">Total</div>
               <div class="t m0 x11 h9 y27 ff1 fs5 fc0 sc0 ls0 ws0">4037.50</div>
               <div class="t m0 x7 h7 y28 ff2 fs2 fc0 sc0 ls0 ws0">Amt. Chargeable (words) <span class="ff1">Four Thousand And Thirty Seven Rupees  And Fifty</span></div>
               <div class="t m0 x7 h7 y29 ff1 fs2 fc0 sc0 ls0 ws0">Paisa  Only</div>
               <div class="t m0 x15 h7 y28 ff1 fs2 fc0 sc0 ls0 ws0">E. &amp; OE.</div>
               <div class="t m0 x7 h4 y2a ff2 fs2 fc0 sc0 ls0 ws0">Narration :</div>
               <div class="t m0 x7 h2 y2b ff1 fs0 fc0 sc0 ls0 ws0">Terms and Condition:</div>
               <div class="t m0 x16 h7 y2c ff2 fs2 fc0 sc0 ls0 ws0">For, <span class="ff1">M POONAM NATURAL</span></div>
               <div class="t m0 x16 h6 y2d ff2 fs0 fc0 sc0 ls0 ws0">Authorised Signatory</div>
            </div>
            <div class="pi" data-data='{"ctm":[1.000000,0.000000,0.000000,1.000000,0.000000,0.000000]}'></div>
         </div>
      </div>
      <div class="loading-indicator">
      </div>
   </body>
</html>
<?php }?>