<?php 

$tabel = "stat_pengunjung";
$ip      = $_SERVER['REMOTE_ADDR']; // Mendapatkan IP komputer user
$tanggal = date("Ymd"); // Mendapatkan tanggal sekarang
$waktu   = time(); // 

// Mencek berdasarkan IPnya, apakah user sudah pernah mengakses hari ini 
$database->query("SELECT * FROM {$tabel} WHERE ip='$ip' AND tanggal='$tanggal'");
$database->execute();
$s = $database->rowCount();
// Kalau belum ada, simpan data user tersebut ke database
if($s == 0){
  $database->query("INSERT INTO {$tabel} (ip, tanggal, online) VALUES(:ip,:tanggal,:waktu)");
  $database->bind(':ip',$ip);
  $database->bind(':tanggal',$tanggal);
  $database->bind(':waktu', $waktu);
  $database->execute();
} else{
  $database->query("UPDATE {$tabel} SET online = :waktu WHERE ip = :ip AND tanggal = :tanggal");
  $database->bind(':ip',$ip);
  $database->bind(':tanggal',$tanggal);
  $database->bind(':waktu', $waktu);
  $database->execute();
}

	$database->query("SELECT * FROM {$tabel} WHERE tanggal=:tanggal GROUP BY ip");
	$database->bind(':tanggal',$tanggal);
	$database->execute();
	$pengunjung       = $database->rowCount();

	$database->query("SELECT COUNT(hits) FROM {$tabel}");
	$database->execute();
	$totalpengunjung  = $database->fetchColumn();

	$bataswaktu       = time() - 300;

	$database->query("SELECT * FROM {$tabel} WHERE online > :bataswaktu");
	$database->bind(':bataswaktu',$bataswaktu);
	$database->execute();
	$pengunjungonline = $database->rowCount();

	$tanggal_hariini  = date('d-m-Y');

?>

<p class="contact-us-details">
    <b>Reset :</b> 5 September 2014 <br/>
    <b>Tanggal :</b><?php echo $tanggal_hariini; ?> <br/>
    <b>Pengunjung Hari Ini :</b><?php echo $pengunjung; ?> orang <br/>
    <b>Total Pengunjung : </b><?php echo $totalpengunjung; ?> orang<br/>
    <b>Pengunjung Online : </b><?php echo $pengunjungonline; ?> orang</br/>
</p>


