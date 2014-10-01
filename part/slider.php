<div class="homepage-slider">
	<div id="sequence">
		<ul class="sequence-canvas">
			<!-- Slide 1 -->
<?php

$sql_artikel_pilihan = "SELECT * FROM " . artikel::$nama_tabel;
$sql_artikel_pilihan .=" WHERE pilihan = 1";
$database->query($sql_artikel_pilihan);
$database->execute();
$nResults = $database->rowCount();
if($nResults > 0){
	$i = 0;
	while($row = $database->fetch()){
		$i++;
		$output ="<li class=\"bg{$i}\">";
			$output .="<h2 class=\"title\"><a href=\"artikel_pilihan.php?i={$row['id']}\" style=\"color:#FFFFFF;\">{$row['judul']}</a></h2>";
			$content = html_entity_decode($row['content']);
            $content = strip_tags($content);
            $x = $content;
            if(strlen($x)<=300)
                $y = $x;
            else
                $y=substr($x,0,300) . '...';
			$output .="<h3 class=\"subtitle\">{$y} </h3>";
			$gambar = str_replace(' ', '%20', $row['gambar']);
			if(!empty($gambar) && is_file("images_artikel/{$gambar}"))
				$output .="<img class=\"slide-img img-rounded img-responsive\" src=\"images_artikel/{$gambar}\" 
							alt=\"{$row['judul']}\" width=\"400\" height=\"300\" />";
		$output .="</li>";

		echo $output;
	}
}else{

}
?>
		</ul>
		<div class="sequence-pagination-wrapper">
		<ul class="sequence-pagination">
<?php
$database->query($sql_artikel_pilihan);
$database->execute();
$nResults = $database->rowCount();
if($nResults > 0){
	$i2 = 0;
	while($row = $database->fetch()){
		$i2++;
		echo "<li>{$i2}</li>";
	}
}
?>
		</ul>
		</div>
	</div>
</div>