<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khella - Tienda deportiva</title>
    <link rel="stylesheet" href="./assets/css/index-style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="./assets/img/logo-w.ico" type="image/x-icon">
</head>
<body>
    <header>
      <?php include("./components/navbar.php") ?>
    </header>
  <section class="hero-section">
       <img src="./assets/img/bannertres.jpg" alt="" />
  </section>

    <section class="store-categories">
        <button>categoria</button>
        <button>categoria</button>
        <button>categoria</button>
        <button>categoria</button>
    </section>

    <section class="main-storeSection">
        <ul class="grid-4" id="ulStoreGrid">
            
        </ul>
    </section>
    <div class="show-more-div">
        <button class="show-more" id="showMore">Mostrar más +</button>
    </div>

    <?php include("components/footer.php"); ?>
    
    <script src="./assets/js/index-script.js"></script>
</body>
</html>
