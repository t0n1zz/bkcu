<?php 
 require_once("function.php");
 require_once("database.php");
 require_once("kegiatan.php");

 $database->query("DELETE FROM ".kegiatan::$nama_tabel. " WHERE tanggal2 < NOW()");

?>