<html>
    <head>
        
    </head>
<body>
<?php
include 'connection.php';
// $con=mysqli_connect('localhost','root','','gayatri_studio');
?>
<?php 
    

?>
<form>
    <table border="1">
        <thead>
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
        </thead>
        <?php
            if(isset($_REQUEST["BtnDeliveryBoyInvoice"]))
            {
        
                $start_date=$_REQUEST["txtsdate"];
                $end_date=$_REQUEST["txtedate"];
                $deliveryboy_id=$_REQUEST["txtdelivery_boy"];
                
                echo "Start Date : "."".$start_date."<br>";
                echo "End Date : "."".$end_date."<br><br>";
                
                $count=1;
                // $result=mysqli_query($conn,"select * from tbl_user as u left join tbl_deliveryboy as d on u.deliveryboy_id=d.deliveryboy_id where u.deliveryboy_id='$deliveryboy_id'");
                    $result=mysqli_query($conn,"SELECT u.*,u.deliveryboy_id,p.product_name,oc.product_id,oc.order_date,oc.order_qty as order_qty,oc.order_total_amt as order_total_amt from tbl_order_calendar as oc LEFT JOIN tbl_user as u ON oc.user_id=u.user_id left join tbl_deliveryboy as d on d.deliveryboy_id=u.deliveryboy_id left join tbl_product as p on p.product_id=oc.product_id where u.deliveryboy_id='$deliveryboy_id' and oc.order_date between '$start_date' and '$end_date' GROUP BY p.product_id");
                while($row=mysqli_fetch_array($result))
                {?>
<tbody>
    <tr>
    <td><b><?php echo $count; $count++?></b></td>
    <td><b><?php echo $row['user_first_name']." ".$row['user_last_name']; ?></b></td>
    <td><b><?php echo $row['product_name']; ?></b></td>
    <td><b><?php echo $row['order_qty']; ?></b></td>
    <td><b><?php echo $row['order_total_amt']; ?></b></td>
    </tr>
</tbody>
<?php }} ?>
</table>
<button onClick="window.print()">Print</button>
</form>
<script scr="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $(document).on('click','a[data-role=update]',function(){
            alert($(this).data('id'));
        })
    });
</script>
    </body>
</html>
