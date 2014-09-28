<?php
require_once("includes/function.php");
require_once("includes/database.php");
require_once("includes/kegiatan.php"); 

if(isset($_GET['januari'])){
    $selected = "1";
}elseif(isset($_GET['februari'])){
    $selected = "2";
}elseif(isset($_GET['maret'])){
    $selected = "3";
}elseif(isset($_GET['april'])){
    $selected = "4";
}elseif(isset($_GET['mei'])){
    $selected = "5";
}elseif(isset($_GET['juni'])){
    $selected = "6";
}elseif(isset($_GET['juli'])){
    $selected = "7";
}elseif(isset($_GET['agustus'])){
    $selected = "8";
}elseif(isset($_GET['september'])){
    $selected = "9";
}elseif(isset($_GET['oktober'])){
    $selected = "10";
}elseif(isset($_GET['november'])){
    $selected = "11";
}elseif(isset($_GET['desember'])){
    $selected = "12";
}else{
    $selected = "0";
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
						<h1>Agenda Diklat</h1>
					</div>
				</div>
			</div>
		</div>

		<div class="section">
	    	<div class="container">
				<h2>Bulan</h2>
				<a href="agenda_diklat.php" class="
	            <?php
	                if($selected == "0")
	                    echo "btn btn-primary";
	                else
	                    echo "btn btn-default";
	                    $sql_kegiatan_0 = "SELECT * FROM " .kegiatan::$nama_tabel;
	                    $bln0 = $database->query($sql_kegiatan_0);
	                    $nbln0 = mysql_num_rows($bln0);
	            ?> btn-block"><b>Semua Kegiatan</b> <span class="badge"><?php echo $nbln0; ?></span></a>
	          	<br />
	          	<br />
	          	<div class="btn-group btn-group-justified">
		            <div class="btn-group">
		                <a href="agenda_diklat.php?januari"class="
		                <?php
		                    if($selected == "1")
		                        echo "btn btn-primary";
		                    else
		                        echo "btn btn-default";
		                    $sql_kegiatan_1 = "SELECT * FROM " .kegiatan::$nama_tabel;
		                    $sql_kegiatan_1 .= " WHERE DATE_FORMAT(tanggal,'%c')='1'";
		                    $bln1 = $database->query($sql_kegiatan_1);
		                    $nbln1 = mysql_num_rows($bln1);
		                ?>"><b>January</b> <span class="badge"><?php echo $nbln1; ?></span></a>
		            </div>
		            <div class="btn-group">
		                <a href="agenda_diklat.php?februari"class="
		                <?php
		                    if($selected == "2")
		                        echo "btn btn-primary";
		                    else
		                        echo "btn btn-default";
		                    $sql_kegiatan_2 = "SELECT * FROM " .kegiatan::$nama_tabel;
		                    $sql_kegiatan_2 .= " WHERE DATE_FORMAT(tanggal,'%c')='2'";
		                    $bln2 = $database->query($sql_kegiatan_2);
		                    $nbln2 = mysql_num_rows($bln2);
		                ?>"><b>Februari</b> <span class="badge"><?php echo $nbln2; ?></span></a>
		            </div>
		            <div class="btn-group">
		                <a href="agenda_diklat.php?maret"class="
		                <?php
		                    if($selected == "3")
		                        echo "btn btn-primary";
		                    else
		                        echo "btn btn-default";
		                    $sql_kegiatan_3 = "SELECT * FROM " .kegiatan::$nama_tabel;
		                    $sql_kegiatan_3 .= " WHERE DATE_FORMAT(tanggal,'%c')='3'";
		                    $bln3 = $database->query($sql_kegiatan_3);
		                    $nbln3 = mysql_num_rows($bln3);
		                ?>"><b>Maret</b> <span class="badge"><?php echo $nbln3; ?></span></a>
		            </div>
		            <div class="btn-group">
		                <a href="agenda_diklat.php?april"class="
		                <?php
		                    if($selected == "4")
		                        echo "btn btn-primary";
		                    else
		                        echo "btn btn-default";
		                    $sql_kegiatan_4 = "SELECT * FROM " .kegiatan::$nama_tabel;
		                    $sql_kegiatan_4 .= " WHERE DATE_FORMAT(tanggal,'%c')='4'";
		                    $bln4 = $database->query($sql_kegiatan_4);
		                    $nbln4 = mysql_num_rows($bln4);
		                ?>"><b>April</b> <span class="badge"><?php echo $nbln4; ?></span></a>
		            </div>
		            <div class="btn-group">
		                <a href="agenda_diklat.php?mei"class="
		                <?php
		                    if($selected == "5")
		                        echo "btn btn-primary";
		                    else
		                        echo "btn btn-default";
		                    $sql_kegiatan_5 = "SELECT * FROM " .kegiatan::$nama_tabel;
		                    $sql_kegiatan_5 .= " WHERE DATE_FORMAT(tanggal,'%c')='5'";
		                    $bln5 = $database->query($sql_kegiatan_5);
		                    $nbln5 = mysql_num_rows($bln5);
		                ?>"><b>Mei</b> <span class="badge"><?php echo $nbln5; ?></span></a>
		            </div>
		            <div class="btn-group">
		                <a href="agenda_diklat.php?juni"class="
		                <?php
		                    if($selected == "6")
		                        echo "btn btn-primary";
		                    else
		                        echo "btn btn-default";
		                    $sql_kegiatan_6 = "SELECT * FROM " .kegiatan::$nama_tabel;
		                    $sql_kegiatan_6 .= " WHERE DATE_FORMAT(tanggal,'%c')='6'";
		                    $bln6 = $database->query($sql_kegiatan_6);
		                    $nbln6 = mysql_num_rows($bln6);
		                ?>"><b>Juni</b> <span class="badge"><?php echo $nbln6; ?></span></a>
		            </div>
		        </div>
		        <br/>
		        <div class="btn-group btn-group-justified">

		            <div class="btn-group">
		                <a href="agenda_diklat.php?juli"class="
		                <?php
		                    if($selected == "7")
		                        echo "btn btn-primary";
		                    else
		                        echo "btn btn-default";
		                    $sql_kegiatan_7 = "SELECT * FROM " .kegiatan::$nama_tabel;
		                    $sql_kegiatan_7 .= " WHERE DATE_FORMAT(tanggal,'%c')='7'";
		                    $bln7 = $database->query($sql_kegiatan_7);
		                    $nbln7 = mysql_num_rows($bln7);
		                ?>"><b>Juli</b> <span class="badge"><?php echo $nbln7; ?></span></a>
		            </div>
		            <div class="btn-group">
		                <a href="agenda_diklat.php?agustus"class="
		                <?php
		                    if($selected == "8")
		                        echo "btn btn-primary";
		                    else
		                        echo "btn btn-default";
		                    $sql_kegiatan_8 = "SELECT * FROM " .kegiatan::$nama_tabel;
		                    $sql_kegiatan_8 .= " WHERE DATE_FORMAT(tanggal,'%c')='8'";
		                    $bln8 = $database->query($sql_kegiatan_8);
		                    $nbln8 = mysql_num_rows($bln8);
		                ?>"><b>Agustus</b> <span class="badge"><?php echo $nbln8; ?></span></a>
		            </div>
		            <div class="btn-group">
		                <a href="agenda_diklat.php?september"class="
		                <?php
		                    if($selected == "9")
		                        echo "btn btn-primary";
		                    else
		                        echo "btn btn-default";
		                    $sql_kegiatan_9 = "SELECT * FROM " .kegiatan::$nama_tabel;
		                    $sql_kegiatan_9 .= " WHERE DATE_FORMAT(tanggal,'%c')='9'";
		                    $bln9 = $database->query($sql_kegiatan_9);
		                    $nbln9 = mysql_num_rows($bln9);
		                ?>"><b>September</b> <span class="badge"><?php echo $nbln9; ?></span></a>
		            </div>
		            <div class="btn-group">
		                <a href="agenda_diklat.php?oktober"class="
		                <?php
		                    if($selected == "10")
		                        echo "btn btn-primary";
		                    else
		                        echo "btn btn-default";
		                    $sql_kegiatan_10 = "SELECT * FROM " .kegiatan::$nama_tabel;
		                    $sql_kegiatan_10 .= " WHERE DATE_FORMAT(tanggal,'%c')='10'";
		                    $bln10 = $database->query($sql_kegiatan_10);
		                    $nbln10 = mysql_num_rows($bln10);
		                ?>"><b>Oktober</b> <span class="badge"><?php echo $nbln10; ?></span></a>
		            </div>
		            <div class="btn-group">
		                <a href="agenda_diklat.php?november"class="
		                <?php
		                    if($selected == "11")
		                        echo "btn btn-primary";
		                    else
		                        echo "btn btn-default";
		                    $sql_kegiatan_11 = "SELECT * FROM " .kegiatan::$nama_tabel;
		                    $sql_kegiatan_11 .= " WHERE DATE_FORMAT(tanggal,'%c')='11'";
		                    $bln11 = $database->query($sql_kegiatan_11);
		                    $nbln11 = mysql_num_rows($bln11);
		                ?>"><b>November</b> <span class="badge"><?php echo $nbln11; ?></span></a>
		            </div>
		            <div class="btn-group">
		                <a href="agenda_diklat.php?desember" class="
		                <?php
		                    if($selected == "12")
		                        echo "btn btn-primary";
		                    else
		                        echo "btn btn-default";
		                    $sql_kegiatan_12 = "SELECT * FROM " .kegiatan::$nama_tabel;
		                    $sql_kegiatan_12 .= " WHERE DATE_FORMAT(tanggal,'%c')='12'";
		                    $bln12 = $database->query($sql_kegiatan_12);
		                    $nbln12 = mysql_num_rows($bln12);
		                ?>"><b>Desember</b> <span class="badge"><?php echo $nbln12; ?></span></a>
		            </div>
		        </div> 
			</div>
		</div>
        
        <div class="section">
	    	<div class="container">
	    		<?php

					$sql_agenda = "SELECT * FROM " .kegiatan::$nama_tabel;

					if($selected > 0)
						$sql_agenda .=" WHERE DATE_FORMAT(tanggal,'%c')='{$selected}'";

					$sql_agenda .=" ORDER BY Tanggal asc";
					$fullpage = 1; 
					include("part/agenda.php"); 
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
  		
    </body>
</html>