<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khella - Busqueda</title>
    <link rel="stylesheet" href="../assets/css/index-style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../assets/img/logo-w.ico" type="image/x-icon">
</head>
<body>
  <header style="margin-bottom: 50px">
    <?php include("../components/navbar.php") ?>
  </header>
  <section class="main-storeSection" id="mainStore">
        <ul class="grid-4" id="ulStoreGrid">
        </ul>
    </section>
    <div class="show-more-div">
        <button onclick="window.history.back();" class="btn-volver" style="margin-top: 20px">
          <i class="fa-solid fa-arrow-left"></i><-- Volver atrás
      </button>
       <!-- <button class="show-more" id="showMore">Mostrar más +</button> -->
    </div>
    <script src="../assets/js/busqueda-script.js"></script>
</body>
</html>
