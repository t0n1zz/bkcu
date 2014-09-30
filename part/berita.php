<?php
require_once("includes/kategori_artikel.php");
require_once("includes/artikel.php");

$database->query($sql_kategori_berita);
$database->execute();
$nResults = $database->rowCount();
if($nResults > 0){
	$i = 0;
	echo "<ul class=\"nav nav-tabs\" role=\"tablist\">";
	while ($row = $database->fetch()) {
		if($i == 0)
			echo "<li class=\"active\"><a href=\"#{$row['id']}\" role=\"tab\" data-toggle=\"tab\"><b>{$row['name']}</b> <span 
					  class=\"badge\">{$row['countartikel']}<span></a></li>";
		else
			echo "<li><a href=\"#{$row['id']}\" role=\"tab\" data-toggle=\"tab\"><b>{$row['name']}</b> <span 
					  class=\"badge\">{$row['countartikel']}<span></a></li>";
		$i++;
	}
	echo "</ul>";
}

$database->query($sql_kategori_berita);
$database->execute();
$nResults = $database->rowCount();
if($nResults > 0){
	$i2 = 0;
	echo "<div class=\"tab-content\">";
	while ($row = $database->fetch()) {
		if($i2 == 0)
			$output = "<div class=\"tab-pane fade in active\" id=\"{$row['id']}\">";
		else
			$output = "<div class=\"tab-pane fade\" id=\"{$row['id']}\">";

		$sql_berita = "SELECT * FROM " .artikel::$nama_tabel; 
	    $sql_berita .=" WHERE kategori={$row['id']}";
	    $sql_berita .=" AND status=1";

	    if($fullpage == 0)
	    	$sql_berita .=" AND pilihan=0";

	    $sql_berita .=" ORDER BY tanggal desc";
	    
	    if($fullpage == 0)
	    	$sql_berita .=" LIMIT 3";
	    else
	    	$sql_berita .=" LIMIT 12";

	    $results2 = $database->dbh->query($sql_berita);
	    $nResults2 = $results2->rowCount();
	    $output .="<div class=\"row\">";
	    if($nResults2 > 0){
	    	$i3 = 0;
	    	while($row2 = $results2->fetch()){
		   		if($i3 % 3 == 0 || $i3 == 0){
					$output .="<div class=\"row\">";
				}

				$output .="<div class=\"col-md-4 col-sm-6\"><div class=\"blog-post\">";
				$gambar = str_replace(' ', '%20', $row2['gambar']);
				if(!empty($gambar) && is_file("images_artikel/{$gambar}"))
					$output .="<img src=\"images_artikel/{$gambar}\" class=\"post-image\" alt=\"Post Title\">";

					$output .="<div class=\"post-title\">";
						$output .="<h3><a href=\"detail_artikel.php?i={$row2['id']}\">{$row2['judul']}</a></h3>";
					$output .="</div>";

                    $output .="<div class=\"post-summary\">";
                    	$phpdate = strtotime( $row2['tanggal'] );
                    	$mysqldate = date( 'F j, Y, g:i a ', $phpdate );
	                    $output .="<div class=\"date\" style=\"font-size: 14px;\"><i class=\"fa fa-clock-o\"></i> {$mysqldate}</div><br/> ";
						
						$content = html_entity_decode($row2['content']);
			  			$content = strip_tags($content);
		                $x = $content;
		                if(strlen($x)<=400)
		                	$y = $x;
		                else
		                	$y=substr($x,0,400) . '...';

	                    $output .="<p>{$y}</p>";
	                $output .="</div>";
                    $output .="<div class=\"post-more\">";
						$output .="<a href=\"detail_artikel.php?i={$row2['id']}\" class=\"btn btn-small\">Selengkapnya</a>";
					$output .="</div>";
				$output .="</div></div>";

				$i3++;	
				if($i3 % 3 == 0 || $i3 == $nResults2){
					$output .="</div>";
				}
	    	}
	    	if($nResults2 >= 3 && $fullpage == 0){
	    		$output .="<div class=\"row\">";
					$output .="<div class=\"col-sm-12\"><div class=\"col-sm-12\">";
						$output .="<hr style=\"border-top:1px solid #D2D2D2;\" />";
						$output .="<a href=\"list_artikel.php?i={$row['id']}\" class=\"btn pull-right\"><b>{$row['name']} Selengkapnya &raquo</b></a>";
					$output .="</div></div>";
				$output .="</div>";
	    	}
	    	if($nResults2 >= 12 && $fullpage == 1){
	    		$output .="<div class=\"row\">";
					$output .="<div class=\"col-sm-12\"><div class=\"col-sm-12\">";
						$output .="<hr style=\"border-top:1px solid #D2D2D2;\" />";
						$output .="<a href=\"list_artikel.php?i={$row['id']}\" class=\"btn pull-right\"><b>{$row['name']} Selengkapnya &raquo</b></a>";
					$output .="</div></div>";
				$output .="</div>";
	    	}
	    }else{
	    	$output .="<div class=\"col-sm-12\"><div class=\"blog-post\">";
				$output .="<div class=\"post-summary\">";
					$output .="<h3>Belum terdapat artikel...</h3>";
                $output .="</div>";
			$output .="</div></div>";
	    }
	    $output .="</div>";
		$output.="</div>";

		$i2++;

		echo $output;
	}
	echo "</div>";
} 
?>
