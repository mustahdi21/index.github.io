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

	if (isset($_POST['change_pswd'])) {
		$post_password = trim($_POST['password']);
		$post_npassword = trim($_POST['npassword']);
		$post_cnpassword = trim($_POST['cnpassword']);
		if (empty($post_password) || empty($post_npassword) || empty($post_cnpassword)) {
			$msg_type = "error";
			$msg_content = "<b>Gagal:</b> Mohon mengisi semua input.";
		} else if ($post_password <> $data_user['password']) {
			$msg_type = "error";
			$msg_content = "<b>Gagal:</b> Password salah.";
		} else if (strlen($post_npassword) < 5) {
			$msg_type = "error";
			$msg_content = "<b>Gagal:</b> Password baru telalu pendek, minimal 5 karakter.";
		} else if ($post_cnpassword <> $post_npassword) {
			$msg_type = "error";
			$msg_content = "<b>Gagal:</b> Konfirmasi password baru tidak sesuai.";
		} else {
			$update_user = mysqli_query($db, "UPDATE users SET password = '$post_npassword' WHERE username = '$sess_username'");
			if ($update_user == TRUE) {
				$msg_type = "success";
				$msg_content = "<b>Success:</b> Password telah diubah.";
			} else {
				$msg_type = "error";
				$msg_content = "<b>Gagal:</b> Error system.";
			}
		}
	} else if (isset($_POST['change_api'])) {
		$set_api_key = random(20);
		$update_user = mysqli_query($db, "UPDATE users SET api_key = '$set_api_key' WHERE username = '$sess_username'");
		if ($update_user == TRUE) {
			$msg_type = "success";
			$msg_content = "<b>Berhasil:</b> API Key telah diubah.";
		} else {
			$msg_type = "error";
			$msg_content = "<b>Gagal:</b> Error system.";
		}
	} else if (isset($_POST['change_email'])) {
		$post_email = trim($_POST['email']);
		$update_user = mysqli_query($db, "UPDATE users SET email = '$post_email' WHERE username = '$sess_username'");
		if ($update_user == TRUE) {
			$msg_type = "success";
			$msg_content = "<b>Berhasil:</b> Email telah diubah.";
		} else {
			$msg_type = "error";
			$msg_content = "<b>Gagal:</b> Error system.";
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
<div class="col-lg-12 text-center">
<h3>Top 10 Pengguna Bulan Ini</h3>
<p>Kami Official Batam Media Mengucapkan Terima Kasih Telah Menjadi Pelanggan Setia Batam Media!</p>
</div>
<div class="col-lg-6">
<div class="card m-b-30">
<h6 class="card-header"><i class="mdi mdi-trophy"></i> Top 10 Pengguna dengan Pesanan Sosmed Tertinggi</h6>
<div class="card-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-box">
													<thead>
							
													<tr>
														<th>Peringkat</th>
														<th>Username</th>
														<th>Jumlah Pesanan</th>
													</tr>
												</thead>
												<tbody>
												<?php
													$check_news = mysqli_query($db, "SELECT * FROM hof ORDER BY pembelian_sosmed DESC LIMIT 5");
													$no = 1;
													while ($data_news = mysqli_fetch_assoc($check_news)) {
													    $ripalsensortransaksis = "-".strlen($data_news['username']);
		$mulaisensor = substr($data_news['username'],$ripalsensortransaksis,-2);
													?>
													<tr>
														<th scope="row"><?php echo $no; ?></th>
														<td><?php echo $mulaisensor; ?>**</td>
														<td>Rp <?php echo number_format($data_news['pembelian_sosmed'],0,',','.'); ?> (Dari <?php echo $data_news['jumlah_sosmed']; ?> pesanan)</td>
													</tr>
													<?php
													$no++;
													}
													?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
				
						<!-- end row -->
						<div class="col-lg-6">
<div class="card m-b-30">
<h6 class="card-header"><i class="mdi mdi-trophy"></i> Top 10 Pengguna dengan Pesanan Pulsa Tertinggi</h6>
<div class="card-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-box">
													<thead>
							
													<tr>
														<th>Peringkat</th>
														<th>Username</th>
														<th>Jumlah Pesanan</th>
													</tr>
												</thead>
												<tbody>
											<?php
													$check_news = mysqli_query($db, "SELECT * FROM hof ORDER BY pembelian_pulsa DESC LIMIT 5");
													$no = 1;
													while ($data_news = mysqli_fetch_assoc($check_news)) {
													    $ripalsensortransaksis = "-".strlen($data_news['username']);
		$mulaisensor = substr($data_news['username'],$ripalsensortransaksis,-2);
													?>
													<tr>
														<th scope="row"><?php echo $no; ?></th>
														<td><?php echo $mulaisensor; ?>**</td>
														<td>Rp <?php echo number_format($data_news['pembelian_pulsa'],0,',','.'); ?> (Dari <?php echo $data_news['jumlah_pulsa']; ?> pesanan)</td>
													</tr>
													<?php
													$no++;
													}
													?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					
<?php
	include("../lib/footer.php");
} else {
	header("Location: ".$cfg_baseurl);
}
?>