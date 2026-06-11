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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Khella - Panel de Usuario</title>
  <link rel="stylesheet" href="../assets/css/user-style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../assets/img/logo-w.ico" type="image/x-icon">
  
  <style>
    header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 5%;
        background: #fff;
        flex-wrap: wrap;
        gap: 15px;
    }
    .user-name { font-size: 1.5rem; color: #121042; font-weight: 700; margin: 0; }
    .logout-btn { color: #dc3545; text-decoration: none; font-weight: 600; }
    
    .hero { width: 100%; height: 200px; overflow: hidden; }
    .hero img { width: 100%; height: 100%; object-fit: cover; }

    .actions {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin: 30px auto;
        padding: 0 15px;
        max-width: 600px;
        flex-wrap: wrap;
    }
    .action-btn {
        flex: 1;
        min-width: 140px;
        background-color: #5a2a2a;
        color: #fff;
        text-align: center;
        padding: 12px 20px;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
        transition: 0.3s;
    }
    .action-btn:hover { background-color: #fff; color: #5a2a2a; border: 1px solid #5a2a2a; }

    
    .user-info {
        background: #fdfaf8;
        padding: 25px;
        border-radius: 12px;
        max-width: 800px;
        margin: 20px auto;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .user-info h3 { color: #5a2a2a; font-weight: 700; border-bottom: 2px solid #d9bcbc; padding-bottom: 10px; }
    
    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-top: 20px;
    }
    .info-item {
        background: #fff;
        padding: 12px 15px;
        border-radius: 8px;
        border: 1px solid #d9bcbc;
    }
    .info-item label { font-size: 12px; color: #888; font-weight: 600; display: block; margin-bottom: 4px; }

    @media (max-width: 767.98px) {
        header { text-align: center; justify-content: center; flex-direction: column; }
        .info-grid { grid-template-columns: 1fr; }
        .actions { width: 100%; }
        .action-btn { width: 100%; flex: none; }
    }
  </style>
</head>

<body style="padding-top: 100px;"> <header class="d-none"> </header>
  
  <?php include("../components/navbar.php") ?>

  <section class="hero">
    <img src="../assets/img/mar.jpg" alt="Fondo marino">
  </section>

  <div class="container px-3">
    <div class="my-4 text-center text-md-start">
        <h2 class="user-name"><i class="fa-solid fa-circle-user"></i> Panel de: <?php echo $_SESSION["nombre"]; ?></h2>
        <small class="text-muted"><?php echo $_SESSION["email"]; ?></small>
    </div>

    <div class="actions">
      <a href="/ecommerce-tienda-deportiva/frontend/pages/favoritos.php" class="action-btn">
        <i class="fa-regular fa-heart"></i> Favoritos
      </a>
      <a href="/ecommerce-tienda-deportiva/frontend/pages/carrito.php" class="action-btn">
        <i class="fa-solid fa-cart-shopping"></i> Carrito
      </a>
      <a href="../../backend/index.php?action=logout" class="logout-btn">
      <i class="fa-solid fa-right-from-bracket"></i> cerrar sesion
    </a>
    </div>

    <section class="user-info">
      <h3><i class="fa-solid fa-id-card"></i> Información del Usuario</h3>
      
      <form id="formEditarPerfil" class="main-form">
        <div class="info-grid">
          <div class="info-item">
            <label for="inputNombre">Nombre Completo</label>
            <input type="text" id="inputNombre" name="nombre" value="<?php echo $_SESSION['nombre']; ?>" disabled style="border: none; background: transparent; width: 100%; font-size: 16px; color: #2c2c2c; outline: none;">
          </div>
          <div class="info-item">
            <label for="inputEmail">Correo Electrónico</label>
            <input type="email" id="inputEmail" name="email" value="<?php echo $_SESSION['email']; ?>" disabled style="border: none; background: transparent; width: 100%; font-size: 16px; color: #2c2c2c; outline: none;">
          </div>
          
          <div class="info-item col-12" id="wrapperPassword" style="display: none; grid-column: 1 / -1;">
            <label for="inputPassword">Confirmar con Contraseña</label>
            <input type="password" id="inputPassword" name="password" placeholder="Escribe la contraseña para guardar" style="border: 1px solid #d9bcbc; background: #fff; width: 100%; font-size: 15px; color: #2c2c2c; padding: 8px; border-radius: 6px; box-sizing: border-box; outline: none;" required>
          </div>
        </div>

        <div class="d-flex justify-content-center gap-3 mt-4">
          <button type="button" id="btnEditar" class="edit-btn" style="background-color: transparent; border: 1px solid #5a2a2a; color: #5a2a2a; padding: 10px 20px; border-radius: 6px; cursor: pointer; transition: 0.3s; font-weight: 600;">Editar Perfil</button>
          <button type="submit" id="btnGuardar" class="edit-btn" style="display: none; background-color: #5a2a2a; border: 1px solid #5a2a2a; color: #fff; padding: 10px 20px; border-radius: 6px; cursor: pointer; transition: 0.3s; font-weight: 600;">Guardar Cambios</button>
        </div>
      </form>
      <div id="statusPerfil" class="mt-3 text-center" style="font-weight: 600;"></div>
    </section>
  </div>

  <script src="../assets/js/user-script.js"></script>
</body>
</html>