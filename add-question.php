<?php

	require 'functions.php';

	if ( isset ( $_GET['question'] ) )
		$question = $_GET['question'];

	if ( $_GET['type'] == 'object' || $_GET['type'] == 'action' )
		$type = $_GET['type'];
	else
		$type = 'action';

	if ( isset( $_GET['lang'] ) )
		$lang = $_GET['lang'];
	else
		$lang = 'en';

	if ( isset( $question ) && isset( $type ) && isset( $lang ) ) {
		echo addQuestion($question, $type, $lang);
	}
	else {
		echo 'Failed. Try again please!';
	}