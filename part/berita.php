<?php
require_once("includes/kategori_artikel.php");
require_once("includes/artikel.php");

$results = $database->query($sql_kategori_berita);
$nResults = mysql_num_rows($results);
if($nResults > 0){
	$i2 = 0;
	while($row = $database->fetch_array($results)){
		if($i2 % 3 == 0 || $i2 == 0){
			echo "<div class=\"row\">";
		}

		$output ="<div class=\"col-md-4 col-sm-6 latest-news\">";
			$output .="<h3 style=\"border-bottom: 2px solid #53555c;line-height: 1.5em;margin: 30px 0;\">{$row['name']}</h3>";

			$sql_berita = "SELECT * FROM " .artikel::$nama_tabel; 
		    $sql_berita .=" WHERE kategori={$row['id']}";
		    $sql_berita .=" AND status=1";
		    $sql_berita .=" ORDER BY tanggal desc";
		    $sql_berita .=" LIMIT 4";
		    $results2 = $database->query($sql_berita);
		    $nResults2 = mysql_num_rows($results2);
		    if($nResults2 > 0){
		    	$i = 0;
		    	while($row2 = $database->fetch_array($results2)){
		    		if($i <= 2){ 	
						$output .="<div class=\"row\">";
							$output .="<div class=\"col-sm-12\">";
							$output .="<div class=\"caption\"><a href=\"detail_artikel.php?i={$row2['id']}\"><b>{$row2['judul']}</b></a></div>";

							$phpdate = strtotime( $row2['tanggal'] );
                            $mysqldate = date( 'F j, Y, g:i a ', $phpdate );

                            $output .="<div class=\"date\" style=\"font-size: 14px;\">{$mysqldate}</div>";

                            $content = html_entity_decode($row2['content']);
                            $content = strip_tags($content);
                            $x = $content;
                            if(strlen($x)<=100)
                                $y = $x;
                            else
                                $y=substr($x,0,100) . '...';

                            $output .="<div class=\"intro\">{$y}</div>";
                            $output .="</div>";
						$output .="</div>";
						$i++;
					}
		    	}
		    	if($nResults2 > 3){
		    		$output .="<div class=\"row\">";
						$output .="<div class=\"col-sm-12\">";
							$output .="<a href=\"list_artikel.php?i={$row['id']}\" class=\"btn\"><b>Selengkapnya &raquo</b></a>";
						$output .="</div>";
					$output .="</div>";
		    	}
		    }else{
		    	$output .="<div class=\"row\">";
					$output .="<div class=\"col-sm-12\">";
					$output .="<div class=\"caption\"><b>Belum terdapat artikel...</b></div>";
                    $output .="</div>";
				$output .="</div>";
		    }
		$output .="</div>";

		echo $output;

		$i2++;	

		if($i2 % 3 == 0 || $i2 == $nResults){
			echo "</div> <hr/>";
		}
	}
}
?>
