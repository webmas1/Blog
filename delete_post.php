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
            $uid = $_SESSION['uid'];
            $sql = "DELETE FROM posts WHERE id = '$post_id' AND uid = '$uid'";
            $result = mysqli_query($link, $sql);

            if (!$result && mysqli_affected_rows($link <= 0)) {
                $_SESSION['del_err'] = 'Something went wrong with deleting the post, try again';
            } else {
                $_SESSION['del_err'] = 'Post has been deleted';
            }
            
            header('location: index.php');
        }
    }
}

?>