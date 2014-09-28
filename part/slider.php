<div class="homepage-slider">
	<div id="sequence">
		<ul class="sequence-canvas">
			<!-- Slide 1 -->
<?php
require_once("includes/artikel_pilihan.php");
$artikel_pilihan = new artikel_pilihan();

$sql_artikel_pilihan = "SELECT * FROM " . artikel_pilihan::$nama_tabel;
$result = $database->query($sql_artikel_pilihan);
$nResults = mysql_num_rows($result);
if($nResults > 0){
	$i = 0;
	while($row = $database->fetch_array($result)){
		$i++;
		$output ="<li class=\"bg{$i}\">";
			$output .="<h2 class=\"title\"><a href=\"detail_artikel_pilihan.php?i={$row['id']}\" style=\"color:#FFFFFF;\">{$row['judul']}</a></h2>";
			$content = html_entity_decode($row['content']);
            $content = strip_tags($content);
            $x = $content;
            if(strlen($x)<=100)
                $y = $x;
            else
                $y=substr($x,0,100) . '...';
			$output .="<h3 class=\"subtitle\">{$y} </h3>";
				$output .="<img class=\"slide-img img-rounded img-responsive\" src=\"images_pilihan/{$row['gambar']}\" 
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
$result = $database->query($sql_artikel_pilihan);
$nResults = mysql_num_rows($result);
if($nResults > 0){
	$i2 = 0;
	while($row = $database->fetch_array($result)){
		$i2++;
		echo "<li>{$i2}</li>";
	}
}
?>
		</ul>
		</div>
	</div>
</div>