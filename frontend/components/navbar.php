<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>

<nav
  id="miNavbar"
  class="navbar navbar-expand-lg navbar-dark fixed-top py-3"
  style="
    background-color: rgb(247, 241, 239);
    font-family: 'Montserrat', sans-serif;
    font-weight: 800;
    transition: top 0.8s;
  "
>
  <style>
    /* Estilos de la lupa (boton buscar)*/
    .search-wrapper {
        display: flex;
        align-items: center;
        position: relative;
        margin-right: 15px;
    }
    .search-input {
        width: 0px;
        opacity: 0;
        border: none;
        outline: none;
        padding: 6px 0px;
        background: transparent;
        border-bottom: 2px solid #5a2a2a;
        color: #2c2c2c;
        font-family: 'Montserrat', sans-serif;
        font-weight: 600;
        font-size: 14px;
        transition: width 0.4s ease, opacity 0.3s ease, padding 0.4s ease;
        pointer-events: none;
    }
    .search-input.active {
        width: 180px;
        opacity: 1;
        padding: 6px 10px;
        pointer-events: auto;
    }
    .search-icon-btn {
        background: transparent;
        border: none;
        color: #5a2a2a;
        font-size: 18px;
        cursor: pointer;
        transition: transform 0.3s ease;
        padding: 5px 10px;
    }
    .search-icon-btn:hover {
        transform: scale(1.1);
    }
  </style>

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
    <div class="search-wrapper">
        <input type="text" id="navbarSearchInput" class="search-input" placeholder="Buscar producto...">
        <button type="button" id="btnToggleSearch" class="search-icon-btn" title="Buscar">
          BUSCAR
            <i class="fa-solid fa-magnifying-glass" id="searchIcon"></i>
        </button>
    </div>

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
    //logica del scroll para ocultar
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

    //animacion de la lupa
    document.addEventListener("DOMContentLoaded", () => {
        const btnToggleSearch = document.getElementById("btnToggleSearch");
        const searchInput = document.getElementById("navbarSearchInput");
        const searchIcon = document.getElementById("searchIcon");
        btnToggleSearch.addEventListener("click", (e) => {
            e.stopPropagation(); // Evita que el clic cierre la barra inmediatamente
            
            const isOpen = searchInput.classList.contains("active");

            if (!isOpen) {
                // Abrir barra de búsqueda
                searchInput.classList.add("active");
                searchInput.focus();
                // Mutamos el icono a una 'X' de cierre para dar feedback visual premium
                searchIcon.className = "fa-solid fa-xmark";
            } else {
                // Si ya estaba abierta y tiene texto, puedes elegir que busque o que se cierre
                if (searchInput.value.trim() !== "") {
                    // Si el usuario da clic teniendo texto, puedes disparar la búsqueda también
                    dispararBusqueda(searchInput.value.trim());
                } else {
                    cerrarBuscador();
                }
            }
        });

        //cerrar si presionan la tecla ESC
        searchInput.addEventListener("keydown", (e) => {
            if (e.key === "Escape") {
                cerrarBuscador();
            }
            if (e.key === "Enter") {
                dispararBusqueda(searchInput.value.trim());
            }
        });

        //cerrar si hacen clic en cualquier otra parte del navbar/pantalla
        document.addEventListener("click", (e) => {
            if (!e.target.closest(".search-wrapper")) {
                cerrarBuscador();
            }
        });

        function cerrarBuscador() {
            searchInput.classList.remove("active");
            searchInput.value = "";
            searchIcon.className = "fa-solid fa-magnifying-glass";
        }

        
        function dispararBusqueda(termino) {
            if (!termino) return;
            console.log("Buscando:", termino);
            
            // Ejemplo de redirección clásica al catálogo pasándole el query string:
            window.location.href = `/ecommerce-tienda-deportiva/frontend/pages/pagina-busqueda.php?search=${encodeURIComponent(termino)}`;
        }
    });
</script>