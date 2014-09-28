<?php
	require_once('../includes/function.php');
	require_once('../includes/database.php');
	require_once('../includes/session_admin.php');
	require_once('../includes/admin.php');

	$admin = new admin();
	$admin->id = $_SESSION['bkcu_user'];
	$admin->update_offline();

	$session->logout();
	$session->pesan("Kamu sudah logout.");

	redirect_to("login.php");
?>