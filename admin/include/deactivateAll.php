<?php

	require '../../functions.php';
	if( isset($_POST) ) {
		$data = $_POST;
		$age = $data['age'];
		$type = $data['type'];
		checkedToZero($age, $type);
	}