<?php 
    include '../connection.php';
    $action=$_POST["action"];
    
    $response=array();

        $deliveryboy_id=$_POST["deliveryboy_id"];
        $date=$_POST["date"];
        
        $result=mysqli_query($conn,"select product_id,product_name,product_image from tbl_product") or die(mysqli_error($conn));

        if(mysqli_num_rows($result)<=0)
        {
            $response["status"]="no";
            $response["error"]="No Data Available!";
        }
        else
        {
            while($row=mysqli_fetch_assoc($result))
            {
                $response[]=array(
                    "product_id" => $row["product_id"],
                    "product_name" => $row["product_name"],
                    "product_image" => $row["product_image"],
                );
            }
        }
        
    echo json_encode($response);
?>