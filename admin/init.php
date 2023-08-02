<?php
ini_set("display_errors", "1");
error_reporting(E_ALL);

	$tpl 	= 'includes/templates/'; 
	$lang 	= 'includes/languages/';
	$func	= 'includes/functions/'; 
	$css 	= 'layout/css/'; 
	$js 	= 'layout/js/'; 

	include $func . 'functions.php';
	include $lang . 'english.php';
	include $tpl . 'header.php';

	if (!isset($no_navbar)) { include $tpl . 'navbar.php'; }
	

	