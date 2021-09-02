<?php
session_start();
require("../mainconfig.php");
$sess_username = $_SESSION['user']['username'];
mysqli_query($db, "INSERT INTO ripalloglogin(username, aktifitas, tanggal, jam, ip) VALUES ('$sess_username','Logout','$date','$time','$ipnya')");
session_destroy();
header("Location: ".$cfg_baseurl);