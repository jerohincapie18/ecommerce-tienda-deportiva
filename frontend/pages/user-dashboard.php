<?php
session_start();
if(!isset($_SESSION["user_id"]) || !isset($_SESSION["rol"])) {
  header("Location: ../pages/login.php");
  exit();
}
?>

<!DOCTYPE HTML>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel de Usuario</title>
  <link rel="stylesheet" href="../assets/css/user-style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
  <header>
  <div class="header-logo">
    <a href="/ecommerce-tienda-deportiva/frontend/index.php">
        <img src="/ecommerce-tienda-deportiva/frontend/assets/img/logo.png" alt="Logo de la tienda" style="height: 60px; width: auto;" />
    </a>
</div>
    <h2 class="user-name">Hola <?php echo $_SESSION["nombre"]; ?></h2>
    <a href="../../backend/index.php?action=logout" class="logout-btn">
      <i class="fa-solid fa-right-from-bracket"></i> cerrar sesion
    </a>
  </header>

  <section class="hero">
    <img src="../assets/img/mar.jpg" alt="Fondo marino">
  </section>



    <div class="actions">
      <a href="/ecommerce-tienda-deportiva/frontend/pages/favoritos.php" class="action-btn">
        <i class="fa-regular fa-heart"></i> Favoritos
      </a>
      <a href="/ecommerce-tienda-deportiva/frontend/pages/carrito.php" class="action-btn">
        <i class="fa-solid fa-cart-shopping"></i> Carrito
      </a>
    </div>

<section class="user-info">
  <h3>Información del Usuario</h3>
  
  <form id="formEditarPerfil" class="main-form">
    <div class="info-grid">
      <div class="info-item">
        <label for="inputNombre">Nombre</label>
        <input type="text" id="inputNombre" name="nombre" value="<?php echo $_SESSION['nombre']; ?>" disabled style="border: none; background: transparent; width: 100%; font-size: 16px; color: #2c2c2c; outline: none;">
      </div>
      <div class="info-item">
        <label for="inputEmail">Email</label>
        <input type="email" id="inputEmail" name="email" value="<?php echo $_SESSION['email']; ?>" disabled style="border: none; background: transparent; width: 100%; font-size: 16px; color: #2c2c2c; outline: none;">
      </div>
      
      <div class="info-item" id="wrapperPassword" style="display: none;">
        <label for="inputPassword">Ingrese la contraseña</label>
        <input type="password" id="inputPassword" name="password" placeholder="Escribe la contraseña para guardar los cambios" style="border: 1px solid #d9bcbc; background: #fff; width: 100%; font-size: 16px; color: #2c2c2c; padding: 10px; border-radius: 6px; box-sizing: border-box; outline: none;" required>
      </div>
    </div>

    <div class="d-flex justify-content-center gap-3 mt-4">
      <button type="button" id="btnEditar" class="edit-btn" style="background-color: transparent; border: 1px solid #5a2a2a; color: #5a2a2a; padding: 10px 20px; border-radius: 6px; cursor: pointer; transition: 0.3s;">Editar perfil</button>
      <button type="submit" id="btnGuardar" class="edit-btn" style="display: none; background-color: #5a2a2a; border: 1px solid #5a2a2a; color: #fff; padding: 10px 20px; border-radius: 6px; cursor: pointer; transition: 0.3s;">Guardar cambios</button>
    </div>
  </form>
  <div id="statusPerfil" class="mt-3" style="font-weight: 600;"></div>
</section>
<script src="../assets/js/user-script.js"></script>
</body>
</html>
