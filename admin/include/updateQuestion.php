<?php
	require '../../functions.php';
	if( isset($_POST) ) {
		$data = $_POST;
		$id = $data['id'];
		$lang = json_encode($data['lang']);
		updateQuestion($id, $lang);
		print_r(json_decode($lang));
	}