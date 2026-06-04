<?php
//ARCHIVO TEMPORAL!!
//para que me muestre los errores si los hay
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require("../config/main-config.php");

$sql = "SELECT * FROM users";
$resultado = $conn->query($sql);

$datosFinales = array();
if ($resultado->num_rows > 0) {
  while ($row = $resultado->fetch_assoc()) {
    $datosFinales[] = $row;
  }
  $conn->close();
  echo json_encode($datosFinales);
}
