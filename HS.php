<?php
session_start();
require("mainconfig.php");

if (isset($_SESSION['user'])) {
	$sess_username = $_SESSION['user']['username'];
	$check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sess_username'");
	$data_user = mysqli_fetch_assoc($check_user);
	if (mysqli_num_rows($check_user) == 0) {
		header("Location: ".$cfg_baseurl."logout.php");
	} else if ($data_user['status'] == "Suspended") {
		header("Location: ".$cfg_baseurl."logout.php");
	}

	include("lib/header.php");
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
 <main class="main">
     <!-- Breadcrumb -->
            <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
                <li class="breadcrumb-item ">
                    <a href="">History Saldo</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="#"><?php echo $logo_white; ?></a>
                </li>
                <li class="breadcrumb-item active">History Saldo</li>

            </ol>
<div class="container-fluid">

                <div class="animated fadeIn">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-accent-theme">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-color panel-info">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><i class="fa fa-trophy"></i> 50 LAST HISTORY SALDO</h3>
                                    </div>
                                    <div class="panel-body">
                                <div class="table-responsive m-t-0">
<table id="datatable-responsive" class="table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
							
													<tr>
														<th>#</th>
														<th>Catatan Aktifitas</th>
														<th>Waktu</th>
													</tr>
												</thead>
												<tbody>
												<?php
													$check_user = mysqli_query($db, "SELECT * FROM balance_history WHERE username = '$sess_username' ORDER BY id DESC LIMIT 50");
													$no = 1;
													while ($data_user = mysqli_fetch_assoc($check_user)) {
													?>
													<tr>
														<th scope="row"><?php echo $no; ?></th>
														<td>Melakukan <?php echo $data_user['msg']; ?></td>
														<td><?php echo $data_user['date']; ?> - <?php echo $data_user['time']; ?></td>
													</tr>

												<?php
													$no++;
													}
													?>
										</tbody>
									</table>
                                </div>
							</div></div></div></div>
						</div>
<?php
	include("lib/footer.php");
} else {
	header("Location: ".$cfg_baseurl);
}
?>