<?php
    setcookie('logged_user', $user, time() - 1);
    header('Location: /admin/');
?>