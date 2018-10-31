<?php

	require 'functions.php';
	$data = $_POST;
    if ( isset( $data['problem'] ) ) {
        $problem = json_encode($data['problem'] );
        addProblems( (int)$data['id'], $data['gender'], $problem);
    }
