<?php
require("../mainconfig.php");

if (isset($_POST['server'])) {
	$post_server = mysqli_real_escape_string($db, $_POST['server']);
	$check_server = mysqli_query($db, "SELECT * FROM service_cat_pulsa WHERE type = '$post_server' ORDER BY name ASC");
	?>
	<option value="0">Pilih Oprator..</option>
	<?php
	while ($data_server = mysqli_fetch_assoc($check_server)) {
	?>
	<option value="<?php echo $data_server['code'];?>"><?php echo $data_server['name'];?></option>
	<?php
	}
} else {
?>
<option value="0">Error.</option>
<?php
}