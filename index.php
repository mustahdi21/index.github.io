<?php
session_start();
require("mainconfig.php");
$msg_type = "nothing";

if (isset($_SESSION['user'])) {
	$sess_username = $_SESSION['user']['username'];
	$check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sess_username'");
	$data_user = mysqli_fetch_assoc($check_user);
	if (mysqli_num_rows($check_user) == 0) {
		header("Location: ".$cfg_baseurl."account/logout");
	} else if ($data_user['status'] == "Suspended") {
		header("Location: ".$cfg_baseurl."account/logout");        
    }
    
	$check_order = mysqli_query($db, "SELECT SUM(price) AS total FROM orders WHERE user = '$sess_username'");
	$data_order = mysqli_fetch_assoc($check_order);
	$check_order33 = mysqli_query($db, "SELECT SUM(price) AS total FROM orders_pulsa WHERE user = '$sess_username'");
	$data_order23 = mysqli_fetch_assoc($check_order33);
	$check_user24 = mysqli_query($db, "SELECT * FROM orders_pulsa WHERE user = '$sess_username'");
	$data_order33 = mysqli_num_rows($check_user24);
	$check_user22 = mysqli_query($db, "SELECT * FROM orders WHERE user = '$sess_username'");
	$data_order22 = mysqli_num_rows($check_user22);    
    $check_orderp = mysqli_query($db, "SELECT SUM(price) AS total FROM orders_pulsa WHERE user = '$sess_username'");
    $data_orderp = mysqli_fetch_assoc($check_orderp);        
    $check_deposit = mysqli_query($db, "SELECT SUM(quantity) AS total FROM deposits WHERE user = '$sess_username' AND status = 'Success'");
    $data_deposit = mysqli_fetch_assoc($check_deposit);
    $check_users = mysqli_query($db, "SELECT * FROM users");
	$count_users = mysqli_num_rows($check_users);
	
	$check_worder = mysqli_query($db, "SELECT SUM(amount) AS total FROM history_topup WHERE username = '$sess_username'");
	$data_worder = mysqli_fetch_assoc($check_worder);
	$check_worder2w2 = mysqli_query($db, "SELECT * FROM history_topup WHERE username = '$sess_username'");
	$data_worder22 = mysqli_num_rows($check_worder2w2);

    $check_order_today = mysqli_query($db, "SELECT * FROM orders WHERE date ='$date' AND user = '$sess_username'");
    $check_orderp_today = mysqli_query($db, "SELECT * FROM orders_pulsa WHERE date ='$date' AND user = '$sess_username'");
    $check_depo_today = mysqli_query($db, "SELECT * FROM deposits WHERE date ='$date' AND user = '$sess_username'");
    $today = date("Y-m-d");
    
    $oneday_ago = date('Y-m-d', strtotime("-1 day"));
    $check_order_oneday_ago = mysqli_query($db, "SELECT * FROM orders WHERE date ='$oneday_ago' AND user = '$sess_username'");
    $check_orderp_oneday_ago = mysqli_query($db, "SELECT * FROM orders_pulsa WHERE date ='$oneday_ago' AND user = '$sess_username'");
    $check_depo_oneday_ago = mysqli_query($db, "SELECT * FROM deposits WHERE date ='$oneday_ago' AND user = '$sess_username'");
    
    $twodays_ago = date('Y-m-d', strtotime("-2 day"));
    $check_order_twodays_ago = mysqli_query($db, "SELECT * FROM orders WHERE date ='$twodays_ago' AND user = '$sess_username'");
    $check_orderp_twodays_ago = mysqli_query($db, "SELECT * FROM orders_pulsa WHERE date ='$twodays_ago' AND user = '$sess_username'");
    $check_depo_twodays_ago = mysqli_query($db, "SELECT * FROM deposits WHERE date ='$twodays_ago' AND user = '$sess_username'");
    
    $threedays_ago = date('Y-m-d', strtotime("-3 day"));
    $check_order_threedays_ago = mysqli_query($db, "SELECT * FROM orders WHERE date ='$threedays_ago' AND user = '$sess_username'");
    $check_orderp_threedays_ago = mysqli_query($db, "SELECT * FROM orders_pulsa WHERE date ='$threedays_ago' AND user = '$sess_username'");
    $check_depo_threedays_ago = mysqli_query($db, "SELECT * FROM deposits WHERE date ='$threedays_ago' AND user = '$sess_username'");
    
    $fourdays_ago = date('Y-m-d', strtotime("-4 day"));
    $check_order_fourdays_ago = mysqli_query($db, "SELECT * FROM orders WHERE date ='$fourdays_ago' AND user = '$sess_username'");
    $check_orderp_fourdays_ago = mysqli_query($db, "SELECT * FROM orders_pulsa WHERE date ='$fourdays_ago' AND user = '$sess_username'");
    $check_depo_fourdays_ago = mysqli_query($db, "SELECT * FROM deposits WHERE date ='$fourdays_ago' AND user = '$sess_username'");
    
    $fivedays_ago = date('Y-m-d', strtotime("-5 day"));
    $check_order_fivedays_ago = mysqli_query($db, "SELECT * FROM orders WHERE date ='$fivedays_ago' AND user = '$sess_username'");
    $check_orderp_fivedays_ago = mysqli_query($db, "SELECT * FROM orders_pulsa WHERE date ='$fivedays_ago' AND user = '$sess_username'");
    $check_depo_fivedays_ago = mysqli_query($db, "SELECT * FROM deposits WHERE date ='$fivedays_ago' AND user = '$sess_username'");
    
    $sixdays_ago = date('Y-m-d', strtotime("-6 day"));
    $check_order_sixdays_ago = mysqli_query($db, "SELECT * FROM orders WHERE date ='$sixdays_ago' AND user = '$sess_username'");
    $check_orderp_sixdays_ago = mysqli_query($db, "SELECT * FROM orders_pulsa WHERE date ='$sixdays_ago' AND user = '$sess_username'");
    $check_depo_sixdays_ago = mysqli_query($db, "SELECT * FROM deposits WHERE date ='$sixdays_ago' AND user = '$sess_username'");
    
    $sevendays_ago = date('Y-m-d', strtotime("-7 day"));
    $check_order_sevendays_ago = mysqli_query($db, "SELECT * FROM orders WHERE date ='$sevendays_ago' AND user = '$sess_username'");    
    $check_orderp_sevendays_ago = mysqli_query($db, "SELECT * FROM orders_pulsa WHERE date ='$sevendays_ago' AND user = '$sess_username'");    
    $check_depo_sevendays_ago = mysqli_query($db, "SELECT * FROM deposits WHERE date ='$sevendays_ago' AND user = '$sess_username'");     
} else {
    $_SESSION['user'] = $data_user;
    header("Location: ".$cfg_baseurl."landing");
    }

include("lib/header.php");
$berita1 = mysqli_query($db, "SELECT * FROM news ORDER BY id DESC LIMIT 1");
$berita2 = mysqli_fetch_array($berita1);
$berita3 = $berita2['content'];
if (isset($_SESSION['user'])) {
?>

<div class="wrapper">
            <div class="container-fluid">
                
        <br><br><br>
        <div class="row">
                    <div class="col-lg-6">
                        <div class="card-box tilebox-one">
                            <i class="mdi mdi-cart float-right"></i>
                            <h6 class="text-muted text-uppercase mb-3">Total Pesanan Sosmed</h6>
                            <h4 class="mb-3" data-plugin="counterup"><?php echo $data_order22; ?></h4>
                            <span> Dengan Total Harga</span> <span class="text-muted ml-2 vertical-middle">Rp <?php echo number_format($data_order['total'],0,',','.'); ?></span>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card-box tilebox-one">
                            <i class="mdi mdi-cart float-right"></i>
                            <h6 class="text-muted text-uppercase mb-3">Total Deposit</h6>
                            <h4 class="mb-3" data-plugin="counterup"><?php echo $data_worder22; ?></h4>
                            <span> Dengan Total Deposit</span> <span class="text-muted ml-2 vertical-middle">Rp <?php echo number_format($data_worder['total'],0,',','.'); ?></span>
                        </div>
                    </div>
        </div>
        
         <!-- START BERITA -->     
        <div class="col-lg-12">
<div class="card m-b-30">
<h6 class="card-header"><i class="mdi mdi-newspaper"></i> Berita & Informasi</h6>
<div class="card-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-box">
<thead>
<tr>
<th style="width: 200px;">Tanggal & Waktu</th>
<th style="width: 150px;">Kategori</th>
<th>Konten</th>
</tr>
</thead>
<tbody>
     <?php
                                                    $check_news = mysqli_query($db, "SELECT * FROM news ORDER BY id DESC LIMIT 5");
                                                    $no = 1;
                                                    while ($data_news = mysqli_fetch_assoc($check_news)) {
                                                    if($data_news['section'] == "Informasi") {
                                                        $label = "primary";
                                                    } else if($data_news['section'] == "Update") {
                                                        $label = "info";
                                                    } else if($data_news['section'] == "Penting") {
                                                        $label = "danger";
                                                    } else if($data_news['section'] == "Event") {
                                                        $label = "success";
                                                    } else if($data_news['section'] == "Maintence") {
                                                        $label = "danger";
                                                    }
                                                    ?>
                                                    <tr>
                                                    <td><?php echo $data_news['date']; ?></td>                                                  
                                                    <td align="center"><label class="badge badge-<?php echo $label; ?>"><?php echo $data_news['section']; ?></label></td>
                                                    <td><?php echo $data_news['content']; ?></td>
                                                    </tr>
                                                    <?php
                                                    $no++;
                                                    }
                                                    ?>
</tbody>
</table>
</div>
</div>
</div>
</div>
     <!-- START HISTORY AKTIFITAS -->     
     <div class="row">
                      <div class="col-lg-6">
<div class="card m-b-30">
<h6 class="card-header"><i class="mdi mdi-newspaper"></i> History Aktifitas</h6>
<div class="card-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-box">
<thead>
<tr>
<th>#</th>
<th style="width: 500px;">Aktifitas</th>
<th style="width: 250px;">Waktu</th>
</tr>
</thead>
<tbody>
													<?php
													$check_user = mysqli_query($db, "SELECT * FROM ripalloglogin WHERE username = '$sess_username' ORDER BY id DESC LIMIT 6");
													$no = 1;
													while ($data_user = mysqli_fetch_assoc($check_user)) {
													?>
													<tr>
														<th scope="row"><?php echo $no; ?></th>
														<td>Berhasil <?php echo $data_user['aktifitas']; ?> Dengan Ip <?php echo $data_user['ip']; ?></td>
														<td><?php echo $data_user['tanggal']; ?> - <?php echo $data_user['jam']; ?></td>
													</tr>
													<?php
													$no++;
													}
													?>
											
										</tbody>
                                    </table>
                            <center><a href="HA">See All History</a></center>
</div>
</div>
</div>
</div>
          <!-- END HISTORY AKTIFITAS -->     
          <!-- START HISTORY SALDO -->     
                      <div class="col-lg-6">
<div class="card m-b-30">
<h6 class="card-header"><i class="mdi mdi-newspaper"></i> History Saldo</h6>
<div class="card-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-box">
<thead>
<tr>
<th>#</th>
<th style="width: 500px;">Aktifitas</th>
<th style="width: 250px;">Waktu</th>
</tr>
</thead>
<tbody>
														<?php
													$check_user = mysqli_query($db, "SELECT * FROM balance_history WHERE username = '$sess_username' ORDER BY id DESC LIMIT 4");
													$no = 1;
													while ($data_user = mysqli_fetch_assoc($check_user)) {
													?>
													<tr>
														<th scope="row"><?php echo $no; ?></th>
														<td>Melakukan <?php echo $data_user['msg']; ?> </td>
														<td><?php echo $data_user['date']; ?> - <?php echo $data_user['time']; ?></td>
													</tr>
													<?php
													$no++;
													}
													?>
											
										</tbody>
                                    </table>
                            <center><a href="HS">See All History</a></center>
</div>
</div>
</div>
</div>
</div>
          <!-- END HISTORY SALDO -->           
                        </div></div>

<?php
}
include("lib/footer.php");
?>
<?php
$check_info = mysqli_query($db, "SELECT * FROM news");
		$data_info = mysqli_fetch_assoc($check_info); 
		?>
<script> swal("INFORMASI SERVER [<?php echo $date ?>]", "<?php echo $data_info['content'] ?>") 
</script>

<!-- WhatsHelp.io widget -->
<script type="text/javascript">
    (function () {
        var options = {
            whatsapp: "6282285300849", // WhatsApp number
            sms: "6282285300849", // Sms phone number
            line: "//line.me/ti/p/@putraa", // Line QR code URL
            call: "6282285300849", // Call phone number
            snapchat: "@Putraautama", // Snapchat username
            telegram: "putraautama", // Telegram bot username
            call_to_action: "Silahkan Hubungi Kami!", // Call to action
            button_color: "#129BF4", // Color of button
            position: "left", // Position may be 'right' or 'left'
            order: "whatsapp,sms,line,call,snapchat,telegram", // Order of buttons
        };
        var proto = document.location.protocol, host = "whatshelp.io", url = proto + "//static." + host;
        var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = url + '/widget-send-button/js/init.js';
        s.onload = function () { WhWidgetSendButton.init(host, proto, options); };
        var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);
    })();
</script>
<!-- /WhatsHelp.io widget -->
</body>
</html>