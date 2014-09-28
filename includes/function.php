<?php

defined('ds') ? null : define('ds', DIRECTORY_SEPARATOR);


defined('website') ? null :
	define('website', ds. 'xampp' .ds. 'htdocs' .ds. 'bkcu');

/*
defined('website') ? null :
	define('website', ds. 'home' .ds. 'puskopdi' .ds. 'public_html');
*/
defined('folder') ? null : define('folder', website.ds.'includes');


function __autoload($nama_class){
	$nama_class = strtolower($nama_class);
	$path=folder.ds."{$nama_class}.php";
	if(file_exists($path)){
		require_once($path);
	}else{
		die("File {$nama_class}.php tidak dapat ditemukan.");
	}
}

function cek_field($field_array){
	$field_errors = array();
	foreach($field_array as $namafield){
		if(!isset($_POST[$namafield]) || empty($_POST[$namafield]) ){
				$field_errors[] = $namafield;
			}
	}
	return $field_errors;
}

function cek_panjang_field($panjang_field){
	$field_errors = array();
	foreach($panjang_field as $namafield => $panjang){
		if(strlen(trim(mysql_prep($_POST[$namafield]))) > $panjang){
			$field_errors[] = $namafield;
		}
	}
	return $field_errors;
}

function redirect_to($location){
	if($location != NULL){
		header("Location: {$location}");
		exit;
	}
}

function mysql_prep($value){
	$magic_quotes_active = get_magic_quotes_gpc();
	$new_enough_php = function_exists("mysql_real_escape_string");
	if($new_enough_php){
		if($magic_quotes_active){ $value = stripslashes( $value ); }
		$value = mysql_real_escape_string($value);
	} else {
		if(!$magic_quotes_active){ $value = addslashes( $value ); }
	}
	return $value;
}

function confirm_query($result_set){
	if(!$result_set){
		die("Database query failed: " . mysql_error());
	}
}

function get_all_subjects(){
	global $connection;
	$query ="SELECT * FROM produk ";
	$query .="ORDER BY position ASC";
	$subject_set = mysql_query($query,$connection);
	confirm_query($subject_set);
	return $subject_set;
}
?>