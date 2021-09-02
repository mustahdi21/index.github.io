<?php
session_start();
require("../mainconfig.php");

if (isset($_SESSION['user'])) {
	$sess_username = $_SESSION['user']['username'];
	$check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sess_username'");
	$data_user = mysqli_fetch_assoc($check_user);
	if (mysqli_num_rows($check_user) == 0) {
		header("Location: ".$cfg_baseurl."logout.php");
	} else if ($data_user['status'] == "Suspended") {
		header("Location: ".$cfg_baseurl."logout.php");
	}

	include("../lib/header.php");
	$msg_type = "nothing";
if (isset($_POST['submit'])) {
		$post_method = mysqli_real_escape_string($db,$_POST['method']);
		$post_quantity = (int)mysqli_real_escape_string($db,$_POST['quantity']);
		$no_kode= mysqli_real_escape_string($db,$_POST['kode']);
		$nohp=$no_pengirim;

    		if($post_method == "BANK BCA") {
			    $operator = "Deposito saldo via BANK BCA";
			    $quantity = $post_quantity;
			    $provider = "BANK BCA";
			    $tujuan="2831506271 [DHIFO AKSA HERMAWAN]";
			    $balance_amount = $post_quantity + rand(1,999);
    		} else {
			die("Incorrect input!");
		
		}
         $check_data_history = mysqli_query($db, "SELECT * FROM deposits WHERE  quantity ='$post_quantity' AND AND date = '$date'");
		if ($post_quantity < 1000) {
			$msg_type = "error";
			$msg_content = "×</span></button><b>Failed:</b> Minimum deposit is 5000";
		} else if($data_user['nohp'] == FALSE) {
			$msg_type = "error";
			$msg_content = "×</span></button><b>Failed:</b> harap Melengkapi Biodata anda Terlebih dahulu .";
		} else {
		    $kode=random_number(6);
		    $expired_deposit = date('Y-m-d', strtotime("+2 day"));
			$insert_topup = mysqli_query($db, "INSERT INTO deposits VALUES ('','$kode','$sess_username','$post_method','$tujuan','','$balance_amount','$balance_amount','Pending','$date','$time','$expired_deposit')");
			if ($insert_topup == TRUE) {
				$msg_type = "success";
				$msg_content = "×</span></button><b>Permintaan deposito saldo diterima.</b><br /><b>Oprator:</b> $operator<br /><b>Tujuan:</b> $tujuan<br /><b>Jumlah:</b> ".number_format($balance_amount,0,',','.')."<br /><b>Tanggal:</b> $date<br /><b>Saldo Yang Didapat :</b> $balance_amount";
				$msg_depo = "×</span></button>Silakan transfer Bank sebesar <span style='color: red'><b>Rp. ".number_format($balance_amount,0,',','.')."</b></span> ke Tujuan ".$tujuan." <br /><span style='color: red'>Jika jumlah transfer tidak sesuai maka sistem tidak akan memproses permintaan deposit Anda.</span><br>
		<hr>
Jika SUdah Melakukan Transfer Saldo Silahkan Klik Tombol Konfirmasi Di Bawah Ini<br>
<form action='' method='POST'>
                                       <input type='hidden' name='code' value='".$kode."'>
                                      <center><button type='submit' class='btn btn-success btn-xs'name='konfirmasi'><strong><span class='fa fa-money'></span> Konfirmasi Deposit</strong></button></center></form>";
			} else {
				$msg_type = "error";
				$msg_content = "×</span></button><b>Failed:</b> System error.";
			}
		}
	}
	if(isset($_POST['konfirmasi'])) {
	    $kode_tf=mysqli_real_escape_string($db,$_POST['code']);
	    require("server/function_bca.php");
	    if(empty($kode_tf)){
	        $msg_type = "error";
			$msg_content = "×</span></button><b>Failed:</b> Invalid Post";
	    }else{
$methode = "BANK BCA";

$get = mysqli_query($db, "SELECT * FROM deposits WHERE status = 'Pending' AND method = '$methode' AND code='$kode_tf'");
if(mysqli_num_rows($get) == 0) {
	$msg_type = "error";
			$msg_content = "×</span></button><b>Failed:</b> Data Transfer Tidak Ditemukan";
			
} else {
    while($data_deposito = mysqli_fetch_assoc($get)) {
        $invoice = $data_deposito['code'];
        $user = $data_deposito['user'];
        $jumlah = $data_deposito['balance'];
        $balance = $data_deposito['balance'];
        
        $check = check_bca($jumlah);
        
        if($check == "sukses") {
            
    $saldoskr=$balance+$data_user['balance'];
            $pesannya="Atlantic-Pedia:thank you for adding balance of ".number_format($balance,0,',','.')." Rupiah your balance now Rp ".number_format($saldoskr,0,',','.')." Rupiah";
$nomerhp=$data_user['nohp'];
$postdata = "api_key=fGuHn-ZCESX-GMXia-yz8zZ&pesan=$pesannya&nomer=$nomerhp";
$apibase= "https://serverh2h.web.id/sms_gateway";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apibase);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$chresult = curl_exec($ch);
curl_close($ch);
$json_result = json_decode($chresult, true);
            $update_user = mysqli_query($db, "INSERT INTO balance_history (username, action, quantity, catatan, date, time) VALUES ('$user', 'add balance', '$balance', 'Add Balance. Via Auto Deposit BCA', '$date', '$time')");
			                
            $update = mysqli_query($db, "UPDATE deposits set status = 'Success' WHERE code = '$invoice'");
            $update = mysqli_query($db, "UPDATE users set balance = balance+$balance WHERE username = '$user'");
            if($update) {
             	$msg_type = "success";
			$msg_content = "×</span></button><b>Sukses:</b> Saldo Telah Berhasi Di Tambahkan";
            } else {
                	$msg_type = "error";
			$msg_content = "×</span></button><b>Failed:</b> System Error";
		}
        } else {
           	$msg_type = "error";
			$msg_content = "×</span></button><b>Failed:</b> Dana Belum Di Terima!";
		
      }
   }
}
    }
	}else if(isset($_POST['delet'])) {
	    $post_code = mysqli_real_escape_string($db,$_POST['kode']);
	    
	    $select = mysqli_query($db, "SELECT * FROM deposits WHERE code = '$post_code'");
	    $datana = mysqli_fetch_assoc($select);
	    
	    if(mysqli_num_rows($select) == 0) {
	        $msg_type = "error";
	        $msg_content = "×</span></button><b>Gagal:</b> Data tidak di temukan. ";
	    } else if($datana['status'] == "Success") {
             $msg_type = "error";
	        $msg_content = "×</span></button><b>Gagal:</b> Data tidak bisa di batalkan.  ";	 
	    } else {
	        $update = mysqli_query($db, "UPDATE deposits set status = 'error' WHERE code = '$post_code'");
	        if($update == TRUE) {
	            $msg_type = "success";
	            $msg_content = "×</span></button> Berhasil membatalkan!";
	        } else {
	            $msg_type = "error";
	            $msg_content = "×</span></button>GAGAL MEMBATALKAN #1";
	        }
	    }
	}
?>
						<div class="page-header">
			  <h2>Permintaan Deposit</h2>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo $cfg_baseurl; ?>"><?php echo $cfg_webname; ?></a></li>
					<li class="breadcrumb-item active">Permintaan Deposit</li>
				</ol>
			</div>
						<div class="row">
							<div class="col-md-offset-2 col-md-8">
								<div class="card">
                        <div class="card-heading  card-primary">
                           Permintaan Deposit
                        </div>
                        <div class="card-block">
										<?php 
										if ($msg_type == "success") {
										?>
										<div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><?php echo $msg_content; ?></div>
										<?php if ($msg_depo == TRUE){ ?>
										<div class="alert alert-info alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><?php echo $msg_depo; ?></div>
										<?php } if ($msg_warning == TRUE){?>
										<div class="alert alert-warning alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><?php echo $msg_warning; ?></div>
										
										<?php
										}
										} else if ($msg_type == "error") {
										?>
										<div class="alert alert-danger alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><?php echo $msg_content; ?></div>
										<?php if ($msg_depo == TRUE){ ?>
										<div class="alert alert-info alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><?php echo $msg_depo; ?></div>
										
										<?php
										}
										}
										?>
										<form class="form-horizontal" role="form" method="POST">
											<div class="form-group">
												<label >Metode</label>
												
													<select class="form-control" name="method" id="depomethod">
														<option value="0">Pilih salah satu...</option>
														<option value="BANK BCA">BANK BCA </option>
													</select>
												
											</div>
										
											<input type="hidden" name="kode" value="<?php echo random_number(7); ?>">
											<div class="form-group">
												<label>Jumlah Deposit</label>
											
													<input type="number" name="quantity" class="form-control" placeholder="Jumlah" onkeyup="get_total(this.value).value;">
											
											</div>
											<input type="hidden" id="rate" value="0">
										
											<button type="submit" class="pull-right btn btn-success btn-bordered waves-effect w-md waves-light" name="submit">Buat Permintaan</button>
										</form>
									
									</div>
								</div>
							</div>
								<div class="col-md-12">
								<div class="card">
                        <div class="card-heading  card-primary">
                          Riwayat Deposit
                        </div>
                        <div class="card-block">
										<div class="table-responsive">
											<table class="table table-striped table-bordered table-hover m-0">
												<thead>
													<tr>
														<th>Tanggal</th>
														<th>Time</th>
														<th>Provider</th>
														<th>Jumlah</th>
														<th>Status</th>
														<th>Expired</th>
															<th>Action</th>
													</tr>
												</thead>
												<tbody>
												<?php
// start paging config
$query_order = "SELECT * FROM deposits WHERE user = '$sess_username' ORDER BY id DESC"; // edit
$records_per_page = 30; // edit

$starting_position = 0;
if(isset($_GET["page_no"])) {
	$starting_position = ($_GET["page_no"]-1) * $records_per_page;
}
$new_query = $query_order." LIMIT $starting_position, $records_per_page";
$new_query = mysqli_query($db, $new_query);
// end paging config
												while ($data_order = mysqli_fetch_assoc($new_query)) {
													if($data_order['status'] == "Pending") {
													    $statusnya="Waiting";
														$label = "warning";
													} else if($data_order['status'] == "Error") {
													    $statusnya="Canceled";
														$label = "danger";
													} else if($data_order['status'] == "Success") {
													    $statusnya="Success";
														$label = "success";
													}
													$no_pengirimnya=$data_order['no_pengirim'];
													$no_pengrim_asli=str_replace('62','0',$no_pengirimnya);
												?>
													<tr>
														<th><?php echo $data_order['date']; ?></th>
														<th><?php echo $data_order['time']; ?></th>
														<td><?php echo $data_order['method']; ?></td>
														<td>Rp <?php echo number_format($data_order['balance'],0,',','.'); ?></td>
														<td><label class="label label-<?php echo $label; ?>"><?php echo $statusnya; ?></label></td>
														<td><?php echo $data_order['expired']; ?></td>
														<?php if($data_order['status'] == "Pending") { ?>
														<td> <form action="" method="POST">
                                       <input type="hidden" name="code" value="<?php echo $data_order['code']; ?>">
                                      <button type="submit" class="btn btn-success btn-xs"name="konfirmasi"><strong><span class="fa fa-money"></span> Konfirmasi Deposit</strong></button></form>
                                       <form action="" method="POST">
                                       <input type="hidden" name="kode" value="<?php echo $data_order['code']; ?>">
                                      <button type="submit" class="btn btn-danger btn-xs"name="delet"><strong><span class="fa fa-remove"></span> Batalkan Deposit</strong></button></form>
                                                                                        </td> <?php } else { ?>
                                                    	<td><span class="label label-success"><strong>Not Action</strong></span> </td>		
                                                    	<?php } ?>			
													</tr>
													<?php
												}
												?>
												</tbody>
											</table>
									
										<ul class="pagination">
<?php
// start paging link
$self = $_SERVER['PHP_SELF'];
$query_order = mysqli_query($db, $query_order);
$total_no_of_records = mysqli_num_rows($query_order);
echo "<li class='page-item disabled'><a class='page-link' href='#'>Total: ".$total_no_of_records."</a></li>";
if($total_no_of_records > 0) {
	$total_no_of_pages = ceil($total_no_of_records/$records_per_page);
	$current_page = 1;
	if(isset($_GET["page_no"])) {
		$current_page = $_GET["page_no"];
	}
	if($current_page != 1) {
		$previous = $current_page-1;
		echo "<li class='page-item'><a class='page-link' href='".$self."?page_no=1'>← First</a></li>";
		echo "<li class='page-item'><a class='page-link' href='".$self."?page_no=".$previous."'>Previous</a></li>";
	}
	for($i=1; $i<=$total_no_of_pages; $i++) {
		if($i==$current_page) {
			echo "<li class='page-item active'><a class='page-link' href='".$self."?page_no=".$i."'>".$i." <span class='sr-only'>(current)</span></a></li>";
			} else {
			echo "<li class='page-item'><a class='page-link' href='".$self."?page_no=".$i."'>".$i."</a></li>";
		}
		}
	if($current_page!=$total_no_of_pages) {
		$next = $current_page+1;
		echo "<li class='page-item'><a class='page-link' href='".$self."?page_no=".$next."'>Next</a></li>";
		echo "<li class='page-item'><a class='page-link' href='".$self."?page_no=".$total_no_of_pages."'>Last →</a></li>";
			}
}
// end paging link
											?>
										</ul>
									</div>
								</div>
							</div>
						</div>
						</div>
						<!-- end row -->
<?php
	include("../lib/footer.php");
} else {
	header("Location: ".$cfg_baseurl);
}
?>