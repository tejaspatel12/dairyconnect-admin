<option value="" selected>Select State</option>
<?php
include 'connection.php';
$id=$_POST['id'];
$result=mysqli_query($conn,"select * from tbl_state where country_id='".$id."'");
while($row=mysqli_fetch_array($result))
{?>
<option value="<?php echo $row['state_id'];?>"><?php echo $row['state_name'];?></option>
<?php } ?>