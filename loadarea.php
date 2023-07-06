<option value="" selected>Select Area</option>
<?php
include 'connection.php';
$id=$_POST['id'];
$result=mysqli_query($conn,"select * from tbl_area where city_id='".$id."'");
while($row=mysqli_fetch_array($result))
{?>
<option value="<?php echo $row['area_id'];?>"><?php echo $row['area_name'];?></option>
<?php } ?>