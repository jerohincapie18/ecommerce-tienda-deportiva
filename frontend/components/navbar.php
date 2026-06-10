<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start(); //esto basicamente me lee la sesion en todas las paginas
  //entonces, como el include carga todo el codigo no hay que ir 1 a 1 llamando el session_start
}
?>

<nav
  id="miNavbar"
  class="navbar navbar-expand-lg navbar-dark fixed-top py-3"
  style="
    background-color: rgb(247, 241, 239);
    font-family: &quot;Montserrat&quot;, sans-serif;
    font-weight: 800;
    transition: top 0.8s;
  "
>
  <div class="header-storeSections">
    <a href="/ecommerce-tienda-deportiva/frontend/pages/hombre.php"><button>Hombre</button></a>
    <a href="/ecommerce-tienda-deportiva/frontend/pages/mujer.php"><button>Mujer</button></a>
    <a href="/ecommerce-tienda-deportiva/frontend/pages/catalogo.php"><button>Nuevo: Catalogo</button></a>
  </div>
<div class="header-logo">
    <a href="/ecommerce-tienda-deportiva/frontend/index.php">
        <img src="/ecommerce-tienda-deportiva/frontend/assets/img/logo.png" alt="Logo de la tienda" style="height: 60px; width: auto;" />
    </a>
</div>
  
  <div class="header-storeOptions">
    
    <a href="/ecommerce-tienda-deportiva/frontend/pages/favoritos.php" style="text-decoration: none;">
      <button>Favoritos</button></a>
    <a href="/ecommerce-tienda-deportiva/frontend/pages/carrito.php" style="text-decoration: none;">
      <button>Carrito</button></a>
    <button>
    <?php
      if(isset($_SESSION["user_id"]))
      {
        if($_SESSION["rol"] == "user")
          echo "<a style='color:black; text-decoration:none;' href='/ecommerce-tienda-deportiva/frontend/pages/user-dashboard.php'>" . $_SESSION["nombre"] . "</a>";
        else if($_SESSION["rol"] == "admin")
          echo "<a style='color:black; text-decoration: none; ' href='/ecommerce-tienda-deportiva/frontend/pages/admin-dashboard.php'>" . $_SESSION["nombre"] . "</a>";
      }
      else
      {
        echo "<a style='color:black; text-decoration: none; ' href='/ecommerce-tienda-deportiva/frontend/pages/login.php'>Ingresar</a>";
      }
    ?>
    </button>
  </div>
</nav>

<script>
    let ubicacionPrincipal = window.pageYOffset;
    const miNavbar = document.getElementById("miNavbar");

    window.addEventListener("scroll", function() {
        let desplazamientoActual = window.pageYOffset;
        
        if (ubicacionPrincipal >= desplazamientoActual) {
            miNavbar.style.top = "0"; 
        } else {
            miNavbar.style.top = "-150px"; 
        }
        
        ubicacionPrincipal = desplazamientoActual;
    });
</script>
