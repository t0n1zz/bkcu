<?php
require_once("includes/gambar_kegiatan.php");

$sql_gambar_kegiatan = "SELECT * FROM " .gambar_kegiatan::$nama_tabel; 
$database->query($sql_gambar_kegiatan);
$database->execute();
$nResults = $database->rowCount();
if($nResults > 0){
	while($row = $database->fetch()){ 
		$output ="<div class=\"shop-item\">";
			$output .="<div class=\"image modalphotos\">";
				$output .="<img style=\"cursor: pointer;cursor: hand;\" src=\"images_kegiatan/{$row['gambar']}\" alt=\"Item Name\"></a>";
			$output .="</div>";
			$output .="<div class=\"title\">";
				$output .="<h3>{$row['name']}</h3>";
			$output .="</div>";
		$output .="</div>";

		echo $output;
	}
}else{
	$output ="<div class=\"shop-item\">";
		$output .="<div class=\"title\">";
			$output .="<h3>Belum terdapat foto kegiatan kami...</h3>";
		$output .="</div>";
	$output .="</div>";

	echo $output;
}
?>

