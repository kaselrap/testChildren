<?php
	
	require 'libs/db.php';

	function getQuestions ( $type = 'object', $lang = 'en' ) {
		return R::findAll('questions', 'type = ? AND lang = ?', array($type, $lang));
	}

	function getQuestion ( $age, $type, $checked = 1 ) {
		return R::findOne('questions', 'age = ? AND type = ? AND checked = ?', array($age, $type, $checked));
	}

	function getQuestionById ( $id_question ) {
		return R::findOne('questions', $id_question);
	}

	function getLang ( $lang ) {
		R::findAll('questions', 'lang = ?', array($lang) );
	}
	function addQuestion ( $question, $type, $age ) {
		$questions = R::dispense( 'questions' );
		$questions->question = $question;
		$questions->type = $type;
		$questions->age = $age;
		R::store($questions);
		return true;
	}
	function updateQuestion ( $id, $question ) {
		$questions = R::load( 'questions', $id );
		$questions->question = $question;
		R::store($questions);
		return true;
	}
	function addProblems ( $id_question, $problem ) {
		$problems = R::dispense( 'problems' );
		$problems->id_question = $id_question;
		$problems->problem = $problem;
		R::store($problems);
		return true;
	}

	function getProblems ( $id_question ) {
		return R::findAll('problems');
	}

	function getProblem ( $id_question ) {
		return R::findOne('problems', 'id_question = ?', array($id_question));
	}

	function setSettingsDefault ($timer1 = 100, $timer2 = 100) {
		$settings = R::findOne('settings', 1);
		if ( ! $settings ) {
			$settings = R::dispense( 'settings' );
			$settings->timer1 = $timer1;
			$settings->timer2 = $timer2;
			R::store($settings);
		} 
		else {
			$settings = R::load('settings', 1);
			$settings->timer1 = $timer1;
			$settings->timer2 = $timer2;
			R::store($settings);
		}

	}
	function setUser ($login = 'admin', $password = 'admin') {
		$users = R::findOne('users', 1);
		if ( !$users ) {
			$user = R::dispense( 'users' );
		    $user->login = $login;
		    $user->password = password_hash($password,PASSWORD_DEFAULT);
		    R::store($user);
		}
		else {
			$user = R::load( 'users', 1 );
		    $user->login = $login;
		    $user->password = password_hash($password,PASSWORD_DEFAULT);
		    R::store($user);
		}
	}
	function removeQuestion ($id) {
		$question = R::load('questions', $id);
		R::trash($question);
	}
	function getSettings () {
		return R::findOne('settings', 1);
	}
	function checkedToZero ($age, $type) {
		$questions = R::findAll('questions', 'age = ? AND type = ?', array($age, $type));
		foreach ($questions as $question) {
			$quest = R::load('questions', $question->id);
			$quest->checked = 0;
			R::store($quest);
		}
	}
	function addChecked ($id, $check, $age, $type) {
		checkedToZero($age, $type);
		$questions = R::load('questions', $id);
		$questions->checked = 1;
		R::store($questions);
	}
	// setSettingsDefault(10);
	