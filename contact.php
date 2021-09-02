<?php
session_start();
require("mainconfig.php");
$page_type = "staff_list";

if (isset($_SESSION['user'])) {
	$sess_username = $_SESSION['user']['username'];
	$check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sess_username'");
	$data_user = mysqli_fetch_assoc($check_user);
	if (mysqli_num_rows($check_user) == 0) {
		header("Location: ".$cfg_baseurl."logout.php");
	} else if ($data_user['status'] == "Suspended") {
		header("Location: ".$cfg_baseurl."logout.php");
	}
}

include("lib/header.php");
?> <div class="wrapper">
<div class="container-fluid" style="padding: 50px 20px;">
<div class="row">
<div class="col-lg-12">
</div>
</div>
<div class="row">  <div class="col-md-12">
								<div class="card m-b-30">
<h6 class="card-header"><i class="mdi mdi-cart"></i> Contact</h6>
<div class="card-body">
						<div class="row">
							<div class="col-md-12">
								<div class="alert alert-info">
									<i class="fa fa-info-circle"></i> Anda dapat menghubungi kami untuk mengisi saldo.
								</div>
							</div>
								<?php
							$check_staff = mysqli_query($db, "SELECT * FROM staff ORDER BY level ASC");
							while ($data_staff = mysqli_fetch_assoc($check_staff)) {
							?>
							<div class="col-md-4">
<div class="panel panel-info text-center" style="padding: 20px 0;">
										<img src="<?php echo $data_staff['pict']; ?>" class="img-thumbnail" style="width: 100px; border-radius: 50px;"><br />
										<h5 class="text-black text-uppercase"><i class="ti-user"></i> <?php echo $data_staff['name']; ?></h5>
										<p class="text-black text-uppercase"><b><?php echo $data_staff['level']; ?></b></p>
										<p class="text-black"><a href="https://api.whatsapp.com/send?phone=<?php echo nl2br($data_staff['contact']); ?>&amp;text=Halo%20gan,%20Saya%20mau%20order....."><img src="https://www.aboudcar.com/wp-content/uploads/2018/03/GAC_Whatsapp-chat-icon.png" style="max-width: 30%;" /></a></p>
									</div>
							</div><!-- end col -->
						
								<?php
							}
							?>
						</div>
						<!-- end row -->
								

                               
                               <div></div>

                              
</p>
                                </div>
                            </div>
                        </div>
                    </div>
						<!-- end row -->
<?php
include("lib/footer.php");
?>