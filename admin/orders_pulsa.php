<?php
session_start();
require("../mainconfig.php");
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

				include("../lib/header.php");

	// widget
	$check_worder = mysqli_query($db, "SELECT SUM(price) AS total FROM orders_pulsa");
	$data_worder = mysqli_fetch_assoc($check_worder);
	$check_worder = mysqli_query($db, "SELECT * FROM orders_pulsa");
	$count_worder = mysqli_num_rows($check_worder);
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
<h6 class="card-header"><i class="mdi mdi-history"></i> Detail Pembelian</h6>
<div class="card-body">
                		<div class="panel-body">
										<div class="alert alert-info">
											 Klik tombol <i class="fa fa-edit fa-fw"></i> untuk mengubah pesanan.<br />
											 Klik tombol <i class="fa fa-eye fa-fw"></i> intuk melihat detail pesanan
										</div>
										<div class="col-md-6">
										</div>
										<div class="col-md-6">
											<form method="GET">
											<div class="input-group">
												<input type="text" name="search" class="form-control" placeholder="Cari order id">
												<span class="input-group-btn">
													<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
												</span>
											</div>
											</form>
										</div>
										<div class="clearfix"></div>
										<br />
										<div class="table-responsive">
											<table class="table table-condense table-bordered">
												<thead>
													<tr>
														<th>OID</th>
														<th>Pengguna</th>
														<th>Layanan</th>
														<th>No. Telp</th>
														<th>Harga</th>
														<th>Status</th>
														<th>Aksi</th>
													</tr>
												</thead>
												<tbody>
												<?php
// start paging config
if (isset($_GET['search'])) {
	$search = $_GET['search'];
	$query_list = "SELECT * FROM orders_pulsa WHERE oid LIKE '%$search%' ORDER BY id DESC"; // edit
} else {
	$query_list = "SELECT * FROM orders_pulsa ORDER BY id DESC"; // edit
}
$records_per_page = 30; // edit

$starting_position = 0;
if(isset($_GET["page_no"])) {
	$starting_position = ($_GET["page_no"]-1) * $records_per_page;
}
$new_query = $query_list." LIMIT $starting_position, $records_per_page";
$new_query = mysqli_query($db, $new_query);
// end paging config
												while ($data_show = mysqli_fetch_assoc($new_query)) {
													if($data_show['status'] == "Pending") {
														$label = "warning";
													} else if($data_show['status'] == "Processing") {
														$label = "info";
													} else if($data_show['status'] == "Error") {
														$label = "danger";
													} else if($data_show['status'] == "Partial") {
														$label = "danger";
													} else if($data_show['status'] == "Success") {
														$label = "success";
													}
												?>
													<tr>
														<td><?php echo $data_show['oid']; ?></td>
														<td><?php echo $data_show['user']; ?></td>
														<td><?php echo $data_show['service']; ?></td>
														<td><?php echo $data_show['phone']; ?></td>
														<td><?php echo number_format($data_show['price'],0,',','.'); ?></td>
														<td><label class="badge badge-<?php echo $label; ?>"><?php echo $data_show['status']; ?></label></td>
														<td align="center">
														<a href="<?php echo $cfg_baseurl; ?>admin/order_pulsa/edit.php?oid=<?php echo $data_show['oid']; ?>" class="btn btn-xs btn-info btn-rounded"><i class="fa fa-edit"></i></a>
														</td>
													</tr>
												<?php
												}
												?>
												</tbody>
											</table>
								
										<ul class="pagination">
											<?php
// start paging link
$self = $_SERVER['PHP_SELF'];
$query_list = mysqli_query($db, $query_list);
$total_no_of_records = mysqli_num_rows($query_list);
echo "<li class='disabled page-item'><a class='page-link' href='#'>Total: ".$total_no_of_records."</a></li>";
if($total_no_of_records > 0) {
	$total_no_of_pages = ceil($total_no_of_records/$records_per_page);
	$current_page = 1;
	if(isset($_GET["page_no"])) {
		$current_page = $_GET["page_no"];
	}
	if($current_page != 1) {
		$previous = $current_page-1;
		echo "<li class='page-item'><a class='page-link' href='".$self."?page_no=1'>← First</a></li>";
		echo "<li class='page-item'><a class='page-link' href='".$self."?page_no=".$previous."'><i class='fa fa-angle-left'></i> Previous</a></li>";
	}
	for($i=1; $i<=$total_no_of_pages; $i++) {
		if($i==$current_page) {
			echo "<li class='active page-item'><a class='page-link' href='".$self."?page_no=".$i."'>".$i."</a></li>";
		} else {
			echo "<li class='page-item'><a class='page-link' href='".$self."?page_no=".$i."'>".$i."</a></li>";
		}
	}
	if($current_page!=$total_no_of_pages) {
		$next = $current_page+1;
		echo "<li class='page-item'><a class='page-link' href='".$self."?page_no=".$next."'>Next <i class='fa fa-angle-right'></i></a></li>";
		echo "<li class='page-item'><a class='page-link' href='".$self."?page_no=".$total_no_of_pages."'>Last →</a></li>";
	}
}
// end paging link
											?>
										</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- end row -->
<?php
	include("../lib/footer.php");
	}
} else {
	header("Location: ".$cfg_baseurl);
}
?>