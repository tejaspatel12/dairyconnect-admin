<?php 
    include '../connection.php';
    
    
    $result=mysqli_query($conn,"SELECT * from tbl_user order by user_id DESC");
while($row=mysqli_fetch_array($result))
{
    echo $row['user_mobile_number']."<br>";
                                                
}

?>