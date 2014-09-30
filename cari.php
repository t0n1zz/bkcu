<?php
require_once("includes/function.php");
require_once("includes/database.php");

$thispage= 1;

if(isset($_POST['cari'])){
	if(preg_match("/^[  a-zA-Z]+/", $_POST['textcari'])){ 
		$cari = $_POST['textcari'];
	}
	redirect_to("cari.php?cari={$cari}");
}elseif(isset($_GET['cari'])){
	if(preg_match("/^[  a-zA-Z]+/", $_GET['cari'])){ 
		$cari = $_GET['cari'];
		$cari2 = explode(" ", $cari);
		$kondisi_cari = "judul LIKE '%" . implode("%' AND judul LIKE '%", $cari2) . "%'";
		$sql_cari = "SELECT * FROM ". artikel::$nama_tabel ." WHERE " .$kondisi_cari. " AND status=1 AND kategori NOT IN (1)";
		$title = "Pencarian Artikel : <i>" .$cari. "</i>";	
	}else{
		redirect_to("wrong.php");
	}
}else{
	redirect_to("wrong.php");
}
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Puskopdit BKCU Kalimantan</title>
        <link rel="shortcut icon" href="images/logo.png"> 
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
		<link href="admin/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/icomoon-social.css">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,600,800' rel='stylesheet' type='text/css'>
		<!--[if lte IE 8]>
		    <link rel="stylesheet" href="css/leaflet.ie.css" />
		<![endif]-->
		<link rel="stylesheet" href="css/main.css">

        <script src="js/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
        

        <!-- Navigation & Logo-->
        <?php include("part/navigation.php"); ?>

		<!-- Page Title -->
		<div class="section section-breadcrumbs">
			<div class="container">
				<div class="row">
					<div class="col-md-8">
						<h1><?php echo $title; ?></h1>
					</div>
					<div class="col-md-4">
						<form action="cari.php" method="post">
							<div class="input-group">
								<input class="form-control input-md" id="appendedInputButtons" type="text" name="textcari" placeholder="Masukkan Kata Kunci">
								<span class="input-group-btn">
									<button class="btn btn-md" type="submit" name="cari"><i class="fa fa-search"></i></button>
								</span>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<!-- Posts List -->
        <div class="section blog-posts-wrapper">
	    	<div class="container">
		    	<div class="row">
	    		<?php
	    		$database->query($sql_cari);
	    		$database->execute();
				$nResults = $database->rowCount();
				if($nResults > 0){
					$i = 0;
				   while($row = $database->fetch()){
				   		$output ="";
				   		if($i % 3 == 0 || $i == 0){
							$output .="<div class=\"row\">";
						}

						$output .="<div class=\"col-md-4 col-sm-6\">";
							$output .="<div class=\"blog-post\">";
								$output .="<div class=\"post-title\">";
									$output .="<h3><a href=\"detail_artikel.php?i={$row['id']}\">{$row['judul']}</a></h3>";
								$output .="</div>";
								$output .="<div class=\"post-summary\">";
								$phpdate = strtotime( $row['tanggal'] );
	                            $mysqldate = date( 'F j, Y, g:i a ', $phpdate );

	                            $output .="<div class=\"date\" style=\"font-size: 14px;\">{$mysqldate}</div><br /> ";
									$content = html_entity_decode($row['content']);
						  			$content = strip_tags($content,'<p>');
					                $x = $content;
					                if(strlen($x)<=400)
					                	$y = $x;
					                else
					                	$y=substr($x,0,400) . '...';
									$output .="<p>{$y}</p>";
								$output .="</div>";
								$output .="<div class=\"post-more\">";
									$output .="<a href=\"detail_artikel.php?i={$row['id']}\" class=\"btn btn-small\">Selengkapnya &raquo</a>";
								$output .="</div>";
							$output .="</div>";
						$output .="</div>";

						$i++;	
						if($i % 3 == 0 || $i == $nResults){
							$output .="</div>";
						}
						echo $output;
				   }
				}else{
					$output ="<div class=\"col-md-12 col-sm-12\">";
						$output .="<div class=\"blog-post\">";
								$output .="<div class=\"post-title\">";
								$output .="<h3>Tidak terdapat artikel yang dicari</h3>";
							$output .="</div>";
						$output .="</div>";
					$output .="</div>";
					echo $output;
				}
	    		?>
				</div>
	        </div>
	    </div>
	    <!-- End Posts List -->


	    <!-- Footer -->
	    <?php include("part/footer.php"); ?>


        <!-- Javascripts -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/jquery-1.9.1.min.js"><\/script>')</script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.fitvids.js"></script>
        <script src="js/jquery.sequence-min.js"></script>
        <script src="js/jquery.bxslider.js"></script>
        <script src="js/main-menu.js"></script>
        <script src="js/template.js"></script>
		<script src="js/jquery-ui-1.10.3.custom.js"></script>
  		<script src="js/myscript.js"></script>
    </body>
</html>