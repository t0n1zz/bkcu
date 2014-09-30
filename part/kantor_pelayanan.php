<?php
require_once("includes/kantor_pelayanan.php");
$sql_kantor_pelayanan = "SELECT * FROM " . kantor_pelayanan::$nama_tabel;
$sql_kantor_pelayanan .= " WHERE id NOT IN (1)";

$database->query($sql_kantor_pelayanan);
$database->execute();
$nResults = $database->rowCount();
if($nResults > 0){
   $i = 0;
   while($row = $database->fetch()){
   		if($i % 2 == 0 || $i == 0){
			echo "<div class=\"row\">";
		}

		$output ="<div class=\"testimonial col-md-6 col-sm-6\">";
			$output .="<div class=\"testimonial-bubble\">";
					$output .="<h3>{$row['name']}</h3><br>";
					if(!empty($row['alamat']))
						$output .="{$row['alamat']}<br>";
					if(!empty($row['alamat2']))
						$output .="{$row['alamat2']}<br>";
					if(!empty($row['alamat3']) || !empty($row['pos']))
						$output .="{$row['alamat3']} {$row['pos']}<br>";
					if(!empty($row['telp']) || !empty($row['fax']))
						$output .="Telp: {$row['telp']} Fax: {$row['fax']}<br>";
					if(!empty($row['email']))
						$output .="<abbr title=\"Email\"><a href=\"mailto:{$row['email']}\" target=\"_top\">{$row['email']}</a>";	
            	$output .="<div class=\"sprite arrow-speech-bubble\"></div>";
            $output .="</div>";
        $output .="</div>";

        echo $output;

		$i++;	
		if($i % 2 == 0){
			echo "</div>";
		}
	}
}
?>