<?php
    session_start();
    include 'connection.php';
    $title = "Login";
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title><?php echo $title;?> - <?php echo $webname;?>  </title>
	<!--favicon-->
	<link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" />
	<!-- loader-->
	<link href="assets/css/pace.min.css" rel="stylesheet" />
	<script src="assets/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<!-- Icons CSS -->
	<link rel="stylesheet" href="assets/css/icons.css" />
	<!-- App CSS -->
	<link rel="stylesheet" href="assets/css/app.css" />
</head>

<body class="bg-login">
	<!-- wrapper -->
	<div class="wrapper">
		<div class="section-authentication-login d-flex align-items-center justify-content-center">
			<div class="row">
				<div class="col-12 col-lg-10 mx-auto">
					<div class="card radius-15">
						<div class="row no-gutters">
							<div class="col-lg-6">
                            
                                <form method="post">
								<div class="card-body p-md-5">
                                <?php
                                    if(isset($_REQUEST["btnLogin"]))
                                    {
                                        
                                        $result = mysqli_query($conn,"select * from tbl_admin where username='".$_REQUEST["txtUser"]."' and password='".$_REQUEST["txtPass"]."'");
                                        if(mysqli_num_rows($result)<=0)
                                        {
                                            ?>
                                            <div class="alert bg-danger alert-icon-left alert-dismissible mb-2" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                            <strong>Opps!</strong> UserName or password not found
                                            </div>
                                            <?php
                                        }
                                        else
                                        {
                                            while($row=mysqli_fetch_array($result))
                                            {
                                                if($row["username"]==$_REQUEST["txtUser"] && $row["password"]==$_REQUEST["txtPass"])
                                                {
                                                    $_SESSION["admin_id"]=$row["admin_id"];
                                                    $_SESSION['username']=$_POST['txtUser'];
                                                    echo "<script>window.location='index.php';</script>";
                                                }
                                                else
                                                {
                                                    ?>
                                            <div class="alert bg-danger alert-icon-left alert-dismissible mb-2" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                                <strong>Oh snap!</strong> User Name or password not found
                                                </div>
                                            <?php
                                            break;
                                                }
                                            }
                                        }
                                    }
                                ?>
									<div class="text-center">
										<img src="assets/images/logo_admin.png" width="80" alt="">
										<h3 class="mt-4 font-weight-bold">Welcome Back,<BR> <?php echo $webname?></h3>
									</div>
									<?php echo date("jS \of F Y h:i:s A");?>
									<div class="login-separater text-center">
										<hr/>
									</div>
									<div class="form-group mt-4">
										<label>Username</label>
										<input type="text" class="form-control" name="txtUser" />
									</div>
									<div class="form-group">
										<label>Password</label>
										<input type="password" class="form-control" name="txtPass"/>
									</div>
						
									<div class="btn-group mt-3 w-100">
										<button type="submit" name="btnLogin" class="btn btn-primary btn-block">Log In</button>
										<button type="submit" name="btnLogin" class="btn btn-primary"><i class="lni lni-arrow-right"></i>
										</button>
									</div>
								</div>
                                </form>
							</div>
							<div class="col-lg-6">
								<img src="assets/images/login-images/abc.png" class="card-img login-img h-100" alt="...">
							</div>
						</div>
						<!--end row-->
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end wrapper -->
</body>

</html>