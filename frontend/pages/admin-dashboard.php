<?php
//aqui va la logina php que protege al panel de administrador
session_start();
if(!isset($_SESSION["user_id"]) || ($_SESSION["rol"] != "admin"))
{
  header("Location: ../index.php");
  exit();
}
?>
<!DOCTYPE HTML>
<html>
<head>

</head>
<body>
  <h1><?php echo "hola administrador ". $_SESSION["nombre"];?></h1>
  <button><a href="../../backend/index.php?action=logout">Cerrar sesion</a></button>
  <button><a href="../index.php">Volver a la pagina de inicio</a></button>
</body>

</html>
