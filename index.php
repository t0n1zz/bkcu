<?php
require_once("includes/function.php");
require_once("includes/database.php");
require_once('includes/session_public.php');
require_once("includes/saran.php");

$saran = new saran();

if(isset($_POST['kirim'])){
	$errors = array();
	$field_array = array('saran');
	$errors = array_merge($errors, cek_field($field_array,$_POST));

	if(empty($errors)){
		date_default_timezone_set('Asia/Jakarta');
		$dt = time();
		$waktu = strftime("%Y-%m-%d %H:%M:%S", $dt);
		$saran->content = $_POST['saran'];
		$saran->tanggal = $waktu;

		if($saran->save()){
		   $session2->pesan("Terima kasih atas masukkan yang anda berikan.");
		   redirect_to("index.php#saran");
		}else{
		   redirect_to("index.php");
		}
	}else{
		redirect_to("index.php");
	}
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

        <!-- Homepage Slider -->
        <?php include("part/slider.php"); ?>
        <!-- End Homepage Slider -->


		<!-- pengumuman-->
		<?php include("part/pengumuman.php"); ?>
		<!-- End pengumuman -->

		<!-- Press berita -->
        <div class="section">
	    	<div class="container">
				<?php 
					$sql_kategori_berita = "SELECT * FROM " . kategori_artikel::$nama_tabel;
					$sql_kategori_berita .=" WHERE id NOT IN (1)";
					include("part/berita.php"); 
				?>
			</div>
		</div>
		<!-- Press berita -->

		<!-- Solusi -->
        <div class="section section-breadcrumbs">
	        <div class="container">
	        <h2 style="color: #FFFFFF;border-bottom: 2px solid #FFFFFF;">Solusi</h2>
	        	<?php include("part/layanan.php"); ?>
	        </div>
	    </div>
	    <!-- End Solusi -->


		<!-- Agenda Diklat-->
	    <div class="section">
	    	<div class="container">
	    		<h2>Agenda Diklat</h2>
				<?php 
					require_once("includes/kegiatan.php");
					$sql_agenda = "SELECT * FROM " .kegiatan::$nama_tabel;
					$sql_agenda .=" ORDER BY Tanggal asc";
					$sql_agenda .=" LIMIT 6";
					$fullpage = 0; 
					include("part/agenda.php"); 
				?>						
	    	</div>
	    </div>
	    <!-- End Agenda Diklat -->

	    <!-- Call to Action Bar -->
	    <div class="section section-white" id="saran">
			<div class="container" >
				<div class="row">
					<div class="col-md-12">
						<div class="calltoaction-wrapper">
							<?php
						      if(!empty($pesan)){
						        echo "<i class=\"fa fa-check-circle fa-3x\"></i><br /><h3>Terima kasih atas kesan atau saran anda </h3>";
						      }else{
						        echo "<h3>Bagaimana kesan atau saran anda mengenai website ini?</h3> <button 
						        class=\"btn btn-orange modal1\">Beritahu Kami</button>";
						      }
						    ?>						
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End Call to Action Bar -->

		<!-- Kegiatan Kami -->
	    <div class="section">
	    	<div class="container">
	    		<h2>Kegiatan Kami</h2>
				<div class="row">
					<div class="col-md-12">
						<div class="products-slider">
						<?php include("part/gambar_kegiatan.php"); ?>
						</div>
					</div>
				</div>
			</div>
	    </div>
	    <!-- End Kegiatan Kami -->

	    <!-- Footer -->
	    <?php include("part/footer.php"); ?>

	    <div class="modal fade" id="modalphotoshow">
		    <div class="modal-body">
		      <img class="pointer img-responsive center-block" src="" id="modalimage"/>
		    </div>
		</div>

		<!-- feedback -->
	    <div class="modal fade" id="modal1show" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	       <form role="form" action="index.php" method="post">
	        <div class="modal-dialog">
	          <div class="modal-content">
	            <div class="modal-header">
	              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	              <h4 class="modal-title ">Kesan atau Saran</h4>
	            </div>
	            <div class="modal-body">
	              <strong>Beritahu kami kesan atau saran atas website Puskopdit BKCU Kalimantan yang baru </strong> 
	              <br />
	              <br />
	              <input type="text" class="form-control" name="saran" placeholder="Silahkan masukkan kesan dan saran anda" />
	            </div>
	            <div class="modal-footer">
	              <button type="submit" class="btn btn-primary" name="kirim"
	                    id="modalbutton">Ok</button>
	              <button type="button" class="btn btn-red" data-dismiss="modal"> Batal</button>
	            </div>
	          </div><!-- /.modal-content -->
	        </div><!-- /.modal-dialog -->
	       </form>
	    </div>
	    <!-- /feedback -->


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