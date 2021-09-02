<?php
session_start();
require("../mainconfig.php");
$msg_type = "nothing";
function dapetin($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        $data = curl_exec($ch);
        curl_close($ch);
                return json_decode($data, true);
}
	if (isset($_POST['reset'])) {
		$post_username = mysqli_real_escape_string($db, trim($_POST['username']));
		$post_email = mysqli_real_escape_string($db, trim($_POST['email']));		
		$check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$post_username'");

		$secret_key = '6Lc7ynMUAAAAAMTxtQYLNqb3vlFHyEw2l_rYRaCz'; //masukkan secret key-nya berdasarkan secret key masig-masing saat create api key nya
        $captcha=$_POST['g-recaptcha-response'];
        $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secret_key) . '&response=' . $captcha;
        $recaptcha = dapetin($url);
        
	    $data_user = mysqli_fetch_assoc($check_user);
		$check_email = mysqli_query($db, "SELECT * FROM users WHERE email = '$post_email'");
	    $data_email = mysqli_fetch_assoc($check_email);	    
			
		if (empty($post_username) || empty($post_email)) {
			$msg_type = "error";
			$msg_content = "<script>swal('Error!', 'Mohon mengisi input.', 'error');</script><b>Gagal:</b> Mohon mengisi input.";
		} else if (mysqli_num_rows($check_user) == 0) {
			$msg_type = "error";
			$msg_content = "<script>swal('Error!', 'User tidak ditemukan.', 'error');</script><b>Gagal:</b> User tidak ditemukan.";
		} else if (mysqli_num_rows($check_email) == 0) {
			$msg_type = "error";
			$msg_content = "<script>swal('Error!', 'Email tidak ditemukan.', 'error');</script><b>Gagal:</b> Email tidak ditemukan.";			
		} else if (strlen($post_username) > 10) {
			$msg_type = "error";
			$msg_content = "<script>swal('Error!', 'Username Maksimal 10 karakter.', 'error');</script><b>Gagal:</b> Username Maksimal 10 karakter.";
		} else if ($recaptcha['success'] == false) {
            $msg_type = "error";
			$msg_content = "<b>Gagal:</b> Mohon mengisi captcha.";
		} else {
			
			    $to = $data_user['email'];
                $new_password = random(7);
                $msg = "Password akun anda di Batam-Media adalah <b>$new_password.</b>";
                $subject = "Reset Password Batam Media";
                $header = "From:System@batam-media.xyz \r\n";
         $header .= "Cc:system@batam-media.xyz \r\n";
         $header .= "MIME-Version: 1.0\r\n";
         $header .= "Content-type: text/html\r\n";
                $send = mail ($to, $subject, $msg, $header);
                $send = mysqli_query($db, "UPDATE users SET password = '$new_password' WHERE username = '$post_username'");
                if ($send == true) {
					$msg_type = "success";
					$msg_content = "<b>Berhasil:</b> Kata sandi baru telah dikirim.";
                } else {
                    $msg_type = "error";
					$msg_content = "<script>swal('Error!', 'Error system (1).', 'error');</script><b>Gagal:</b> Error system (1).";
                }	
			}
		}
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
                                        if ($msg_type == "success") {
                                        ?>
                                        <div class="alert alert-success">
                                            <?php echo $msg_content; ?>
                                        </div>
                                        <?php
                                        }
                                        ?>
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
											<div class="form-group">
												<label class="col-md-2 control-label">Username</label>
												<div class="col-md-12">
													<input type="text" name="username" class="form-control" placeholder="Username">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Email</label>
												<div class="col-md-12">
													<input type="text" name="email" class="form-control" placeholder="Email">
												</div>
											</div>											
											<div class="form-group">
												<label class="col-md-2 control-label">Captcha</label>
												<div class="col-md-12">
                                               <div class="g-recaptcha" data-sitekey="6Lc7ynMUAAAAAIkAID--gWh7MUaKG9z2rjc7zF9G"></div>
												</div>
											</div>
											<div class="form-group">
												<div class="col-md-offset-2 col-md-10">
													<button type="submit" class="btn btn-info waves-effect w-md waves-light" name="reset">Reset</button>
													<button type="reset" class="btn btn-default waves-effect w-md waves-light">Ulangi</button>

												</div>
											</div>
										</form>
										 <div class="row m-t-50">
                                                    <div class="col-sm-12 text-center">
                                                    <p class="text-muted">Sudah Punya Akun? <a href="<?php echo $cfg_baseurl; ?>account/auth" class="text-dark m-l-5"><b>Login</b></a></p>
                                                </div>
									</div>
									
								</div>
							</div>
						</div>
						<!-- end row -->
						</div></div></div></div></div>

<script src='https://www.google.com/recaptcha/api.js'></script>
						
						
<?php
include("../lib/footer.php");
?>