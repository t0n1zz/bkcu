<?php 

$tabel = "stat_pengunjung";
$ip      = $_SERVER['REMOTE_ADDR']; // Mendapatkan IP komputer user
$tanggal = date("Ymd"); // Mendapatkan tanggal sekarang
$waktu   = time(); // 

// Mencek berdasarkan IPnya, apakah user sudah pernah mengakses hari ini 
$s = mysql_query("SELECT * FROM {$tabel} WHERE ip='$ip' AND tanggal='$tanggal'");
// Kalau belum ada, simpan data user tersebut ke database
if(mysql_num_rows($s) == 0){
  mysql_query("INSERT INTO {$tabel} (ip, tanggal, hits, online) VALUES('$ip','$tanggal','1','$waktu')");
} 
else{
  mysql_query("UPDATE {$tabel} SET hits=hits+1, online='$waktu' WHERE ip='$ip' AND tanggal='$tanggal'");
}

$pengunjung       = mysql_num_rows(mysql_query("SELECT * FROM {$tabel} WHERE tanggal='$tanggal' GROUP BY ip"));
$totalpengunjung  = mysql_result(mysql_query("SELECT COUNT(hits) FROM {$tabel}"), 0); 
$hits             = mysql_fetch_assoc(mysql_query("SELECT SUM(hits) as hitstoday FROM {$tabel} WHERE tanggal='$tanggal' GROUP BY tanggal")); 
$totalhits        = mysql_result(mysql_query("SELECT SUM(hits) FROM {$tabel}"), 0); 
$tothitsgbr       = mysql_result(mysql_query("SELECT SUM(hits) FROM {$tabel}"), 0); 
$bataswaktu       = time() - 300;
$pengunjungonline = mysql_num_rows(mysql_query("SELECT * FROM {$tabel} WHERE online > '$bataswaktu'"));
$tanggal_hariini  = date('j F Y');

?>

<p class="contact-us-details">
    <b>Reset :</b> 5 September 2014 <br/>
    <b>Tanggal :</b><?php echo $tanggal_hariini; ?> <br/>
    <b>Pengunjung Hari Ini :</b><?php echo $pengunjung; ?> orang <br/>
    <b>Total Pengunjung : </b><?php echo $totalpengunjung; ?> orang<br/>
    <b>Pengunjung Online : </b><?php echo $pengunjungonline; ?> orang</br/>
    <b>Hits Hari Ini : </b><?php echo $hits['hitstoday']; ?>x</br>
    <b>Total Hits : </b><?php echo $totalhits; ?>x
</p>


