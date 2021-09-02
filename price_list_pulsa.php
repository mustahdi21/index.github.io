<?php
session_start();
require("mainconfig.php");

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
?>
					 <div class="wrapper">
<div class="container-fluid" style="padding: 50px 20px;">
<div class="row">
<div class="col-lg-12">
</div>
</div>
<div class="row">  <div class="col-md-12">
								<div class="card m-b-30">
<h6 class="card-header"><i class="mdi mdi-cart"></i> Daftar Harga</h6>
<div class="card-body">
										<div class="table-responsive">
											<table class="table table-striped table-bordered table-hover m-0">
												<thead>
													<tr>
														<th>ID</th>
														<th>Layanan</th>
														<th>Harga</th>
													</tr>
												</thead>
												<tbody>
												<?php
												$check_service = mysqli_query($db, "SELECT * FROM services_pulsa WHERE status = 'Active'");
												while ($data_service = mysqli_fetch_assoc($check_service)) {
												?>
													<tr>
														<th scope="row"><?php echo $data_service['id']; ?></th>
														<td><?php echo $data_service['name']; ?></td>
														<td>Rp <?php echo number_format($data_service['price'],0,',','.'); ?></td>
													</tr>
												<?php
												}
												?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- end row -->
<?php
include("lib/footer.php");
?>