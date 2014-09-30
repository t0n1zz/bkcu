<?php
require_once("includes/pelayanan.php");
$pelayanan = new pelayanan();

$sql_pelayanan = "SELECT * FROM " . pelayanan::$nama_tabel;
$database->query($sql_pelayanan);
$database->execute();
$nResults = $database->rowCount();
if($nResults > 0){
   $i = 0;
   while($row = $database->fetch()){
   		if($i % 3 == 0 || $i2 == 0){
			   echo "<div class=\"row\">";
		  }

		$output ="<div class=\"col-md-4 col-sm-6\">";
			$output .="<div class=\"service-wrapper\">";
			$gambar = $row['gambar'];
  		$gambar = str_replace(' ', '%20', $gambar);
    			$output .="<img src=\"images/{$gambar}\" class=\"img-rounded img-responsive\" alt=\"{$row['name']}\" width=\"300\">";
    			$output .="<h3>{$row['name']}</h3>";
    			$content = html_entity_decode($row['content']);
	  			$content = strip_tags($content);
                $x = $content;
                if(strlen($x)<=200)
                	$y = $x;
                else
                	$y=substr($x,0,200) . '...';

	            $output .="<p>{$y}</p>";
    			$output .="<a href=\"solusi.php#pelayanan{$row['id']}\" class=\"btn\">Selengkapnya &raquo</a>";
    		$output .="</div>";
		$output .="</div>";

		echo $output;

		$i++;	
		if($i % 3 == 0){
			echo "</div>";
		}
  }

}

?>