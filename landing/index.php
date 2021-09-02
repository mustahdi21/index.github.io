<?php
session_start();
require("../mainconfig.php");

	$check_order = mysqli_query($db, "SELECT SUM(price) AS total FROM orders WHERE user = '$sess_username'");
	$data_order = mysqli_fetch_assoc($check_order);
	$check_depo = mysqli_query($db, "SELECT SUM(balance) AS total FROM deposits WHERE user = '$sess_username'");
	$data_depo = mysqli_fetch_assoc($check_depo);
	$check_depop = mysqli_query($db, "SELECT SUM(balance) AS total FROM deposits_auto WHERE user = '$sess_username'");
	$data_depop = mysqli_fetch_assoc($check_depop);
	$total_deposit = $data_depop+$data_depo;
	$count_users = mysqli_num_rows(mysqli_query($db, "SELECT * FROM users"));
	$count_sosmed = mysqli_num_rows(mysqli_query($db, "SELECT * FROM orders WHERE user = '$sess_username'"));
	$count_pulsa = mysqli_num_rows(mysqli_query($db, "SELECT * FROM orders_pulsa WHERE user = '$sess_username'"));
	$count_game = mysqli_num_rows(mysqli_query($db, "SELECT * FROM orders_dm WHERE user = '$sess_username'"));
 

// widget
	$check_worder = mysqli_query($db, "SELECT SUM(price) AS total FROM orders"); //total pesanan
	$data_worder = mysqli_fetch_assoc($check_worder);
	$check_worder = mysqli_query($db, "SELECT * FROM orders");
	$count_worder = mysqli_num_rows($check_worder);
	
	$check_wuser = mysqli_query($db, "SELECT SUM(balance) AS total FROM users");// total user
	$data_wuser = mysqli_fetch_assoc($check_wuser);
	$check_wuser = mysqli_query($db, "SELECT * FROM users");
	$count_wuser = mysqli_num_rows($check_wuser);
	
	$check_wser = mysqli_query($db, "SELECT SUM(balance) AS total FROM services");// total layanan
	$data_wser = mysqli_fetch_assoc($check_wser);
	$check_wser = mysqli_query($db, "SELECT * FROM services");
	$count_wser = mysqli_num_rows($check_wser);
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="<?php echo $cfg_logo_txt; ?> adalah sebuah platform bisnis yang menyediakan berbagai layanan social media marketing yang bergerak terutama di Indonesia. Dengan bergabung bersama kami, Anda dapat menjadi penyedia jasa social media atau reseller social media seperti jasa penambah Followers, Likes, dll. Saat ini tersedia berbagai layanan untuk social media terpopuler seperti Instagram, Facebook, Twitter, Youtube, dll.">
<meta name="author" content="<?php echo $cfg_logo_txt; ?>Team">
<meta name="keywords" content="smm panel reseller, smm panel indonesia, panel all sosmed, daftar panel all sosmed, smm reseller, smm reseller panel, smm panel">
<link rel="shortcut icon" href="https://pictr.com/images/2018/10/27/0GIAtl.png">
<title><?php echo $cfg_webname; ?></title>
<link href="<?php echo $cfg_baseurl; ?>landing/ripalganteng/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo $cfg_baseurl; ?>landing/ripalganteng/css/icons.css" rel="stylesheet">
<link href="<?php echo $cfg_baseurl; ?>landing/ripalganteng/css/icons-social.css" rel="stylesheet">
<link href="<?php echo $cfg_baseurl; ?>landing/ripalganteng/css/style.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.8/typed.min.js"></script>

</head>
<body style="padding-top: 80px;">
<nav class="navbar navbar-default navbar-custom navbar-fixed-top sticky">
<div class="container">

<div class="navbar-header">
<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
<span class="sr-only">Toggle navigation</span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>
<a class="navbar-brand" href="<?php echo $cfg_baseurl; ?>"><?php echo $cfg_logo_txt; ?></a>
</div>

<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
<ul class="nav navbar-nav navbar-right">
<li><a href="<?php echo $cfg_baseurl; ?>">Halaman Utama</a></li>
<li><a href="<?php echo $cfg_baseurl; ?>price_list">Daftar Layanan</a></li>
<li><a href="<?php echo $cfg_baseurl; ?>contact">Kontak</a></li>
<li><a href="<?php echo $cfg_baseurl; ?>terms">Ketentuan Layanan</a></li>
<li><a href="<?php echo $cfg_baseurl; ?>faq">Pertanyaan Umum</a></li>
<li><a href="<?php echo $cfg_baseurl; ?>landing/_Batam_Media_8059886.apk">Download Aplikasinya</a><li>
</ul>
</div>

</div>

</nav>
<div class="clearfix"></div>
<section class="section-lg home-alt bg-solid" id="home">
<div class="container">
<div class="row">
<div class="col-md-8 col-md-offset-2">
<div class="home-wrapper text-center">
<p style="font-size: 25px; font-weight: normal;" class="text-muted"><?php echo $cfg_logo_txt; ?> Social Media Marketing Panel</p>
<h1><span id="typed"></span></h1>
<a href="<?php echo $cfg_baseurl; ?>account/auth" class="btn btn-dark">Masuk</a>
<a href="https://www.facebook.com/putraa.id.33" class="btn btn-white">Daftar</a>
</div>
</div>
</div>
</div>
</section>
<div class="clearfix"></div>
<section>
<div class="container">
<div class="row">
<div class="col-md-8 col-md-offset-2">
<div class="facts-box text-center">
<div class="row">
<div class="col-md-4">
<h2><?php echo number_format($count_wuser,0,',','.'); ?></h2>
<p class="text-muted">Total Pengguna Aktif</p>
</div>
<div class="col-md-4">
<h2><?php echo number_format($count_worder,0,',','.'); ?></h2>
<p class="text-muted">Total Pesanan</p>
</div>
<div class="col-md-4">
<h2><?php echo number_format($count_wser,0,',','.'); ?></h2>
<p class="text-muted">Total Layanan</p>
</div>
 </div>
</div>
</div>
</div>
</div>
</section>
<div class="clearfix"></div>
<section class="section" id="features">
<div class="container">
<div class="row">
<div class="col-sm-4">
<div class="features-box text-center">
<div class="feature-icon">
<span class="icon-noun_1498981_cc gradient " style=""></span>
</div>
<h3>Kualitas Terbaik</h3>
<p class="text-muted">Kami selalu mengutamakan kualitas terbaik untuk layanan yang kami sediakan demi kepercayaan client.</p>
</div>
</div>
<div class="col-sm-4">
<div class="features-box text-center">
<div class="feature-icon">
<span class="icon-noun_356664_cc gradient" style=""></span>
</div>
<h3>Proses Cepat</h3>
<p class="text-muted">Dengan <?php echo $cfg_logo_txt; ?> anda bisa menikmati kecepatan dari panel kami, dari followers,like,views dan lain lainnya hanya dalam waktu 1x24Jam.</p>
</div>
</div>
<div class="col-sm-4">
<div class="features-box text-center">
<div class="feature-icon">
<span class="icon-noun_86266_cc gradient" style=""></span>
</div>
<h3>Terpercaya</h3>
<p class="text-muted">Sudah banyak User yang telah bergabung bersama kami, jadi kami sangat bisa Dipercaya.</p>
</div>
</div>
</div>
</div>
</section>
<section class="section bg-white" id="about">
<div class="container">
<div class="row text-center">
<div class="col-sm-12">
<h2 class="title">Tentang Kami</h2>
<p class="title-alt"><?php echo $cfg_logo_txt; ?> adalah sebuah platform bisnis yang menyediakan berbagai layanan social media marketing yang bergerak terutama di Indonesia.<br />Dengan bergabung bersama kami, Anda dapat menjadi penyedia jasa social media atau reseller social media seperti jasa penambah Followers, Likes, dll.<br>Saat ini tersedia berbagai layanan untuk social media terpopuler seperti Instagram, Facebook, Twitter, Youtube, dll.</p>
</div>
</div>
</div>
</section>
<section class="section" id="faqs">
<div class="container">
<div class="row text-center">
<div class="col-sm-12">
<h2 class="title">Pertanyaan Umum</h2>
<p class="title-alt">Berikut telah kami rangkum beberapa pertanyaan yang sering ditanyakan client terkait layanan kami.</p>
<div class="row text-left">
<div class="col-sm-6">
<div class="question-box">
<h4><span class="text-colored">Q.</span> Apa itu <?php echo $cfg_logo_txt; ?>?</h4>
<p><span><b>A.</b></span> <?php echo $cfg_logo_txt; ?> adalah sebuah platform bisnis yang menyediakan berbagai layanan social media marketing yang bergerak terutama di Indonesia. Dengan bergabung bersama kami, Anda dapat menjadi penyedia jasa social media atau reseller social media seperti jasa penambah Followers, Likes, dll.</p>
</div>
<div class="question-box">
<h4><span class="text-colored">Q.</span> Bagaimana cara mendaftar di <?php echo $cfg_logo_txt; ?>?</h4>
<p><span><b>A.</b></span> Silahkan menghubungi Admin untuk mendapatkan kode undangan, silahkan menuju halaman KONTAK untuk melihat kontak Admin.</p>
</div>
</div>
<div class="col-sm-6">
<div class="question-box">
<h4><span class="text-colored">Q.</span> Bagaimana cara membuat pesanan?</h4>
<p><span><b>A.</b></span> Untuk membuat pesanan sangatlah mudah, Anda hanya perlu masuk terlebih dahulu ke akun Anda dan menuju halaman pemesanan dengan mengklik menu yang sudah tersedia. Selain itu Anda juga dapat melakukan pemesanan melalui request API.</p>
</div>
<div class="question-box">
<h4><span class="text-colored">Q.</span> Bagaimana cara melakukan deposit/isi saldo?</h4>
<p><span><b>A.</b></span> Untuk melakukan deposit/isi saldo, Anda hanya perlu masuk terlebih dahulu ke akun Anda dan menuju halaman deposit dengan mengklik menu yang sudah tersedia. Kami menyediakan deposit melalui bank dan pulsa.</p>
</div>
</div>
</div>
</div>

</div>
</div>
</section>
<footer class="bg-dark footer-one" style="padding-top: 0;">
<div class="footer-one-alt" style="margin-top: 0;">
<div class="container">
<div class="row">
<div class="col-lg-8">
<p class="m-b-0 font-13 copyright">2018 &copy; Batam Media - Dibuat Dengan❤ <a href="https://www.facebook.com/putraa.id.33" target="_blank">Putraa</a></p>
</div>

</div>
</div>
</div>
</footer>

<script src="<?php echo $cfg_baseurl; ?>landing/ripalganteng/js/3.js"></script>
<script src="<?php echo $cfg_baseurl; ?>landing/ripalganteng/js/4.js"></script>

<script type="text/javascript" src="<?php echo $cfg_baseurl; ?>landing/ripalganteng/js/5.js"></script>

<script src="<?php echo $cfg_baseurl; ?>landing/ripalganteng/js/2.js" type="text/javascript"></script>

<script src="<?php echo $cfg_baseurl; ?>landing/ripalganteng/js/1.js"></script>
<script type="text/javascript">
			var typed = new Typed('#typed',{
  strings : ['Kualitas terbaik','Harga termurah','Pelayanan terbaik'],
  typeSpeed : 70,
  delaySpeed : 110,
  loop : true
});
		</script>
</body>
</html>