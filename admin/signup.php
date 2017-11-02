<?php header('Content-Type: text/html; charset:utf-8');
    require '../functions.php';
    $data = $_POST;
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
<?php

if( isset($data['do_signup']) ){
    $errors = array();
    if( trim($data['login']) == '' ){
        $errors[] = "Введите логин!";
    }
    if( $data['password'] == '' ){
        $errors[] = "Введите пароль!";
    }
    if( R::count('users', 'login = ?', array($data['login'])) > 0 ){
        $errors[] = "Пользователь с тааким login уже существует!";
    }
    if( empty($errors) ){
        $user = R::dispense( 'users' );
        $user->login = $data['login'];
        $user->password = password_hash($data['password'],PASSWORD_DEFAULT);
        R::store($user);
    }
}
?>
<div class="container--login">
    <div class="container--active">
        <div class="content">
            <form id="log-in" action="/test/admin/signup.php" method="POST">
                <h1>Registration</h1>
                <input type="text" name="login" placeholder="Enter your login: " value="<?php echo @$data['login']; ?>" maxlength="50">
                <input type="password" name="password" placeholder="Enter your password: " value="<?php echo @$data['password']; ?>" maxlength="50">
                <button type="submit" name="do_signup">Registration</button>
                <a class="login" href="/test/admin/login.php">Authorization</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>