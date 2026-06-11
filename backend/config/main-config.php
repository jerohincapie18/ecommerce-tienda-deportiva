<?php

//$db_data = require("database.php");
$host = "localhost";
$user = "root";
$pass = "";
$db_name = "users_db";

$conn = new mysqli($host, $user, $pass, $db_name);
if ($conn->connect_error)
  die("error de conexion: " . $conn->connect_error);
