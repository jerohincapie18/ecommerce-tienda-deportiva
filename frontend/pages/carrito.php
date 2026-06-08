<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Carrito de Compras</title>
    <link rel="stylesheet" href="../assets/css/index-style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <header style="margin-bottom: 50px">
    <?php include("../components/navbar.php") ?>
  </header>

  <div class="container my-5">
      <h2 style="color: #121042; font-weight: 800;" class="text-uppercase mb-4">🛒 Mi Carrito de Compras</h2>
      
      <div class="row g-4">
          <div class="col-lg-8">
              <div class="table-responsive" style="background: #fff; border: 1px solid #ddd; border-radius: 8px; padding: 15px;">
                  <table class="table align-middle">
                      <thead class="table-light">
                          <tr>
                              <th>Producto</th>
                              <th>Precio</th>
                              <th>Cantidad</th>
                              <th>Subtotal</th>
                              <th>Acciones</th>
                          </tr>
                      </thead>
                      <tbody id="cart-table-body">
                          </tbody>
                  </table>
              </div>
          </div>

          <div class="col-lg-4">
              <div style="background: rgb(247, 241, 239); border: 1px solid #ddd; border-radius: 8px; padding: 25px;">
                  <h4 style="color: #121042; font-weight: bold;" class="mb-4">Resumen del Pedido</h4>
                  <div class="d-flex justify-content-between mb-3" style="font-size: 1.1rem;">
                      <span>Total Productos:</span>
                      <span id="cart-total-productos" class="fw-bold">0</span>
                  </div>
                  <hr>
                  <div class="d-flex justify-content-between mb-4" style="font-size: 1.3rem; color: #28a745; font-weight: bold;">
                      <span>Total Neto:</span>
                      <span id="cart-total-pagar">$0</span>
                  </div>
                  <button class="btn btn-dark w-100 btn-lg py-3" onclick="alert('¡Compra simulada con éxito!')">
                      Proceder al Pago
                  </button>
              </div>
          </div>
      </div>
  </div>

  <script src="../assets/js/carrito-script.js"></script>
</body>
</html>