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
	} else if ($data_user['level'] == "Member" OR $data_user['level'] == "Agen") {
		header("Location: ".$cfg_baseurl);
	} else {
		$post_balance = $cfg_agen_bonus; // bonus agen
		$post_price = $cfg_agen_price; // price agen for registrant
		if (isset($_POST['add'])) {
			$post_fullname = $_POST['fullname'];
			$post_username = trim($_POST['username']);
			$post_password = $_POST['password'];
			$post_email = $_POST['email'];

			$checkdb_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$post_username'");
			$datadb_user = mysqli_fetch_assoc($checkdb_user);
			if (empty($post_username) || empty($post_password)) {
				$msg_type = "error";
				$msg_content = "<b>Gagal:</b> Mohon mengisi semua input.";
			} else if (mysqli_num_rows($checkdb_user) > 0) {
				$msg_type = "error";
				$msg_content = "<b>Gagal:</b> Username $post_username sudah terdaftar dalam database.";
			} else if ($data_user['balance'] < $post_price) {
				$msg_type = "error";
				$msg_content = "<b>Gagal:</b> Saldo Anda tidak mencukupi untuk melakukan pendaftaran Agen.";
			} else if (strlen($post_password) > 12) {
			$msg_type = "error";
			$msg_content = "<b>Failed:</b> New password is too long, at least less than 12 characters.";
		} else {
				$post_api = random(20);
				$update_user = mysqli_query($db, "UPDATE users SET balance = balance-$post_price WHERE username = '$sess_username'");				
				$insert_user = mysqli_query($db, "INSERT INTO users (fullname, username, password, balance, level, registered, status, api_key, email, uplink) VALUES ('$post_fullname', '$post_username', '$post_password', '$post_balance', 'Agen', '$date', 'Active', '$post_api', '$post_email', '$sess_username')");
				if ($insert_user == TRUE) {
					$msg_type = "success";
					$msg_content = "<b>Berhasil:</b> Agen telah ditambahkan.<br /><b>Username:</b> $post_username<br /><b>Password:</b> $post_password<br /><b>Level:</b> Agen<br /><b>Saldo:</b> Rp ".number_format($post_balance,0,',','.');
				} else {
					$msg_type = "error";
					$msg_content = "<b>Gagal:</b> Error system.";
				}
			}
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
<div class="col-lg-6">
<div class="card m-b-30">
<h6 class="card-header"><i class="mdi mdi-account-settings-variant"></i> Tambah Agen</h6>
<div class="card-body">
                <div class="col-md-12">
                    <div class="panel panel-default animated fadeInDown">
                        <div class="panel-heading">
                           <h3 class="panel-title"><i class="fa fa-user-plus"></i> Tambah Agen</h3>
                                </div>
                		<div class="panel-body">
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
												<label class="col-md-4 control-label">Nama Lengkap</label>
												<div class="col-md-10">
													<input type="text" name="fullname" class="form-control" placeholder="Nama Lengkap">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-4 control-label">E-Mail</label>
												<div class="col-md-10">
													<input type="text" name="email" class="form-control" placeholder="E-Mail Aktif">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-24 control-label">Username</label>
												<div class="col-md-10">
													<input type="text" name="username" class="form-control" placeholder="Username">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-4 control-label">Password</label>
												<div class="col-md-10">
													<input type="text" name="password" class="form-control" placeholder="Password">
												</div>
											</div>
											<div class="form-group">
												<div class="col-md-offset-2 col-md-10">
												<button type="submit" class="btn btn-primary" name="add"><i class="fa fa-send"></i> Submit</button>
												<button type="reset" class="btn btn-default"><i class="fa fa-refresh"></i>Ulangi</button>
											</div>
										</div>
										</form>
									</div>
								</div>
							</div>
								</div></div></div>
            	<div class="col-md-6">
<div class="card m-b-30">
<h6 class="card-header"><i class="mdi mdi-account-settings-variant"></i> Perhatian</h6>
<div class="card-body">
                <div class="col-md-7">
                    <div class="panel panel-default animated fadeInDown">
                        <div class="panel-heading">
                           <h3 class="panel-title"><i class="fa fa-user-plus"></i> Perhatian</h3>
                                </div>
                		<div class="panel-body">
                                    	<ul>
                                    		<li>Pastikan saldo anda cukup untuk melakukan pendaftaran Agen.</li>
                                    		<li>Saldo Anda terpotong Rp <?php echo number_format($post_price,0,',','.'); ?> untuk 1x pendaftaran Agen.</li>
                                    		<li>Agen baru akan mendapat saldo Rp. <?php echo number_format($post_balance,0,',','.'); ?>.</li><hr>
                                    		<li><font color="red">*Admin tidak bertanggung jawab atas kesalahan pengguna</font></li>
                                    	</ul>
									</div>
								</div>
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