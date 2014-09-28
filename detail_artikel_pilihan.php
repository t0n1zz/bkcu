<?php
require_once("includes/function.php");
require_once("includes/database.php");
require_once("includes/artikel_pilihan.php");

$artikel_pilihan = new artikel_pilihan();
$thispage = 2;


if(isset($_POST['cari'])){
	if(preg_match("/^[  a-zA-Z]+/", $_POST['textcari'])){ 
		$cari = $_POST['textcari'];	
	}
	redirect_to("cari.php?cari={$cari}");
}if(isset($_GET['i'])){   
    $id = $_GET['i'];
    $artikel_pilihan->id = $id;
    $tampil_artikel = $artikel_pilihan->get_artikel_by_id();

    if(!empty($tampil_artikel)){
        $title = "Artikel Pilihan";
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
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/icomoon-social.css">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,600,800' rel='stylesheet' type='text/css'>
		<link href="admin/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<!--[if lte IE 8]>
		    <link rel="stylesheet" href="css/leaflet.ie.css" />
		<![endif]-->
		<link rel="stylesheet" href="css/main.css">
        <script>
			  window.fbAsyncInit = function() {
			    FB.init({
			      appId      : '296017390598287',
			      xfbml      : true,
			      version    : 'v2.1'
			    });
			  };

			  (function(d, s, id){
			     var js, fjs = d.getElementsByTagName(s)[0];
			     if (d.getElementById(id)) {return;}
			     js = d.createElement(s); js.id = id;
			     js.src = "//connect.facebook.net/en_US/sdk.js";
			     fjs.parentNode.insertBefore(js, fjs);
			   }(document, 'script', 'facebook-jssdk'));
		</script>
		<script>
		!function(d,s,id){
			var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';
			if(!d.getElementById(id)){
				js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';
				fjs.parentNode.insertBefore(js,fjs);
		}}
		(document, 'script', 'twitter-wjs');
		</script>
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
							<div class="single-post-title">
								<h3><?php echo $tampil_artikel['judul']; ?></h3>
							</div>
							<br />
							<div class="single-post-info">
							<?php
								$phpdate = strtotime( $tampil_artikel['tanggal'] );
	                            $mysqldate = date( 'F j, Y, g:i a ', $phpdate );
	                        ?>
								<i class="fa fa-clock-o"></i><?php echo $mysqldate; ?></a>
								<div>
									<a href="https://twitter.com/share" 
									class="twitter-share-button" data-text="<?php echo $tampil_artikel['judul'];?>" >Tweet</a>
								</div>
								<div
								  class="fb-like"
								  data-layout="button_count"
								  data-share="true"
								  data-show-faces="false"
								  data-width="450">
								</div>
							</div>
							<div class="single-post-image">
							<?php
				                if(!empty($tampil_artikel)){                   
				                    if(!empty($tampil_artikel['gambar'])){
				                        echo "<img class=\"img-responsive\" src=\"images_pilihan/{$tampil_artikel['gambar']}\"
				                        		alt=\"{$tampil_artikel['judul']}\" />";
				                    }
				                    
				                }
				            ?>
							</div>
							<div class="single-post-content">
							<?php
								$content = html_entity_decode($tampil_artikel['content']);                            
                        		echo "{$content}";
							?>	
							</div>
						</div>
					</div>
					<!-- End Blog Post -->
					<!-- Sidebar -->
					<div class="col-sm-4 blog-sidebar">
						<h4>Pencarian Artikel</h4>
						<form action="detail_artikel.php" method="post">
							<div class="input-group">
								<input class="form-control input-md" id="appendedInputButtons" type="text" name="textcari" placeholder="Masukkan Kata Kunci">
								<span class="input-group-btn">
									<button class="btn btn-md" type="submit" name="cari"><i class="fa fa-search"></i></button>
								</span>
							</div>
						</form>
						<h4>Artikel Terbaru</h4>
						<ul class="recent-posts">
						<?php
							require_once("includes/artikel.php");

							$sql_berita = "SELECT * FROM " .artikel::$nama_tabel;
							$sql_berita .=" WHERE kategori NOT IN (1)"; 
						    $sql_berita .=" AND status=1";
						    $sql_berita .=" ORDER BY tanggal desc";
						    $sql_berita .=" LIMIT 6";

						    $results = $database->query($sql_berita);
						    $nResults = mysql_num_rows($results);
						    if($nResults > 0){
						    	$i = 0;
						    	while($row = $database->fetch_array($results)){
						    		echo "<li><a href=\"detail_artikel.php?i={$row['id']}\">{$row['judul']}</a></li>";
						    	}
						    }else{
						    	echo "<li>Belum terdapat artikel...</li>";
						    }
						?>
						</ul>

						<h4>Artikel Terkait</h4>
						<ul class="recent-posts">
						<?php
							$query = "SELECT judul FROM " .artikel_pilihan::$nama_tabel;
		                    $query .=" WHERE id ='" .$id. "'";
		                    $hasil = $database->query($query); 
		                    $data = $database->fetch_array($hasil);
		                    $judul = $data['judul'];
		                    $arraysementara = Array();

		                    $sql_related = "SELECT * FROM " .artikel_pilihan::$nama_tabel;
		                    $sql_related .=" WHERE id <> '" .$id. "' AND ";
		                    $sql_related .=" status=1";

		                    $results = $database->query($sql_related);
							$nResults = mysql_num_rows($results);
						    if($nResults > 0){
						    	$i = 0;
						    	while($row = $database->fetch_array($results)){
						    		echo "<li><a href=\"detail_artikel.php?i={$row['id']}\">{$row['judul']}</a></li>";
						    	}
						    }else{
						    	echo "<li>Belum terdapat artikel...</li>";
						    }
						?>
						</ul>

						<h4>Kategori</h4>
						<ul class="blog-categories">
						<?php
							require_once("includes/kategori_artikel.php");

							$sql_kategori_berita = "SELECT * FROM " . kategori_artikel::$nama_tabel;
							$sql_kategori_berita .=" WHERE id NOT IN (1)";

							$results = $database->query($sql_kategori_berita);
							$nResults = mysql_num_rows($results);
							if($nResults > 0){
								while($row = $database->fetch_array($results)){
									echo "<li><a href=\"list_artikel.php?i={$row['id']}\">{$row['name']}</a></li>";
								}
							}else{
						    	echo "<li>Belum terdapat kategori...</li>";
						    }
						?>
						</ul>
					</div>
					<!-- End Sidebar -->
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
    </body>
</html>