<?php
session_start();
//la validacion, de que, si no esta loggeado no me deje pasar
if(!isset($_SESSION["user_id"]) || !isset($_SESSION["rol"]))
{
  header("Location: ../pages/login.php");
  exit();
}
?>

<!DOCTYPE HTML>
<html>
<head>

</head>
<body>
  <h1><?php echo "hola usuario ". $_SESSION["nombre"];?></h1>
  <button><a href="../../backend/index.php?action=logout">Cerrar sesion</a></button>
  <button><a href="../index.php">Volver a la pagina de inicio</a></button>
</body>

</html>


