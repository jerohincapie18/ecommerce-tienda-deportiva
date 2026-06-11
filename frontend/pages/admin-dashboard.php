<?php
//aqui va la logina php que protege al panel de administrador
session_start();
if (!isset($_SESSION["user_id"]) || ($_SESSION["rol"] != "admin")) {
  header("Location: ../index.php");
  exit();
}
?>

<!DOCTYPE HTML>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>hombre</title>
     <link rel="stylesheet" href="../assets/css/admin-style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
 <div class="sidebar">
    <a href="/ecommerce-tienda-deportiva/frontend/index.php">
        <img src="/ecommerce-tienda-deportiva/frontend/assets/img/logo.png" alt="Logo de la tienda" style="height: 60px; width: auto;" />
    </a>
    
    <ul class="menu">
      <li><a href="/ecommerce-tienda-deportiva/frontend/index.php">casa</a></li>
      <li><a href="catalogo.php">Productos</a></li>
      <li><a href="#">Pedidos</a></li>
      <li><a href="#">Usuarios</a></li>
      <li><a href="#">Métricas</a></li>
    </ul>
    <div class="user">
      <p>Hola Administrador<br><strong><?php echo $_SESSION["nombre"]; ?></strong></p>
      <a href="../../backend/index.php?action=logout" class="logout">Cerrar Sesión</a>
    </div>
  </div>
</div>

   

  <div class="main-content">
    <h2>Gestión de Productos</h2>

    <h4>Crear Nuevo Producto</h4>

    <form id="uploadProduct" action="submit" class="product-form">
      <label>Nombre del Producto</label>
      <input type="text" id="nombreProd" name="nombre" required>

      <label>Descripción</label>
      <input type="text" id="descProd" name="descripcion" required>

      <div class="form-row">
        <div>
          <label>Precio</label>
          <input type="number" id="precioProd" name="precio" required>
        </div>
        <div>
          <label>Categoría</label>
          <select name="categoria" id="categoria" required>
            <option value="">--Seleccione--</option>
            <option value="hombre">Hombre</option>
            <option value="mujer">Mujer</option>
          </select>
        </div>
      </div>

      <label>Imagen del producto</label>
      <div class="upload-box">
        <input type="file" id="imagenProd" name="imagen" accept="image/*" required>
      </div>

      <button type="submit" name="enviarProd" class="btn-submit">Crear Producto</button>
    </form>

    <div id="finalStatus"></div>
  </div>

  <script src="../assets/js/admin-script.js"></script>
</body>



</html>