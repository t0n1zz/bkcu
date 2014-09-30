 <?php
require_once("includes/pengumuman.php");

$sql_tampil = "SELECT * FROM " .pengumuman::$nama_tabel; 
$database->query($sql_tampil);
$database->execute();
$nResults = $database->rowCount();
if($nResults > 0){
    echo"<div class=\" section-pengumuman\">";
		echo"<div class=\"container\">";
			echo"<div class=\"row\">";
				echo"<div class=\"col-md-12\">";
					echo"<div class=\"calltoaction-wrapper\">";
					echo"<h3 style=\"border-bottom: 2px solid white;line-height: 1.5em;margin: 10px 0;color:white;\"><b>INFORMASI</b></h3>";
					echo"<ul id=\"ticker\" class=\"list-unstyled\">";
	while($row = $database->fetch()){
		$phpdate = strtotime( $row['tanggal'] );
        $mysqldate = date( 'd-m-Y ', $phpdate );						
						echo "<li style=\"color:white;\"><b>{$mysqldate} : {$row['name']} </b></li>";
    }
    				echo"</ul>";
    				echo"</div>";
				echo"</div>";
			echo"</div>";
		echo"</div>";
	echo"</div>";
}
?>