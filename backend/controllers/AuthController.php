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
      http_response_code(400);
      echo json_encode(["succes" => false, "message" => "Datos incompletos"]);
      exit();
    }
    
    //encontrer el email en la db
    $user = $this->userModel->findByEmail($data);

    //si no encontro nada
    if(!$user)
    {
      http_response_code(401);
      echo json_encode(["success" => false, "message" => "Usuario o contraseña incorrecta"]);
      exit();
    }

    //validar contrasena
    if(password_verify($data["password"], $user["contrasena"]))
    {
      //ahora toca controlar las sesiones para que queden viva en el navegador y poder acceder a los paneles de usuario
      session_start();
      $_SESSION["user_id"] = $user["id"];
      $_SESSION["nombre"] = $user["nombre"];
      $_SESSION["rol"] = $user["rol"];

      if($user["rol"] === "admin")
      {
        $ruta = $this->directions["DIR_ROOT"] . "/frontend/pages/admin-dashboard.php";
      } //header("Location: " . $this->directions["DIR_ROOT"] . "/frontend/pages/admin-dashboard.php");
      else
      {
        $ruta = $this->directions["DIR_ROOT"] . "/frontend/pages/user-dashboard.php";
      }
        //header("Location: ../../frontend/pages/user-dashboard.php");
      //$ruta = $this->directions["DIR_ROOT"] . "/frontend/pages/admin-dashboard.php";
      echo json_encode(["success" => true, "redirect" => $ruta]);
      exit();
    }
    else //si la contrasena es incorecta
    {
      http_response_code(401);
      echo json_encode(["success" => false, "message" => "Usuario o contraseña incorrecta"]);
      exit();
    }
  }

  public function register($data)
  {
    //validar que no haya datos vacios
    if(empty($data["nombre"]) || empty($data["email"]) || empty($data["password"]) || empty($data["rol"]))
    {
      http_response_code(400); //bad request
      echo json_encode(["success" => false, "message" => "Datos incompletos"]);
      exit();
    }

    //verifico si existe el usuario
    $user = $this->userModel->findByEmail($data);
    //var_dump($user);
    if($user)
    {
      http_response_code(409); //conflicto
      echo json_encode(["success" => false, "message" => "El usuario ya existe"]);
      exit();
    }

    //hace el registro si no hay usuario
    $userRegister = $this->userModel->registerUser($data);
    if($userRegister == 1)
    {
      http_response_code(201); //codigo para registros exitosos
      echo json_encode(["success" => true, "message" => "Registro exitoso"]);
      exit();
    }
    else
    {
      http_response_code(500); //error del servidor
      echo json_encode(["success" => false, "message" => "Error al intentar guardar usuario"]);
      exit();
    }
  }
}
