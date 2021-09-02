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
}

include("lib/header.php");
?>
        <div class="wrapper">
<div class="container-fluid" style="padding: 50px 20px;">
<div class="row">
<div class="col-lg-12">
</div>
</div>
<div class="row">            <div class="col-md-12">
								<div class="card m-b-30">
<h6 class="card-header"><i class="mdi mdi-cart"></i> Api DOC</h6>
<div class="card-body">
							<div class="table-responsive">
                                    <table class="table table-bordered">
											<tbody>
												<tr>
													<td>Metode HTTP</td>
													<td>POST</td>
												</tr>
												<tr>
													<td>API URL</td>
													<td><?php echo $cfg_baseurl; ?>api</td>
												</tr>
												<tr>
													<td>Format Respon</td>
													<td>JSON</td>
												</tr>
												<tr>
													<td>Contoh Class</td>
													<td><a href="<?php echo $cfg_baseurl; ?>api_example.php" target="blank">Contoh Class PHP</a></td>
												</tr>
											</tbody>
										</table>
									</div>

						</div>

                <div class="col-md-12">
                    <div class="panel panel-default animated fadeInDown">
                        <div class="panel-heading">
                           <h3 class="panel-title"><i class="fa fa-shopping-cart"></i> Membuat Pesanan</h3>
                                </div>
                			<div class="panel-body">
								<div class="table-responsive">
									<table class="table table-bordered">
										<tbody>
											<tr>
												<th width="50%">Parameter</th>
												<th>Deskripsi</th>
											</tr>
											<tr>
												<td><code>api_key</code></td>
												<td>API Key Anda, cek di halaman <a href="<?php echo $cfg_baseurl; ?>account/profile" target="blank">Pengaturan Akun</a></td>
											</tr>
											<tr>
												<td><code>action</code></td>
												<td>Untuk action diisi dengan <code>add</code></a></td>
											</tr>											
											<tr>
												<td><code>service</code></td>
												<td>ID Layanan, cek di halaman <a href="<?php echo $cfg_baseurl; ?>services" target="blank">Daftar Harga</a></td>
											</tr>
											<tr>
												<td><code>link</code></td>
												<td>Data target yang dibutuhkan (username/link/url) sesuai permintaan layanan.</td>
											</tr>
											<tr>
												<td><code>quantity</code></td>
												<td>Jumlah pemesanan.</td>
											</tr>
										</tbody>
									</table>
								</div>
<p>Contoh Hasil Permintaan Sukses</p>
<pre>{
  "order_id":"R4ND0MK3Y"
}</pre>
<p>Contoh Hasil Permintaan Gagal</p>
<pre>{
  "error":"Incorrect request"
}</pre>								
							</div>
						</div>
					</div>						
                <div class="col-md-12">
                    <div class="panel panel-default animated fadeInDown">
                        <div class="panel-heading">
                           <h3 class="panel-title"><i class="fa fa-refresh"></i> Mengecek Status Pesanan</h3>
                                </div>
                			<div class="panel-body">
								<div class="table-responsive">
									<table class="table table-bordered">
										<tbody>
											<tr>
												<th width="50%">Parameter</th>
												<th>Deskripsi</th>
											</tr>
											<tr>
												<td><code>api_key</code></td>
												<td>API Key Anda, cek di halaman <a href="<?php echo $cfg_baseurl; ?>user/profile" target="blank">Pengaturan Akun</a></td>
											</tr>
											<tr>
												<td><code>action</code></td>
												<td>Untuk action isi dengan <code>status</code></a></td>
											</tr>
											<tr>
												<td><code>order_id</code></td>
												<td>Isi dengan id pesanan.</td>
											</tr>
										</tbody>
									</table>
								</div>
<p>Contoh Hasil Permintaan Sukses</p>
<pre>{
  "charge":"10000",
  "start_count":"123",
  "status":"Success",
  "remains":"0"
}</pre>
<p>Contoh Hasil Permintaan Gagal</p>
<pre>{
  "error":"Incorrect request"
}</pre>								
							</div>
						</div>
					</div>
				</div>
						<!-- end row -->
<?php
include("lib/footer.php");
?>