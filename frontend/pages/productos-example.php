<?php
session_start();
require_once '../../backend/config/conexion.php'; 
require_once '../../backend/models/ProductModel.php';

// 1. Atrapar el ID de la URL. Si no viene ninguno, lo mandamos al index
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: /ecommerce-tienda-deportiva/frontend/index.php");
    exit();
}

$idProducto = intval($_GET['id']); // intval limpia el dato para que sea un número seguro

$productModel = new ProductModel($db);
$item = $productModel->getProductById($idProducto);

// 2. Si el ID no coincide con ningún producto en la BD... ¡404 real o redirección!
if (!$item) {
    echo "<h1>El producto que buscas no existe.</h1>";
    echo "<a href='/ecommerce-tienda-deportiva/frontend/index.php'>Volver a la tienda</a>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $item['nombre']; ?> - Tienda Deportiva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="padding-top: 100px;">

    <?php include '../../backend/componentes/navbar.php'; ?>

    <div class="container my-5">
        <div class="row">
            <div class="col-md-6">
                <img src="/ecommerce-tienda-deportiva/frontend/<?php echo $item['imagen_url']; ?>" alt="<?php echo $item['nombre']; ?>" class="img-fluid rounded shadow" style="width: 100%; max-height: 500px; object-fit: cover;">
            </div>

            <div class="col-md-6 d-flex flex-column justify-content-center">
                <span class="badge bg-secondary mb-2 text-uppercase"><?php echo $item['categoria']; ?></span>
                <h1 class="display-5 fw-bold"><?php echo $item['nombre']; ?></h1>
                <p class="fs-3 text-success my-3 fw-bold">$<?php echo number_format($item['precio'], 2); ?></p>
                <p class="fs-3 text-success my-3 fw-bold"><?php echo $item['stock']; ?></p>
                <hr>
                
                <h5>Descripción del Producto</h5>
                <p class="text-muted"><?php echo $item['descripcion'] ?? 'Sin descripción disponible para este producto por el momento.'; ?></p>
                
                <div class="d-grid gap-2 d-md-flex mt-4">
                    <button class="btn btn-dark btn-lg px-5 py-3" data-id="<?php echo $item['id']; ?>">Añadir al Carrito</button>
                    <button class="btn btn-outline-danger btn-lg px-4" data-id="<?php echo $item['id']; ?>">Añadir a Favoritos</button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
