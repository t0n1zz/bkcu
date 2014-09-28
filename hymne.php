<?php
require_once("includes/function.php");
require_once("includes/database.php");
require_once("includes/artikel.php");
require_once("includes/kategori_artikel.php");

$title = "Hymne Credit Union";
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
						<h1><?php echo $title; ?></h1>
					</div>
				</div>
			</div>
		</div>
        
        <div class="section">
	    	<div class="container">
				<div class="row">
					<!-- Blog Post -->
					<div class="col-sm-8">
						<div class="blog-post blog-single-post">
							<div class="single-post-content modalphotos">
								<img style="cursor: pointer;cursor: hand;" 
									 src="images/HymneCU.png" class="img-responsive">
							</div>
						</div>
					</div>
					<!-- End Blog Post -->
					<!-- Blog Post -->
					<div class="col-sm-4 blog-sidebar">
					<br />
						<h4>Hymne Credit Union Instrumental</h4>
						<audio controls autoplay>
						  <source src="music/CU_melodi.mp3" type="audio/mpeg">
						  Browser mu tidak mendukung memutar lagu ini.
						</audio>

						<h4>Artikel Terkait</h4>
						<ul class="recent-posts">
							<li><a href="tentang_kami.php#tentang">Tentang Kami</a></li>
							<li><a href="tentang_kami.php#visi">Visi dan Misi BKCU</a></li>
							<li><a href="tentang_kami.php#tim">Tim Kami</a></li>
							<li><a href="tentang_kami.php#temui">Temui Kami</a></li>
							<li><a href="sejarah_bkcu.php">Sejarah Puskopdit BKCU Kalimantan</a></li>
						</ul>
					</div>
					<!-- End Blog Post -->
				</div>
			</div>
	    </div>
		
	    <!-- Footer -->
	    <?php include("part/footer.php"); ?>

	    <div class="modal fade" id="modalphotoshow">
		    <div class="modal-body">
		      <img class="pointer img-responsive center-block" src="" id="modalimage"/>
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