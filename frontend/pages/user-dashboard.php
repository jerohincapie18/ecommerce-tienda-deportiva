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
  <div class="info-grid">
    <div class="info-item">
      <label>Nombre</label>
      <p><?php echo $_SESSION["nombre"]; ?></p>
    </div>
    <div class="info-item">
      <label>Apellido</label>
     
    </div>
    <div class="info-item">
      <label>Email</label>
     
    </div>
    <div class="info-item">
      <label>Género</label>

    </div>
  </div>

  <button class="edit-btn">Editar perfil</button>
</section>
</body>
</html>
