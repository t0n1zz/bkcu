<?php
require_once("includes/function.php");
require_once("includes/database.php");
require_once("includes/pelayanan.php");
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
						<h1>Solusi</h1>
					</div>
				</div>
			</div>
		</div>
        
        <div class="section">
	    	<div class="container">
				<?php
		            $sql_pelayanan = "SELECT * FROM " . pelayanan::$nama_tabel;

		            $i = 1;
		            $pos = "";

		            $database->query($sql_pelayanan);
		            $database->execute();
		            while($row = $database->fetch()){
		                if($i % 2 == 0){
		                    $pos = 2;
		                }else if($i % 3 == 0){
		                    $pos =1;
		                }else if($i % 2 == 1){
		                    $pos =1;
		                }

		                $gambar = $row['gambar'];
		                $gambar = str_replace(' ', '%20', $gambar);

		                $content = html_entity_decode($row['content']);

		                if($pos == 1){
		                	$output ="<div class=\"row\" id=\"pelayanan{$row['id']}\">";
		                		$output .="<h2>{$row['name']}</h2>";
		                		$output .="<div class=\"col-sm-6\">{$content}</div>";
								$output .="<div class=\"col-sm-6\">";
									if(!empty($gambar) && is_file("images/{$gambar}")){
		                                $output .="<img class=\"img-responsive img-thumbnail\" src=\"images/{$gambar}\" 
		                                            alt=\"{$row['name']}\" style=\"width: 500px; height: 300px;\">";
		                            }
								$output .="</div>";
							$output .="</div>";
		                }

		                if($pos == 2){
		                	$output ="<div class=\"row\" id=\"pelayanan{$row['id']}\">";
		                		$output .="<h2>{$row['name']}</h2>";
		                		$output .="<div class=\"col-sm-6\">";
									if(!empty($gambar) && is_file("images/{$gambar}")){
		                                $output .="<img class=\"img-responsive img-thumbnail\" src=\"images/{$gambar}\" 
		                                            alt=\"{$row['name']}\" style=\"width: 500px; height: 300px;\">";
		                            }
								$output .="</div>";
		                		$output .="<div class=\"col-sm-6\">{$content}</div>";
		                	$output .="</div>";
		                }
		                $i++;
		                echo $output;
		            }
		        ?>
				</div>
			</div>
		</div>

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

  		<script type="text/javascript">
	    // smooth scroll to website compoenent id
	    $(document).ready(function() {
	        $('html, body').hide();

	        if (window.location.hash) {
	            setTimeout(function() {
	                $('html, body').scrollTop(0).show();
	                $('html, body').animate({
	                    scrollTop: $(window.location.hash).offset().top-20
	                    }, 1000)
	            }, 0);
	        }
	        else {
	            $('html, body').show();
	        }
	    });
	    </script>
    </body>
</html>