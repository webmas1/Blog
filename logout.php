<?php
require_once 'functions/functions.php';
my_session_start('secure_blogest');

session_destroy();
header("location: login.php");
die;
