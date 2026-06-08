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
  <form id="uploadProduct" action="submit" style="margin-top: 20px;">
    <input type="text" placeholder="Nombre" id="nombreProd" name="nombre" required> 
    <input type="text" placeholder="Descripcion" id="descProd" name="descripcion" required>
    <input type="number" placeholder="Precio" id="precioProd" name="precio" required>
    <select name="categoria" id="categoria" required>
      <option value="">--Seleccione una categoria--</option>
      <option value="hombre">Hombre</option>
      <option value="mujer">Mujer</option>
    </select>
    <div style="margin: 10px 0;">
      <label for="imagenProd">Imagen del producto</label>
      <input type="file" id="imagenProd" name="imagen" accept="image/*" required>
    </div>
    <button type="submit" name="enviarProd">Crear Producto</button>
  </form>
  <div id="finalStatus"></div>
  <a href="/ecommerce-tienda-deportiva/frontend/pages/favoritos.php" style="text-decoration: none;">
    <button>Favoritos</button>
</a>
<script src="../assets/js/admin-script.js"></script>
</body>

</html>
