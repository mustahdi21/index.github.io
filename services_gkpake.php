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
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default animated fadeInDown">
                        <div class="panel-heading">
                           <h3 class="panel-title"><i class="fa fa-tag"></i> Daftar Layanan</h3>
                                </div>
                			<div class="panel-body">
                                <div class="table-responsive">
                            <h4><span class="label label-primary">Instagram Followers</span></h4>    	
                                 <table class="table table-condense table-bordered">
                                    <thead>
                                        <tr>
														<th>ID</th>
														<th>Layanan</th>
														<th>Harga/1000</th>
														<th>Min</th>
														<th>Max</th>
														<th>Status</th>
													</tr>
												</thead>
												<tbody>
												<?php
												$check_service = mysqli_query($db, "SELECT * FROM services WHERE category = 'IGF' AND status = 'Active' ORDER BY id");
												while ($data_service = mysqli_fetch_assoc($check_service)) {
												?>
													<tr class="odd gradeX">
														<td><?php echo $data_service['sid']; ?></td>
														<td><?php echo $data_service['service']; ?></td>
														<td>Rp <?php echo number_format($data_service['price'],0,',','.'); ?></td>
														<td><?php echo number_format($data_service['min'],0,',','.'); ?></td>
														<td><?php echo number_format($data_service['max'],0,',','.'); ?></td>
														<td align="center"><span class="label label-primary">NORMAL</span></td>
													</tr>
												<?php
												}
												?>
												</tbody>
											</table>

                            <h4><span class="label label-primary">Instagram Likes</span></h4>    	
                                 <table class="table table-condense table-bordered">
                                    <thead>
                                        <tr>
														<th>ID</th>
														<th>Layanan</th>
														<th>Harga/1000</th>
														<th>Min</th>
														<th>Max</th>
													</tr>
												</thead>
												<tbody>
												<?php
												$check_service = mysqli_query($db, "SELECT * FROM services WHERE category = 'IGL' AND status = 'Active' ORDER BY id");
												while ($data_service = mysqli_fetch_assoc($check_service)) {
												?>
													<tr class="odd gradeX">
														<td><?php echo $data_service['sid']; ?></td>
														<td><?php echo $data_service['service']; ?></td>
														<td>Rp <?php echo number_format($data_service['price'],0,',','.'); ?></td>
														<td><?php echo number_format($data_service['min'],0,',','.'); ?></td>
														<td><?php echo number_format($data_service['max'],0,',','.'); ?></td>
													</tr>
												<?php
												}
												?>
												</tbody>
											</table>

                            <h4><span class="label label-primary">Instagram Views</span></h4>    	
                                 <table class="table table-condense table-bordered">
                                    <thead>
                                        <tr>
														<th>ID</th>
														<th>Layanan</th>
														<th>Harga/1000</th>
														<th>Min</th>
														<th>Max</th>
													</tr>
												</thead>
												<tbody>
												<?php
												$check_service = mysqli_query($db, "SELECT * FROM services WHERE category = 'IGV' AND status = 'Active' ORDER BY id");
												while ($data_service = mysqli_fetch_assoc($check_service)) {
												?>
													<tr class="odd gradeX">
														<td><?php echo $data_service['sid']; ?></td>
														<td><?php echo $data_service['service']; ?></td>
														<td>Rp <?php echo number_format($data_service['price'],0,',','.'); ?></td>
														<td><?php echo number_format($data_service['min'],0,',','.'); ?></td>
														<td><?php echo number_format($data_service['max'],0,',','.'); ?></td>
													</tr>
												<?php
												}
												?>
												</tbody>
											</table>

                            <h4><span class="label label-primary">Facebook</span></h4>    	
                                 <table class="table table-condense table-bordered">
                                    <thead>
                                        <tr>
														<th>ID</th>
														<th>Layanan</th>
														<th>Harga/1000</th>
														<th>Min</th>
														<th>Max</th>
													</tr>
												</thead>
												<tbody>
												<?php
												$check_service = mysqli_query($db, "SELECT * FROM services WHERE category = 'FB' AND status = 'Active' ORDER BY id");
												while ($data_service = mysqli_fetch_assoc($check_service)) {
												?>
													<tr class="odd gradeX">
														<td><?php echo $data_service['sid']; ?></td>
														<td><?php echo $data_service['service']; ?></td>
														<td>Rp <?php echo number_format($data_service['price'],0,',','.'); ?></td>
														<td><?php echo number_format($data_service['min'],0,',','.'); ?></td>
														<td><?php echo number_format($data_service['max'],0,',','.'); ?></td>
													</tr>
												<?php
												}
												?>
												</tbody>
											</table>																							

                            <h4><span class="label label-primary">YouTube</span></h4>    	
                                 <table class="table table-condense table-bordered">
                                    <thead>
                                        <tr>
														<th>ID</th>
														<th>Layanan</th>
														<th>Harga/1000</th>
														<th>Min</th>
														<th>Max</th>
													</tr>
												</thead>
												<tbody>
												<?php
												$check_service = mysqli_query($db, "SELECT * FROM services WHERE category = 'YT' AND status = 'Active' ORDER BY id");
												while ($data_service = mysqli_fetch_assoc($check_service)) {
												?>
													<tr class="odd gradeX">
														<td><?php echo $data_service['sid']; ?></td>
														<td><?php echo $data_service['service']; ?></td>
														<td>Rp <?php echo number_format($data_service['price'],0,',','.'); ?></td>
														<td><?php echo number_format($data_service['min'],0,',','.'); ?></td>
														<td><?php echo number_format($data_service['max'],0,',','.'); ?></td>
													</tr>
												<?php
												}
												?>
												</tbody>
											</table>

                            <h4><span class="label label-primary">Twitter</span></h4>    	
                                 <table class="table table-condense table-bordered">
                                    <thead>
                                        <tr>
														<th>ID</th>
														<th>Layanan</th>
														<th>Harga/1000</th>
														<th>Min</th>
														<th>Max</th>
													</tr>
												</thead>
												<tbody>
												<?php
												$check_service = mysqli_query($db, "SELECT * FROM services WHERE category = 'TW' AND status = 'Active' ORDER BY id");
												while ($data_service = mysqli_fetch_assoc($check_service)) {
												?>
													<tr class="odd gradeX">
														<td><?php echo $data_service['sid']; ?></td>
														<td><?php echo $data_service['service']; ?></td>
														<td>Rp <?php echo number_format($data_service['price'],0,',','.'); ?></td>
														<td><?php echo number_format($data_service['min'],0,',','.'); ?></td>
														<td><?php echo number_format($data_service['max'],0,',','.'); ?></td>
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
 

<?php
include("lib/footer.php");
?>