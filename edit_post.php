<?php
require_once 'functions/functions.php';
my_session_start('secure_blogest');

if (!checkUser()){
    header('location: login.php');
}

if ($link = db_connect()) {
    if (isset($_GET['post_id'])) {
        $post_id = $_GET['post_id'];
        if (is_numeric($post_id)) {
            $post_id = mysqli_real_escape_string($link, $post_id);
            $_SESSION['post_id'] = $post_id;
        }
    }
}

header('location: index.php');
?>