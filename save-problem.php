<?php

	require 'functions.php';
	$data = $_POST;
	if ( isset( $data['action'] ) ) {
		$type = 'action';
		$id = (int)$data['id'];
		$gender = $data['gender'];
		$data_json = json_encode($data['action']);
	} 
	if ( isset( $data['object'] ) ) {
		$type = 'object';
		$id = (int)$data['id'];
		$gender = $data['gender'];
		$data_json = json_encode($data['object']);
	}
	if ( isset( $type ) ) {
		addProblems( $id, $gender, $data_json);
	}