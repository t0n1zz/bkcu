<?php
require_once("../includes/function.php");
require_once("../includes/database.php");
require_once('../includes/session_admin.php');
require_once("../includes/artikel.php");
require_once("../includes/kategori_artikel.php");
require_once("../includes/admin.php");

if(!$session->is_logged_in()){
    $session->pesan("Anda harus login terlebih dahulu");
    redirect_to("login.php");
}

$artikel = new artikel();
$kategori = new kategori_artikel();
$thispage = "artikel";

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

if(isset($_POST['simpan'])){
    $errors = array();
    if($_POST['kategori'] == "tambah"){
        $field_array = array('judul','content' , 'kategori_baru');
    }else{
        $field_array = array('judul','content' , 'kategori');
    }
    $errors = array_merge($errors, cek_field($field_array,$_POST));
    
    if(empty($errors)){
        $judul = $_POST['judul'];
        $content = $_POST['content'];
        $artikel->id = $_POST['id'];
        $artikel->judul = $judul;
        $artikel->penulis = $_POST['penulis'];
        $artikel->tanggal = $_POST['tanggal'];
        $artikel->status = $_POST['status'];
        if(isset($_POST['artikelpilihan']))
            $artikel->pilihan = $_POST['artikelpilihan'];

       
        $entity_content = htmlentities($content);
        $entity_content = stripslashes(str_replace('\r\n', '',$entity_content));
        $artikel->content = $entity_content;
        if(isset($_POST['gambarutama']))
            $gambarutama = $_POST['gambarutama'];

        if($gambarutama == 1){
            $error = $_FILES['upload_file']['error'];
            if ($error == 0 || $error == 4) {
                try{
                    if($_POST['kategori'] == "tambah"){
                        $kategori->name = $_POST['kategori_baru'];
                        if($kategori->validasi_duplikat()){
                            if($kategori->save()){
                                $kategori->name = $_POST['kategori_baru'];
                                $sel_kategori = $kategori->get_kategori();
                                $artikel->kategori = $sel_kategori['id'];

                                if($error != 4)
                                    $artikel->upload_gambar($_FILES['upload_file']['tmp_name']);

                                if($artikel->save()){
                                    if(isset($_POST['simpan'])){
                                        $session->pesan("Artikel {$judul} berhasil di ubah");
                                        redirect_to("tampil_artikel.php");
                                    }
                                }else{
                                    $message = "Gagal mengubah artikel";
                                }
                            }else{
                                $message = "Gagal menambah kategori artikel";
                            }
                        }else{
                            $message = "Gagal menambah kategori artikel : kategori artikel sudah ada";
                        }
                    }else{
                        $artikel->kategori = $_POST['kategori'];

                        if($error != 4)
                            $artikel->upload_gambar($_FILES['upload_file']['tmp_name']);

                        if($artikel->save()){
                            if(isset($_POST['simpan'])){
                                $session->pesan("Artikel {$judul} berhasil di ubah");
                                redirect_to("tampil_artikel.php");
                            }
                        }else{
                            $message = "Gagal mengubah artikel";
                        }
                    }
                }catch(PDOException $e){
                    $message = "Gagal menambah artikel";
                    error_notice($e);
                }
            }else
                $message = $upload_errors[$error];
        }else{
            try{
                if($_POST['kategori'] == "tambah"){
                    $kategori->name = $_POST['kategori_baru'];
                    if($kategori->validasi_duplikat()){

                        if($kategori->save()){
                            $kategori->name = $_POST['kategori_baru'];
                            $sel_kategori = $kategori->get_kategori();
                            $artikel->kategori = $sel_kategori['id'];
                            if($artikel->save()){
                                if(isset($_POST['simpan'])){
                                    $session->pesan("Artikel {$judul} berhasil di ubah");
                                    redirect_to("tampil_artikel.php");
                                }
                            }else{
                                $message = "Gagal mengubah artikel";
                            }
                        }else{
                            $message = "Gagal menambah kategori artikel";
                        }
                    }else{
                        $message = "Gagal menambah kategori artikel : kategori artikel sudah ada";
                    }
                }else{
                    $artikel->kategori = $_POST['kategori'];
                    if($artikel->save()){
                        if(isset($_POST['simpan'])){
                            $session->pesan("Artikel {$judul} berhasil di ubah");
                            redirect_to("tampil_artikel.php");
                        }
                    }else{
                        $message = "Gagal mengubah artikel";
                    }
                }
            }catch(PDOException $e){
                $message = "Gagal menambah artikel";
                error_notice($e);
            }
        }
              
    }else{
        $message = "Gagal menambah artikel";
    }
}

if(isset($_POST['batal'])){
    redirect_to("tampil_artikel.php");
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

    <title>Puskopdit BKCU Kalimantan Admin Site -- Ubah Artikel</title>
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
			if(isset($_GET['artikel'])){
				$artikel->id = $_GET['artikel'];
				$sel_artikel = $artikel->get_subject_by_id();
			}else{
				redirect_to("wrong.php");
			}
		?>
       
		<!-- Content -->
        <div id="page-wrapper">
           	<!-- header -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><span class="fa fa-pencil"></span> Ubah Artikel</h1>
                </div>           
            </div>
            <!-- /header --> 
            <!-- alert -->           
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
                <form role="form" method="post" action="ubah_artikel.php?artikel=<?php echo $sel_artikel['id']; ?>" enctype="multipart/form-data">
                <div class="panel panel-default">
                    <!--button-->
                    <div class="panel-heading tooltip-demo">
                        <button type="submit" name="simpan" data-toggle="tooltip" data-placement="top" 
                                    title="Menyimpan artikel" class="btn btn-default"><span class="fa fa-save"></span> Simpan</button>
                        <button type="submit" name="batal" data-toggle="tooltip" data-placement="top" 
                                    title="Batal menambah artikel dan kembali ke halaman Kelola Artikel" 
                                    class="btn btn-default"><span class="fa fa-times-circle"></span> Batal</button>
                    </div>
                    <!--/button-->
                    <div class="panel-body">
                        <input type="text" name="id" value="<?php echo $sel_artikel['id']; ?>" hidden />
                        <input type="text" name="penulis" value="<?php echo $sel_artikel['penulis']; ?>" hidden />
                        <input type="text" name="tanggal" value="<?php echo $sel_artikel['tanggal']; ?>" hidden />
                        <!--judul-->
                        <div class="col-lg-10">
                        <div class="form-group">
                            <label>Judul Artikel</label>
                            <?php
                                $show_judul = $sel_artikel['judul'];
                                if(!empty($show_judul))
                                    echo "<input type=\"text\" name=\"judul\" class=\"form-control\" 
                                            placeholder=\"Silahkan masukkan judul artikel\" value=\"$show_judul\" />";
                                else
                                    echo "<input type=\"text\" name=\"judul\" class=\"form-control\" 
                                            placeholder=\"Silahkan masukkan judul artikel\" value=\"\" />";
                            ?>
                        </div>
                        </div>
                        <!--/judul-->
                        <!--kategori-->
                        <div class="col-lg-4">
                        <div class="form-group">
                            <label>Kategori</label>
                            <select class="form-control" onChange="changeFunc(value);" name="kategori">
                            <option >Pilih Kategori Artikel</option>
                            <?php
                                $database->query("select * from ". kategori_artikel::$nama_tabel);
                                $database->execute();
                                while($row =$database->fetch()){
                                    $output = "<option value=\"{$row['id']}\"";
                                    if($sel_artikel['kategori'] == $row['id'])
                                        $output .=" selected ";
                                    $output .=">{$row['name']}</option>";
                                    echo $output;
                                }
                            ?>
                             <option 
                                <?php
                                    if($sel_artikel['kategori'] == 0)
                                        echo " selected";
                                ?>
                                >Lain-lain</option>
                            <option value="tambah">Tambah Kategori Baru</option>
                            </select>
                        </div>
                        </div>
                        <!--/kategori-->
                        <!--kategori baru-->
                        <div class="col-lg-4"  id="pilihan" style="display:none;">
                        <div class="form-group">
                            <label>Kategori Baru</label>
                            <input type="text" class="form-control" 
                                name="kategori_baru" placeholder="Masukkan Kategori Baru" maxlength="30">
                        </div>
                        </div>
                        <!--/kategori baru-->
                        <!--status-->
                        <div class="col-lg-4">
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status">
                            <option >Pilih Status Publikasi Artikel</option>
                            <option 
                                <?php
                                    if($sel_artikel['status'] == 0)
                                        echo " selected";
                                ?>
                            >Tidak diterbitkan</option>
                            <option value="1" 
                                <?php
                                if($sel_artikel['status'] == 1)
                                    echo " selected";
                                ?>
                            >Terbitkan</option>
                            </select>
                        </div>
                        </div>
                        <!--/status-->
                        <!--gambar utama-->
                        <div class="col-lg-5">
                        <div class="form-group">
                            <label>Tampilkan Gambar Utama</label>
                            <div class="input-group">
                            <span class="input-group-addon">
                                <input type="checkbox" id="tampilinputgambar" name="gambarutama" value="1"
                                <?php
                                    if(!empty($sel_artikel['gambar']))
                                        echo "checked";
                                ?>>
                            </span>
                            <input type="text" id="gambartext" class="form-control" disabled="true" value="<?php
                                    if(!empty($sel_artikel['gambar']))
                                        echo "Iya, gambar akan muncul di list artikel dan view artikel";
                                    else
                                        echo "tidak";
                            ?>">
                            </div>
                        </div>
                        <div id="inputgambar" 
                        <?php
                           if(empty($sel_artikel['gambar']))
                                echo 'style="display:none;"'; 
                        ?>
                        >
                            <div class="thumbnail" >
                                <img class="img-responsive" src="<?php
                                            $gambar = $sel_artikel['gambar'];
                                            $gambar = str_replace(' ', '%20', $gambar);
                                            if(!empty($gambar) && is_file("../images_artikel/{$gambar}"))
                                                echo "../images_artikel/{$gambar}";
                                            else
                                                echo "../images/no_image.jpg";
                                        ?> "
                                        id="tampilgambar">
                                 <div class="caption">
                                    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size; ?>" />
                                    <input onChange="readURL(this);" type="file" name="upload_file" 
                                            accept="image/jpeg"/>
                                 </div>
                            </div>
                        </div>
                        </div>
                        <!--/gambar utama-->
                        <!--artikel pilihan-->
                        <div class="col-lg-5">
                        <div class="form-group">
                            <label>Artikel Pilihan</label>
                            <div class="input-group">
                            <span class="input-group-addon">
                                <input type="checkbox" id="artikelpilihan" name="artikelpilihan" value="1"
                                <?php
                                    if(!empty($sel_artikel['pilihan']))
                                        echo "checked";
                                ?>>
                            </span>
                            <input type="text" id="artikeltext" class="form-control" disabled="true" value="<?php
                                if(!empty($sel_artikel['pilihan']))
                                    echo "Iya, artikel akan muncul di slideshow";
                            ?>">
                            </div>
                        </div>
                        </div>
                        <!--/artikel pilihan-->
                        <!--content-->
                        <div class="col-lg-12">
                            <label>Isi Artikel</label>
                            <textarea name="content" style="height:300px">
                                <?php
                                    $show_content = $sel_artikel['content'];
                                    if(!empty($show_content)){
                                        $fill_block = html_entity_decode($show_content);
                                        echo $fill_block;
                                    }
                                ?>
                            </textarea>
                        </div>
                        <!--/content-->
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

    <!-- DataTables JavaScript -->
    <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>

    <script type="text/javascript" src="../js/tinymce/tinymce.min.js"></script>
    <script type="text/javascript">
    tinymce.init({
        selector: "textarea",
        theme: "modern",
        skin: 'light',
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern"
        ],
        toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
        toolbar2: "print preview media | forecolor backcolor emoticons | fontselect fontsizeselect",
        image_advtab: true,
        templates: [
            {title: 'Test template 1', content: 'Test 1'},
            {title: 'Test template 2', content: 'Test 2'}
        ],
        file_browser_callback: RoxyFileBrowser
    });


    function RoxyFileBrowser(field_name, url, type, win) {
      var roxyFileman = '../js/tinymce/plugins/fileman/index.html?integration=tinymce4';
      if (roxyFileman.indexOf("?") < 0) {     
        roxyFileman += "?type=" + type;   
      }
      else {
        roxyFileman += "&type=" + type;
      }
      roxyFileman += '&input=' + field_name + '&value=' + document.getElementById(field_name).value;
      tinyMCE.activeEditor.windowManager.open({
         file: roxyFileman,
         title: 'File Manager',
         width: 800, 
         height: 480,
         resizable: "yes",
         plugins: "media",
         inline: "yes",
         close_previous: "no"  
      }, {     window: win,     input: field_name    });
      return false; 
    }
    </script>

	

    <script src="../js/myscript.js"></script>

</body>

</html>
