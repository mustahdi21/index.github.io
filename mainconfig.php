<?php
// Hargailah orang lain jika Anda ingin dihargai

date_default_timezone_set('Asia/Jakarta');
error_reporting(0);

$cfg_mt = 0; // Maintenance? 1 = ya 0 = tidak
if($cfg_mt == 1) {
    die("Site under Maintenance.");
}

// web
$cfg_webname = "Batam Media - Social Media Reseller Panel";
$cfg_logo_txt = "Batam Media";
$cfg_baseurl = "https://demo-panel.viral28.xyz/";
$cfg_desc = "Batam Media ah website penyedia layanan sosial media termurah, cepat & berkualitas.";
$cfg_author = "Putra Batam";
$cfg_about = "Batam Media Merupakan sebuah website penyedia layanan sosial media termurah, cepat & berkualitas.";

// fitur staff
$cfg_min_transfer = 5000; // jumlah minimal transfer saldo
$cfg_member_price = 15000; // harga pendaftaran member
$cfg_member_bonus = 5000; // bonus saldo member
$cfg_agen_price = 40000; // harga pendaftaran agen
$cfg_agen_bonus = 20000; // bonus saldo agen
$cfg_reseller_price = 80000; // harga pendaftaran reseller
$cfg_reseller_bonus = 35000; // bonus saldo reseller
$cfg_admin_price = 150000; // harga pendaftaran admin
$cfg_admin_bonus = 70000; // bonus saldo admin

// database
$db_server = "localhost";
$db_user = "demo1_db1";
$db_password = "demo1_db1";
$db_name = "demo1_db1";
$cfg_apikey = "apikeylo";
function IPnya() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'IP Tidak Dikenali';
 
    return $ipaddress;
}
$ipnya = IPnya();

// date & time
$date = date("Y-m-d");
$time = date("H:i:s");

// require
require("lib/database.php");
require("lib/function.php");
