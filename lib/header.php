<!DOCTYPE html>
<html lang="en">
<!--
//#################################################
//# Created : Muhammad Ripal Nugraha - Se7Code
//# Rilis   : 10 - 10 - 2018
//# ©        HARAP TIDAK MERUBAH         ©
//# ©        HARAP HARGAI SAYA :)        ©
//# -        UU Nomor 28 Tahun 2014      -
//#################################################
-->    
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?php echo $cfg_desc; ?>">
        <meta name="author" content="<?php echo $cfg_author; ?>">
        <meta name="keywords" content="<?php echo $cfg_webname; ?>, Free Followers, SMM Cheap, Se7Code SMM, SMM Panel, SMM Murah, API Integration, Cheap SMM Panel, Admin panel instagram, admin panel twitter, autofollowers instagram, jasa tambah followers instagram murah, jasa tambah followers, Cara menambah followers instagram, Panel SMM, Track Your Activity, Instagram Followers, Free Followers, Free Retweets, Costumer Service, Free Subcribe, Free Views, Beli Followers Instagram, Beli Followers, Social Media, Reseller, Smm, Panel, SMM, Fans, Instagram, Facebook, Youtube, Cheap, Reseller, Panel, Top, 10, Social, Rankings, Working, Fast, Cheap, Free, Safe, Automatic, Instant, Not, Manual, perfect, followersindo, followers gratis, followers ig, followers boom, followers instagram terbanyak, followers instagram bot, followers tk, followers jackpot, instagram followers, followers for instagram, free instagram followers, buy instagram followers, how to get more followers on instagram, get followers on instagram, Mahirdepay, Hirpayzcode">
        <meta name="author" content="RipalNugraha>">
        <meta content="1 days" name="revisit-after"/>
        <meta content="id" name="language"/>
        <meta content="id" name="id.ID"/>
        <meta content="Indonesia" name="geo.placename"/>
        <meta content="all-language" http-equiv="Content-Language"/>
        <meta content="global" name="Distribution"/>
        <meta content="global" name="target"/>
        <meta content="Indonesia" name="geo.country"/>
        <meta content="all" name="robots"/>
        <meta content="all" name="googlebot"/>
        <meta content="all" name="msnbot"/>
        <meta content="all" name="Googlebot-Image"/>
        <meta content="all" name="Slurp"/>
        <meta content="all" name="ZyBorg"/>
        <meta content="all" name="Scooter"/>
        <meta content="ALL" name="spiders"/>
        <meta content="all" name="audience"/>
        <link rel="shortcut icon" href="<?php echo $cfg_baseurl; ?>speaker.png">
    
        <title><?php echo $cfg_webname; ?></title>

        <!-- Google-Fonts -->
        <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:100,300,400,600,700,900,400italic' rel='stylesheet'>

        <!-- Bootstrap core CSS -->
        <!-- App css -->
        <link href="<?php echo $cfg_baseurl; ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $cfg_baseurl; ?>assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $cfg_baseurl; ?>assets/css/style.css" rel="stylesheet" type="text/css" />

        <script src="<?php echo $cfg_baseurl; ?>assets/js/modernizr.min.js"></script>
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

    <body>

        <!-- Navigation Bar-->
        <header id="topnav">
            <div class="topbar-main">
                <div class="container-fluid">

                    <!-- Logo container-->
                <div class="logo">
                <a href="<?php echo $cfg_baseurl; ?>" class="logo">
                <span class="logo-small"><i class="mdi mdi-cart"></i></span>
                <span class="logo-large"><i class="mdi mdi-cart"></i> <?php echo $cfg_logo_txt; ?></span>
                </a>
                    </div>
                    <!-- End Logo container-->
                      <div class="menu-extras topbar-custom">

                        <ul class="list-unstyled topbar-right-menu float-right mb-0">
            
                            <li class="menu-item">
                                <!-- Mobile menu toggle-->
                                <a class="navbar-toggle nav-link">
                                    <div class="lines">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </a>
                                <!-- End mobile menu toggle-->
                            </li>
            <?php
            if (isset($_SESSION[ 'user'])) {
            ?>
            <li class="menu-item">
                <a href="<?php echo $cfg_baseurl; ?>deposits" class="nav-link nav-user text-uppercase text-white">Saldo: Rp <?php echo number_format($data_user['balance'],0,',','.'); ?></a>
            </li>
                    <li class="dropdown notification-list">
                                <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button"
                                   aria-haspopup="false" aria-expanded="false">
                                    <img src="https://pictr.com/images/2018/10/27/0GIjN2.png" alt="user" class="rounded-circle"> <span class="ml-1 pro-user-name"><?php echo $sess_username; ?> <i class="mdi mdi-chevron-down"></i> </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                    <!-- item-->
                                    <div class="dropdown-item noti-title">
                                        <h6 class="text-overflow m-0">Welcome !</h6>
                                    </div>

                                    <!-- item-->
                                    <a href="<?php echo $cfg_baseurl; ?>account/profile" class="dropdown-item notify-item">
                                        <i class="fi-cog"></i> <span>Settings</span>
                                    </a>
                                    <!-- item-->
                                    <a href="<?php echo $cfg_baseurl; ?>account/logout" class="dropdown-item notify-item">
                                        <i class="fi-power"></i> <span>Logout</span>
                                    </a>

                                </div>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <!-- end menu-extras -->

                    <div class="clearfix"></div>

                </div> <!-- end container -->
            </div>
            <!-- / brand -->
            
  <div class="navbar-custom">
                <div class="container-fluid">
                    <div id="navigation">
                        <!-- Navigation Menu-->
                        <ul class="navigation-menu">

                             <li class="has-submenu">
<a href="<?php echo $cfg_baseurl; ?>"><i class="fa fa-home"></i> <span class="nav-label">Halaman Utama</span></a>
              </li>
              <li class="has-submenu">
<a href="<?php echo $cfg_baseurl; ?>/staff/hof"><i class="fa fa-trophy"></i> <span class="nav-label">TOP 5</span></a>              </li>
<?php
            if (isset($_SESSION[ 'user'])) {
            ?>
            <?php
            if ($data_user[ 'level'] != "Member" ) {
            ?>
                            <li class="has-submenu">
                                <a href="#"><i class="fi-briefcase"></i>Tambahan</a>
                                <ul class="submenu">
                                    <li><a href="<?php echo $cfg_baseurl; ?>staff/add_member">Tambah Member</a></li>
                        <li><a href="<?php echo $cfg_baseurl; ?>staff/add_agen">Tambah Agen</a></li>
                        <li><a href="<?php echo $cfg_baseurl; ?>staff/add_reseller">Tambah Reseller</a></li>
                        <li><a href="<?php echo $cfg_baseurl; ?>staff/transfer_balance">Transfer Saldo</a></li>
                                </ul>
                            </li>

<?php 
            }
            ?>
        
         <?php
            if ($data_user[ 'level'] == "Developers") {
            ?>   
       <li class="has-submenu">
                                <a href="#"><i class="fi-briefcase"></i>Developer</a>
                                <ul class="submenu">
                                            <li><a href="<?php echo $cfg_baseurl; ?>admin/users">Kelola Pengguna</a></li>
                        <li><a href="<?php echo $cfg_baseurl; ?>admin/services">Kelola Layanan Sosmed</a></li>
                        <li><a href="<?php echo $cfg_baseurl; ?>admin/services_pulsa">Kelola Layanan Pulsa</a></li>
                        <li><a href="<?php echo $cfg_baseurl; ?>admin/orders">Kelola Pesanan Sosmed</a></li>
                        <li><a href="<?php echo $cfg_baseurl; ?>admin/orders_pulsa">Kelola Pesanan Pulsa</a></li>
                        <li><a href="<?php echo $cfg_baseurl; ?>admin/informations">Kelola Berita</a></li>
                        <li><a href="<?php echo $cfg_baseurl; ?>admin/transfer_history">Riwayat Transfer</a></li>
                        <li><a href="<?php echo $cfg_baseurl; ?>admin/deporiwayatall">Riwayat Deposit</a></li>
                                        </ul>
                            </li>
                                    <?php
            }
            ?>


              <li class="has-submenu">
                                <a href="#"><i class="mdi mdi-cart"></i>Social Media</a>
                                <ul class="submenu megamenu">
                                    <li>
                                        <ul>
                        <li><a href="<?php echo $cfg_baseurl; ?>order/single">Pembelian Baru</a></li>
                        <li><a href="<?php echo $cfg_baseurl; ?>order/history">Riwayat Pembelian</a></li>
                    </ul>
                                    </li>
                    </ul>
                </li>
                
                <li class="has-submenu">
                                        <a href="#"><i class="mdi mdi-cart"></i>Pulsa</a>
                                        <ul class="submenu">
                        <li><a href="<?php echo $cfg_baseurl; ?>order/pulsa">Pembelian Baru</a></li>
                        <li><a href="<?php echo $cfg_baseurl; ?>order/order_dm">Pembelian Diamond ML</a></li>
                        <li><a href="<?php echo $cfg_baseurl; ?>order/history_pulsa">Riwayat Pembelian</a></li>
                    
                    </ul>
                </li>
                <li class="has-submenu">
                                        <a href="#"><i class="mdi mdi-bank"></i>Deposit</a>
                                        <ul class="submenu">
                                     
                        <li><a href="<?php echo $cfg_baseurl; ?>deposits/pulsa">Deposit Otomatis</a></li>
                        <li><a href="<?php echo $cfg_baseurl; ?>deposits/riwayat">Riwayat Deposit</a></li>
                    
                    </ul>
                    
                </li> 
                
            <?php
            } else {
            ?>    
                <li>
                    <a href="<?php echo $cfg_baseurl; ?>account/auth"><i class="fa fa-sign-in"></i> <span class="nav-label">Masuk</span></a>
                </li>
                <li>
                    <a href="<?php echo $cfg_baseurl; ?>account/forgot"><i class="fa fa-sign-in"></i> <span class="nav-label">Forgot Password</span></a>
                </li>
            <?php
            }
            ?>                 
                <li>
                    <a href="<?php echo $cfg_baseurl; ?>api_doc"><i class="mdi mdi-book"></i> <span class="nav-label">API</span></a>
                </li>
                 <li class="has-submenu">
                                        <a href="#"><i class="mdi mdi-sitemap"></i>Halaman</a>
                                        <ul class="submenu">
                                            <li><a href="<?php echo $cfg_baseurl; ?>price_list">Sosial Media</a></a></li>
                        <li><a href="<?php echo $cfg_baseurl; ?>price_list_pulsa">Pulsa</a></a></li>
                        <li><a href="<?php echo $cfg_baseurl; ?>contact">Kontak Admin</a></li>
                        <li><a href="<?php echo $cfg_baseurl; ?>faq">Pertanyaan Umum</a></li>
                        <li><a href="<?php echo $cfg_baseurl; ?>terms">Ketentuan Layanan</a></li>terms
                    </ul>
                </li>
            </ul>
        <!-- End navigation menu -->
                    </div> <!-- end #navigation -->
                </div> <!-- end container -->
            </div> <!-- end navbar-custom -->
        </header>
        <!-- End Navigation Bar-->
