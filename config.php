<?php
	session_start();

	require_once "Facebook/autoload.php";

	$FB = new \Facebook\Facebook([
		'app_id' => '322153161822884',
		'app_secret' => '56c74456ae38092db0f5a238bc027485',
		'default_graph_version' => 'v3.2'
	]);

	$helper = $FB->getRedirectLoginHelper();
?>