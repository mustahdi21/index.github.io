<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?php echo $cfg_desc; ?>">
        <meta name="author" content="<?php echo $cfg_author; ?>">

        <link rel="shortcut icon" href="">

        <title><?php echo $cfg_webname; ?></title>

        <!-- Google-Fonts -->
        <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:100,300,400,600,700,900,400italic' rel='stylesheet'>

        <!-- Bootstrap core CSS -->
        <link href="<?php echo $cfg_baseurl; ?>css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo $cfg_baseurl; ?>css/bootstrap-reset.css" rel="stylesheet">

        <!--Animation css-->
        <link href="<?php echo $cfg_baseurl; ?>css/animate.css" rel="stylesheet">

        <!--Icon-fonts css-->
        <link href="<?php echo $cfg_baseurl; ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href="<?php echo $cfg_baseurl; ?>assets/ionicon/css/ionicons.min.css" rel="stylesheet" />

        <!--Morris Chart CSS -->
        <link rel="stylesheet" href="<?php echo $cfg_baseurl; ?>assets/morris/morris.css">

        <!-- sweet alerts -->
        <link href="<?php echo $cfg_baseurl; ?>assets/sweet-alert/sweet-alert.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="<?php echo $cfg_baseurl; ?>css/style.css" rel="stylesheet">
        <link href="<?php echo $cfg_baseurl; ?>css/helper.css" rel="stylesheet">
        <link href="<?php echo $cfg_baseurl; ?>css/style-responsive.css" rel="stylesheet" />
        <script src="//cdn.ckeditor.com/4.9.1/standard/ckeditor.js"></script>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','../../../www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-62751496-1', 'auto');
  ga('send', 'pageview');

</script>

    </head>

    <body>

        <!-- Aside Start-->
        <aside class="left-panel">

            <!-- brand -->
            <div class="logo">
                <a href="<?php echo $cfg_baseurl; ?>" class="logo-expanded">
                    <i class="fa fa-shopping-cart"></i>
                    <span class="nav-label"><?php echo $cfg_logo_txt; ?></span>
                </a>
            </div>
            <!-- / brand -->

            <!-- Navbar Start -->
            <nav class="navigation">
                <ul class="list-unstyled">
            <?php
            if (isset($_SESSION[ 'user'])) {
            ?>
            <?php
            if ($data_user[ 'level'] == "Developers") {
            ?>                 
                <li class="has-submenu">
                    <a href="#"><i class="fa fa-shopping-cart"></i> <span class="nav-label">Data Pembelian</span></a>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo $cfg_baseurl; ?>admin/orders.php">Sosial Media</a></li>
                        <li><a href="<?php echo $cfg_baseurl; ?>admin/orderss.php">Sosial Media S2</a></li>
                       
                        <li><a href="<?php echo $cfg_baseurl; ?>admin/orders_pulsa.php">Pulsa & Voucher</a></li>
                    </ul>
                </li>
                <li class="has-submenu">
                    <a href="#"><i class="fa fa-tags"></i> <span class="nav-label">Data Layanan</span></a>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo $cfg_baseurl; ?>admin/services.php">Sosial Media</a></li>
                        <li><a href="<?php echo $cfg_baseurl; ?>admin/servicess.php">Sosial Media S2</a></li>
                       
                        <li><a href="<?php echo $cfg_baseurl; ?>admin/services_pulsa.php">Pulsa & Voucher</a></li>
                    </ul>
                </li>
                <li>
                    <a href="<?php echo $cfg_baseurl; ?>admin/users.php"><i class="fa fa-users"></i> <span class="nav-label">Data Pengguna</span></a>
                </li>            
		<li> 
		<a href="<?php echo $cfg_baseurl; ?>admin/info.php"><i class="fa fa-envolope"></i> <span
class="nav-label">Kelola Info Sosmed<span></a>
		</li>
                <li>
                    <a href="<?php echo $cfg_baseurl; ?>admin/informations.php"><i class="fa fa-warning"></i> <span class="nav-label">Data Informasi</span></a>
                </li>
                <li>
                    <a href="<?php echo $cfg_baseurl; ?>admin/tickets.php"><i class="fa fa-envelope"></i> <span class="nav-label">Data Tiket</span></a>
                </li>
                <li>
                    <a href="<?php echo $cfg_baseurl; ?>admin/get-code.php"><i class="fa fa-ticket"></i> <span class="nav-label">Data Kode Undangan</span></a>
                </li>
                <li>
                    <a href="<?php echo $cfg_baseurl; ?>admin/transfer_history.php"><i class="fa fa-money"></i> <span class="nav-label">Riwayat Transfer</span></a>
                </li>
                <li>
                    <a href="<?php echo $cfg_baseurl; ?>admin/providers.php"><i class="fa fa-star"></i> <span class="nav-label">kelola Provider</span></a>
                </li>
                <li>
                    <a href="<?php echo $cfg_baseurl; ?>admin/deposits.php"><i class="fa fa-star"></i> <span class="nav-label">kelola Deposit</span></a>
                </li>
                <li>
                    <a href="<?php echo $cfg_baseurl; ?>admin/staff.php"><i class="fa fa-star"></i> <span class="nav-label">kelola Staff</span></a>
                </li>
                <li>
                    <a href="<?php echo $cfg_baseurl; ?>admin/voucher.php"><i class="fa fa-star"></i> <span class="nav-label">kelola Redeem</span></a>
                </li>
                <li>
                    <a href="<?php echo $cfg_baseurl; ?>admin/riwayat_mutasi.php"><i class="fa fa-star"></i> <span class="nav-label">riwayat saldo</span></a>
                </li>
                
            <?php
            }
            ?>      

            <?php
            }
            ?>                                 
   
            </ul>
        </nav>
    </aside>

        <!--Main Content Start -->
        <section class="content">
            
            <!-- Header -->
            <header class="top-head container-fluid">
                <button type="button" class="navbar-toggle pull-left">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
               <!-- Left navbar -->
                <nav class=" navbar-default hidden-xs" role="navigation">
                    <ul class="nav navbar-nav">
                    </ul>
                </nav>
               <!-- Right navbar -->
                <ul class="list-inline navbar-right top-menu top-right-menu"> 
            <?php
            if (isset($_SESSION[ 'user'])) {
            ?>
            <li>
                <a href="<?php echo $cfg_baseurl; ?>"><i class="fa fa-home"></i> <span>Back to home</span></a>
            </li>
        </ul>
    </li>
                    <?php
                    }
                    ?>     
</ul>
                <!-- End right navbar -->
</header>
            <!-- Header Ends -->

            <!-- Page Content Start -->
            <!-- ================== -->

            <div class="wraper container-fluid">
