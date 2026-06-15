<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "mamakhalu";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed");
}
?>
