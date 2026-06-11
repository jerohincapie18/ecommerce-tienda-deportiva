<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khella - Catalogo</title>
    <link rel="stylesheet" href="../assets/css/index-style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <header style="margin-bottom: 50px">
    <?php include("../components/navbar.php") ?>
  </header>
  <section class="main-carousel" id="mainCarousel">
    <div class="carousel" id="carousel">
    </div>
    <div class="controls">
        <button onclick="mover(-1)">Anterior</button>
        <button onclick="mover(1)">Siguiente</button>
    </div>
  </section>
  <section class="main-storeSection">
        <ul class="grid-4" id="ulStoreGrid">
        </ul>
    </section>
    <div class="show-more-div">
        <button class="show-more" id="showMore">Mostrar más +</button>
    </div>
    <script src="../assets/js/catalogo-script.js"></script>

    <?php include("../components/footer.php"); ?>
</body>
</html>
