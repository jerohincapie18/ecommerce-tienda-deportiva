<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start(); //esto basicamente me lee la sesion en todas las paginas
  //entonces, como el include carga todo el codigo no hay que ir 1 a 1 llamando el session_start
}
?>
<nav
  class="navbar navbar-expand-lg navbar-dark fixed-top py-3"
  style="
    background-color: rgb(247, 241, 239);
    font-family: &quot;Montserrat&quot;, sans-serif;
    font-weight: 800;
  "
>
  <div class="header-storeSections">
    <a href="/ecommerce-tienda-deportiva/frontend/pages/hombre.php"><button>Hombre</button></a>
    <a href="/ecommerce-tienda-deportiva/frontend/pages/mujer.php"><button>Mujer</button></a>
    <button>Nuevo</button>
  </div>

  <div class="header-logo">
    <img src="" alt="" />
    <h1><a href="/ecommerce-tienda-deportiva/frontend/index.php">LOGO</a></h1>
  </div>
  
  <div class="header-storeOptions">
    
    <button>favoritos</button>
    <button>carrito</button>
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

