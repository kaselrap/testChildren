<?php header('Content-Type: text/html; charset:utf-8');
    include '../functions.php';
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
    <title>Admin Panel</title>
</head>
<?php  
    $users = R::findOne('users', 1);
    $settings = R::findOne('settings', 1);
    if ( ! $users ) {
        setUser('admin', 'admin'); 
    }
    if( ! $settings ) {
        setSettingsDefault(10, 10);
    }
    if( isset($_GET['age']) && ($_GET['age'] == '11-14' || $_GET['age'] == '15-16') ) {
        $age = $_GET['age'];
    } else {
        $age = '8-10';
    }
?>
<body data-age="<?php echo $age; ?>">
<?php
    if( isset($_COOKIE['logged_user']) ){
        $cookie = json_decode($_COOKIE['logged_user']);
        ?>
    <div class="container-fluid">
            <div class="container container--active">
                <div class="header">
                    <div class="logo">
                        Hello, <?php echo $cookie->login; ?>
                    </div>
                    <div class="logForm">
                        <ul>
                            <li>
                                <select name="ageS" id="ageS">
                                <?php
                                    if ($age == '11-14') {
                                        ?>
                                        <option value="8-10"><a href="&age=8-10">8-10</a></option>
                                        <option value="11-14" selected><a href="&age=11-14">11-14</a></option>
                                        <option value="15-16"><a href="&age=15-16">15-16</a></option>
                                        <?php
                                    } 
                                    else if($age == '15-16') {
                                        ?>
                                        <option value="8-10"><a href="&age=8-10">8-10</a></option>
                                        <option value="11-14"><a href="&age=11-14">11-14</a></option>
                                        <option value="15-16" selected><a href="&age=15-16">15-16</a></option>
                                        <?php
                                    } else {
                                        ?>
                                        <option value="8-10" selected><a href="&age=8-10">8-10</a></option>
                                        <option value="11-14"><a href="&age=11-14">11-14</a></option>
                                        <option value="15-16"><a href="&age=15-16">15-16</a></option>
                                        <?php
                                    }
                                ?>
                                    
                                </select>   
                            </li>
                            <li>
                                <a class="fa fa-cog settings button" href="#">
                                    <i aria-hidden="true"></i>
                                </a>
                                <div id="settings">
                                    <div class="settings-title">
                                        Settings 
                                    </div>
                                    <?php
                                        $settings = getSettings();
                                    ?>
                                    <form id="form-settings">
                                        <label for="login">
                                            <span>Login</span>
                                            <input type="text" name="login" placeholder="Your login..." value="<?php echo $cookie->login; ?>">
                                        </label>
                                        <label for="password">
                                            <span>Password</span>
                                            <input type="text" name="password" placeholder="Your password..." value="<?php echo $_COOKIE['password']; ?>">
                                        </label>
                                        <label for="time1">
                                            <span>Time 1 round</span>
                                            <input type="text" name="time1" value="<?php echo $settings->timer1; ?>">
                                        </label>
                                        <label for="time2">
                                            <span>Time 2 round</span>
                                            <input type="text" name="time2" value="<?php echo $settings->timer2; ?>">
                                        </label>
                                    </form>
                                </div>
                            </li>
                            <li>
                                <a class="fa fa-plus add" href="#">
                                    <i aria-hidden="true"></i>
                                </a>
                            </li>
                            <?php
                            $countActive = R::count('questions','age = ?', array('8-10'));
                            $countDone =R::count('questions','age = ?', array('11-14'));
                            $countTrash = R::count('questions','age = ?', array('15-16'));
                            ?>
                            <li>
                                <a class="active">
                                    <?php echo $countActive; ?>
                                </a>
                                <p class="hidden-info">It's questions for <strong>8</strong> to <strong>10</strong> age group of child</p>
                            </li>
                            <li>
                                <a class="done"><?php echo $countDone; ?></a>
                                <p class="hidden-info">It's questions for <strong>11</strong> to <strong>14</strong> age group of child</p>

                            </li>
                            <li>
                                <a class="trash"><?php echo $countTrash; ?></a>
                                <p class="hidden-info">It's questions for <strong>15</strong> to <strong>17</strong> age group of child</p>
                            </li>
                            <li><a class="exit" href="/admin/logout.php">Exit</a></li>
                        </ul>
                    </div>
                </div>
                <div class="task task--a">
                    <div class="task--active">
                        <div class="block objects">
                            <h2 class="title">Objects</h2>
                            <a href="#" class="deactivate-all" data-type="object">Deactivate All</a>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Set question</th>
                                        <th>type</th>
                                        <th>en</th>
                                        <th>rus</th>
                                        <th>de</th>
                                        <th>es</th>
                                        <th>it</th>
                                        <th>Edit</th>
                                        <th>Remove</th>
                                    </tr>
                                </thead>                            
                                <?php
                                    $objects = R::findAll('questions','age = ? && type = ?', array($age, 'object'));
                                ?>
                                <tbody>
                                    <?php
                                        foreach ($objects as $object) {
                                            $question = json_decode($object['question']);
                                            ?>
                                            <tr class="object">
                                                <td>
                                                    <?php 
                                                        echo ($object['checked'] == 0 || $object['checked'] == NULL) ? 
                                                        '<a href="#" id="deactivated" class="checkbox" data-id="' . $object["id"] . '">Deactivated</a>' :
                                                        '<a href="#" id="activated" class="checkbox" data-id="' . $object["id"] . '">Activate</a>';
                                                    ?>
                                                </td>
                                                <td><?php echo $object['type']; ?></td>
                                                <?php 
                                                foreach ($question as $key => $value) {
                                                    ?>
                                                <td data-lang="<?php echo $key; ?>"><?php echo $value; ?></td>
                                                    <?php
                                                }
                                                ?>
                                                <td>
                                                    <a href="#" class="fa fa-pencil edit" data-id="<?php echo $object['id']; ?>"></a>
                                                </td>
                                                <td>
                                                    <a href="#" class="fa fa-trash remove" data-id="<?php echo $object['id']; ?>"></a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="block actions">
                            <h2 class="title">Actions</h2>
                            <a href="#" class="deactivate-all" data-type="action">Deactivate All</a>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Set question</th>
                                        <th>type</th>
                                        <th>en</th>
                                        <th>rus</th>
                                        <th>de</th>
                                        <th>es</th>
                                        <th>it</th>
                                        <th>Edit</th>
                                        <th>Remove</th>
                                    </tr>
                                </thead>                            
                                <?php
                                    $actions = R::findAll('questions','age = ? && type = ?', array($age, 'action'));
                                ?>
                                <tbody>
                                    <?php
                                        foreach ($actions as $action) {
                                            $question = json_decode($action['question']);
                                            ?>
                                            <tr class="action">
                                                <td>
                                                    <?php 
                                                        echo ($action['checked'] == 0 || $action['checked'] == NULL) ? 
                                                        '<a href="#" id="deactivated" class="checkbox" data-id="' . $action["id"] . '">Deactivated</a>' :
                                                        '<a href="#" id="activated" class="checkbox" data-id="' . $action["id"] . '">Activate</a>';
                                                    ?>
                                                </td>
                                                <td><?php echo $action['type']; ?></td>
                                                <?php 
                                                foreach ($question as $key => $value) {
                                                    ?>
                                                <td data-lang="<?php echo $key; ?>" data-lang="<?php echo $key; ?>"><?php echo $value; ?></td>
                                                    <?php
                                                }
                                                ?>
                                                <td>
                                                    <a href="#" class="fa fa-pencil edit" data-id="<?php echo $action['id']; ?>"></a>
                                                </td>
                                                <td>
                                                    <a href="#" class="fa fa-trash remove" data-id="<?php echo $action['id']; ?>"></a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="container--add">
            <div class="overlay"></div>
            <div class="task--add">
                <div class="menu">
                    <i class="title">Add question</i>
                    <i class="fa fa-times close" aria-hidden="true"></i>
                </div>
                <form id="form--add" action="/admin/" method="POST">
                    <div class="select">
                        <div class="label">
                            Choose age child
                        </div>
                        <select class="age" name="age" id="age" required>
                            <option value="8-10">8-10</option>
                            <option value="11-14">11-14</option>
                            <option value="15-16">15-16</option>
                        </select> 
                    </div> 
                    <div class="select">
                        <div class="label">
                            Choose type question
                        </div>
                        <select class="type" name="type" id="type" required>
                            <option value="object">object</option>
                            <option value="action">action</option>
                        </select>  
                    </div>
                    <ul class="questions">
                        <li>
                            <label>
                                <span class="label">En</span>
                                <input name="lang[en]" placeholder="Type your question..." maxlength="200" required>
                            </label>
                        </li>
                        <li>
                            <label>
                                <span class="label">Ru</span>
                                <input name="lang[ru]" placeholder="Type your question..." maxlength="200">
                            </label>
                        </li>
                        <li>
                            <label>
                                <span class="label">De</span>
                                <input name="lang[de]" placeholder="Type your question..." maxlength="200">
                            </label>
                        </li>
                        <li>
                            <label>
                                <span class="label">Es</span>
                                <input name="lang[es]" placeholder="Type your question..." maxlength="200">
                            </label>
                        </li>
                        <li>
                            <label>
                                <span class="label">It</span>
                                <input name="lang[it]" placeholder="Type your question..." maxlength="200">
                            </label>
                        </li>
                    </ul>
                    <button type="submit" name="do_add">Add</button>
                </form>
            </div>
        </div>
        <div class="container--edit">
            <div class="overlay"></div>
            <div class="task--edit">
                <div class="menu">
                    <i class="title">Edit question</i>
                    <i class="fa fa-times close" aria-hidden="true"></i>
                </div>
                <form id="form--edit" data-id="">
                    <ul class="questions">
                        <li>
                            <label>
                                <span class="label">En</span>
                                <input lang="en" name="lang[en]" placeholder="Type your question..." maxlength="200" required>
                            </label>
                        </li>
                        <li>
                            <label>
                                <span class="label">Ru</span>
                                <input lang="ru" name="lang[ru]" placeholder="Type your question..." maxlength="200">
                            </label>
                        </li>
                        <li>
                            <label>
                                <span class="label">De</span>
                                <input lang="de" name="lang[de]" placeholder="Type your question..." maxlength="200">
                            </label>
                        </li>
                        <li>
                            <label>
                                <span class="label">Es</span>
                                <input lang="es" name="lang[es]" placeholder="Type your question..." maxlength="200">
                            </label>
                        </li>
                        <li>
                            <label>
                                <span class="label">It</span>
                                <input lang="it" name="lang[it]" placeholder="Type your question..." maxlength="200">
                            </label>
                        </li>
                    </ul>
                    <input type="hidden" name="id" value="">
                    <button type="submit" name="do_edit">Edit</button>
                </form>
            </div>
        </div>
        <?php
    } else {
        ?>
    <div class="container">
        <div class="container--active">
            <div class="content">
                <form id="log-in">
                    <a class="login" href="/admin/login.php">Войти</a>
                </form>
            </div>
        </div>
    </div>
        <?php
    }
?>
<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/script.js"></script>
</body>
</html>