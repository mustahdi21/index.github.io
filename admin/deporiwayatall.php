<?php
session_start();
require("../mainconfig.php");
$msg_type = "nothing";

if (isset($_SESSION['user'])) {
	$sess_username = $_SESSION['user']['username'];
	$check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sess_username'");
	$data_user = mysqli_fetch_assoc($check_user);
	if (mysqli_num_rows($check_user) == 0) {
		header("Location: ".$cfg_baseurl."logout.php");
	} else if ($data_user['status'] == "Suspended") {
	    header("Location: ".$cfg_baseurl."logout.php");
	} else if ($data_user['level'] != "Developers") {
		header("Location: ".$cfg_baseurl);
	} else {

	include("../lib/header.php");

	// widget
	$check_worder = mysqli_query($db, "SELECT SUM(amount) AS total FROM history_topup");
	$data_worder = mysqli_fetch_assoc($check_worder);
	$check_worder = mysqli_query($db, "SELECT * FROM history_topup");
	$count_worder = mysqli_num_rows($check_worder);
	
	if(isset($_POST['delet'])) {
	    $post_code = $_POST['kode'];
	    
	    $select = mysqli_query($db, "SELECT * FROM history_topup WHERE id = '$post_code'");
	    $datana = mysqli_fetch_assoc($select);
	    
	    if(mysqli_num_rows($select) == 0) {
	        $msg_type = "error";
	        $msg_content = "×</span></button><b>Gagal:</b> Data tidak di temukan. ";
	    } else if($datana['status'] == "YES") {
             $msg_type = "error";
	        $msg_content = "×</span></button><b>Gagal:</b> Data tidak bisa di batalkan.  ";	 
	    } else {
	        $update = mysqli_query($db, "UPDATE history_topup set status = 'CANCEL' WHERE id = '$post_code'");
	      	$ip_add=$ip_add = $_SERVER['REMOTE_ADDR'];
				$catatan_aktifitas ="User Melakukan Pembatalan Deposit ID :$post_code ";
				$update_user = mysqli_query($db, "INSERT INTO log_activity (waktu, ip, note, username) VALUES ('$waktu', '$ip_add', '$catatan_aktifitas', '$sess_username')");
			
	        if($update == TRUE) {
	            $msg_type = "success";
	            $msg_content = "×</span></button> Berhasil membatalkan!";
	        } else {
	            $msg_type = "error";
	            $msg_content = "×</span></button>GAGAL MEMBATALKAN #1";
	        }
	    }
	}
?> <div class="wrapper">
<div class="container-fluid" style="padding: 50px 20px;">
<div class="row">
<div class="col-lg-12">
</div>
</div>
<div class="row">
<div class="col-lg-12">
<div class="card m-b-30">
<h6 class="card-header"><i class="mdi mdi-history"></i> Riwayat Deposit</h6>
<div class="card-body">
							<section class="panel panel-default">
								<div class="row m-l-none m-r-none bg-light lter">
									<div class="col-sm-12 padder-v b-r b-light lt">
										<span class="fa-stack fa-2x pull-left m-r-sm">
											<i class="fa fa-circle fa-stack-2x text-info"></i>
											<i class="fa fa-shopping-cart fa-stack-1x text-white"></i>
										</span>
										<a class="clear" href="#">
											<span class="h3 block m-t-xs">
												<strong>Rp <?php echo number_format($data_worder['total'],0,',','.'); ?> (Dari <?php echo number_format($count_worder,0,',','.'); ?> Deposit)</strong>
											</span>
											<small class="text-muted text-uc">Total Deposit Batam Media</small>
										</a>
									</div>
								</div>
							</section>

						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-heading">
										<h3 class="panel-title"><i class="fa fa-shopping-cart"></i> Daftar Deposit</h3>
									</div>
									<div class="panel-body">
										<div class="col-md-6">
										</div>
										<div class="col-md-6">
											<form method="GET">
											<div class="input-group m-b-20">
												<input type="text" name="search" class="form-control" placeholder="Cari order id">
												<span class="input-group-btn">
													<button type="submit" class="btn waves-effect waves-light btn-info"><i class="fa fa-search"></i></button>
												</span>
											</div>
											</form>
										</div>
										<div class="clearfix"></div>
										<br />
										<div class="col-md-12 table-responsive" style="overflow: auto;">
											<table class="table table-striped table-bordered table-hover m-0">
												<thead>
													<tr>
														<th>ID Pengisian</th>
														<th>Username</th>
														<th>Provider</th>
														<th>Jumlah Transfer</th>
														<th>Amount</th>
														<th>No Pengirim</th>
														<th>Tanggal</th>
														<th>Waktu</th>
														<th>Status</th>	
														<th>Action</th>
													</tr>
												</thead>
												<tbody>
												<?php
// start paging config
$query_order = "SELECT * FROM history_topup ORDER BY id DESC"; // edit
$records_per_page = 30; // edit

$starting_position = 0;
if(isset($_GET["page_no"])) {
	$starting_position = ($_GET["page_no"]-1) * $records_per_page;
}
$new_query = $query_order." LIMIT $starting_position, $records_per_page";
$new_query = mysqli_query($db, $new_query);
// end paging config
												while ($data_depo = mysqli_fetch_assoc($new_query)) {
													if($data_depo['status'] == "NO") {
														$label = "warning";
														$ss1="Waiting";
													} else if($data_depo['status'] == "CANCEL") {
														$label = "danger";
															$ss1="CANCELED";
													} else if($data_depo['status'] == "YES") {
														$label = "success";
															$ss1="Success";
													}
												?>
													<tr>
													    <td><?php echo $data_depo['id']; ?></td>
													    <td><?php echo $data_depo['username']; ?></td>
														<td><?php if($data_depo['provider'] == "TSEL") { ?>TELKOMSEL<?php } else { ?><span class= "label label-danger"><i class="fa fa-times"></i> XXX</span><?php } ?>	</td>
														<td><?php echo number_format($data_depo['jumlah_transfer'],0,',','.'); ?></td>
														<td><?php echo number_format($data_depo['amount'],0,',','.'); ?></td>
														<td><?php echo $data_depo['no_pengirim']; ?></td>
														<td><?php echo $data_depo['date']; ?></td>
														<td><?php echo $data_depo['time']; ?></td>
														<td><label class="badge badge-<?php echo $label; ?>"><?php echo $ss1; ?></label></td>
														<?php if($data_depo['status'] == "NO") { ?>
														<td> <form action="" method="POST">
                                                             <input type="hidden" name="kode" value="<?php echo $data_depo['id']; ?>">
                                                                <button type="submit" class="btn btn-danger btn-xs"name="delet">
                                                                    <strong><span class="fa fa-remove"></span> Batalkan Deposit</strong></button>
                                                        </td> <?php } else { ?>
                                                        <td><span class="label label-success"><strong>Not Action</strong></span></td>
                                                    			
                                                    	<?php } ?>
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
echo "<li class='disabled'><a href='#'>Total: ".$total_no_of_records."</a></li>";
if($total_no_of_records > 0) {
	$total_no_of_pages = ceil($total_no_of_records/$records_per_page);
	$current_page = 1;
	if(isset($_GET["page_no"])) {
		$current_page = $_GET["page_no"];
	}
	if($current_page != 1) {
		$previous = $current_page-1;
		echo "<li><a href='".$self."?page_no=1'>← First</a></li>";
		echo "<li><a href='".$self."?page_no=".$previous."'><i class='fa fa-angle-left'></i> Previous</a></li>";
	}
	for($i=1; $i<=$total_no_of_pages; $i++) {
		if($i==$current_page) {
			echo "<li class='active'><a href='".$self."?page_no=".$i."'>".$i."</a></li>";
		} else {
			echo "<li><a href='".$self."?page_no=".$i."'>".$i."</a></li>";
		}
	}
	if($current_page!=$total_no_of_pages) {
		$next = $current_page+1;
		echo "<li><a href='".$self."?page_no=".$next."'>Next <i class='fa fa-angle-right'></i></a></li>";
		echo "<li><a href='".$self."?page_no=".$total_no_of_pages."'>Last →</a></li>";
	}
}
// end paging link
											?>
											</ul>
										</div>
									</div>
								</div>
							</div>
						
						<!-- end row -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.js"></script>
	                    <script type="text/javascript">
	                        var htmlobjek;
                            $(document).ready(function(){
                        $("#depomethod").change(function(){
                                    var depomethod = $("#depomethod").val();
                                $.ajax({
                                    url: '<?php echo $cfg_baseurl; ?>inc/deposit_method.php',
                                    data: 'depomethod='+depomethod,
                                    type: 'POST',
                                    dataType: 'html',
                                    success: function(msg){
                                    $("#rates1").html(msg);
                                }
                            });
                        });
                    });
	        </script>


<?php
	include("../lib/footer.php");
	}
} else {
	header("Location: ".$cfg_baseurl);
}
?>