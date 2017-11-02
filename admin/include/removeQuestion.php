<?php

	require '../../functions.php';

	if( isset($_POST) ){
		$data = $_POST;
		removeQuestion($data['id']);
	}