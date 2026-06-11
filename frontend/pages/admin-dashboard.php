<?php
session_start();
if (!isset($_SESSION["user_id"]) || ($_SESSION["rol"] != "admin")) {
  header("Location: ../index.php");
  exit();
}
?>

<!DOCTYPE HTML>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="../assets/css/user-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Ajustes específicos para mantener orden de los formularios de administración */
        .admin-section {
            background-color: #fdfaf8;
            border-radius: 10px;
            padding: 30px;
            margin: 30px auto;
            width: 80%;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .admin-section h3 {
            color: #5a2a2a;
            font-weight: 700;
            border-bottom: 2px solid #d9bcbc;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .form-control, .form-select {
            border: 1px solid #d9bcbc !important;
            border-radius: 6px;
            padding: 10px;
        }
        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 0.25rem rgba(90, 42, 42, 0.15) !important;
            border-color: #5a2a2a !important;
        }
        label {
            font-weight: 600;
            color: #5a2a2a;
            margin-top: 12px;
            margin-bottom: 5px;
            display: block;
        }
        .btn-custom-vino {
            background-color: #5a2a2a;
            color: #fff;
            border: 1px solid #5a2a2a;
            padding: 10px 20px;
            border-radius: 6px;
            transition: 0.3s;
            font-weight: 600;
        }
        .btn-custom-vino:hover {
            background-color: #fff;
            color: #5a2a2a;
        }
    </style>
</head>
<body>
 <div class="sidebar">
    <a href="/ecommerce-tienda-deportiva/frontend/index.php">
        <img src="/ecommerce-tienda-deportiva/frontend/assets/img/logo.png" alt="Logo de la tienda" style="height: 60px; width: auto;" />
    </a>
    
    <ul class="menu">
      <li><a href="/ecommerce-tienda-deportiva/frontend/index.php">casa</a></li>
      <li><a href="catalogo.php">Productos</a></li>
      <li><a href="#">Pedidos</a></li>
      <li><a href="#">Usuarios</a></li>
      <li><a href="#">Métricas</a></li>
    </ul>
    <div class="user">
      <p>Hola Administrador<br><strong><?php echo $_SESSION["nombre"]; ?></strong></p>
      <a href="../../backend/index.php?action=logout" class="logout">Cerrar Sesión</a>

  <header>
    <div class="header-logo">
        <a href="/ecommerce-tienda-deportiva/frontend/index.php">
            <h1>LOGO</h1>
        </a>
    </div>
    <h2 class="user-name"><i class="fa-solid fa-user-shield"></i> Modo Administrador: <?php echo $_SESSION["nombre"]; ?></h2>
    <a href="../../backend/index.php?action=logout" class="logout-btn">
      <i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión
    </a>
  </header>

  <section class="hero">
    <img src="../assets/img/mar.jpg" alt="Fondo operativo">
  </section>

  <div class="actions">
      <a href="#section-crear" class="action-btn"><i class="fa-solid fa-plus"></i> Registrar Producto</a>
      <a href="#section-gestion" class="action-btn"><i class="fa-solid fa-boxes-stacked"></i> Inventario & Edición</a>
      <a href="#section-tabla" class="action-btn"><i class="fa-solid fa-list"></i> Ver Inventario</a>
  </div>
</div>

   

  <div class="container my-4">
      
      <section id="section-crear" class="admin-section">
          <h3><i class="fa-solid fa-square-plus"></i> Crear Nuevo Producto</h3>
          <form id="uploadProduct" class="row g-3">
              <div class="col-md-6">
                  <label for="nombreProd">Nombre del Producto</label>
                  <input type="text" class="form-control" id="nombreProd" name="nombre" required placeholder="Ej. Camiseta Oficial Selección" >
              </div>
              <div class="col-md-6">
                  <label for="categoria">Categoría</label>
                  <select class="form-select" name="categoria" id="categoria" required>
                      <option value="">-- Seleccione --</option>
                      <option value="hombre">Hombre</option>
                      <option value="mujer">Mujer</option>
                  </select>
              </div>
              <div class="col-md-12">
                  <label for="descProd">Descripción</label>
                  <textarea class="form-control" id="descProd" name="descripcion" rows="2" required placeholder="Especificaciones de la prenda..."></textarea>
              </div>
                <div class="col-md-12">
                  <label for="stockProd">Stock Disponible</label>
                  <input type="number" class="form-control" id="stockProd" name="stock" min="0" required placeholder="Ej: 20" required>
                </div>
              <div class="col-md-6">
                  <label for="precioProd">Precio (COP)</label>
                  <input type="number" class="form-control" id="precioProd" name="precio" required placeholder="0.00">
              </div>
              <div class="col-md-6">
                  <label for="imagenProd">Imagen del producto</label>
                  <input type="file" class="form-control" id="imagenProd" name="imagen" accept="image/*" required>
              </div>
              <div class="col-12 text-center mt-4">
                  <button type="submit" class="btn-custom-vino w-50">Crear Producto</button>
              </div>
          </form>
          <div id="finalStatus" class="mt-3 text-center fw-bold"></div>
      </section>

    <h4>Crear Nuevo Producto</h4>
      <section id="section-gestion" class="admin-section">
          <h3><i class="fa-solid fa-sliders"></i> Control de Inventario</h3>
          <p class="text-muted">Busca un producto por ID para modificar sus valores globales o sacarlo de las vitrinas.</p>
          
          <div class="row g-3 align-items-end mb-4" style="background: #fff; padding: 15px; border-radius: 8px; border: 1px solid #d9bcbc;">
              <div class="col-md-8">
                  <label for="buscarIdProd" class="mt-0">Ingresa el ID del Producto</label>
                  <input type="number" class="form-control" id="buscarIdProd" placeholder="Ej: 14">
              </div>
              <div class="col-md-4">
                  <button type="button" id="btnCargarProd" class="btn btn-outline-secondary w-100 py-2 fw-bold" style="border-color: #5a2a2a; color: #5a2a2a;">
                      <i class="fa-solid fa-magnifying-glass"></i> Cargar Datos
                  </button>
              </div>
          </div>

          <form id="formGestionProducto" class="row g-3">
              <input type="hidden" id="editIdProd" name="id">
              
              <div class="col-md-6">
                  <label for="editNombre">Nombre del Producto</label>
                  <input type="text" class="form-control" id="editNombre" name="nombre" disabled required>
              </div>
              <div class="col-md-6">
                  <label for="editCategoria">Categoría</label>
                  <select class="form-select" id="editCategoria" name="categoria" disabled required>
                      <option value="hombre">Hombre</option>
                      <option value="mujer">Mujer</option>
                  </select>
              </div>
              <div class="col-12">
                  <label for="editDescripcion">Descripción</label>
                  <input type="text" class="form-control" id="editDescripcion" name="descripcion" disabled required>
              </div>
              <div class="col-md-12">
                  <label for="editPrecio">Precio</label>
                  <input type="number" class="form-control" id="editPrecio" name="precio" disabled required>
              </div>
                <div class="col-md-12">
                  <label>Stock</label>
                  <input type="number" class="form-control" id="editStock" name="stock" min="0" required placeholder="Ej: 20"disabled required>
                </div>
              
              <div class="col-12 d-flex justify-content-center gap-3 mt-4">
                  <button type="button" id="btnActualizar" class="btn btn-success px-4 py-2 fw-bold" disabled>
                      <i class="fa-solid fa-floppy-disk"></i> Actualizar Cambios
                  </button>
                  <button type="button" id="btnEliminar" class="btn btn-danger px-4 py-2 fw-bold" disabled>
                      <i class="fa-solid fa-trash-can"></i> Eliminar Producto
                  </button>
              </div>
          </form>
          <div id="gestionStatus" class="mt-3 text-center fw-bold"></div>
      </section>

      <section id="section-tabla" class="admin-section">
          <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2" style="border-color: #d9bcbc !important;">
              <h3 class="m-0" style="border: none; padding: 0;"><i class="fa-solid fa-list-check"></i> Productos en Base de Datos</h3>
              <button type="button" id="btnRefrescarTabla" class="btn btn-sm btn-custom-vino">
                  <i class="fa-solid fa-rotate"></i> Actualizar Tabla
              </button>
          </div>
          <p class="text-muted">Lista completa del inventario actual disponible en la tienda.</p>

          <div class="table-responsive" style="background: #fff; border-radius: 8px; border: 1px solid #d9bcbc; padding: 10px;">
              <table class="table table-hover align-middle m-0">
                  <thead style="background-color: #f8eaea; color: #5a2a2a;">
                      <tr>
                          <th scope="col" class="fw-bold" style="color: #5a2a2a;">ID</th>
                          <th scope="col" class="fw-bold" style="color: #5a2a2a;">Miniatura</th>
                          <th scope="col" class="fw-bold" style="color: #5a2a2a;">Nombre</th>
                          <th scope="col" class="fw-bold" style="color: #5a2a2a;">Categoría</th>
                          <th scope="col" class="fw-bold" style="color: #5a2a2a;">Precio</th>
                          <th scope="col" class="fw-bold" style="color: #5a2a2a;">Stock</th>
                          <th scope="col" class="fw-bold text-center" style="color: #5a2a2a;">Acción</th>
                      </tr>
                  </thead>
                  <tbody id="tbodyProductos">
                      <tr>
                          <td colspan="7" class="text-center text-muted py-4">Cargando inventario...</td>
                      </tr>
                  </tbody>
              </table>
          </div>
      </section>

  </div>

  <script src="../assets/js/admin-script.js"></script>
</body>
</html>