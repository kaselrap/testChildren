<?php

	require 'functions.php';

	if ( $_GET['type'] == 'object' || $_GET['type'] == 'action' )
		$type = $_GET['type'];
	else
		$type = 'action';

	if ( isset( $_GET['lang'] ) )
		$lang = $_GET['lang'];
	else
		$lang = 'en';

	if ( isset( $type ) && isset( $lang ) ) {
		$question = getQuestion(getQuestions($type, $lang));
		echo $question;
	}
	else {
		echo 'Failed. Try again please!';
	}