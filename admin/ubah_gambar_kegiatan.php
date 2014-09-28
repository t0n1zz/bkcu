<?php
require_once("../includes/function.php");
require_once("../includes/database.php");
require_once('../includes/session_admin.php');
require_once("../includes/gambar_kegiatan.php");
require_once("../includes/resize_image.php");

if(!$session->is_logged_in()){
    $session->pesan("anda harus login terlebih dahulu");
    redirect_to("login.php");
}

$max_file_size = 5048576;
$upload_errors = array(
   // http://www.php.net/manual/en/features.file-upload.errors.php
  UPLOAD_ERR_OK         => "Tidak Terdapat Error.",
  UPLOAD_ERR_INI_SIZE   => "Ukuran file melebihi batasan upload php.",
  UPLOAD_ERR_FORM_SIZE  => "Ukuran file terlalu besar.",
  UPLOAD_ERR_PARTIAL    => "Partial upload.",
  UPLOAD_ERR_NO_FILE    => "Tidak ditemukan file.",
  UPLOAD_ERR_NO_TMP_DIR => "Tidak ditemukan direktori sementara.",
  UPLOAD_ERR_CANT_WRITE => "Tidak bisa memindahkan file.",
  UPLOAD_ERR_EXTENSION  => "Upload file terhenti."
);

$gambar_kegiatan = new gambar_kegiatan();
$resize_image = new resize_image();
$thispage = "ubah_gambar_kegiatan";

if(isset($_POST['simpan'])){
    $errors = array();
    $field_array = array('name');
    $errors = array_merge($errors, cek_field($field_array,$_POST));

    if(empty($errors)){
    	if ($_FILES['upload_file']['error'] < 1) {

            date_default_timezone_set('Asia/Jakarta');
            $dt = time();
            $waktu = strftime("%Y-%m-%d %H:%M:%S", $dt);
            $gambar_kegiatan->tanggal = $waktu;

            $gambar_kegiatan->id = $_POST['id'];  
            $gambar_kegiatan->name = $_POST['name'];
            $name = $_POST['name'];
            $gambar_kegiatan->upload_gambar($_FILES['upload_file']['tmp_name']);
                        
            if($gambar_kegiatan->save()){
                if(isset($_POST['simpan'])){
                    $session->pesan("Berhasil mengubah gambar kegiatan {$name}");
                    redirect_to("tampil_gambar_kegiatan.php");
                }
            }else{
                $message = "Gagal mengubah gambar kegiatan : " . mysql_error();
            }
		} else{
            $message = $upload_errors[$error];
	    }
    }else
        $message = "Gagal mengubah gambar kegiatan : " . mysql_error();
}


if(isset($_POST['batal'])){
    redirect_to("tampil_gambar_kegiatan.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Puskopdit BKCU Kalimantan Admin Site -- Ubah Gambar Kegiatan</title>
    <link rel="shortcut icon" href="../images/logo.png"> 
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="css/plugins/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link href="../css/mystyle.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <?php include_once("component/header.php"); ?>
            <?php include_once("component/sidebar.php"); ?>
        </nav>
             
        <?php
            if(isset($_GET['gambar'])){
                $gambar_kegiatan->id = $_GET['gambar'];
                $sel_gambar = $gambar_kegiatan->get_subject_by_id();
            }else{
                redirect_to("wrong.php");
            }
        ?>
        
        <!-- Content -->
        <div id="page-wrapper">
            <!-- header -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><span class="fa fa-pencil"></span> Ubah Gambar Kegiatan</h1>
                </div>           
            </div>
            <!-- /header --> 
            <!-- alert -->
                <?php
                    if(!empty($pesan)){
                        $output ="<div class=\"alert alert-success alert-dismissable\">";
                        $output .="<button type=\"button\" class=\"close\" data-dismiss=\"alert\" 
                                aria-hidden=\"true\">&times;</button>";
                        $output .=$pesan ."<br />";
                        $output .="</div>";
                        echo $output;
                    }
                ?>           
                 <?php
                    if(!empty($message)){
                        $output ="<div class=\"alert alert-warning alert-dismissible\" role=\"alert\">";
                        $output .="<button type=\"button\" class=\"close\" data-dismiss=\"alert\"><span 
                                        aria-hidden=\"true\">&times;</span><span class=\"sr-only\">Close</span></button>";
                        $output .=$message ."<br />";
                        if(!empty($errors)){
                            $output .="Ada kesalahan pada bagian : <br />";
                            foreach($errors as $error){
                                $output .= " - " . $error . "<br />";
                            }
                        }
                        $output .="</div>";
                        echo $output;
                    }
                ?>
              <!-- /alert --> 
                <form role="form" method="post" action="ubah_gambar_kegiatan.php?gambar=<?php echo $sel_gambar['id']; ?>" enctype="multipart/form-data">
                <div class="panel panel-default">
                    <!--button-->
                    <div class="panel-heading tooltip-demo">
                        <button type="submit" name="simpan" data-toggle="tooltip" data-placement="top" 
                                    title="Menyimpan gambar kegiatan" class="btn btn-default"><span class="fa fa-save"></span> Simpan</button>
                        <button type="submit" name="batal" data-toggle="tooltip" data-placement="top" 
                                    title="Batal mengubah gambar kegiatan dan kembali ke halaman Kelola gambar kegiatan" 
                                    class="btn btn-default"><span class="fa fa-times-circle"></span> Batal</button>
                    </div>
                    <!--/button-->
                    <div class="panel-body">
                        <input type="text" name="id" value="<?php echo $sel_gambar['id']; ?>" hidden />
                        <!--judul-->
                        <div class="col-lg-10">
                        <div class="form-group">
                            <label>Deskripsi Singkat</label>
                            <?php
                                $show_name = $sel_gambar['name'];
                                if(!empty($show_name))
                                    echo "<input type=\"text\" name=\"name\" class=\"form-control\" 
                                            placeholder=\"Silahkan masukkan deskripsi singkat gambar\" value=\"$show_name\" />";
                                else
                                    echo "<input type=\"text\" name=\"name\" class=\"form-control\" 
                                            placeholder=\"Silahkan masukkan ndeskripsi singkat gambar\" value=\"\" />";
                            ?>
                        </div>
                        </div>
                        <!--/judul-->
                        <!--gambar-->
                        <div class="col-lg-5">
                        <label>Upload Gambar</label>
                            <div class="thumbnail">
                                <img class="img-responsive" src="<?php
                                            $gambar = $sel_gambar['gambar'];
                                            $gambar = str_replace(' ', '%20', $gambar);
                                            if(!empty($gambar) && is_file("../images_kegiatan/{$gambar}"))
                                                echo "../images_kegiatan/{$gambar}";
                                            else
                                                echo "../images/no_image.jpg";
                                        ?> "
                                        id="tampilgambar"
                                        alt="Generic placeholder image" style="width: 300px;; height: 200px;">
                             <div class="caption">
                                <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size; ?>" />
                                <input onChange="readURL(this);" type="file" name="upload_file" 
                                        accept="image/jpeg" value=<?php
                                            if(!empty($sel_gambar['gambar']))
                                                echo $sel_gambar['gambar'];
                                        ?>
                                        />
                             </div>
                            </div>
                        </div>
                        <!--/gambar-->
                    </div>
                 </div>
                 </form>
                 </div>
             </div>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery Version 1.11.0 -->
    <script src="js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="js/plugins/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>

    <script src="../js/myscript.js"></script>

</body>

</html>
