<div class="mainmenu-wrapper">
    <div class="container">
    	<div class="menuextras">
			<div class="extras">
				<ul>
					<li><b>Badan Hukum Nomor : 927/BH/M.KUKM.2/X/2010</b></li>
				</ul>						
			</div>
        </div>
		<nav id="mainmenu" class="mainmenu">
			<ul>
				<li class="logo-wrapper"><a href="index.html"><img src="images/logo2.jpg" alt="Puskopdit BKCU Kalimantan" class=""></a></li>
				<li>
					<a href="index.php">Home</a>
				</li>
				<li>
					<a href="berita.php">Berita</a>
				</li>
				<li>
					<a href="solusi.php">Solusi</a>
				</li>
				<li>
					<a href="list_artikel.php?i=4">Filosofi</a>
				</li>
				<li>
					<a href="agenda_diklat.php">Agenda</a>
				</li>
				<li>
					<a href="jejaring.php">Jejaring</a>
				</li>
				<li>
					<a href="tentang_kami.php">Tentang Kami</a>
				</li>
				<li class="has-submenu">
					<a href="agenda_diklat.php"><span class="fa fa-caret-square-o-down "></span></a>
					<div class="mainmenu-submenu">
						<div class="mainmenu-submenu-inner"> 
							<div>
								<h4><a href="index.php" style="border-bottom: 2px solid #FFFFFF;line-height: 1.5em;margin: 30px 0;">Home</a></h4>
								<h4><a href="berita.php" style="border-bottom: 2px solid #FFFFFF;line-height: 1.5em;margin: 30px 0;">Berita</a></h4>
								<ul>
								<?php
									require_once("includes/kategori_artikel.php");

									$sql_kategori_nav = "SELECT * FROM " . kategori_artikel::$nama_tabel;
									$sql_kategori_nav .=" WHERE id NOT IN (1,4)";

									$result = $database->query($sql_kategori_nav);
									while($row = $database->fetch_array($result)){
										echo "<li><a href=\"list_artikel.php?i={$row['id']}\" >{$row['name']}</a></li>";
									}
								?>	
								</ul>
								<h4><a href="solusi.php" style="border-bottom: 2px solid #FFFFFF;line-height: 1.5em;margin: 30px 0;">Solusi</a></h4>
								<ul>
								<?php
									require_once("includes/pelayanan.php");

									$sql_pelayanan_nav = "SELECT * FROM " . pelayanan::$nama_tabel;

									$result = $database->query($sql_pelayanan_nav);
									while($row = $database->fetch_array($result)){
										echo "<li><a href=\"solusi.php#pelayanan{$row['id']}\" >{$row['name']}</a></li>";
									}
								?>	
								</ul>						
							</div>
							<div>
								<h4><a href="list_artikel.php?i=4" style="border-bottom: 2px solid #FFFFFF;line-height: 1.5em;margin: 30px 0;">Filosofi</a></h4>
								<ul>
								<?php
									require_once("includes/artikel.php");

									$sql_kategori_nav = "SELECT * FROM " . artikel::$nama_tabel;
									$sql_kategori_nav .=" WHERE id IN (1,2,3)";

									$result = $database->query($sql_kategori_nav);
									while($row = $database->fetch_array($result)){
										echo "<li><a href=\"detail_artikel.php?i={$row['id']}\" >{$row['judul']}</a></li>";
									}
								?>	
								</ul>
								<h4><a href="agenda_diklat.php" style="border-bottom: 2px solid #FFFFFF;line-height: 1.5em;margin: 30px 0;">Agenda</a></h4>
								<ul>
									<li><a href="agenda_diklat.php?januari" >Januari</a></li>
									<li><a href="agenda_diklat.php?februari" >Februari</a></li>
									<li><a href="agenda_diklat.php?maret" >Maret</a></li>
									<li><a href="agenda_diklat.php?april" >April</a></li>
									<li><a href="agenda_diklat.php?mei" >Mei</a></li>
									<li><a href="agenda_diklat.php?juni" >Juni</a></li>
									<li><a href="agenda_diklat.php?juli" >Juli</a></li>
									<li><a href="agenda_diklat.php?agustus" >Agustus</a></li>
									<li><a href="agenda_diklat.php?september" >September</a></li>
									<li><a href="agenda_diklat.php?oktober" >Oktober</a></li>
									<li><a href="agenda_diklat.php?november" >November</a></li>
									<li><a href="agenda_diklat.php?desember" >Desember</a></li>	
								</ul>
							</div>
							<div>
								<h4><a href="jejaring.php" style="border-bottom: 2px solid #FFFFFF;line-height: 1.5em;margin: 30px 0;">Jejaring</a></h4>
								<ul>
									<li><a href="jejaring.php?#link" >Link</a></li>
									<li><a href="jejaring.php?#anggota" >Anggota Puskopdit BKCU Kalimantan</a></li>
									<li><br/></li>
									<li><a href="jejaring.php?#A1" >CU Wilayah Kalimantan Barat</a></li>
									<li><a href="jejaring.php?#A2" >CU Wilayah Kalimantan Timur</a></li>
									<li><a href="jejaring.php?#A3" >CU Wilayah Kalimantan Tengah</a></li>
									<li><a href="jejaring.php?#A10" >CU Wilayah Kalimantan Utara</a></li>
									<li><a href="jejaring.php?#A4" >CU Wilayah DKI, DIY dan Jawa</a></li>
									<li><a href="jejaring.php?#A5" >CU Wilayah Sulawesi dan Maluku</a></li>
									<li><a href="jejaring.php?#A6" >CU Wilayah Kepulauan Riau</a></li>
									<li><a href="jejaring.php?#A7" >CU Wilayah Nusa Tenggara Timur</a></li>
									<li><a href="jejaring.php?#A8" >CU Wilayah Papua</a></li>
									<li><a href="jejaring.php?#A9" >CU Wilayah Sumatera</a></li>
								</ul>
								<h4><a href="tentang_kami.php" style="border-bottom: 2px solid #FFFFFF;line-height: 1.5em;margin: 30px 0;">Tentang Kami</a></h4>
								<ul>
									<li><a href="tentang_kami.php#visi">Visi dan Misi BKCU</a></li>
									<li><a href="tentang_kami.php#tim">Tim Kami</a></li>
									<li><a href="tentang_kami.php#temui">Temui Kami</a></li>
									<li><a href="hymne.php">Hymne Credit Union</a></li>
								<?php
									require_once("includes/artikel.php");

									$sql_kategori_nav2 = "SELECT * FROM " . artikel::$nama_tabel;
									$sql_kategori_nav2 .=" WHERE id=3";

									$result = $database->query($sql_kategori_nav2);
									while($row = $database->fetch_array($result)){
										echo "<li><a href=\"sejarah_bkcu.php\" >{$row['judul']}</a></li>";
									}
								?>
								</ul>
							</div>
						</div><!-- /mainmenu-submenu-inner -->
					</div><!-- /mainmenu-submenu -->
				</li>
			</ul>
		</nav>
	</div>
</div>
