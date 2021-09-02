<?php
session_start();
require("../../mainconfig.php");
$msg_type = "nothing";

if (isset($_SESSION['user'])) {
	$sess_username = $_SESSION['user']['username'];
	$check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sess_username'");
	$data_user = mysqli_fetch_assoc($check_user);
	if (mysqli_num_rows($check_user) == 0) {
		header("Location: ".$cfg_baseurl."account/logout");
	} else if ($data_user['status'] == "Suspended") {
		header("Location: ".$cfg_baseurl."account/logout");
	} else if ($data_user['level'] != "Developers") {
		header("Location: ".$cfg_baseurl);
	} else {
		if (isset($_GET['sid'])) {
			$post_sid = $_GET['sid'];
			$check_target = mysqli_query($db, "SELECT * FROM services_pulsa WHERE sid = '$post_sid'");
			$data_target = mysqli_fetch_assoc($check_target);
			if (mysqli_num_rows($check_target) == 0) {
				header("Location: ".$cfg_baseurl."admin/services_pulsa.php");
			} else {
				include("../../lib/headeradmin.php");
?>


            <div class="wrapper">
<div class="container-fluid" style="padding: 50px 20px;">
<div class="row">
<div class="col-lg-12">
</div>
</div>
<div class="row">
<div class="col-lg-12">
<div class="card m-b-30">
<h6 class="card-header"><i class="mdi mdi-history"></i>Detail Service</h6>
<div class="card-body">
										<div class="table-responsive">
											<table class="table table-striped table-bordered table-hover m-0">
												<tr>
													<th>Service ID</th>
													<td><?php echo $data_target['sid']; ?></td>
												</tr>
												<tr>
													<th>Service Name</th>
													<td><?php echo $data_target['name']; ?></td>
												</tr>
												<tr>
													<th>Operator</th>
													<td>
														<?php echo $data_cat['oprator']; ?>
													</td>
												</tr>
												<tr>
													<th>Harga</th>
													<td><?php echo number_format($data_target['price'],0,',','.'); ?></td>
												</tr>
												<tr>
													<th>Provider ID</th>
													<td><?php echo $data_target['pid']; ?></td>
												</tr>
												<tr>
													<th>Provider Code</th>
													<td><?php echo $data_target['provider']; ?></td>
												</tr>
												<tr>
													<th>Status</th>
													<td><?php echo $data_target['status']; ?></td>
												</tr>
											</table>
										</div>
										<a href="<?php echo $cfg_baseurl; ?>admin/services_pulsa.php" class="btn btn-info m-t-20">Kembali ke daftar</a>
									</div>
								</div>
							</div>
						</div>
						<!-- end row -->
<?php
				include("../../lib/footer.php");
			}
		} else {
			header("Location: ".$cfg_baseurl."admin/services_pulsa.php");
		}
	}
} else {
	header("Location: ".$cfg_baseurl);
}
?>