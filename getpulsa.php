<?php
   require_once("mainconfig.php");
       
        $querrr = mysqli_query($db, "SELECT * FROM provider WHERE code = 'PM'");
        $hah = mysqli_fetch_array($querrr);
        $apinya = $hah['api_key'];
       
        mysqli_query($db, "DELETE FROM services_pulsa WHERE provider = 'PM'");  //JIKA INGIN HAPUS SERVICES SEBELUM NYA
   
        $url = 'https://penajam-media.com/api/pulsa.php';
        $postdata = "key=apikeylo&action=service";
       
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        echo $result;
        $olah = json_decode($result, true);
 
        $no = 1;
        foreach($olah as $datanya){
            $kode = $datanya['id'];
            $service = $datanya['name'];
            $category = $datanya['oprator'];         
            $price = $datanya['price'];
            $status = $datanya['status'];
            $rate = 200; 
            $rate_asli = $price / 0.84 + $rate;
            $totaly = $rate+$price;
 
            $cek_service = mysqli_query($db, "SELECT * FROM services_pulsa WHERE provider = 'PM' AND pid = '$kode'");
            $hitung = mysqli_num_rows($cek_service);
 
        if ($hitung > 0) {
            echo "Services $service => Sudah Ada Gan<br>";
           $no++;
        } else {
            $input = mysqli_query($db, "INSERT INTO services_pulsa (pid, name, oprator, price, status, provider) VALUES ('$kode','$service','$category','$totaly','$status','PM')");
            if ($input){
                echo "===============<br>Successfully Adding Services<br>name: $service<br>oprator: $category<br>Price: $totaly<br>Status: $status<br>===============<br>";
            $no++;
            }else{
                echo mysqli_error();
            }
            $no++;
        }
    }
?>