<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//definir las cabeceras para manejar json
header("Content-Type: application/json; charset=UTF-8");
require("./controllers/AuthController.php");
require("./controllers/ProductController.php");
require_once("./models/ProductModel.php");

//recibe una accion del dom (lo que quiero hacer, login, registro de usuario, de producto, etc)
$action = trim($_GET['action'] ?? '');

//recibe el json y lo decodifica a un arreglo asociativo
$json = file_get_contents("php://input");
$data = json_decode($json, true);

//enrutar las clases
$authController = new AuthController();
$productController = new ProductController();

//variables adicionales
//$imagenesCarrusel = $productModel->getCarouselProducts();
switch ($action)
{
  case "login":
    $authController->login($data);
    break;
  case "register":
    $authController->register($data);
    break;
  case "logout":
    session_start(); //se conecta al sistema de sesiones 
    session_unset(); //borra las variables de la sesion
    session_destroy(); //destruye el archivo del servidor de la sesion
    header("Location: ../frontend/index.php");
    exit();
    break;
  case "createProduct":
    //validacion auxiliar de usuario
    session_start();
    if(!isset($_SESSION["user_id"]) || $_SESSION["rol"] !== "admin")
    {
      http_response_code(403);
      echo json_encode(["success" => false, "message" => "Accion no autorizada"]);
      exit();
    }
    $productController->create($_POST, $_FILES);
    break;
  case "getCarousel":
    $productController->getCarousel();
    break;
  case "getProducts":
    $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
    $limit = 5;
    $productController->getProducts($limit, $offset);
    break;
  default:
    http_response_code(404);
    echo json_encode(["succes" => false, "message" => "Ruta no encontrada"]);
    break;
}
