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
	$msg_type = "nothing";

	if (isset($_POST['change_pswd'])) {
		$post_password = trim($_POST['password']);
		$post_npassword = trim($_POST['npassword']);
		$post_cnpassword = trim($_POST['cnpassword']);
		if (empty($post_password) || empty($post_npassword) || empty($post_cnpassword)) {
			$msg_type = "error";
			$msg_content = "<b>Failed:</b> Please fill all input.";
		} else if ($post_password <> $data_user['password']) {
			$msg_type = "error";
			$msg_content = "<b>Failed:</b> Wrong password.";
		} else if (strlen($post_npassword) < 5) {
			$msg_type = "error";
			$msg_content = "<b>Failed:</b> New password is too short, at least 5 characters.";
		} else if (strlen($post_npassword) > 12) {
			$msg_type = "error";
			$msg_content = "<b>Failed:</b> New password is too long, at least less than 12 characters.";
		} else if ($post_cnpassword <> $post_npassword) {
			$msg_type = "error";
			$msg_content = "<b>Failed:</b> The new password confirmation does not match.";
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
			$msg_type = "sukses";
			$msg_content = "<b>Berhasil:</b> API Key telah diubah.";
		} else {
			$msg_type = "gagal";
			$msg_content = "<b>Gagal:</b> Error system.";
		}
	
	} else if (isset($_POST['change_name'])) {
		$newname = $_POST['newname'];
		$update_user = mysqli_query($db, "UPDATE users SET fullname = '$newname' WHERE username = '$sess_username'");
		if ($update_user == TRUE) {
			$msg_type = "sukses";
			$msg_content = "<b>Berhasil:</b> Nama telah diubah.";
		} else {
			$msg_type = "gagal";
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
<div class="row">  <div class="col-md-6">
								<div class="card m-b-30">
<h6 class="card-header"><i class="mdi mdi-cart"></i> Pengaturan Akun</h6>
<div class="card-body">
										<?php 
										if ($msg_type == "sukses") {
										?>
										<div class="alert alert-success">
											<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
											<i class="fa fa-check-circle"></i>
											<?php echo $msg_content; ?>
										</div>
										<?php
										} else if ($msg_type == "gagal") {
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
												<label class="col-md-2 control-label">Nama Lengkap</label>
												<div class="col-md-10">
													<div class="input-group">
														<input type="text" class="form-control" name="newname" placeholder="Note" value="<?php echo $data_user['fullname']; ?>">
														<span class="input-group-btn">
															<button type="submit" class="btn btn-primary" name="change_name"><i class="fa fa-random"></i> Ubah</button>
														</span>
													</div>
												</div>
											</div>											
											<div class="form-group">
												<label class="col-md-2 control-label">Username</label>
												<div class="col-md-10">
													<input class="form-control" type="text" value="<?php echo $data_user['username']; ?>" readonly="readonly">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">E-Mail</label>
												<div class="col-md-10">
													<input class="form-control" type="text" value="<?php echo $data_user['email']; ?>" readonly="readonly">
												</div>
											</div>											
											<div class="form-group">
												<label class="col-md-2 control-label">API Key</label>
												<div class="col-md-10">
													<div class="input-group">
														<input type="text" class="form-control" value="<?php echo $data_user['api_key']; ?>" readonly="readonly">
														<span class="input-group-btn">
															<button type="submit" class="btn btn-primary" name="change_api"><i class="fa fa-random"></i> Ubah</button>
														</span>
													</div>
												</div>
											</div>
										</form>
							</div></div>
							</div>
                <div class="col-md-6">
								<div class="card m-b-30">
<h6 class="card-header"><i class="mdi mdi-cart"></i> Ubah Sandi</h6>
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
												<label class="col-md-2 control-label">Password</label>
												<div class="col-md-10">
													<input type="password" name="password" class="form-control" placeholder="Password">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Password Baru</label>
												<div class="col-md-10">
													<input type="password" name="npassword" class="form-control" placeholder="Password Baru">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Konfirmasi Password</label>
												<div class="col-md-10">
													<input type="password" name="cnpassword" class="form-control" placeholder="Konfirmasi Password Baru">
												</div>
											</div>										
											<div class="form-group">
												<div class="col-md-offset-2 col-md-10">
											<button type="submit" class="btn btn-primary" name="change_pswd"><i class="fa fa-send"></i> Submit </button>
											<button type="submit" class="btn btn-warning" name="change_pswd"><i class="fa fa-refresh"></i> Ulangi </button>											
											    </div>
											</div>
										</form>
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