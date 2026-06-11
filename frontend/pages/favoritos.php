<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khella - Mis Favoritos</title>
    <link rel="stylesheet" href="../assets/css/index-style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <header style="margin-bottom: 50px">
    <?php include("../components/navbar.php") ?>
  </header>

  <main class="main-storeSection">
        <div class="container mb-4">
            <h2 style="color: #121042; font-weight: 800;" class="text-uppercase">❤️ Mis Productos Favoritos</h2>
            <p class="text-muted">Artículos que guardaste para comprar después</p>
        </div>

        <ul class="grid-4" id="ulFavoritosGrid">
            </ul>
  </main>

  <script src="../assets/js/favoritos-script.js"></script>
  <?php include("../components/footer.php"); ?>
</body>
</html>