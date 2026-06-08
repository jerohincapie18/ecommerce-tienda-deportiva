<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Producto</title>
    <link rel="stylesheet" href="../assets/css/index-style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <header style="margin-bottom: 50px">
    <?php include("../components/navbar.php") ?>
  </header>

  <div class="container my-5">
      <div class="row g-5">
          <div class="col-md-6">
              <div class="product-image-container" style="border: 1px solid #ddd; overflow:hidden; border-radius: 8px;">
                  <img id="det-imagen" src="" alt="Cargando..." class="img-fluid w-100" style="height: 500px; object-fit: cover;">
              </div>
          </div>
          
          <div class="col-md-6 d-flex flex-column justify-content-center">
              <h1 id="det-nombre" class="text-capitalize mb-2" style="color: #121042;">Cargando producto...</h1>
              <span id="det-categoria" class="badge bg-secondary align-self-start mb-3 text-uppercase">Categoría</span>
              <h2 id="det-precio" class="text-success fw-bold mb-4">$0</h2>
              
              <p id="det-descripcion" class="text-muted mb-5">
                  Cargando la descripción detallada del producto desde la base de datos...
              </p>

              <div class="d-flex gap-3">
                  <button id="btn-add-carrito" class="btn btn-dark btn-lg px-5">
                       🛒 Añadir al Carrito 
                  </button>
                  <button id="btn-add-favorito" class="btn btn-outline-danger btn-lg px-4">
                      ❤ Favorito
                  </button>
              </div>
          </div>
      </div>
  </div>

  <script src="../assets/js/producto-script.js"></script>
</body>
</html>