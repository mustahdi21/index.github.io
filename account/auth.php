<?php
session_start();
require("../mainconfig.php");
$msg_type = "nothing";

if (isset($_SESSION['user'])) {
	header("Location: ".$cfg_baseurl);
} else {
	if (isset($_POST['login'])) {
		$post_username = mysqli_real_escape_string($db, trim($_POST['username']));
		$post_password = mysqli_real_escape_string($db, trim($_POST['password']));
		if (empty($post_username) || empty($post_password)) {
			$msg_type = "error";
            $msg_content = "<b>Respon : Gagal <br>Pesan </b>: Lengkapi semua input. <script>swal('Oh Snap!', 'Lengkapi semua input.', 'error');</script>";
		} else {
			$check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$post_username'");
			if (mysqli_num_rows($check_user) == 0) {
				$msg_type = "error";
                $msg_content = "<b>Respon : Gagal <br>Pesan</b> : Nama Pengguna atau Kata Sandi salah.. <script>swal('Oh Snap!', 'Kombinasi username dan password tidak ditemukan.', 'error');</script>";
			} else {
				$data_user = mysqli_fetch_assoc($check_user);
				if ($post_password <> $data_user['password']) {
					$msg_type = "error";
                    $msg_content = "<b>Respon : Gagal <br>Pesan </b>: Nama Pengguna atau Kata Sandi salah. <script>swal('Oh Snap!', 'Kombinasi username dan password tidak ditemukan.', 'error');</script>";
				} else if ($data_user['status'] == "Suspended") {
					$msg_type = "error";
					$msg_content = "<b>Respon : Gagal <br>Pesan</b> : Akun nonaktif. <script>swal('Oh Snap!', 'Akun Suspended.', 'error');</script>";
				} else {
					$_SESSION['user'] = $data_user;
					mysqli_query($db, "INSERT INTO ripalloglogin(username, aktifitas, tanggal, jam, ip) VALUES ('$post_username','Login','$date','$time','$ipnya')");
					header("Location: ".$cfg_baseurl);
				}
			}
		}
	}
if (isset($_SESSION['user'])) {
    } else {
?>
<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?php echo $cfg_desc; ?>">
        <meta name="author" content="<?php echo $cfg_author; ?>">

        <link rel="shortcut icon" href="https://www.freeiconspng.com/uploads/megaphone-message-news-promotion-speaker-icon--17.png">

        <title><?php echo $cfg_webname; ?></title>

        <!-- Google-Fonts -->
        <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:100,300,400,600,700,900,400italic' rel='stylesheet'>

        <!-- Bootstrap core CSS -->
        <!-- App css -->
        <link href="<?php echo $cfg_baseurl; ?>2/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $cfg_baseurl; ?>2/assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $cfg_baseurl; ?>2/assets/css/style.css" rel="stylesheet" type="text/css" />

        <script src="<?php echo $cfg_baseurl; ?>2/assets/js/modernizr.min.js"></script>
        <script src="//cdn.ckeditor.com/4.9.1/standard/ckeditor.js"></script>  

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','../../../www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-62751496-1', 'auto');
  ga('send', 'pageview');

</script>
<script src='https://www.google.com/recaptcha/api.js'></script>


    </head>
 <body class="bg-accpunt-pages">

        <!-- HOME -->
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">

                        <div class="wrapper-page">

                            <div class="account-pages">
                                <div class="account-box">
                                    <div class="account-logo-box">
                                        <h2 class="text-uppercase text-center">
                    <a href="<?php echo $cfg_baseurl; ?>" style="color: #0BB1BF">
                    <span><i class="mdi mdi-cart"></i> <?php echo $cfg_logo_txt; ?></span>
                    </a>
            </h2>
                                    </div>
                                    <div class="account-content">
                                        <?php 
                                        if ($msg_type == "error") {
                                        ?>
                                        <div class="alert alert-danger">
                                            <?php echo $msg_content; ?>
                                        </div>
                                        <?php
                                        }
                                        ?>
                                        <form class="form-horizontal" role="form" method="POST">
                                            <div class="form-group m-b-20 row">
<div class="col-12">
<label>Nama Pengguna</label>
<input class="form-control" type="text" name="username">
</div>
</div>
<div class="form-group row m-b-20">
<div class="col-12">
<label>Kata Sandi</label>
<input class="form-control" type="password" name="password">
</div>
</div>
                                                                                       <div class="form-group row text-center m-t-10">
                                            <div class="col-12">
                                            <button name="login" class="btn btn-block btn-gradient waves-effect waves-light" type="submit">Masuk</button>
                                            </div>
                                            </div>
                                        </form>
                                                <div class="row m-t-50">
                                                    <div class="col-sm-12 text-center">
                                                    <p class="text-muted">Belum punya akun? <a href="https://www.facebook.com/putraa.id.33" class="text-dark m-l-5"><b>Daftar</b></a></p>
                                                    <p class="text-muted">Lupa Akun <a href="<?php echo $cfg_baseurl;?>account/forgot" class="text-dark m-l-5"><b>Reset</b></a></p>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>

<?php
}
}
?>

        <!-- js placed at the end of the document so the pages load faster -->
        <script src="<?php echo $cfg_baseurl; ?>js/jquery.js"></script>
        <!-- jQuery  -->
        <script src="<?php echo $cfg_baseurl; ?>2/assets/js/jquery.min.js"></script>
        <script src="<?php echo $cfg_baseurl; ?>2/assets/js/popper.min.js"></script>
        <script src="<?php echo $cfg_baseurl; ?>2/assets/js/bootstrap.min.js"></script>
        <script src="<?php echo $cfg_baseurl; ?>2/assets/js/waves.js"></script>
        <script src="<?php echo $cfg_baseurl; ?>2/assets/js/jquery.slimscroll.js"></script>

        <!-- Counter number -->
        <script src="<?php echo $cfg_baseurl; ?>2/assets/waypoints/lib/jquery.waypoints.min.js"></script>
        <script src="<?php echo $cfg_baseurl; ?>2/assets/counterup/jquery.counterup.min.js"></script>

        <!-- Chart JS -->
        <script src="<?php echo $cfg_baseurl; ?>2/assets/chart.js/chart.bundle.js"></script>

        <!-- init dashboard -->
        <script src="<?php echo $cfg_baseurl; ?>2/assets/pages/jquery.dashboard.init.js"></script>


        <!-- App js -->
        <script src="<?php echo $cfg_baseurl; ?>2/assets/js/jquery.core.js"></script>
        <script src="<?php echo $cfg_baseurl; ?>2/assets/js/jquery.app.js"></script>


        <script type="text/javascript">
        /* ==============================================
             Counter Up
             =============================================== */
            jQuery(document).ready(function($) {
                $('.counter').counterUp({
                    delay: 100,
                    time: 1200
                });
            });
        </script>
<script>
	var beamer_config = {
		product_id : "wARrekbf6346", //DO NOT CHANGE: This is your product code on Beamer
		button_position: 'bottom-left' /*Position for the default notification button. Other possible values are 'bottom-left', 'top-left' and 'top-left'.*/
	};
</script>
<script type="text/javascript" src="https://app.getbeamer.com/js/beamer-embed.js" defer="defer"></script>
<script src='https://code.responsivevoice.org/responsivevoice.js'></script>
<script>
var say = 'Selamat Datang Di Batam Media, Batam Media Merupakan Sebuah Website Penyedia Layanan Sosial Media Seperti, Followers, Like, Views, Pulsa , Voucher Game Termurah, Cepat & Berkualitas.Instant & Auto Processing Harga Murah Dan Berkualitas Data Order Di Proses Secepat JET, Layanan Lengkap, Support 24 Jam Selamat Datang Dan SelamatBergabung Terimakasih';
var voice = 'Indonesian Female';
setTimeout(responsiveVoice.speak(say, voice),5000);
</script>
</body>
</html>
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5bb4490cb033e9743d020998/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->