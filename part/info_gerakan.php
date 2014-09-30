<?php
require_once("includes/info_gerakan.php");
$info_gerakan = new info_gerakan();
$info_gerakan->id = 1;
$sel_info_gerakan = $info_gerakan->get_subject_by_id();

echo "<p class=\"contact-us-details\">";
if(!empty($sel_info_gerakan['tanggal']))
echo "<b>Per : </b>{$sel_info_gerakan['tanggal']}<br/>";
if(!empty($sel_info_gerakan['jumlah_anggota']))
echo "<b>Jumlah Anggota : </b>" .number_format($sel_info_gerakan['jumlah_anggota'], 0, ",", "."). " orang<br/>";
if(!empty($sel_info_gerakan['jumlah_cu']))
echo "<b>Jumlah CU Primer : </b> <a href=\"jejaring.php#anggota\">" .number_format($sel_info_gerakan['jumlah_cu'], 0, ",", ".").  "</a><br/>";
if(!empty($sel_info_gerakan['jumlah_staff_cu']))
echo "<b>Jumlah Staff CU Primer : </b>" .number_format($sel_info_gerakan['jumlah_staff_cu'], 0, ",", "."). " orang<br/>";
if(!empty($sel_info_gerakan['asset']))
echo "<b>Jumlah Asset : </b>".number_format($sel_info_gerakan['asset'], 0, ",", "."). "<br/>";
if(!empty($sel_info_gerakan['piutang_beredar']))
echo "<b>Jumlah Piutang Beredar : </b>".number_format($sel_info_gerakan['piutang_beredar'], 0, ",", ".") ."<br/>";
if(!empty($sel_info_gerakan['piutang_lalai_1']))
echo "<b>Jumlah Piutang Lalai 1 s.d. 12 Bulan : </b>".number_format($sel_info_gerakan['piutang_lalai_1'], 0, ",", "."). "<br/>";
if(!empty($sel_info_gerakan['piutang_lalai_2']))
echo "<b>Jumlah Piutang Lalai > 12 Bulan : </b>".number_format($sel_info_gerakan['piutang_lalai_2'], 0, ",", "."). "<br/>";
if(!empty($sel_info_gerakan['piutang_bersih']))
echo "<b>Jumlah Piutang Bersih : </b>".number_format($sel_info_gerakan['piutang_bersih'], 0, ",", "."). "<br/>";
if(!empty($sel_info_gerakan['shu']))
echo "<b>Jumlah SHU : </b>".number_format($sel_info_gerakan['shu'], 0, ",", "."). "<br/>";

echo "</p>";
?>
