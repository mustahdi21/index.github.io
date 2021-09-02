<?php
require("../mainconfig.php");

$check_order = mysqli_query($db, "SELECT * FROM orders_pulsa WHERE status IN ('','Pending','Processing') AND provider = 'PM'");

if (mysqli_num_rows($check_order) == 0) {
	die("Order Pending not found.");
} else {
	while($data_order = mysqli_fetch_assoc($check_order)) {
		$o_oid = $data_order['oid'];
		$o_poid = $data_order['poid'];
		$o_provider = $data_order['provider'];
	if ($o_provider == "MANUAL") {
		echo "Order manual<br />";
	} else {
		
		$check_provider = mysqli_query($db, "SELECT * FROM provider WHERE code = '$o_provider'");
		$data_provider = mysqli_fetch_assoc($check_provider);
		
		$p_apikey = $data_provider['api_key'];
		$p_link = $data_provider['link'];
		
			$api_postdata = "key=UXuOSVnJEPVco7jmL4D8&action=status&order_id=$o_poid";

		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://www.penajam-media.com/api/pulsa");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $api_postdata);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$chresult = curl_exec($ch);
		echo $chresult;
		curl_close($ch);
		$json_result = json_decode($chresult, true);
		
		 if ($o_provider == "PM") {
		  $u_catatan = $json_result['catatan'];

         if ($json_result['status'] == "Pending") {
				$u_status = "Pending";
			} else if ($json_result['status'] == "Processing") {
				$u_status = "Processing";
			} else if ($json_result['status'] == "Error") {
				$u_status = "Error";
			} else if ($json_result['status'] == "Partial") {
				$u_status = "Partial";
			} else if ($json_result['status'] == "Success") {
				$u_status = "Success";
			} else {
				$u_status = "Pending";
			}
        }
		
		$update_order = mysqli_query($db, "UPDATE orders_pulsa SET status = '$u_status', catatan = '$u_catatan' WHERE oid = '$o_oid'");
		if ($update_order == TRUE) {
      echo "<br />ID Pesanan Web: $o_oid<br />ID Pesanan Pusat: $o_poid<br /> Status: $u_status<br /><br />";
    } else {
      echo "Error database.";
    }
	}
	}
}
?>