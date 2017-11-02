<?php

	require 'functions.php';
	$data = $_POST;
	if ( isset( $data['action'] ) ) {
		$type = 'action';
		$id = (int)$data['id'];
		$data_json = json_encode($data['action']);
	} 
	if ( isset( $data['object'] ) ) {
		$type = 'object';
		$id = (int)$data['id'];
		$data_json = json_encode($data['object']);
	}
	if ( isset( $type ) ) {
		addProblems( $id, $data_json);
	}