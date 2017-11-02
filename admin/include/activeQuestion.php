<?php

	require '../../functions.php';
	if( isset($_POST) ) {
		$data = $_POST;
		$id = $data['id'];
		$checked = $data['checked'];
		$age = $data['age'];
		$type = $data['type'];
		addChecked($id, $checked, $age, $type);
	}