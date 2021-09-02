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

	
	$check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sess_username'");
	$data_user = mysqli_fetch_assoc($check_user);
	
	$check_depo = mysqli_query($db, "SELECT * FROM topup WHERE user = '$sess_username' AND status = 'Pending'");
		if (isset($_POST['submit'])) {
		$post_method = $_POST['method'];
		$post_quantity = (int)$_POST['quantity'];
		$no_pengirim = $_POST['nopengirim'];
		$nohp=$no_pengirim;
if(!preg_match('/[^+0-9]/',trim($nohp))){
         // cek apakah no hp karakter 1-3 adalah +62
         if(substr(trim($nohp), 0, 3)=='62'){
             $no_pengirim_pulsa = trim($nohp);
         }
         // cek apakah no hp karakter 1 adalah 0
         elseif(substr(trim($nohp), 0, 1)=='0'){
             $no_pengirim_pulsa = '62'.substr(trim($nohp), 1);
         }
     }
    		if($post_method == "081267932874") { ///MASUKIN NOMOR LO
			    $operator = "Deposito saldo via Pulsa TSEL";
			    $quantity = $post_quantity;
			    $provider = "TSEL";
			    $balance_amount = $post_quantity * 0.88;
		} else {
			die("Incorrect input!");
			
		}
         $check_data_history = mysqli_query($db, "SELECT * FROM history_topup WHERE jumlah_transfer = '$quantity' AND no_pengirim = '$no_pengirim_pulsa' AND date = '$date'");
		if ($post_quantity < 1000) {
			$msg_type = "error";
			$msg_content = "<b>Failed:</b> Minimum deposit is 5000";
		} else if(mysqli_num_rows($check_data_history) > 0) {
			$msg_type = "error";
			$msg_content = "<b>Failed:</b> Deposit lewat Transfer Pulsa lebih dari 1x dalam 1 hari dari nomor yang sama harap mentransfer dengan jumlah berbeda dari sebelumnya.";
		} else {
			$insert_topup = mysqli_query($db, "INSERT INTO history_topup VALUES ('$id','$provider','$balance_amount','$quantity','$sess_username','$no_pengirim_pulsa','$date','$time','NO','WEB')");
			if ($insert_topup == TRUE) {
				$msg_type = "success";
				$msg_content = "<b>Permintaan deposito saldo diterima.</b><br /><b>Oprator:</b> $operator<br /><b>Tujuan:</b> $post_method<br /><b>Jumlah:</b> ".number_format($quantity,0,',','.')."<br /><b>Tanggal & Waktu:</b> $date $time<br /><b>Saldo Yang Didapat :</b> $balance_amount";
				$msg_depo = "Silakan transfer Pulsa sebesar <span style='color: red'><b>Rp. ".number_format($quantity,0,',','.')."</b></span> ke Nomor ".$post_method." <br /><span style='color: red'>Jika jumlah transfer tidak sesuai maka sistem tidak akan memproses permintaan deposit Anda.</span><br>
				<span style='color: red'>ANDA DI KASIH WAKTU 10 MENIT UNTUK TRANSFER PULSA </span><hr>
Jika sudah transfer silahkan menunggu 10-30 menit, maka saldo Anda akan otomatis terisi.<br>
Jika saldo tidak masuk, berarti Anda mengirim nominal tidak sesuai dengan yang di perintahkan diatas.";
			} else {
				$msg_type = "error";
				$msg_content = "<b>Failed:</b> System error.";
			}
		}
	}
	$check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sess_username'");
	$data_user = mysqli_fetch_assoc($check_user);
	
	if(isset($_POST['code'])) {
	    $post_code = $_POST['code'];
	    
	    $select = mysqli_query($db, "SELECT * FROM deposits_history WHERE code = '$post_code'");
	    $datana = mysqli_fetch_assoc($select);
	    
	    if(mysqli_num_rows($select) == 0) {
	        $msg_type = "error";
	        $msg_content = "<b>Gagal:</b> Data tidak di temukan.";
	    } else if($datana['status'] !== "Pending" AND $datana['status'] !== "Processing") {
             $msg_type = "error";
	        $msg_content = "<b>Gagal:</b> Data tidak bisa di batalkan.";	 
	    } else {
	        $update = mysqli_query($db, "UPDATE deposits_history set status = 'Error' WHERE code = '$post_code'");
	        if($update == TRUE) {
	            $msg_type = "success";
	            $msg_content = "Berhasil membatalkan!";
	        } else {
	            $msg_type = "error";
	            $msg_content = "GAGAL MEMBATALKAN #1";
	        }
	    }
	}
	

 ?>
 <div class="wrapper">
<div class="container-fluid" style="padding: 50px 20px;">
<div class="row">
<div class="col-lg-12">
</div>
</div>
<div class="row">
                                             <div class="col-md-12">
								<div class="card m-b-30">
<h6 class="card-header"><i class="mdi mdi-cart"></i> Deposit</h6>
<div class="card-body">

 	                                    <?php 
										if ($msg_type == "success") {
										?>
										<div class="alert alert-success" role="alert">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
											<i class="fa fa-check-circle"></i>
											<?php echo $msg_content; ?>
										</div>
										<div class="alert alert-info" role="alert" style="color: #000;">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
											<i class="fa fa-info-circle"></i>
											<?php echo $msg_depo; ?>
										</div>
										<?php
										} else if ($msg_type == "error") {
										?>
										<div class="alert alert-danger" role="alert">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
											<i class="fa fa-times-circle"></i>
											<?php echo $msg_content; ?>
										</div>
										<?php
										}
										?>
                        <div class="row">
							<div class="col-md-6">
                            <div class="panel panel-default">
									<div class="panel-heading">
                                    <h5><i class="fa fa-credit-card"></i> Deposit Otomatis</h5>
                                </div>
                                    <div class="ibox-content">
										<form class="form-horizontal" role="form" method="POST">
											<div class="form-group">
												<label class="col-md-2 control-label">Metode</label>
												<div class="col-md-10">
													<select class="form-control" name="method" id="method">
														<option value="0">Pilih salah satu...</option>
															<option value="081267932874">Telkomsel #1</option> <!-- ///MASUKIN NOMOR LO -->
																														
													</select>
												</div>
											</div>
                                      	<div class="form-group">
												<label class="col-md-2 control-label">Pengirim</label>
												<div class="col-md-10">
													<input type="text" name="nopengirim" class="form-control" placeholder="Nomor HP PENGIRIM">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Nominal Pulsa</label>
												<div class="col-md-10">
												    <div class="input-group">
                                                     <input type="number" name="quantity" id="quantity" class="form-control" placeholder="Jumlah" onkeyup="get_total(this.value).value;">
                                                           <span class="input-group-btn">
                                                    <button type="button" class="btn btn-info btn-flat"><B>X 0.88</B></button>
                                                    </div>
												</div>
											</div>
											<input type="hidden" id="rate" value="0">
											<div class="form-group">
												<label class="col-md-2 control-label">Get Balance</label>
												<div class="col-md-10">
												  <div class="input-group"><span class="input-group-addon">Rp.</span> 
                                                    <input type="number" class="form-control" id="total" value="0" disabled>
                                                  </div>
                			                    </div>
                			                </div>
                			                <button type="submit" class="pull-right btn btn-success btn-bordered waves-effect w-md waves-light" name="submit">Buat Permintaan Deposit</button>
										</form>
                                        <div class="clearfix"></div>
									</div>
              </div>
              </div>
              <!-- /.tab-pane -->
							
							<div class="col-md-6">
<div class="panel panel-default">
									<div class="panel-heading">
                                    <h5><i class="fa fa-info-circle"></i> INFORMASI</h5>
                                <div class="ibox-tools">
                            
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                                    
										<ul>
											<li>Jangan input deposit yang sama, jika deposit sebelumnya belum selesai. Harap tunggu status <span class="label label-success">Success</span>.</li></b>
											<li>Minimal Deposit Rp. 5,000,00</li></b>
											<li>1 Nomor 1 Transaksi Yang dimaksud adalah Jika Anda Telah mengisi saldo sebesar Rp. 5,000,00 Dengan Nomor 082xxxxx Maka Sebelum 24jam Anda tidak dapat mengisi saldo kembali sebesar Rp. 5,000,00 Dengan Nomor Tersebut Kecuali Jika anda mengisi saldo Dengan Jumlah Yang Lain.</li>
                                     	    <li>Nomer Pengirim Adalah Masukan Nomer Anda Yang Di Pakai Transfer Pulsa</li>
                                     	    <li>Jika Menggunakan Nomer Lain Maka Saldo Tidak Masuk</li>
                                     	    <li>Jumlah Adalah Nominal Pulsa Yang Anda Kirim</li>
                                     	    <li>Jika butuh bantuan silahkan hubungi Admin Melalui Ticket Bantuan</li>
										</ul>
									</div>
								</div>
							</div></div>
						</div>
						</div>
        <!-- end row -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script type="text/javascript">
function get_total(quantity) {
	var result = eval(quantity) * 0.88;
	$('#total').val(result);
}
</script>
<?php

	include("../lib/footer.php");
} else {
	header("Location: ".$cfg_baseurl);
}
?>
