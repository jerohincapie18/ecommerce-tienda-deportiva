<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link href="../assets/css/login-register-style.css" rel="stylesheet">
  </head>
  <body>
    <div class="form-box" id="register-form">

            <form action="submit" method = "POST" id="mainForm">

                <h2>Registrar</h2>

                <div id="logNombre"></div>
                <input type="text" name="nombre" placeholder="Nombre" id="nombre" required>

                <div id="logEmail"></div>
                <input  type="email" name="email"  placeholder="Email"  id="email" required>

                <div id="logPassword"></div>
                <input type="password" name="contrasena" placeholder="Contraseña" id="contrasena" required>
        
                <div id="logRol"></div>
                <select name="rol" id="roles" required>
                    <option value="">--Seleccione su rol--</option>
                    <option value="user">Usuario</option>
                    <option value="admin">Administrador</option>
                </select>

                <button type="submit" name="registrar" id="rgButton">Registrar</button>
                <div id="finalStatus"></div>
                <p>Ya estoy registrado <a href="./login.php">login</a></p> </form>
    </div>
    <script src="../assets/js/register-script.js"></script>
  </body>
</html>
