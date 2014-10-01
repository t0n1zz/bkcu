<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <!-- search -->
            <!--<li class="sidebar-search">
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                    <button class="btn btn-default" type="button">
                        <i class="fa fa-search"></i>
                    </button>
                </span>
                </div>                            
            </li>-->
            <!-- /search -->
            <!-- dashboard -->
            <li>
                <a  <?php if($thispage == "index") echo "class=\"active \"" ?>
                    href="index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
            </li>
            <!-- /dashboard -->
            <!-- pengumuman -->
            <li <?php 
                    if($thispage == "tambah_pengumuman" || $thispage == "tampil_pengumuman")
                         echo "class=\"active \"" 
                ?>
            ><a href="tampil_pengumuman.php"><i class="fa fa-comments-o fa-fw"></i> Pengumuman</a>
            </li>
            <!-- /pengumuman -->
            <!-- info gerakan -->
            <li>
                <a  <?php if($thispage == "info_gerakan") echo "class=\"active \"" ?>
                    href="ubah_info_gerakan.php"><i class="fa fa-exclamation-circle fa-fw"></i> Informasi Gerakan</a>
            </li>
            <!-- /info gerakan -->
            <!-- artikel -->
            <li <?php 
                    if($thispage == "artikel" ||$thispage == "tambah_artikel" 
                        || $thispage == "tampil_artikel" || $thispage == "tampil_kategori_artikel"
                        || $thispage == "tambah_artikel_pilihan" || $thispage == "tampil_artikel_pilihan"
                        || $thispage == "ubah_artikel_pilihan")
                         echo "class=\"active \"" 
                ?>
            ><a href="#"><i class="fa fa-book fa-fw"></i> Artikel<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a <?php if($thispage == "tambah_artikel") echo "class=\"active \"" ?>
                         href="tambah_artikel.php"><span class="fa fa-plus"></span> Tambah Artikel</a>
                    </li>
                    <li>
                        <a <?php if($thispage == "tampil_artikel") echo "class=\"active \"" ?>
                        href="tampil_artikel.php"><span class="fa fa-archive"></span> Kelola Artikel</a>
                    </li>
                    <li>
                        <a <?php if($thispage == "tampil_kategori_artikel") echo "class=\"active \"" ?>
                        href="tampil_kategori_artikel.php"><span class="fa fa-archive"></span> Kelola Kategori Artikel</a>
                    </li>
                </ul>
            </li>
            <!-- /artikel -->
            <!-- gambar -->
            <li <?php 
                    if($thispage == "gambar" ||$thispage == "tampil_gambar_kegiatan" ||$thispage == "tambah_gambar_kegiatan")
                         echo "class=\"active \"" 
                ?>
            ><a href="#"><i class="fa fa-image fa-fw"></i> Gambar<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                	<li>
                        <a <?php if($thispage == "tambah_gambar_kegiatan") echo "class=\"active \"" ?>
                         href="tambah_gambar_kegiatan.php"><span class="fa fa-plus"></span> Tambah Gambar Kegiatan</a>
                    </li>
                    <li>
                        <a <?php if($thispage == "tampil_gambar_kegiatan") echo "class=\"active \"" ?>
                         href="tampil_gambar_kegiatan.php"><span class="fa fa-archive"></span> Kelola Gambar Kegiatan</a>
                    </li>
                </ul>
            </li>
            <!-- /gambar -->
            <!-- info -->
            <li <?php 
                    if($thispage == "pelayanan" || $thispage == "tambah_pelayanan" || $thispage == "tambah_kantor_pelayanan"
                    	||$thispage == "tampil_pelayanan" || $thispage == "tampil_kantor_pelayanan")
                         echo "class=\"active \"" 
                ?>
            ><a href="#"><i class="fa fa-male"></i><i class="fa fa-female fa-fw"></i>Pelayanan<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                	<li>
                        <a <?php if($thispage == "tambah_pelayanan") echo "class=\"active \"" ?>
                         href="tambah_pelayanan.php"><span class="fa fa-plus"></span> Tambah Pelayanan</a>
                    </li>
                    <li>
                        <a <?php if($thispage == "tambah_kantor_pelayanan") echo "class=\"active \"" ?>
                         href="tambah_kantor_pelayanan.php"><span class="fa fa-plus"></span> Tambah Kantor Pelayanan</a>
                    </li>
                    <li>
                        <a <?php if($thispage == "tampil_pelayanan") echo "class=\"active \"" ?>
                         href="tampil_pelayanan.php"><span class="fa fa-archive"></span> Kelola Pelayanan</a>
                    </li>
                    <li>
                        <a <?php if($thispage == "tampil_kantor_pelayanan") echo "class=\"active \"" ?>
                        href="tampil_kantor_pelayanan.php"><span class="fa fa-archive"></span> Kelola Kantor Pelayanan</a>
                    </li>
                </ul>
            </li>
            <!-- /info -->
            <!-- diklat -->
            <li
                  <?php 
                        if($thispage == "ubah_kegiatan" || $thispage == "tampil_kegiatan" || $thispage == "tambah_kegiatan") 
                            echo "class=\"active \"" 
                    ?>
            >
                    <a href="#"><i class="fa fa-calendar fa-fw"></i> Agenda<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a <?php if($thispage == "tambah_kegiatan") echo "class=\"active \"" ?>
                             href="tambah_kegiatan.php"><span class="fa fa-plus"></span> Tambah Kegiatan</a>
                        </li>
                        <li>
                            <a <?php if($thispage == "tampil_kegiatan") echo "class=\"active \"" ?>
                            href="tampil_kegiatan.php"><span class="fa fa-archive"></span> Kelola Kegiatan</a>
                        </li>
                    </ul>
            </li>
            <!-- /diklat -->
            <!-- cuprimer -->
            <li
                  <?php 
                        if($thispage == "ubah_cuprimer" || $thispage == "tampil_cuprimer" || $thispage == "tampil_wilayah" 
                            || $thispage == "tambah_cuprimer") 
                            echo "class=\"active \"" 
                    ?>
            >
                    <a href="#"><i class="fa fa-building-o fa-fw"></i> CU Primer<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a <?php if($thispage == "tambah_cuprimer") echo "class=\"active \"" ?>
                             href="tambah_cuprimer.php"><span class="fa fa-plus"></span> Tambah CU Primer</a>
                        </li>
                        <li>
                            <a <?php if($thispage == "tampil_cuprimer") echo "class=\"active \"" ?>
                            href="tampil_cuprimer.php"><span class="fa fa-archive"></span> Kelola CU Primer</a>
                        </li>
                        <li>
                            <a <?php if($thispage == "tampil_wilayah") echo "class=\"active \"" ?>
                            href="tampil_wilayah.php"><span class="fa fa-archive"></span> Kelola Wilayah CU Primer</a>
                        </li>
                    </ul>
            </li>
            <!-- /cuprimer -->
            <!-- staff -->
            <li>
                <a  <?php if($thispage == "tampil_staff" ||$thispage == "tambah_staff" ||$thispage == "ubah_staff") 
                    echo "class=\"active \"" ?>
                    href="#"><i class="fa fa-sitemap fa-fw"></i> Stafff <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a <?php if($thispage == "tambah_staff") echo "class=\"active \"" ?>
                         href="tambah_staff.php"><span class="fa fa-plus"></span> Tambah Staff</a>
                    </li>
                    <li>
                        <a <?php if($thispage == "tampil_staff") echo "class=\"active \"" ?>
                        href="tampil_staff.php"><span class="fa fa-archive"></span> Kelola staff</a>
                    </li>
                </ul>
            </li>
            <!-- /staff -->
            <!-- admin -->
            <li <?php 
                    if($thispage == "admin" ||$thispage == "tambah_admin" 
                        || $thispage == "tampil_admin")
                         echo "class=\"active \"" 
                ?>
            >
                <a href="#"><i class="fa fa-user fa-fw"></i> Admin<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a <?php if($thispage == "tambah_admin") echo "class=\"active \"" ?>
                         href="tambah_admin.php"><span class="fa fa-plus"></span> Tambah Admin</a>
                    </li>
                    <li>
                        <a <?php if($thispage == "tampil_admin") echo "class=\"active \"" ?>
                        href="tampil_admin.php"><span class="fa fa-archive"></span> Kelola Admin</a>
                    </li>
                </ul>
            </li>
            <!--
            <li>
                <a  <?php if($thispage == "pengaturan") echo "class=\"active \"" ?>
                    href="#"><i class="fa fa-gear fa-fw"></i> Pengaturan</span></a>
            </li>-->
        </ul>
    </div>
</div>