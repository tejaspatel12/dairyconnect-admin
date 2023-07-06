<option value="" selected>Select City</option>
<?php
include 'connection.php';
$id=$_POST['id'];
$result=mysqli_query($conn,"select * from tbl_city where state_id='".$id."'");
while($row=mysqli_fetch_array($result))
{?>
<option value="<?php echo $row['city_id'];?>"><?php echo $row['city_name'];?></option>
<?php } ?>