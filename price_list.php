<?php
session_start();
require("mainconfig.php");

if (isset($_SESSION['user'])) {
	$sess_username = $_SESSION['user']['username'];
	$check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sess_username'");
	$data_user = mysqli_fetch_assoc($check_user);
	if (mysqli_num_rows($check_user) == 0) {
		header("Location: ".$cfg_baseurl."account/logout");
	} else if ($data_user['status'] == "Suspended") {
		header("Location: ".$cfg_baseurl."account/logout");
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
				<table class="table table-bordered table-condense issue-tracker">
                                    <thead>
													<tr>
														<th>ID</th>
														<th>Kategori</th>
														<th>Layanan</th>
														<th>Harga/1000</th>
														<th>Min</th>
														<th>Max</th>
													</tr>
												</thead>
												<tbody>
												<?php
												$check_sosmed = mysqli_query($db, "SELECT * FROM services WHERE status = 'Active'");
												while ($data_sosmed = mysqli_fetch_assoc($check_sosmed)) {
												?>													<tr>
														<th scope="row"><?php echo $data_sosmed['sid']; ?></th>
														<td><?php echo $data_sosmed['category']; ?></td>
														<td><?php echo $data_sosmed['service']; ?></td>
														<td>Rp <?php echo number_format($data_sosmed['price'],0,',','.'); ?></td>
														<td><?php echo number_format($data_sosmed['min'],0,',','.'); ?></td>
														<td><?php echo number_format($data_sosmed['max'],0,',','.'); ?></td>
													</tr>
												<?php
												}
												?>
												</tbody>
											</table>
											
											
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
						<!-- end row -->
 

<?php
include("lib/footer.php");
?>