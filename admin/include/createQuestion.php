<?php
	require '../../functions.php';
	if( isset($_POST) ) {
		$data = $_POST;
		$lang = json_encode($data['lang']);
		addQuestion($lang, $data['type'], $data['age']);
	}