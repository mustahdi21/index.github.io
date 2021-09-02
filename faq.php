<?php
session_start();
require("mainconfig.php");

if (isset($_SESSION['user'])) {
	$sess_username = $_SESSION['user']['username'];
	$check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sess_username'");
	$data_user = mysqli_fetch_assoc($check_user);
	if (mysqli_num_rows($check_user) == 0) {
		header("Location: ".$cfg_baseurl."account/logout");
	} else if ($data_user['status'] == "Suspended") {
		header("Location: ".$cfg_baseurl."account/logout");
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
<div class="row">  <div class="col-md-12">
								<div class="card m-b-30">
<h6 class="card-header"><i class="mdi mdi-cart"></i> FAQ</h6>
<div class="card-body">

                            <div class="row m-t-40">
                                <div class="col-lg-6">
                                    <div class="p-20">
                                        <div class="panel-group m-b-0" id="accordion" role="tablist"
                                             aria-multiselectable="true">
                                            <div class="panel panel-border panel-custom bx-shadow-none">
                                                <div class="panel-heading" role="tab" id="headingOne">
                                                    <h4 class="panel-title">
                                                        <a role="button" data-toggle="collapse"
                                                           data-parent="#accordion" href="#collapseOne"
                                                           aria-expanded="false" aria-controls="collapseOne">
                                                           <i class="fa fa-shopping-cart"></i> Bagaimana cara melakukan pemesanan?
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseOne" class="panel-collapse collapse in"
                                                     role="tabpanel" aria-labelledby="headingOne">
                                                    <div class="panel-body">
                                                       <h4> Untuk melakukan pemesanan Anda harus memiliki saldo yang cukup. Masuk ke halaman pemesanan, pilih kategori, pilih layanan, masukkan target, masukkan jumlah pemesanan, klik pemesanan. Maka akan muncul hasil proses berupa sukses pemesanan/gagal pemesanan. Jika pemesanan sukses silahkan menunggu hingga pemesanan selesai.</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-border panel-custom bx-shadow-none">
                                                <div class="panel-heading" role="tab" id="headingTwo">
                                                    <h4 class="panel-title">
                                                        <a class="collapsed" role="button" data-toggle="collapse"
                                                           data-parent="#accordion" href="#collapseTwo"
                                                           aria-expanded="false" aria-controls="collapseTwo">
                                                           <i class="fa fa-money"></i> Bagaimana cara melakukan deposit?
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseTwo" class="panel-collapse collapse"
                                                     role="tabpanel" aria-labelledby="headingTwo">
                                                    <div class="panel-body">
                                                        <h4>Untuk melakukan deposit silahkan masuk ke halaman Deposit, pilih metode pembayaran, masukkan jumlah deposit, maka akan muncul jumlah saldo yang akan diterima, klik Proses Deposit. Maka akan muncul hasil proses berupa kode request deposit dan nomor tujuan pembayaran. Simpan kode request dan lakukan pembayaran, jika pembayaran telah dilakukan, kirimkan bukti pembayaran dan kode request pada Admin melalui tiket bantuan / kontak Admin.</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- end col -->

                                <div class="col-lg-6">
                                    <div class="p-20">
                                        <div class="panel-group m-b-0" id="accordion1" role="tablist"
                                             aria-multiselectable="false">
                                            <div class="panel panel-border panel-custom bx-shadow-none">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a role="button" data-toggle="collapse"
                                                           data-parent="#accordion1" href="#faq4">
                                                            <i class="fa fa-refresh"></i> Bagaimana jika orderan error/partial ?
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="faq4" class="panel-collapse collapse in">
                                                    <div class="panel-body">
                                                        <h4>Jika status order Anda terjadi Error/Partial sistem akan otomatis mengembalikan saldo Anda, sesuai jumlah yang ditentukan.</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-border panel-custom bx-shadow-none">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a class="collapsed" role="button" data-toggle="collapse"
                                                           data-parent="#accordion1" href="#faq5">
                                                          <i class="fa fa-times-circle"></i> Bagaimana jika orderan stuck/tidak ada status?
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="faq5" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        <h4>Mohon menunggu selama 2x24 jam, orderan stuck kemungkinan dikarenakan server yang sedang pending. Harap bersabar dan jika lebih dari 2x24 jam orderan tetap stuck, segera hubungi Admin.</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- end col -->
                            </div><!-- end row -->

                        </div>
                    </div><!-- end col -->
                </div>
                <!-- end row -->
<?php
include("lib/footer.php");
?>