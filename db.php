<?php
session_start();

$host = "localhost";
$user = "root";
$password = "KimSY0721!";
$database = "first_web";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("연결 실패: " . $conn->connect_error);
}
?>
