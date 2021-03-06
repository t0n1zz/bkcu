<?php
require_once("includes/function.php");
require_once("includes/database.php");
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
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/icomoon-social.css">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,600,800' rel='stylesheet' type='text/css'>
		<link href="admin/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<!--[if lte IE 8]>
		    <link rel="stylesheet" href="css/leaflet.ie.css" />
		<![endif]-->
		<link rel="stylesheet" href="css/main.css">
		<style type="text/css">
		#ticker {
		    height: 40px;
		    overflow: hidden;
		}
		#ticker li {
		    height: 40px;
		}
		</style>

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
					<div class="col-md-12">
						<h1>Berita</h1>
					</div>
				</div>
			</div>
		</div>


		<!-- pengumuman-->
		<?php include("part/pengumuman.php"); ?>
		<!-- End pengumuman -->

		<!-- Press berita -->
        <div class="section">
	    	<div class="container">
				<?php 
					$sql_kategori_berita = "SELECT k.id,k.name,ar.kategori,count(ar.kategori) as countartikel";
					$sql_kategori_berita .=" FROM " .kategori_artikel::$nama_tabel. " k";
					$sql_kategori_berita .=" LEFT JOIN " .artikel::$nama_tabel. " ar";
					$sql_kategori_berita .=" ON k.id = ar.kategori";
					$sql_kategori_berita .=" WHERE k.id NOT IN (1,4)";
					$sql_kategori_berita .=" GROUP BY k.id";
					$fullpage = 1; 
					include("part/berita.php"); 
				?>
			</div>
		</div>
		<!-- Press berita -->

	    <!-- Footer -->
	    <?php include("part/footer.php"); ?>

	    <div class="modal fade" id="modalphotoshow">
		    <div class="modal-body">
		      <img class="pointer img-responsive" src="" id="modalimage"/>
		    </div>
		</div>


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