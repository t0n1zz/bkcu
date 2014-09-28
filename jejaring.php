<?php
require_once("includes/function.php");
require_once("includes/database.php");
require_once("includes/cuprimer.php");
require_once("includes/wilayah_cuprimer.php")
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
						<h1>Jejaring</h1>
					</div>
				</div>
			</div>
		</div>

		<div class="section ">
	        <div class="container">
	        <h2 id="link">Link </h2>
	        	<div class="row">
	        		<div class="col-md-4 col-sm-6">
						<div class="portfolio-item">
						<a href="http://woccu.org/" target="_blank">
							<div class="portfolio-image">
								<img src="images/woccu.jpg" class="img-rounded" alt="woccu">
							</div>
							<div class="portfolio-info-fade">
								<ul>
									<li class="portfolio-project-name">Website WOCCU</li>
								</ul>
							</div>
						</a>
						</div>
					</div>
					<div class="col-md-4 col-sm-6">
						<div class="portfolio-item">
						<a href="http://www.aaccu.coop/" target="_blank">
							<div class="portfolio-image">
								<img src="images/accu.jpg" class="img-rounded" alt="accu" >
							</div>
							<div class="portfolio-info-fade">
								<ul>
									<li class="portfolio-project-name">Website ACCU</li>
								</ul>
							</div>
						</a>
						</div>
					</div>
					<div class="col-md-4 col-sm-6">
						<div class="portfolio-item">
						<a href="http://www.cucoindo.org/" target="_blank">
							<div class="portfolio-image">
								<img src="images/cuco.jpg" class="img-rounded" alt="cuco">
							</div>
							<div class="portfolio-info-fade">
								<ul>
									<li class="portfolio-project-name">Website Inkopdit</li>
								</ul>
							</div>
						</a>
						</div>
					</div>
	        	</div>	
	        </div>
	    </div>
        
        <div class="section section-white">
	    	<div class="container">
	    	<h2 id="anggota" >Anggota Puskopdit BKCU Kalimantan </h2>
				<div class="row">
					<div class="col-md-4 col-sm-6">
						<ul class="sitemap">
							<li>
								<a href="#A1" class="smoothscroll" style="border-bottom: 2px solid #53555c;line-height: 1.5em;margin: 30px 0;">CU Wilayah Kalimantan Barat</a>
								<ul>
								<?php
					                $sql_jejaring = "SELECT * FROM " .cuprimer::$nama_tabel;
					                $sql_jejaring .= " WHERE wilayah=1";

					                $results = $database->query($sql_jejaring);
					                $nResults = mysql_num_rows($results);
					                if($nResults > 0){
					                    while($row = $database->fetch_array($results)){ 
					                    	echo "<li><a class=\"smoothscroll\" href=\"#{$row['id']}\">{$row['name']}</a></li>";
					                    }
					                }else{
					                    echo "<li>Belum terdapat informasi cu.</li>";
					                }
					            ?>
								</ul>
							</li>
							<li>
								<a href="#A2" class="smoothscroll" style="border-bottom: 2px solid #53555c;line-height: 1.5em;margin: 30px 0;">CU Wilayah Kalimantan Timur</a>
								<ul>
								<?php
					                $sql_jejaring = "SELECT * FROM " .cuprimer::$nama_tabel;
					                $sql_jejaring .= " WHERE wilayah=2";

					                $results = $database->query($sql_jejaring);
					                $nResults = mysql_num_rows($results);
					                if($nResults > 0){
					                    while($row = $database->fetch_array($results)){ 
					                    	echo "<li><a class=\"smoothscroll\" href=\"#{$row['id']}\">{$row['name']}</a></li>";
					                    }
					                }else{
					                    echo "<li>Belum terdapat informasi cu.</li>";
					                }
					            ?>
								</ul>
							</li>
							<li>
								<a href="#A3" class="smoothscroll" style="border-bottom: 2px solid #53555c;line-height: 1.5em;margin: 30px 0;">CU Wilayah Kalimantan Tengah</a>
								<ul>
								<?php
					                $sql_jejaring = "SELECT * FROM " .cuprimer::$nama_tabel;
					                $sql_jejaring .= " WHERE wilayah=3";

					                $results = $database->query($sql_jejaring);
					                $nResults = mysql_num_rows($results);
					                if($nResults > 0){
					                    while($row = $database->fetch_array($results)){ 
					                    	echo "<li><a class=\"smoothscroll\" href=\"#{$row['id']}\">{$row['name']}</a></li>";
					                    }
					                }else{
					                    echo "<li>Belum terdapat informasi cu.</li>";
					                }
					            ?>
								</ul>
							</li>
							<li>
								<a href="#A10" class="smoothscroll" style="border-bottom: 2px solid #53555c;line-height: 1.5em;margin: 30px 0;">CU Wilayah Kalimantan Utara</a>
								<ul>
								<?php
					                $sql_jejaring = "SELECT * FROM " .cuprimer::$nama_tabel;
					                $sql_jejaring .= " WHERE wilayah=10";

					                $results = $database->query($sql_jejaring);
					                $nResults = mysql_num_rows($results);
					                if($nResults > 0){
					                    while($row = $database->fetch_array($results)){ 
					                    	echo "<li><a class=\"smoothscroll\" href=\"#{$row['id']}\">{$row['name']}</a></li>";
					                    }
					                }else{
					                    echo "<li>Belum terdapat informasi cu.</li>";
					                }
					            ?>
								</ul>
							</li>
						</ul>
					</div>
					<div class="col-md-4 col-sm-6">
						<ul class="sitemap">
							<li>
								<a href="#A4" class="smoothscroll" style="border-bottom: 2px solid #53555c;line-height: 1.5em;margin: 30px 0;">CU Wilayah DKI, DIY dan Jawa</a>
								<ul>
								<?php
					                $sql_jejaring = "SELECT * FROM " .cuprimer::$nama_tabel;
					                $sql_jejaring .= " WHERE wilayah=4";

					                $results = $database->query($sql_jejaring);
					                $nResults = mysql_num_rows($results);
					                if($nResults > 0){
					                    while($row = $database->fetch_array($results)){ 
					                    	echo "<li><a class=\"smoothscroll\" href=\"#{$row['id']}\">{$row['name']}</a></li>";
					                    }
					                }else{
					                    echo "<li>Belum terdapat informasi cu.</li>";
					                }
					            ?>
								</ul>
							</li>
							<li>
								<a href="#A5" class="smoothscroll" style="border-bottom: 2px solid #53555c;line-height: 1.5em;margin: 30px 0;">CU Wilayah Sulawesi dan Maluku</a>
								<ul>
								<?php
					                $sql_jejaring = "SELECT * FROM " .cuprimer::$nama_tabel;
					                $sql_jejaring .= " WHERE wilayah=5";

					                $results = $database->query($sql_jejaring);
					                $nResults = mysql_num_rows($results);
					                if($nResults > 0){
					                    while($row = $database->fetch_array($results)){ 
					                    	echo "<li><a class=\"smoothscroll\" href=\"#{$row['id']}\">{$row['name']}</a></li>";
					                    }
					                }else{
					                    echo "<li>Belum terdapat informasi cu.</li>";
					                }
					            ?>
								</ul>
							</li>
							<li>
								<a href="#A6" class="smoothscroll" style="border-bottom: 2px solid #53555c;line-height: 1.5em;margin: 30px 0;">CU Wilayah Kepulauan Riau</a>
								<ul>
								<?php
					                $sql_jejaring = "SELECT * FROM " .cuprimer::$nama_tabel;
					                $sql_jejaring .= " WHERE wilayah=6";

					                $results = $database->query($sql_jejaring);
					                $nResults = mysql_num_rows($results);
					                if($nResults > 0){
					                    while($row = $database->fetch_array($results)){ 
					                    	echo "<li><a class=\"smoothscroll\" href=\"#{$row['id']}\">{$row['name']}</a></li>";
					                    }
					                }else{
					                    echo "<li>Belum terdapat informasi cu.</li>";
					                }
					            ?>
								</ul>
							</li>
						</ul>
					</div>
					<div class="col-md-4 col-sm-6">
						<ul class="sitemap">
							<li>
								<a href="#A7" class="smoothscroll" style="border-bottom: 2px solid #53555c;line-height: 1.5em;margin: 30px 0;">CU Wilayah Nusa Tenggara Timur</a>
								<ul>
								<?php
					                $sql_jejaring = "SELECT * FROM " .cuprimer::$nama_tabel;
					                $sql_jejaring .= " WHERE wilayah=7";

					                $results = $database->query($sql_jejaring);
					                $nResults = mysql_num_rows($results);
					                if($nResults > 0){
					                    while($row = $database->fetch_array($results)){ 
					                    	echo "<li><a class=\"smoothscroll\" href=\"#{$row['id']}\">{$row['name']}</a></li>";
					                    }
					                }else{
					                    echo "<li>Belum terdapat informasi cu.</li>";
					                }
					            ?>
								</ul>
							</li>
							<li>
								<a href="#A8" class="smoothscroll" style="border-bottom: 2px solid #53555c;line-height: 1.5em;margin: 30px 0;">CU Wilayah Papua</a>
								<ul>
								<?php
					                $sql_jejaring = "SELECT * FROM " .cuprimer::$nama_tabel;
					                $sql_jejaring .= " WHERE wilayah=8";

					                $results = $database->query($sql_jejaring);
					                $nResults = mysql_num_rows($results);
					                if($nResults > 0){
					                    while($row = $database->fetch_array($results)){ 
					                    	echo "<li><a class=\"smoothscroll\" href=\"#{$row['id']}\">{$row['name']}</a></li>";
					                    }
					                }else{
					                    echo "<li>Belum terdapat informasi cu.</li>";
					                }
					            ?>
								</ul>
							</li>
							<li>
								<a href="#A9" class="smoothscroll" style="border-bottom: 2px solid #53555c;line-height: 1.5em;margin: 30px 0;">CU Wilayah Sumatera</a>
								<ul>
								<?php
					                $sql_jejaring = "SELECT * FROM " .cuprimer::$nama_tabel;
					                $sql_jejaring .= " WHERE wilayah=9";

					                $results = $database->query($sql_jejaring);
					                $nResults = mysql_num_rows($results);
					                if($nResults > 0){
					                    while($row = $database->fetch_array($results)){ 
					                    	echo "<li><a class=\"smoothscroll\" href=\"#{$row['id']}\">{$row['name']}</a></li>";
					                    }
					                }else{
					                    echo "<li>Belum terdapat informasi cu.</li>";
					                }
					            ?>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>

	    <div class="eshop-section section">
	    	<div class="container">
	    	<?php
	    		$sql_wilayah_cu = "SELECT * FROM " .wilayah_cuprimer::$nama_tabel;

		    	$results = $database->query($sql_wilayah_cu);
				$nResults = mysql_num_rows($results);
				if($nResults > 0){
					
					while($row = $database->fetch_array($results)){

						$output ="<h2 id=A{$row['id']}>CU Wilayah {$row['name']}</h2>";
						$output .="<div class=\"row\">";
						
							$sql_cu = "SELECT * FROM " .cuprimer::$nama_tabel; 
						    $sql_cu .=" WHERE wilayah={$row['id']}";

						    $results2 = $database->query($sql_cu);
						    $nResults2 = mysql_num_rows($results2);
						    if($nResults2 > 0){
						    	$i = 0;
						    	while($row2 = $database->fetch_array($results2)){
						    		
						    		if($i % 4 == 0 || $i == 0){
										$output .="<div class=\"row\">";
									}

									$output .="<div class=\"col-md-3 col-sm-6\" id={$row2['id']}>";
										$output .="<div class=\"blog-post\">";
											$output .="<div class=\"post-title\">";
												$output .="<h3>{$row2['name']}</h3>";
											$output .="</div>";
											$output .="<div class=\"post-summary\">";
												$output .="<div class=\"actions\">";
													$content = html_entity_decode($row2['content']);
													$output .=$content;
												$output .="</div>";
											$output .="</div>";
										$output .="</div>";
									$output .="</div>";

									$i++;	
									if($i % 4 == 0 || $i == $nResults2){
										$output .="</div>";
									}

						    	}
						    }else{
						    	$output .="<div class=\"row\">";
									$output .="<div class=\"col-sm-12\">";
									$output .="<h3>Belum terdapat CU Primer di wilayah ini...</h3>";
				                    $output .="</div>";
								$output .="</div>";
						    }

						$output .="</div>";
						echo $output;
					}
				}
			?>
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