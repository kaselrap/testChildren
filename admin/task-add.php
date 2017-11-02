<?php
    require '../functions.php';
    $cookie = json_decode($_COOKIE['logged_user']);
    $data = $_POST;
    $errors = array();
    if( ! preg_match("/^([a-z0-9]*)$/i", $data['task'])){
        $errors[] ='Некорректные символы';
    }
    if( trim($data['task']) == '' ){
        $errors[] = 'Вы ничего не ввели';
    }
    if( empty($errors) ){
        $task = R::dispense('tasks');
        $task->user = $cookie->login;
        $task->task = $data['task'];
        $task->status = "active";
        $id = R::store($task);
        $arr = array(
            'type' => true,
            'success' => '<div style="padding: 10px 0; margin: 0 0 40px 0; border-radius: 10px; background: green; color: #fff; top: 20px; text-align: center;">Задание добавлно!</div>',
            'text' => $data['task'],
            'id' => $id
        );
        echo json_encode($arr);
    } else{
        $arr = array(
            'type' => false,
            'success' => '<div style="padding: 10px 0; margin: 0 0 40px 0; border-radius: 10px; background: red; color: #fff; top: 20px; text-align: center;">'.array_shift($errors).'</div>'
        );
        echo json_encode($arr);
    }
?>