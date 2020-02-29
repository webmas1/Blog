<?php

//----SETTING SESSION EXP-TIME----//
if (!function_exists('my_session_start')) {

    function my_session_start($name) {
        $for_time = 60 * 60 * 2; //--2 HOURS
        session_set_cookie_params($for_time);
        session_name($name);
        session_start();
        session_regenerate_id();
    }

}

//----SESSION START----//

if (!function_exists('db_connect')) {

    function db_connect() {
        require_once 'config/database.php';

        if (!$link = @mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB)) {
            die('Error connecting to mysql server!');
        }

        mysqli_set_charset($link, "utf8");

        return $link;
    }

}


//----CHECK USER----//
if (!function_exists('checkUser')) {

    function checkUser() {
        $valid = false;

        if (isset($_SESSION['uid']) && $_SERVER['REMOTE_ADDR'] == $_SESSION['ip_address']) {

            if ($_SERVER['HTTP_USER_AGENT'] == $_SESSION['HTTP_USER_AGENT']) {

                $valid = true;
            }
        }
        return $valid;
    }

}


//----CHECK ADMIN----//
if (!function_exists('checkAdmin')) {

    function checkAdmin() {
        $valid = false;

        if (isset($_SESSION['admin']) && $_SERVER['REMOTE_ADDR'] == $_SESSION['ip_address']) {

            if ($_SERVER['HTTP_USER_AGENT'] == $_SESSION['HTTP_USER_AGENT']) {

                $valid = true;
            }
        }
        return $valid;
    }

}



