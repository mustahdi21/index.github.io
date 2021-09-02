<?php
require("../mainconfig.php");

$check_order = mysqli_query($db, "SELECT * FROM orders WHERE status IN ('Error','Partial') AND refund = '0'");

if (mysqli_num_rows($check_order) == 0) {
	die("Order Error or Partial not found.");
} else {
	while($data_order = mysqli_fetch_assoc($check_order)) {
		$o_oid = $data_order['oid'];
		$u_remains = $data_order['remains'];
		$status = $data_order['status'];
		$price = $data_order['price'];
		
		    $priceone = $data_order['price'] / $data_order['quantity'];
		    $refund = $priceone * $u_remains;
		    $buyer = $data_order['user'];
		    
	    if($status == 'Error'){
			$insert_order = mysqli_query($db, "INSERT INTO balance_history (id, username, action, quantity, msg, date, time) VALUES ('', '$buyer', 'Refunded Balance', '$price', 'Saldo Dikembalikan Untuk Pembelian, OrderID : $o_oid', '$date', '123123')");
			$update_user = mysqli_query($db, "UPDATE users SET balance = balance+$price WHERE username = '$buyer'");
			$update_user = mysqli_query($db, "UPDATE hof SET pembelian_sosmed = pembelian_sosmed-$price, jumlah_sosmed = jumlah_sosmed-1 WHERE username = '$buyer'");
	    } else if($status == 'Partial'){
			$insert_order = mysqli_query($db, "INSERT INTO balance_history (id, username, action, quantity, msg, date, time) VALUES ('', '$buyer', 'Refunded Balance', '$refund', 'Saldo Dikembalikan Untuk Pembelian, OrderID : $o_oid', '$date', '123123')");
			$update_user = mysqli_query($db, "UPDATE users SET balance = balance+$refund WHERE username = '$buyer'");
			$update_user = mysqli_query($db, "UPDATE hof SET pembelian_sosmed = pembelian_sosmed-$refund WHERE username = '$buyer'");
	    } else {
	        echo 'null';
	    }
		    
    		$update_order = mysqli_query($db, "UPDATE orders SET refund = '1'  WHERE oid = '$o_oid'");
    		if ($update_order == TRUE) {
    			echo "Refunded Rp $refund - $o_oid<br />";
    		} else {
    			echo "Error database.";
    		}
	}
}
?>