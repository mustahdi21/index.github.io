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
				header("Location: ".$cfg_baseurl."admin/informations");
			} else {
				include("../../lib/header.php");
?>

            <div class="row">
                <div class="col-md-offset-2 col-md-8">
                    <div class="panel panel-default animated fadeInDown">
                        <div class="panel-heading">
                           <h3 class="panel-title"><i class="fa fa-trash"></i> Hapus Informasi</h3>
                                </div>
                		<div class="panel-body">
										<form class="form-horizontal" role="form" method="POST" action="<?php echo $cfg_baseurl; ?>admin/informations">
											<input type="hidden" name="id" value="<?php echo $datadb_news['id']; ?>">
											<div class="form-group">
												<label class="col-md-2 control-label">Konten</label>
												<div class="col-md-10">
													<textarea class="form-control" placeholder="Content" readonly><?php echo $datadb_news['content']; ?></textarea>
												</div>
											</div>
											<div class="form-group">
												<div class="col-md-offset-2 col-md-10">
												<button type="submit" class="btn btn-info" name="delete"><i class="fa fa-send"></i> Submit</button>
											<a href="<?php echo $cfg_baseurl; ?>admin/informations" class="btn btn-default"><i class="fa fa-refresh"></i> Kembali</a>
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