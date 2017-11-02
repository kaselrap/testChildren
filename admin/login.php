<?php
    require '../functions.php';
    $data = $_POST;
    if( isset($data['do_login']) ){
        $errors = array();
        $user = R::findOne('users','login = ?', array($data['login']));
        
        if( $user ){
            if( password_verify($data['password'], $user->password) ){
                setcookie("logged_user", $user, time() + 86400);
                setcookie('password', $data['password'], time() + 86400, '/');
                echo '<div style="padding: 10px 0; width: 320px; border-radius: 10px; background: green; color: #fff; position: absolute; top: 50px; text-align: center;">Вы успешно зарегестрированы! Можете перейти в <a href="/admin/">личный кабинет</a></a></div>';
            } else{
                $errors[] = "Пароль не верный!";
            }
        } else{
            $errors[] = "Пользователь с таким логином не найден!";
        }
        if( !empty($errors) ){
            echo '<div style="padding: 10px 0; width: 320px; border-radius: 10px; background: red; color: #fff; position: absolute; top: 80px; text-align: center;">'.array_shift($errors).'</div>';
        }
    }
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet/less" type="text/css" href="css/style.less">
    <script src="js/less.min.js"></script>
    <title>To do all</title>
</head>
<body>
<div class="container--login">
    <div class="container--active">
        <div class="content">
            <form id="log-in" action="/admin/login.php" method="POST">
                <h1>Authorization</h1>
                <input type="text" name="login" placeholder="login: " value="<?php echo @$data['login']; ?>" maxlength="50">
                <input type="password" name="password" placeholder="password: " value="<?php echo @$data['password']; ?>" maxlength="50">
                <button type="submit" name="do_login">Log In</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
