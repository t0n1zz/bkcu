<?php
require_once("includes/function.php");
require_once("includes/database.php");
require_once("includes/artikel.php");

$artikel = new artikel();
$artikel->id = 4;
$tampil_artikel = $artikel->get_artikel_by_id();
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

        <script src="https://maps.googleapis.com/maps/api/js"></script>
        <style>
          #map_canvas {
            width: 700px;
            height: 350px;
          }
        </style>
        <script>
          function initialize() {
            var mapCanvas = document.getElementById('map_canvas');
            var mapOptions = {
              center: new google.maps.LatLng(-0.03946, 109.34875),
              zoom: 18,
              mapTypeId: google.maps.MapTypeId.ROADMAP
            }
            var map = new google.maps.Map(mapCanvas, mapOptions)
            var iconBase = 'https://maps.google.com/mapfiles/kml/shapes/';
            var marker = new google.maps.Marker({
              position: new google.maps.LatLng(-0.03946, 109.34875),
              map: map,
              icon: iconBase + 'schools_maps.png'
            });
          }
          google.maps.event.addDomListener(window, 'load', initialize);
        </script>
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
                        <h1>Tentang Kami</h1>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <h2 id="tentang">Puskopdit BKCU Kalimantan</h2>
                        <p>
                            BKCU Kalimantan (awalnya BK3D Kalbar) berdiri pada tanggal 27 November 1988 di Pontianak.<br/><br/>
                            Sebagai credit union sekunder, BKCU Kalimantan aktif mempromosikan dan memfasilitasi berdirinya credit union - credit union primer.<br/>

                        </p>
                        <br/>
                        <h3>&nbsp Jaringan BKCU Kalimantan</h3>
                        <p>
                            Jaringan BKCU Kalimantan tersebar hampir ke seluruh wilayah Republik Indonesia.<br/>
                            Mayoritas credit union anggota BKCU Kalimantan berkembang dengan baik;aset dan jumlah anggota cukup kencang peningkatannya.<br/><br/>
                            Walaupun demikian, kami tetap menyadari masih diperlukan pembenahan-pembenahan baik internal maupun eksternal pada masa yang akan datang agar credit union mampu menghadapi berbagai dinamika yang terjadi.
                        </p>
                    </div>
                    <div class="col-sm-6">
                        <img src="images/bkcu.jpg" class="img-rounded" width="550">
                    </div>
                </div>
            </div>
        </div>

        <!-- Press Coverage -->
        <div class="section">
            <div class="container">
                <h2 id="visi"><?php echo $tampil_artikel['judul']; ?></h2>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                    <?php
                        $content = html_entity_decode($tampil_artikel['content']);                            
                        echo "{$content}";
                    ?>  
                    </div>
                </div>
            </div>
        </div>
        <!-- Press Coverage -->

        <div class="section">
            <div class="container">
                <h2 id="tim">Tim Kami</h2>
                <div class="row">
                <?php
                    require_once("includes/staff.php");
                    $sql_tim = "SELECT * FROM " . staff::$nama_tabel;

                    $results = $database->query($sql_tim);
                    $nResults = mysql_num_rows($results);
                    if($nResults > 0){
                        $i = 0;
                        while($row = $database->fetch_array($results)){
                            $output ="";
                            if($i % 4 == 0 || $i == 0){
                                $output .="<div class=\"row\">";
                            }
                            $output .="<div class=\"col-md-3 col-sm-6\">";
                                $output .="<div class=\"team-member\">";
                                    $output .="<div class=\"team-member-image\"><img src=\"images_staff/{$row['gambar']}\" 
                                                    alt=\"{$row['name']}\" class=\"img-rounded\" width=\"200\"></div>";
                                    $output .="<div class=\"team-member-info\">";
                                        $output .="<ul>";
                                            $output .="<li class=\"team-member-name\">{$row['name']}</li>";
                                            $output .="<li><b>{$row['jabatan']}</b></li>";
                                        $output .="</ul>";
                                    $output .="</div>";
                                $output .="</div>";
                            $output .="</div>";

                            $i++;   
                            if($i % 4 == 0 || $i == $nResults){
                                $output .="</div>";
                            }

                            echo $output;
                        }
                    }
                ?>              
                </div>
            </div>
        </div>

        <div class="section">
            <div class="container">
                <h2 id="temui">Temui Kami Di</h2>
                <div class="row">
                    <div class="col-sm-8">
                        <div id="map_canvas"></div>
                        <!--<div id="contact-us-map">
                        </div>-->
                    </div>
                    <div class="col-sm-4">
                    <?php
                        require_once("includes/kantor_pelayanan.php");
                        $sql_kantor_pusat = "SELECT * FROM " . kantor_pelayanan::$nama_tabel;
                        $sql_kantor_pusat .= " WHERE id=1";

                        $results = $database->query($sql_kantor_pusat);
                        $nResults = mysql_num_rows($results);
                        if($nResults > 0){
                           while($row = $database->fetch_array($results)){
                                $output ="<h3>Puskopdit BKCU Kalimantan <br/><small>{$row['name']}</small></h3><br>";
                                if(!empty($row['alamat']))
                                    $output .="{$row['alamat']}<br>";
                                if(!empty($row['alamat2']))
                                    $output .="{$row['alamat2']}<br>";
                                if(!empty($row['alamat3']) || !empty($row['pos']))
                                    $output .="{$row['alamat3']} {$row['pos']}<br>";
                                if(!empty($row['telp']) || !empty($row['fax']))
                                    $output .="Telp: {$row['telp']} Fax: {$row['fax']}<br>";
                                if(!empty($row['email']))
                                    $output .="<abbr title=\"Email\"><a href=\"mailto:{$row['email']}\" target=\"_top\">{$row['email']}</a>";   

                                echo $output;
                            }
                        }
                    ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="container">
                <h2 id="hadir">Kami juga Hadir Di</h2>
                <?php include("part/kantor_pelayanan.php"); ?>
            </div>
        </div>

        <div class="section">
            <div class="container">
                <h2 id="hadir">Artikel Terkait</h2>
                <ul class="recent-posts">
                    <li><a href="sejarah_bkcu.php">Sejarah Puskopdit BKCU Kalimantan</a></li>
                    <li><a href="hymne.php">Hymne Credit Union</a></li>
                </ul>
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