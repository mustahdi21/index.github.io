<?php
session_start();
require("../mainconfig.php");

if (isset($_SESSION['user'])) {
	$sess_username = $_SESSION['user']['username'];
	$check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sess_username'");
	$data_user = mysqli_fetch_assoc($check_user);
	if (mysqli_num_rows($check_user) == 0) {
		header("Location: ".$cfg_baseurl."logout.php");
	} else if ($data_user['status'] == "Suspended") {
		header("Location: ".$cfg_baseurl."logout.php");
	}

	include("../lib/header.php");
	$msg_type = "nothing";

	if (isset($_POST['order'])) {
		$post_service = $_POST['service'];
		$post_phone = $_POST['phone'];
		$post_zoneid = $_POST['zoneid'];

		$check_service = mysqli_query($db, "SELECT * FROM services_pulsa WHERE pid = '$post_service' AND status = 'Active'");
		$data_service = mysqli_fetch_assoc($check_service);

		$price = $data_service['price'];
		$service = $data_service['name'];

		if (empty($post_service) || empty($post_phone)) {
			$msg_type = "error";
			$msg_content = "<b>Gagal:</b> Mohon mengisi input.";
		} else if (mysqli_num_rows($check_service) == 0) {
			$msg_type = "error";
			$msg_content = "<b>Gagal:</b> Layanan tidak ditemukan.";
		} else if ($data_user['balance'] < $price) {
			$msg_type = "error";
			$msg_content = "<b>Gagal:</b> Saldo Anda tidak mencukupi untuk melakukan pembelian ini.";
		} else {
			$postdata = "key=apikeylo&action=order&service=$post_service&phone=$post_phone&phone2=$post_zoneid";
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://penajam-media.com/api/moba");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$chresult = curl_exec($ch);
			echo $chresult;
			curl_close($ch);
			$json_result = json_decode($chresult, true);

			if ($json_result['error'] == TRUE) {
				$msg_type = "error";
				$msg_content = "<b>Gagal:</b> Server Maintenance (1).";
			} else {
				    $poid = $json_result['order_id'];
				    $catatan = $json_result['catatan'];
			        $oid = random_number(5);
				$update_user = mysqli_query($db, "UPDATE users SET balance = balance-$price WHERE username = '$sess_username'");
				if ($update_user == TRUE) {
				if (mysqli_num_rows($check_hof) == 0) {
				    $insert_hof = mysqli_query($db, "INSERT INTO hof (username, pembelian_pulsa, jumlah_pulsa) VALUES ('$sess_username', '$price', '$hof')");
				    } else {
				    $insert_order = mysqli_query($db, "UPDATE hof SET pembelian_pulsa = pembelian_pulsa+$price, jumlah_pulsa = jumlah_pulsa+$hof WHERE username = '$sess_username'");
				    }
					$insert_order = mysqli_query($db, "INSERT INTO orders_pulsa (poid, oid, user, service, catatan, price, modal, untung, phone, status, date, provider, place_from, refund) VALUES ('$poid', '$oid', '$sess_username', '$service', '$catatan', '$price', '$price', '0', '$post_phone', 'Pending', '$date', 'PM', 'WEB', '0')");
					if ($insert_order == TRUE) {
						$msg_type = "success";
						$msg_content = "<b>Pesanan telah diterima.</b><br /><b>Provider ID:</b> $poid<br /><b>Order ID:</b> $oid<br /><b>Layanan:</b> $service<br /><b>NO. Telp:</b> $post_phone<br /><b>Biaya:</b> Rp ".number_format($price,0,',','.');
					} else {
						$msg_type = "error";
						$msg_content = "<b>Gagal:</b> Error system (2).";
					}
				} else {
					$msg_type = "error";
					$msg_content = "<b>Gagal:</b> Error system (1).";
				}
			}
		}
	}
	
	$check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sess_username'");
	$data_user = mysqli_fetch_assoc($check_user);
?>
		<div class="wrapper">
<div class="container-fluid" style="padding: 50px 20px;">
<div class="row">
<div class="col-lg-12">
</div>
</div>
<div class="row">
                               <div class="col-md-7">
								<div class="card m-b-30">
<h6 class="card-header"><i class="mdi mdi-cart"></i> Pemesanan Baru</h6>
<div class="card-body">
										<?php 
										if ($msg_type == "success") {
										?>
										<div class="alert alert-success">
											<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
											<i class="fa fa-check-circle"></i>
											<?php echo $msg_content; ?>
										</div>
										<?php
										} else if ($msg_type == "error") {
										?>
										<div class="alert alert-danger">
											<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
											<i class="fa fa-times-circle"></i>
											<?php echo $msg_content; ?>
										</div>
										<?php
										}
										?>
										<form class="form-horizontal" role="form" method="POST">
										    <div class="form-group">
												<label class="col-md-2 control-label">SERVER</label>
												<div class="col-md-10">
													<select class="form-control" id="server">
													    <option value="0">Select one...</option>
														<option value="DMML">Mobile Legends</option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Oprator</label>
												<div class="col-md-10">
													<select class="form-control" id="category">
														<option value="0">Select one...</option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Layanan</label>
												<div class="col-md-10">
													<select class="form-control" id="service" name="service">
														<option value="0">Select one...</option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">User ID</label>
												<div class="col-md-10">
													<input type="text" name="phone" class="form-control" placeholder="USER ID">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Zone ID</label>
												<div class="col-md-10">
													<input type="text" name="zoneid" class="form-control" placeholder="ZONE ID">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Total Harga</label>
												<div class="col-md-10">
													<input type="text" class="form-control" name="price" id="price" readonly>
												</div>
											</div>
											
											<button type="submit" class="pull-right btn btn-success btn-bordered waves-effect w-md waves-light" name="order">Buat Pesanan</button>
										</form>
									</div>
							
</div></div>
                            <div class="col-md-5">
                                <div class="panel panel-color panel-info">
                                    <div class="card m-b-30">
<h6 class="card-header"><i class="mdi mdi-cart"></i> Pemesanan Baru</h6>
<div class="card-body">
                                    <div class="panel-body">
										<ul>
										
											<li>CEK USER ID DAN ZONE ID DI PROFILE MOBILE LEGEND ANDA.</li>
											<li>UNTUK MENGETAHUI YANG MANA USER ID DAN ZONE ID CEK DI GOOGLE.</li>
											<li>MASUKKAN SEMUA DENGAN BENAR KARENA KESALAHAN INPUT BUKAN TANGGUNG JAWAB KAMI.</li>
										</ul>
									</div>
								</div>
							</div></div>
						</div>
						</div>
						<!-- end row -->
						<script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.js"></script>
	<script type="text/javascript">
$(document).ready(function() {
    $("#server").change(function() {
		var server = $("#server").val();
		$.ajax({
			url: '<?php echo $cfg_baseurl; ?>inc/order_service_cat_pulsa.php',
			data: 'server=' + server,
			type: 'POST',
			dataType: 'html',
			success: function(msg) {
				$("#category").html(msg);
			}
		});
	});
	$("#category").change(function() {
		var category = $("#category").val();
		$.ajax({
			url: '<?php echo $cfg_baseurl; ?>inc/order_service_pulsa.php',
			data: 'category=' + category,
			type: 'POST',
			dataType: 'html',
			success: function(msg) {
				$("#service").html(msg);
			}
		});
	});
	$("#service").change(function() {
		var service = $("#service").val();
		$.ajax({
			url: '<?php echo $cfg_baseurl; ?>inc/order_pulsa.php',
			data: 'service=' + service,
			type: 'POST',
			dataType: 'html',
			success: function(msg) {
				$("#price").val(msg);
			}
		});
	});
});

function get_total(quantity) {
	var rate = $("#rate").val();
	var result = eval(quantity) * rate;
	$('#total').val(result);
}
	</script>
<?php
	include("../lib/footer.php");
} else {
	header("Location: ".$cfg_baseurl);
}
?>