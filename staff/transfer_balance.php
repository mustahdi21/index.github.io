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
	} else if ($data_user['level'] == "Member") {
		header("Location: ".$cfg_baseurl);
	} else {
		if (isset($_POST['add'])) {
			$post_username = $_POST['username'];
			$post_balance = $_POST['balance'];

			$checkdb_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$post_username'");
			$datadb_user = mysqli_fetch_assoc($checkdb_user);
			if (empty($post_username) || empty($post_balance)) {
				$msg_type = "error";
				$msg_content = "<b>Gagal:</b> Mohon mengisi semua input.";
			} else if (mysqli_num_rows($checkdb_user) == 0) {
				$msg_type = "error";
				$msg_content = "<b>Gagal:</b> User $post_username tidak ditemukan.";
			} else if ($post_balance < $cfg_min_transfer) {
				$msg_type = "error";
				$msg_content = "<b>Gagal:</b> Minimal transfer adalah Rp $cfg_min_transfer.";
			} else if ($data_user['balance'] < $post_balance) {
				$msg_type = "error";
				$msg_content = "<b>Gagal:</b> Saldo Anda tidak mencukupi untuk melakukan transfer dengan jumlah tersebut.";
			} else {
				$update_user = mysqli_query($db, "UPDATE users SET balance = balance-$post_balance WHERE username = '$sess_username'"); // cut sender
				$update_user = mysqli_query($db, "UPDATE users SET balance = balance+$post_balance WHERE username = '$post_username'"); // send receiver
				$insert_tf = mysqli_query($db, "INSERT INTO transfer_balance (sender, receiver, quantity, date) VALUES ('$sess_username', '$post_username', '$post_balance', '$date')");
				if ($insert_tf == TRUE) {
					$msg_type = "success";
					$msg_content = "<b>Berhasil:</b> Transfer saldo berhasil.<br /><b>Pengirim:</b> $sess_username<br /><b>Penerima:</b> $post_username<br /><b>Jumlah Transfer:</b> Rp ".number_format($post_balance,0,',','.')." Saldo";
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
<h6 class="card-header"><i class="mdi mdi-account-settings-variant"></i> Transfer Saldo</h6>
<div class="card-body">
                <div class="col-md-12">
                    <div class="panel panel-default animated fadeInDown">
                        <div class="panel-heading">
                           <h3 class="panel-title"><i class="fa fa-user-plus"></i> Trasfer Saldo</h3>
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
												<label class="col-md-6 control-label">Username Penerima</label>
												<div class="col-md-10">
													<input type="text" name="username" class="form-control" placeholder="Username">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label">Jumlah Transfer</label>
												<div class="col-md-10">
													<input type="number" name="balance" class="form-control" placeholder="Jumlah Transfer">
												</div>
											</div>
											<div class="form-group">
												<div class="col-md-offset-2 col-md-10">
												<button type="submit" class="btn btn-primary" name="add"><i class="fa fa-send"></i> Submit</button>
												<button type="reset" class="btn btn-default"><i class="fa fa-refresh"></i> Ulangi</button>
											</div>
										</div>
										</form>
									</div>
								</div>
							</div>
              	</div>
								</div>
							</div>
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
                                    		<li><font color="red">*Admin tidak bertanggung jawab atas kesalahan pengguna</font></li>
                                    	</ul>
									</div>
								</div>
							</div>
						</div>
						</div>
						</div>
<?php
	include("../lib/footer.php");
	}
} else {
	header("Location: ".$cfg_baseurl);
}
?>