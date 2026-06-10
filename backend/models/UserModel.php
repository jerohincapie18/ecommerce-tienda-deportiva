<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//puedo llamar asi como si estuviera en ./backend, porque desde la api de js viene a buscar desde ese directiorio
require("./config/main-config.php");
class UserModel
{
  private $db;
  public function __construct()
  {
    // Usamos la palabra clave global SOLO aqui para meter la variable $conn 
    // que viene de 'main-config.php' dentro de la clase
    global $conn;
    // La guardamos en nuestra propiedad interna para usarla en cualquier metodo
    $this->db = $conn;
  }

  public function findByEmail($data)
  {
    //como recibi los datos como arreglo asociativo, los llamo por []
    $email = $data["email"];
    // $this->db tiene la conexion guardada de $conn, con sentencias preparadas por seguridad
    $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ? LIMIT 1"); //limit 1 hace que pare la consulta apenas encontro los datos
    //le dice al stmt que el email es un string
    $stmt->bind_param("s", $email);
    $stmt->execute();
    //captura el resultado y se hace el fetch para guardar la fila en un arreglo asociativo
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    //se cierra por buena practica
    $stmt->close();
    //retorno usuario para seguirlo manipulando en authcontroller
    return $user;
  }

  public function registerUser($data)
  {
    //rescato los datos
    $nombre = $data["nombre"];
    $email = $data["email"];
    $pass = $data["password"];
    $rol = $data["rol"];
    //hasheo la contrasena
    $passHash = password_hash($data["password"], PASSWORD_DEFAULT); //bcrypt a partir de php 5.5.0
    //preparo la consulta
    $stmt = $this->db->prepare("INSERT INTO users (nombre, email, contrasena, rol) VALUES (?, ?, ?, ?)");
    //le digo al stmt que son cada uno de los ?
    $stmt->bind_param("ssss", $nombre, $email, $passHash, $rol);
    //ejecucion y evaluacion del valor devuelto
    $stmt->execute();
    //guardo las columnas afectadas (si se realizo la consulta guarda 1, sino -1)
    $affectedRows = $stmt->affected_rows;
    $stmt->close();
    return $affectedRows;
  }

  public function updateProfile($userData, $id)
  {
    $userName = $userData["nombre"];
    $userEmail = $userData["email"];
    $userId = $id;
    $stmt = $this->db->prepare("UPDATE users SET nombre = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $userName, $userEmail, $userId);
    $resultado = $stmt->execute();
    $stmt->close();
    return $resultado;
  }
}
