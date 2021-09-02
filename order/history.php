<?php
session_start();
require("../mainconfig.php");

if (isset($_SESSION['user'])) {
	$sess_username = $_SESSION['user']['username'];
	$check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sess_username'");
	$data_user = mysqli_fetch_assoc($check_user);
	if (mysqli_num_rows($check_user) == 0) {
		header("Location: ".$cfg_baseurl."account/logout");
	} else if ($data_user['status'] == "Suspended") {
		header("Location: ".$cfg_baseurl."account/logout");
	}

	include("../lib/header.php");
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
<h6 class="card-header"><i class="mdi mdi-history"></i> Riwayat Pemesanan</h6>
<div class="card-body">
										<div class="alert alert-info">
											<i class="fa fa-globe"></i>: Dipesan melalui website.<br />
											<i class="fa fa-random"></i>: Dipesan melalui API.<br /><br />
											<i class="fa fa-check"></i>: Mengalami Pengembalian Dana.<br />
											<i class="fa fa-times"></i>: Tidak Mengalami Pengembalian Dana.

										</div><hr>
											<div class="row">
										<div class="col-md-6">
										<form method="post">	
										    <select name="status" class="form-control" required>
										           <option selected hidden> -- Pilih Status -- </option>
										           <option value="Pending">Pending</option>
										           <option value="Processing">Processing</option>
										           <option value="Partial">Partial</option>
										           <option value="Success">Success</option>
										           <option value="Error">Error</option>
										    </select>
										</div>
										<div class="col-md-6">
											<button name="tampil" type="submit" class="pull-right btn btn-primary">Tampilkan Data</button>
										</div></form>										
									</div><br />										
										<div class="table-responsive">
                                    <table class="table table-condense issue-tracker table-bordered">
                                        <thead>
													<tr>
														<th></th>
														<th>Waktu</th>
														<th>OID</th>
														<th>Produk</th>
														<th>Data</th>
														<th>Jumlah</th>
														<th>Harga</th>
														<th>Status</th>
													</tr>
												</thead>
												<tbody>
												<?php
if(isset($_POST['status'])) {
// start paging config
$status=$_POST['status'];
$query_order = "SELECT * FROM orders WHERE user = '$sess_username' AND status='$status' ORDER BY id DESC"; // edit
} else {
 $query_order = "SELECT * FROM orders WHERE user = '$sess_username' ORDER BY id DESC"; // edit  
}
$records_per_page = 30; // edit

$starting_position = 0;
if(isset($_GET["page_no"])) {
	$starting_position = ($_GET["page_no"]-1) * $records_per_page;
}
$new_query = $query_order." LIMIT $starting_position, $records_per_page";
$new_query = mysqli_query($db, $new_query);
// end paging config
												while ($data_order = mysqli_fetch_assoc($new_query)) {
													if($data_order['status'] == "Pending") {
														$label = "warning";
													} else if($data_order['status'] == "Processing") {
														$label = "info";
													} else if($data_order['status'] == "Error") {
														$label = "danger";
													} else if($data_order['status'] == "Partial") {
														$label = "danger";
													} else if($data_order['status'] == "Success") {
														$label = "success";
													}
												?>
													<tr>
														<td align="center"><label class="badge badge-<?php if($data_order['refund'] == 0) { echo "danger"; } else { echo "success"; } ?>"><?php if($data_order['refund'] == 0) { ?><i class="fa fa-times"></i><?php } else { ?><i class="fa fa-check"></i><?php } ?></label> <label class="label label-<?php if($data_order['place_from'] == API) { echo "primary"; } else { echo "success"; } ?>"><?php if($data_order['refund'] == API) { ?><i class="fa fa-random"></i><?php } else { ?><i class="fa fa-globe"></i><?php } ?></label></td>	
														<td><?php echo $data_order['date']; ?></td>
														<td><?php echo $data_order['oid']; ?></td>
														<td><?php echo $data_order['service']; ?></td>
														<td><?php echo $data_order['link']; ?></td>
														<td><?php echo number_format($data_order['quantity'],0,',','.'); ?></td>
														<td>Rp <?php echo number_format($data_order['price'],0,',','.'); ?></td>
														<td align="center"><label class="badge badge-<?php echo $label; ?>"><?php echo $data_order['status']; ?></label></td>
													</tr>
												<?php
												}
												?>
												</tbody>
											</table>
										</div>
										<ul class="pagination">
											<?php
// start paging link
$self = $_SERVER['PHP_SELF'];
$query_order = mysqli_query($db, $query_order);
$total_no_of_records = mysqli_num_rows($query_order);
echo "<li class='disabled'><div class='card-body text-center'><center>
Total Seluruh Data: ".$total_no_of_records." </center></div>
</div></li>";

// end paging link
											?>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<!-- end row -->
<?php
	include("../lib/footer.php");
} else {
	header("Location: ".$cfg_baseurl);
}
?>