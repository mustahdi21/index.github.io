<?php
require("../mainconfig.php");

$check_order = mysqli_query($db, "SELECT * FROM orders_pulsa WHERE status IN ('Error','Partial') AND refund = '0'");

if (mysqli_num_rows($check_order) == 0) {
	die("Order Error or Partial not found.");
} else {
	while($data_order = mysqli_fetch_assoc($check_order)) {
		$o_oid = $data_order['oid'];
		$u_remains = $data_order['remains'];
		
		    $price = $data_order['price'];
		    $buyer = $data_order['user'];

		    
		    if($data_order['status'] == "Error" OR $data_order['status'] == "Partial"){
		        
		        $update_user = mysqli_query($db, "UPDATE users SET balance_used = balance_used-$price WHERE username = '$buyer'");
		        $update_user = mysqli_query($db, "UPDATE hof SET pembelian_pulsa = pembelian_pulsa-$price, jumlah_pulsa = jumlah_pulsa-1 WHERE username = '$buyer'");
		        $update_user = mysqli_query($db, "UPDATE users SET balance = balance+$price WHERE username = '$buyer'");
		        $update_order = mysqli_query($db, "UPDATE orders_pulsa SET refund = '$price'  WHERE oid = '$o_oid'");
		        $update_order = mysqli_query($db, "INSERT INTO balance_history (username, action, quantity, msg, date, time) VALUES ('$buyer', 'Penambahan Saldo', '$price', 'Refund balance. ID ORDER : $o_oid', '$date', '$time')");

		    }
		    
    		
    		if ($update_order == TRUE) {
    			echo "Refunded Rp $refund - $o_oid<br />";
    		} else {
    			echo "Error database.";
    		}
	}
}