<?php
session_start();
require("../../mainconfig.php");
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
		if (isset($_GET['id'])) {
			$post_id = $_GET['id'];
			$checkdb_news = mysqli_query($db, "SELECT * FROM news WHERE id = '$post_id'");
			$datadb_news = mysqli_fetch_assoc($checkdb_news);
			if (mysqli_num_rows($checkdb_news) == 0) {
				header("Location: ".$cfg_baseurl."admin/news.php");
			} else {
				if (isset($_POST['edit'])) {
					$post_content = $_POST['content'];
					if (empty($post_content)) {
						$msg_type = "error";
						$msg_content = "<b>Gagal:</b> Mohon mengisi semua input.";
					} else {
						$update_news = mysqli_query($db, "UPDATE news SET content = '$post_content' WHERE id = '$post_id'");
						if ($update_news == TRUE) {
							$msg_type = "success";
							$msg_content = "<b>Berhasil:</b> Informasi berhasil diubah.";
						} else {
							$msg_type = "error";
							$msg_content = "<b>Gagal:</b> Error system.";
						}
					}
				}
				$checkdb_news = mysqli_query($db, "SELECT * FROM news WHERE id = '$post_id'");
				$datadb_news = mysqli_fetch_assoc($checkdb_news);
				include("../../lib/header.php");
?>
            <div class="row">
                <div class="col-md-offset-2 col-md-8">
                    <div class="panel panel-default animated fadeInDown">
                        <div class="panel-heading">
                           <h3 class="panel-title"><i class="fa fa-edit"></i> Ubah Informasi</h3>
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
												<label class="col-md-2 control-label">Konten</label>
												<div class="col-md-10">
													<textarea name="content" class="form-control" placeholder="Konten"><?php echo $datadb_news['content']; ?></textarea>
												</div>
											</div>
											<div class="form-group">
												<div class="col-md-offset-2 col-md-10">
												<button type="submit" class="btn btn-info" name="edit"><i class="fa fa-send"></i> Submit</button>
											<a href="<?php echo $cfg_baseurl; ?>admin/informations" class="btn btn-default"><i class="fa fa-refresh"></i> Kembali </a>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
						<!-- end row -->
<?php
				include("../../lib/footer.php");
			}
		} else {
			header("Location: ".$cfg_baseurl."admin/informations.php");
		}
	}
} else {
	header("Location: ".$cfg_baseurl);
}
?>