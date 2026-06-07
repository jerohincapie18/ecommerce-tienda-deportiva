<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//definir las cabeceras para manejar json
header("Content-Type: application/json; charset=UTF-8");
require("./controllers/AuthController.php");

//recibe una accion del dom (lo que quiero hacer, login, registro de usuario, de producto, etc)
$action = trim($_GET['action'] ?? '');

//recibe el json y lo decodifica a un arreglo asociativo
$json = file_get_contents("php://input");
$data = json_decode($json, true);

//enrutar las clases
$authController = new AuthController();

switch ($action)
{
  case "login":
    $authController->login($data);
    break;
  case "register":
    $authController->register($data);
    break;
  default:
    http_response_code(404);
    echo json_encode(["succes" => false, "message" => "Ruta no encontrada"]);
    break;
}
