<table class="table">
<tr class=" success">
    <td>
    <label>Template Dasar Hak Akses</label>
    </td>
    <td>
    <label class="radio-inline">
      <input name="accesstype" id="radio1" value="option1" type="radio" 
        data-access-type="master"/> Akses Penuh
    </label>
    </td>
    <td>
    <label class="radio-inline">
      <input name="accesstype" id="radio2" value="option2" type="radio"
        data-access-type="admin"/> Akses Minimal
    </label>
    </td>
  </tr>
</table>
<br />
<?php 
  if(!empty($admin->id))
    $sel_hak_akses = $admin->get_subject_by_id();
?>
<table class="table table-striped">
  <tr>
    <td>Tambah Pengumuman</td>
    <td><input name="tambah_pengumuman" value="1" class="access" type="checkbox" 
               <?php 
                  if(!empty($sel_hak_akses))
                    if($sel_hak_akses['tambah_pengumuman']==1){ echo " checked"; } 
                ?>
               data-access-admin="" data-access-master="" /></td>
  </tr>
  <tr>
    <td>Ubah Pengumuman</td>
    <td><input name="ubah_pegumuman" value="1" class="access" type="checkbox" 
               <?php 
                  if(!empty($sel_hak_akses))
                    if($sel_hak_akses['tambah_pengumuman']==1){ echo " checked"; } 
                ?>
               data-access-admin="" data-access-master="" /></td>
  </tr>
  <tr>
    <td>Tambah Artikel</td>
    <td><input name="tambah_artikel" value="1" class="access" type="checkbox" 
               <?php
                  if(!empty($sel_hak_akses)) 
                    if($sel_hak_akses['tambah_artikel']==1){ echo " checked"; } 
               ?>
               data-access-admin="" data-access-master="" /></td>
  </tr>
  <tr>
    <td>Ubah Artikel</td>
    <td><input name="ubah_artikel" value="1" class="access" type="checkbox"
               <?php 
                  if(!empty($sel_hak_akses))
                    if($sel_hak_akses['ubah_artikel']==1){ echo " checked"; } 
               ?> 
               data-access-master="" /></td>
  </tr>
  <tr>
    <td>Ubah Status Artikel</td>
    <td><input name="ubah_status_artikel" value="1" class="access" type="checkbox"
               <?php
                  if(!empty($sel_hak_akses)) 
                    if($sel_hak_akses['ubah_status_artikel']==1){ echo " checked"; } 
               ?>
               data-access-master="" /></td>
  </tr>
  <tr>
    <td>Ubah Kategori Artikel</td>
    <td><input name="ubah_kategori_artikel" value="1" class="access" type="checkbox"
               <?php
                  if(!empty($sel_hak_akses)) 
                    if($sel_hak_akses['ubah_kategori_artikel']==1){ echo " checked"; } 
               ?>
               data-access-master="" /></td>
  </tr>
  <tr>
    <td>Tambah Kategori</td>
    <td><input name="tambah_kategori" value="1" class="access" type="checkbox"
               <?php
                  if(!empty($sel_hak_akses)) 
                    if($sel_hak_akses['tambah_kategori']==1){ echo " checked"; } 
               ?>
               data-access-master="" /></td>
  </tr>
  <tr>
    <td>Ubah Kategori</td>
    <td><input name="ubah_kategori" value="1" class="access" type="checkbox"
               <?php
                  if(!empty($sel_hak_akses)) 
                    if($sel_hak_akses['ubah_kategori']==1){ echo " checked"; } 
               ?>
               data-access-master="" /></td>
  </tr>
  <tr>
    <td>Tambah Artikel Pilihan</td>
    <td><input name="tambah_artikel_pilihan" value="1" class="access" type="checkbox"
               <?php
                  if(!empty($sel_hak_akses)) 
                    if($sel_hak_akses['tambah_artikel_pilihan']==1){ echo " checked"; } 
               ?>
               data-access-master="" /></td>
  </tr>
  <tr>
    <td>Ubah Artikel Pilihan</td>
    <td><input name="ubah_artikel_pilihan" value="1" class="access" type="checkbox" 
               <?php
                  if(!empty($sel_hak_akses)) 
                    if($sel_hak_akses['ubah_artikel_pilihan']==1){ echo " checked"; } 
               ?>
               data-access-master="" /></td>
  </tr>
  <tr>
    <td>Ubah Status Artikel Pilihan</td>
    <td><input name="ubah_status_artikel_pilihan" value="1" class="access" type="checkbox" 
               <?php
                  if(!empty($sel_hak_akses)) 
                    if($sel_hak_akses['ubah_status_artikel_pilihan']==1){ echo " checked"; } 
               ?>
               data-access-master="" /></td>
  </tr>
  <tr>
    <td>Tambah Gambar Kegiatan</td>
    <td><input name="tambah_gambar_kegiatan" value="1" class="access" type="checkbox" 
               <?php
                  if(!empty($sel_hak_akses)) 
                    if($sel_hak_akses['tambah_gambar_kegiatan']==1){ echo " checked"; } 
               ?>
               data-access-master="" /></td>
  </tr>
  <tr>
    <td>Ubah Gambar Kegiatan</td>
    <td><input name="ubah_gambar_kegiatan" value="1" class="access" type="checkbox" 
               <?php
                  if(!empty($sel_hak_akses)) 
                    if($sel_hak_akses['ubah_gambar_kegiatan']==1){ echo " checked"; } 
               ?>
               data-access-master="" /></td>
  </tr>
  <tr>
    <td>Tambah Pelayanan</td>
    <td><input name="tambah_pelayanan" value="1" class="access" type="checkbox" 
               <?php
                  if(!empty($sel_hak_akses)) 
                    if($sel_hak_akses['tambah_pelayanan']==1){ echo " checked"; } 
               ?>
               data-access-master="" /></td>
  </tr>
  <tr>
    <td>Ubah Pelayanan</td>
    <td><input name="ubah_pelayanan" value="1" class="access" type="checkbox" 
               <?php
                  if(!empty($sel_hak_akses)) 
                    if($sel_hak_akses['ubah_pelayanan']==1){ echo " checked"; } 
               ?>
               data-access-master="" /></td>
  </tr>
  <tr>
    <td>Tambah Kantor Pelayanan</td>
    <td><input name="tambah_kantor_pelayanan" value="1" class="access" type="checkbox" 
               <?php
                  if(!empty($sel_hak_akses)) 
                    if($sel_hak_akses['tambah_kantor_pelayanan']==1){ echo " checked"; } 
               ?>
               data-access-master="" /></td>
  </tr>
  <tr>
    <td>Ubah tambah_kantor_pelayanan Pelayanan</td>
    <td><input name="ubah_kantor_pelayanan" value="1" class="access" type="checkbox" 
               <?php
                  if(!empty($sel_hak_akses)) 
                    if($sel_hak_akses['ubah_kantor_pelayanan']==1){ echo " checked"; } 
               ?>
               data-access-master="" /></td>
  </tr>
  <tr>
    <td>Tambah Kegiatan</td>
    <td><input name="tambah_kegiatan" value="1" class="access" type="checkbox" 
               <?php
                  if(!empty($sel_hak_akses)) 
                    if($sel_hak_akses['tambah_kegiatan']==1){ echo " checked"; } 
               ?>
               data-access-master="" /></td>
  </tr>
  <tr>
    <td>Ubah Kegiatan</td>
    <td><input name="ubah_kegiatan" value="1" class="access" type="checkbox" 
               <?php
                  if(!empty($sel_hak_akses)) 
                    if($sel_hak_akses['ubah_kegiatan']==1){ echo " checked"; } 
               ?>
               data-access-master="" /></td>
  </tr>
    <td>Tambah CU Primer</td>
    <td><input name="tambah_cuprimer" value="1" class="access" type="checkbox" 
               <?php
                  if(!empty($sel_hak_akses)) 
                    if($sel_hak_akses['tambah_cuprimer']==1){ echo " checked"; } 
               ?>
               data-access-master="" /></td>
  </tr>
  <tr>
    <td>Ubah CU Primer</td>
    <td><input name="ubah_cuprimer" value="1" class="access" type="checkbox" 
               <?php
                  if(!empty($sel_hak_akses)) 
                    if($sel_hak_akses['ubah_cuprimer']==1){ echo " checked"; } 
               ?>
               data-access-master="" /></td>
  </tr>
  <tr>
    <td>Akses Admin</td>
    <td><input name="akses_admin" value="1" class="access" type="checkbox" 
               <?php
                  if(!empty($sel_hak_akses)) 
                    if($sel_hak_akses['akses_admin']==1){ echo " checked"; } 
               ?>
               data-access-master="" /></td>
  </tr>
</table>