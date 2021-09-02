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
?> <div class="wrapper">
<div class="container-fluid" style="padding: 50px 20px;">
<div class="row">
<div class="col-lg-12">
</div>
</div>
<div class="row">  <div class="col-md-12">
								<div class="card m-b-30">
<h6 class="card-header"><i class="mdi mdi-cart"></i> Ketentuan Layanan</h6>
<div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default animated fadeInDown">
                        <div class="panel-heading">
                           <h3 class="panel-title"><i class="fa fa-info-circle"></i> Ketentuan Layanan</h3>
                                </div>
                                    <div class="panel-body">
                                        <p>Layanan yang disediakan oleh <?php echo $cfg_webname; ?> telah ditetapkan kesepakatan-kesepakatan berikut.</p>
                                        <p><b>1. Umum</b>
                                        <br />Dengan mendaftar dan menggunakan layanan <?php echo $cfg_webname; ?>, Anda secara otomatis menyetujui semua ketentuan layanan kami. Kami berhak mengubah ketentuan layanan ini tanpa pemberitahuan terlebih dahulu. Anda diharapkan membaca semua ketentuan layanan kami sebelum membuat pesanan.
                                        <br />Penolakan: <?php echo $cfg_webname; ?> tidak akan bertanggung jawab jika Anda mengalami kerugian dalam bisnis Anda.
                                        <br />Kewajiban: <?php echo $cfg_webname; ?> tidak bertanggung jawab jika Anda mengalami suspensi akun atau penghapusan kiriman yang dilakukan oleh Instagram, Twitter, Facebook, Youtube, dan lain-lain.<hr>
                                        <b>2. Layanan</b>
                                        <br /><?php echo $cfg_webname; ?> hanya digunakan untuk media promosi sosial media dan membantu meningkatkan penampilan akun Anda saja.<hr>
                                        <br /><?php echo $cfg_webname; ?> tidak menjamin pengikut baru Anda berinteraksi dengan Anda, kami hanya menjamin bahwa Anda mendapat pengikut yang Anda beli.
                                        <br /><?php echo $cfg_webname; ?> tidak menerima permintaan pembatalan/pengembalian dana setelah pesanan masuk ke sistem kami. Kami memberikan pengembalian dana yang sesuai jika pesanan tida dapat diselesaikan.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
<?php
include("lib/footer.php");
?>