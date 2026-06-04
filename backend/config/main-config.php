<?php

$db_data = require("database.php");
$host = $db_data["DB_HOST"];
$user = $db_data["DB_USER"];
$pass = $db_data["DB_PASS"];
$db_name = $db_data["DB_NAME"];

$conn = new mysqli($host, $user, $pass, $db_name);
if ($conn->connect_error)
  die("error de conexion: " . $conn->connect_error);
