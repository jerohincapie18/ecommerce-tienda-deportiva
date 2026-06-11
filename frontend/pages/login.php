<?php
  session_start();
  if(isset($_SESSION["user_id"]))
  {
    header("Location: ../index.php");
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Khella - Log in</title>
    <link href="../assets/css/login-register-style.css" rel="stylesheet">
    <link rel="shortcut icon" href="../assets/img/logo-w.ico" type="image/x-icon">
  </head>
  <body>
   <div class="container">
        <div class="form-box" id="login-form">
            <form action="submit" method = "post" id="main-form">
                <h2>Login</h2>
                <input 
                    type="email" name="email" placeholder="Email" id="email" required>
                <input 
                    type="password" name="contrasena" placeholder="Contraseña" id="contrasena" required>

                <button type="submit" name="login"> Login </button>
                <div id="finalStatus"></div>
                <p>
                    No estoy registrado <a href="./register.php">Registrar</a>
                <p><a href="../index.php">Regresar al home</a></p>
                </p>
            </form>
        </div>
      <script src="../assets/js/login-script.js"></script>
  </body>
</html>
