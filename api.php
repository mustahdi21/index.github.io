<?php
require("mainconfig.php");
header("Content-Type: application/json");

if (isset($_POST['key']) AND isset($_POST['action'])) {
	$post_key = mysqli_real_escape_string($db, trim($_POST['key']));
	$post_action = $_POST['action'];
	if (empty($post_key) || empty($post_action)) {
		$array = array("error" => "Incorrect request");
	} else {
		$check_user = mysqli_query($db, "SELECT * FROM users WHERE api_key = '$post_key'");
		$data_user = mysqli_fetch_assoc($check_user);
		if (mysqli_num_rows($check_user) == 1) {
			$username = $data_user['username'];
			if ($post_action == "add") {
				if (isset($_POST['service']) AND isset($_POST['link']) AND isset($_POST['quantity'])) {
					$post_service = $_POST['service'];
					$post_link = $_POST['link'];
					$post_quantity = $_POST['quantity'];
					if (empty($post_service) || empty($post_link) || empty($post_quantity)) {
						$array = array("error" => "Incorrect request");
					} else {
		$cekpesanan = mysqli_query($db, "SELECT * FROM orders WHERE link = '$post_link' AND status = 'Pending'");
		$hitungpesanan = mysqli_num_rows($cekpesanan);
						$check_service = mysqli_query($db, "SELECT * FROM services WHERE sid = '$post_service' AND status = 'Active'");
						$data_service = mysqli_fetch_assoc($check_service);
						if (mysqli_num_rows($check_service) == 0) {
							$array = array("error" => "Service not found");
						} else {
							$rate = $data_service['price'] / 1000;
							$price = $rate*$post_quantity;
							$service = $data_service['service'];
							$provider = $data_service['provider'];
							$pid = $data_service['pid'];
							if ($post_quantity < $data_service['min']) {
								$array = array("error" => "Quantity inccorect");
							} else if ($post_quantity > $data_service['max']) {
								$array = array("error" => "Quantity inccorect");
							} else if ($data_user['balance'] < $price) {
								$array = array("error" => "Low balance");
							} else if ($hitungpesanan > 0) {
								$array = array("error" => "There is a Same Order Username & Status Pending");
							} else {
								$check_provider = mysqli_query($db, "SELECT * FROM provider WHERE code = '$provider'");
								$data_provider = mysqli_fetch_assoc($check_provider);
								$provider_key = $data_provider['api_key'];
								$provider_link = $data_provider['link'];
	
			// api data
			$api_link = $data_provider['link'];
			$api_key = $data_provider['api_key'];//PESAN ERROR
			// end api data

			if ($provider == "MANUAL") {
				$api_postdata = "";
			} else if ($provider == "LOVEPEDIA") {
                $postdata = "api_key=$provider_key&service=$pid&target=$post_link&quantity=$post_quantity";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $api_link);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $chresult = curl_exec($ch);
                curl_close($ch);
                    $json_result = json_decode($chresult);
			} else {
				die("System Error!");
			}

			if ($provider != "MANUAL" AND $json_result->status == false) {
									$array = array("error" => "Server maintenance");
			} else {
				if ($provider == "LOVEPEDIA") {
					$poid = $json_result->data->id;
				} else if ($provider == "MANUAL") {
					$poid = $oid;
				}
									$update_user = mysqli_query($db, "UPDATE users SET balance = balance-$price WHERE username = '$username'");
									if ($update_user == TRUE) {
										$insert_order = mysqli_query($db, "INSERT INTO orders (oid, poid, user, service, link, quantity, price, status, date, provider, place_from) VALUES ('$poid', '$poid', '$username', '[API] $service', '$post_link', '$post_quantity', '$price', 'Pending', '$date', '$provider', 'API')");
										if ($insert_order == TRUE) {
											$array = array("order_id" => "$poid");
										} else {
											$array = array("error" => "System error");
										}
									} else {
										$array = array("error" => "System error");
									}
								}
							}
						}
					}
				} else {
					$array = array("error" => "Incorrect request");
				}
			} else if ($post_action == "status") {
				if (isset($_POST['order_id'])) {
					$post_oid = $_POST['order_id'];
					$check_order = mysqli_query($db, "SELECT * FROM orders WHERE poid = '$post_oid' AND user = '$username'");
					$data_order = mysqli_fetch_array($check_order);
					if (mysqli_num_rows($check_order) == 0) {
						$array = array("error" => "Order not found");
					} else {
						$array = array("charge" => $data_order['price'], "link" => $data_order['link'], "status" => $data_order['status']);
					}
				} else {
					$array = array("error" => "Incorrect request");
				}
			} else {
				$array = array("error" => "Wrong action");
			}
		} else {
			$array = array("error" => "Invalid API key");
		}
	}
} else {
	$array = array("error" => "Incorrect request");
}

$print = json_encode($array);
print_r($print);