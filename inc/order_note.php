<?php
require("../mainconfig.php");

if (isset($_POST['service'])) {
	$post_sid = mysqli_real_escape_string($db, $_POST['service']);
	$check_service = mysqli_query($db, "SELECT * FROM services WHERE sid = '$post_sid' AND status = 'Active'");
	if (mysqli_num_rows($check_service) == 1) {
		$data_service = mysqli_fetch_assoc($check_service);
	?>
													<div class="form-row">
<div class="form-group col-md-4">
<label class="col-form-label">Harga/1000 <span class="text-danger" id="txt_custom_price"></span></label>
<div class="input-group">
<div class="input-group-prepend">
<span class="input-group-text">Rp</span>
</div>
<input type="text" class="form-control" id="price" value="<?php echo number_format($data_service['price'],0,',','.'); ?>" readonly="">
</div>
</div>
<div class="form-group col-md-4">
<label class="col-form-label">Minimal Pesan</label>
<input type="text" class="form-control" id="min" value="<?php echo number_format($data_service['min'],0,',','.'); ?>" readonly="">
</div>
<div class="form-group col-md-4">
<label class="col-form-label">Maksimal Pesan</label>
<input type="text" class="form-control" id="max" value="<?php echo number_format($data_service['max'],0,',','.'); ?>" readonly="">
</div>
</div>
												</div>
	<?php
	} else {
	?>
												<div class="alert alert-icon alert-danger alert-dismissible fade in" role="alert">
													<button type="button" class="close" data-dismiss="alert" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
													<i class="mdi mdi-block-helper"></i>
													<b>Error:</b> Service not found.
												</div>
	<?php
	}
} else {
?>
												<div class="alert alert-icon alert-danger alert-dismissible fade in" role="alert">
													<button type="button" class="close" data-dismiss="alert" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
													<i class="mdi mdi-block-helper"></i>
													<b>Error:</b> Something went wrong.
												</div>
<?php
}