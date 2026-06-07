<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require("./models/UserModel.php");

class AuthController
{
  //variables que voy a usar para recibir usermodel y las rutas
  private $userModel;
  private $directions;
  public function __construct()
  {
    $this->userModel = new UserModel();
    //hacerla global para que cualquiera la pueda usar
    $this->directions = require "./config/directions.php";
  }

  public function login($data)
  {
    //si no hay datos, manda el error y termina el proceso
    if (empty($data["email"]) || empty($data["password"]))
    {
      http_response_code(404);
      echo json_encode(["succes" => false, "message" => "Ruta no encontrada"]);
      return;
    }
    
    //encontrer el email en la db
    $user = $this->userModel->findByEmail($data);

    //validar contrasena
    if(password_verify($data["password"], $user["contrasena"]))
    {
      if($user["rol"] === "admin")
      {

      } //header("Location: " . $this->directions["DIR_ROOT"] . "frontend/pages/admin-dashboard.php");
      else
      {

      }
        //header("Location: ../../frontend/pages/user-dashboard.php");
      $ruta = $this->directions["DIR_ROOT"] . "frontend/pages/admin-dashboard.php";
      echo json_encode([
        "success" => true,
        "redirect" => $ruta
      ]);
      return;
    }
  }
}
