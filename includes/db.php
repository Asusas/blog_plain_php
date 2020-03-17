<?php

$host = 'localhost';
$root = 'root';
$password_ = '';
$db = 'php_cms';

$Conn = mysqli_connect($host, $root, $password_, $db);
if (!$Conn) {
    die("Database connection failed !") . mysqli_error($Conn);
}