<?php

	require '../../functions.php';
	if( isset($_POST) ){
		$data = $_POST;
		setSettingsDefault($data['timer1'], $data['timer2']);
		setUser($data['login'], $data['password']);
	}