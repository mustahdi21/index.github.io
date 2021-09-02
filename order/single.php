<?php
session_start();
require("../mainconfig.php");
$page_type = "sosmed";

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
		$post_quantity = $_POST['quantity'];
		$post_link = trim($_POST['link']);
		$post_category = $_POST['category'];
		$check_service = mysqli_query($db, "SELECT * FROM services WHERE sid = '$post_service' AND status = 'Active'");
		$data_service = mysqli_fetch_assoc($check_service);

        $check_orders = mysqli_query($db, "SELECT * FROM orders WHERE link = '$post_link' AND status IN ('Pending','Processing')");
        $data_orders = mysqli_fetch_assoc($check_orders);
		$rate = $data_service['price'] / 1000;
		$price = $rate*$post_quantity;
		$oid = random_number(3).random_number(4);
		$service = $data_service['service'];
		$provider = $data_service['provider'];
		$pid = $data_service['pid'];

		$check_provider = mysqli_query($db, "SELECT * FROM provider WHERE code = '$provider'");
		$data_provider = mysqli_fetch_assoc($check_provider);
		$hof = 1;
			$check_hof = mysqli_query($db, "SELECT * FROM hof WHERE username = '$sess_username'");
		$data_hof = mysqli_fetch_assoc($check_hof);
		
		if (empty($post_service) || empty($post_link) || empty($post_quantity)) {
			$msg_type = "error";
			$msg_content = "<b>Gagal:</b> Mohon mengisi input.";
		} else if (mysqli_num_rows($check_orders) == 1) {
		    $msg_type = "error";
		    $msg_content = "<b>Gagal:</b> Terdapat Orderan Username Yang Sama Dan berstatus Pending/Processing.";
		} else if (mysqli_num_rows($check_service) == 0) {
			$msg_type = "error";
			$msg_content = "<b>Gagal:</b> Layanan tidak ditemukan.";
		} else if (mysqli_num_rows($check_provider) == 0) {
			$msg_type = "error";
			$msg_content = "<b>Gagal:</b> Server Maintenance.";
		} else if ($post_quantity < $data_service['min']) {
			$msg_type = "error";
			$msg_content = "<b>Gagal:</b> Jumlah minimal adalah ".$data_service['min'].".";
		} else if ($post_quantity > $data_service['max']) {
			$msg_type = "error";
			$msg_content = "<b>Gagal:</b> Jumlah maksimal adalah ".$data_service['max'].".";
		} else if ($data_user['balance'] < $price) {
			$msg_type = "error";
			$msg_content = "<b>Gagal:</b> Saldo Anda tidak mencukupi untuk melakukan pembelian ini.";
		} else {

			// api data
			$api_link = $data_provider['link'];
			$api_key = $data_provider['api_key'];
			// end api data

			if ($provider == "MANUAL") {
				$api_postdata = "";
				$poid = $oid;
			} else if ($provider == "IRVANKEDE") {
				$api_postdata = "api_id=apiidlo&api_key=apikeylo&service=$pid&target=$post_link&quantity=$post_quantity";
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, "https://irvankede-smm.co.id/api/order");
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $api_postdata);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				$chresult = curl_exec($ch);
				curl_close($ch);
				$json_result = json_decode($chresult);
				$poid = $json_result->data->id;
			} else if ($provider == "JAP") {
				$api_postdata = "key=$api_key&action=add&service=$pid&link=$post_link&quantity=$post_quantity";
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $api_link);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $api_postdata);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				$chresult = curl_exec($ch);
				curl_close($ch);
				$json_result = json_decode($chresult);
				$poid = $json_result->order;				
			} else {
				die("System Error!");
			}

			if (empty($poid)) {
				$msg_type = "error";
				$msg_content = "<script>swal('Error!', 'Server Maintenance.', 'error');</script><b>Gagal:</b> Server Maintenance.";
			} else {
				$update_user = mysqli_query($db, "UPDATE users SET balance = balance-$price WHERE username = '$sess_username'");
				if ($update_user == TRUE) {
				    if (mysqli_num_rows($check_hof) == 0) {
				    $insert_hof = mysqli_query($db, "INSERT INTO hof (username, pembelian_sosmed, jumlah_sosmed) VALUES ('$sess_username', '$price', '$hof')");
				    } else {
				    $insert_order = mysqli_query($db, "UPDATE hof SET pembelian_sosmed = pembelian_sosmed+$price, jumlah_sosmed = jumlah_sosmed+$hof WHERE username = '$sess_username'");
				    }
                    $insert_order = mysqli_query($db, "INSERT INTO balance_history (username, action, quantity, msg, date, time) VALUES ('$sess_username', 'Cut Balance', '$price', 'Pemotongan Saldo untuk pembelian $post_quantity $service OID : $oid', '$date', '$time')");				    
					$insert_order = mysqli_query($db, "INSERT INTO orders (oid, poid, user, service, link, quantity, remains, start_count, price, status, date, provider, place_from) VALUES ('$oid', '$poid', '$sess_username', '$service', '$post_link', '$post_quantity', '$post_quantity', '$start_count', '$price', 'Pending', '$date', '$provider', 'WEB')");
					if ($insert_order == TRUE) {
						$msg_type = "success";
                        $msg_content = "<script>swal('Success!', 'Pesanan anda telah berjaya.', 'success');</script><b>Pesanan telah diterima.</b><br /><b>Service:</b> $service<br /><b>Link:</b> $post_link<br /><b>Jumlah:</b> ".number_format($post_quantity,0,',','.')."<br><b>Price:</b> Rp. ".$price;
					} else {
						$msg_type = "error";
						$msg_content = "<script>swal('Error!', 'Error system (2).', 'error');</script><b>Gagal:</b> Error system (2).";
					}
				} else {
					$msg_type = "error";
					$msg_content = "<script>swal('Error!', 'Error system (1).', 'error');</script><b>Gagal:</b> Error system (1).";
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
    <div class="row">
                            <div class="col-md-12 col-lg-12">
                                <div class="card w-150 text-center">
                                        <div class="card-header">
                                            TRANSAKSI HARI INI
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title"><i class="mdi mdi-information-variant"></i> Transaksi Sosmed Hari Ini [ <?php echo $date; ?> ]</h5>
                                            <p class="card-text"> <marquee scrollamount="10"><?php
													$check_newsa = mysqli_query($db, "SELECT * FROM orders WHERE date = '$date' ORDER BY id DESC LIMIT 15");
													$no = 1;
													while ($data_newsa = mysqli_fetch_assoc($check_newsa)) {
													    $ripalsensortransaksis = "-".strlen($data_newsa['user']);
		$mulaisensor = substr($data_newsa['user'],$ripalsensortransaksis,-5);
													?><font color="red" size="4px"><?php echo $mulaisensor; ?>*****</font> Telah Melakukan Pembelian <font color="red"><?php echo $data_newsa['quantity']; ?></font> <?php echo $data_newsa['service']; ?> [-] 
													<?php
													$no++;
													}
													?>
						</marquee></p>
                                        </div>
                                        <div class="card-footer text-muted">
                                            Today
                                        </div>
                                    </div>
                                    </div></div>
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
												<label class="col-md-2 control-label">Kategori</label>
												<div class="col-md-12">
													<select class="form-control" id="category" name="category">
														<option value="0">Pilih salah satu...</option>
		                                <option value="Facebook Auto Likes - 30 Days Subscription">Facebook Auto Likes - 30 Days Subscription</option>
                                                <option value="Facebook Followers / Friends / Group Members">Facebook Followers / Friends / Group Members</option>
                                                <option value="Facebook Page Likes">Facebook Page Likes</option>
                                                <option value="Facebook Post Likes / Comments / Shares / Events">Facebook Post Likes / Comments / Shares / Events</option>
                                                <option value="Facebook Video Views / Live Stream">Facebook Video Views / Live Stream</option>
                                                <option value="Dailymotion">Dailymotion</option>
                                                <option value="Google">Google</option>
                                                <option value="Instagram Auto Comments / Impressions / Saves">Instagram Auto Comments / Impressions / Saves</option>
                                                <option value="Instagram Auto Likes">Instagram Auto Likes</option>
                                                <option value="Instagram Auto Likes - 30 Days Subscription">Instagram Auto Likes - 30 Days Subscription</option>
                                                <option value="Instagram Auto Likes - 7 Days Subscription">Instagram Auto Likes - 7 Days Subscription</option>
                                                <option value="Instagram Auto Likes [Per Minute]">Instagram Auto Likes [Per Menit]</option>
                                                <option value="Instagram Auto Views">Instagram Auto Views</option>
                                                <option value="Instagram Comments">Instagram Comments</option>
                                                <option value="Instagram Followers [Negara]">Instagram Followers [Negara]</option>
	    			                <option value="Instagram Followers [Refill] [Guaranteed] [NonDrop">Instagram Followers [Refill] [Guaranteed] [NonDrop]</option>
	    			                <option value="Instagram Followers Indonesia">Instagram Followers Indonesia</option>
	    			                <option value="Instagram Followers No Refill/Not Guaranteed">Instagram Followers No Refill/Not Guaranteed</option>
	    			                <option value="Instagram Likes">Instagram Likes</option>
	    			                <option value="Instagram Likes / Likes + Impressions">Instagram Likes / Likes + Impressions</option>
	    			                <option value="Instagram Likes Indonesia">Instagram Likes Indonesia</option>
	    			                <option value="Instagram Likes [Targeted Negara]">Instagram Likes [Targeted Negara]</option>
	    			                <option value="Instagram Live Video">Instagram Live Video</option>
	    			                <option value="Instagram Mentions">Instagram Mentions</option>
	    			                <option value="Instagram Story / Impressions / Saves">Instagram Story / Impressions / Saves</option>
	    			                <option value="Instagram TV">Instagram TV</option>
	    			                <option value="Instagram Views">Instagram Views</option>
	    			                <option value="Like Comments Indonesia">Like Comments Indonesia</option>
	    			                <option value="Linkedin">Linkedin</option>
	    			                <option value="Musical.ly">Musical.ly</option>
	    			                <option value="Pinterest">Pinterest</option>
	    			                <option value="SoundCloud">SoundCloud</option>
	    			                <option value="Spotify">Spotify</option>
				                <option value="Telegram">Telegram</option>
				                <option value="Tumblr">Tumblr</option>
				                <option value="Twitter Auto Likes / Retweets">Twitter Auto Likes / Retweets</option>
                                                <option value="Twitter Followers">Twitter Followers</option>
		                                <option value="Twitter Likes">Twitter Likes</option>
		                                <option value="Twitter Retweets">Twitter Retweets</option>
		                                <option value="Twitter Poll Votes">Twitter Poll Votes</option>
		                                <option value="Twitter Views / Impressions / Live / Comments">Twitter Views / Impressions / Live / Comments</option>
		                                <option value="VK.com">VK.Com</option>
		                                <option value="Website Traffic">Website Traffic</option>
		                                <option value="Website Traffic [Targeted]">Website Traffic [Targeted]</option>
                                                <option value="Youtube Likes / Comments / Favs...">Youtube Likes / Comments / Favs...</option>
                                                <option value="Youtube Live Stream">Youtube Live Stream</option>
                                                <option value="Youtube Subscribers">Youtube Subscribers</option>
                                                <option value="Youtube Views">Youtube Views</option>
                                                <option value="Youtube Views [HR] [JAM TAYANG]">Youtube Views [HR] [JAM TAYANG]</option>
                                                <option value="Youtube Views [Targeted]">Youtube Views [Targeted]</option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Layanan</label>
												<div class="col-md-12">
													<select class="form-control" name="service" id="service">
														<option value="0">Pilih kategori...</option>
													</select>
												</div>
											</div>
											<div id="note">
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Link/Target</label>
												<div class="col-md-12">
													<input type="text" name="link" class="form-control" placeholder="Link/Target">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Jumlah</label>
												<div class="col-md-12">
													<input type="number" name="quantity" class="form-control" placeholder="Jumlah" onkeyup="get_total(this.value).value;">
												</div>
											</div>
											
											<input type="hidden" id="rate" value="0">
											<div class="form-group">
												<label class="col-md-2 control-label">Total Harga</label>
												<div class="col-md-12">
													<input type="number" class="form-control" id="total" readonly>
												</div>
											</div>
											<div class="form-group">
												<div class="col-md-offset-2 col-md-10">
											<button type="submit" class="btn btn-info waves-effect w-md waves-light" name="order">Buat Pesanan</button>
											<button type="reset" class="btn btn-default waves-effect w-md waves-light">Ulangi</button>
											    </div>
											</div>    
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
											<li>Pastikan username / link data yang di input benar dan valid,</li>
											<li>Pastikan akun target tidak berstatus private,</li>
											<li>Jangan input data yang sama dengan orderan sebelum nya apabila orderan sebelum nya belum Completed,</li>
											<li>Apabila orderan tidak mengalami perubahan status, silahkan kontak admin untuk di tangani,</li>
                                            <li>Tidak ada pengembalian dana untuk kesalahan pengguna.</li>
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
	$("#category").change(function() {
		var category = $("#category").val();
		$.ajax({
			url: '<?php echo $cfg_baseurl; ?>inc/order_service.php',
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
			url: '<?php echo $cfg_baseurl; ?>inc/order_note.php',
			data: 'service=' + service,
			type: 'POST',
			dataType: 'html',
			success: function(msg) {
				$("#note").html(msg);
			}
		});
		$.ajax({
			url: '<?php echo $cfg_baseurl; ?>inc/order_rate.php',
			data: 'service=' + service,
			type: 'POST',
			dataType: 'html',
			success: function(msg) {
				$("#rate").val(msg);
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