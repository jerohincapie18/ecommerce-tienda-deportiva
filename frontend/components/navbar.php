<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>

<nav id="miNavbar" class="navbar navbar-expand-lg navbar-light fixed-top py-2 py-md-3" style="background-color: rgb(247, 241, 239); font-family: 'Montserrat', sans-serif; font-weight: 800; transition: top 0.8s; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
  <div class="container-fluid px-3 px-md-4">
    
    <a class="navbar-brand m-0 p-0 order-1" href="/ecommerce-tienda-deportiva/frontend/index.php">
        <img src="/ecommerce-tienda-deportiva/frontend/assets/img/logo.png" alt="Logo" style="height: 45px; width: auto; transition: 0.3s;" id="navLogo" />
    </a>

    <button class="navbar-toggler order-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavOptions" aria-controls="navbarNavOptions" aria-expanded="false" aria-label="Toggle navigation" style="border-color: #5a2a2a; color: #5a2a2a;">
        <span class="navbar-toggler-icon" style="filter: invert(18%) sepia(43%) saturate(1344%) hue-rotate(323deg) brightness(85%) contrast(92%);"></span>
    </button>

    <div class="collapse navbar-collapse order-4 order-lg-2" id="navbarNavOptions">
        
        <div class="navbar-nav me-auto my-3 my-lg-0 gap-2 store-sections-nav">
            <a class="nav-link-custom" href="/ecommerce-tienda-deportiva/frontend/pages/hombre.php">Hombre</a>
            <a class="nav-link-custom" href="/ecommerce-tienda-deportiva/frontend/pages/mujer.php">Mujer</a>
            <a class="nav-link-custom" href="/ecommerce-tienda-deportiva/frontend/pages/catalogo.php" style="color: #28a745 !important;">Nuevo: Catalogo</a>
        </div>
        
        <div class="navbar-nav ms-auto align-items-lg-center gap-2 store-options-nav">
            
            <div class="search-wrapper my-2 my-lg-0">
                <input type="text" id="navbarSearchInput" class="search-input" placeholder="Buscar producto...">
                <button type="button" id="btnToggleSearch" class="search-icon-btn" title="Buscar">
                    <i class="fa-solid fa-magnifying-glass" id="searchIcon"></i>
                </button>
            </div>

            <a class="nav-link-custom" href="/ecommerce-tienda-deportiva/frontend/pages/favoritos.php"><i class="fa-regular fa-heart d-none d-lg-inline me-1"></i>Favoritos</a>
            <a class="nav-link-custom" href="/ecommerce-tienda-deportiva/frontend/pages/carrito.php"><i class="fa-solid fa-cart-shopping d-none d-lg-inline me-1"></i>Carrito</a>
            
            <?php
              if(isset($_SESSION["user_id"])) {
                $dashboardUrl = ($_SESSION["rol"] == "admin") ? 'admin-dashboard.php' : 'user-dashboard.php';
                echo "<a class='nav-link-custom user-profile-link' href='/ecommerce-tienda-deportiva/frontend/pages/{$dashboardUrl}'><i class='fa-solid fa-user me-1'></i>" . $_SESSION["nombre"] . "</a>";
              } else {
                echo "<a class='nav-link-custom user-profile-link' href='/ecommerce-tienda-deportiva/frontend/pages/login.php'><i class='fa-solid fa-right-to-bracket me-1'></i>Ingresar</a>";
              }
            ?>
        </div>
    </div>
  </div>

  <style>
  /* Estilos para los iconos */
    @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css');
    .nav-link-custom {
        color: #5a2a2a !important;
        text-decoration: none;
        padding: 8px 16px;
        font-size: 14px;
        font-weight: 700;
        text-transform: uppercase;
        border-radius: 6px;
        transition: 0.3s;
        display: inline-block;
        text-align: center;
    }
    .nav-link-custom:hover {
        background-color: rgba(90, 42, 42, 0.08);
    }
    .user-profile-link {
        background-color: #5a2a2a;
        color: #fff !important;
    }
    .user-profile-link:hover {
        background-color: #3d1c1c;
    }
    
    /* Buscador animado */
    .search-wrapper {
        display: flex;
        align-items: center;
        position: relative;
        background: rgba(90, 42, 42, 0.04);
        border-radius: 20px;
        padding: 2px 6px;
    }
    .search-input {
        width: 0px;
        opacity: 0;
        border: none;
        outline: none;
        padding: 4px 0px;
        background: transparent;
        border-bottom: 2px solid #5a2a2a;
        color: #2c2c2c;
        font-family: 'Montserrat', sans-serif;
        font-weight: 600;
        font-size: 14px;
        transition: width 0.4s ease, opacity 0.3s ease;
        pointer-events: none;
    }
    .search-input.active {
        width: 150px;
        opacity: 1;
        padding: 4px 8px;
        pointer-events: auto;
    }
    .search-icon-btn {
        background: transparent;
        border: none;
        color: #5a2a2a;
        font-size: 16px;
        cursor: pointer;
        padding: 6px 10px;
        font-weight: 700;
    }

    @media (max-width: 991.98px) {
        #miNavbar { padding: 10px 0 !important; }
        #navLogo { height: 40px !important; }
        .collapse { background: #f7f1ef; padding: 15px; border-radius: 8px; margin-top: 10px; }
        .nav-link-custom { width: 100%; text-align: left; margin-bottom: 4px; padding: 10px 15px; }
        .search-wrapper { width: 100%; justify-content: space-between; padding: 6px 12px; }
        .search-input.active { width: 80%; }
    }
  </style>
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
            e.stopPropagation(); 
            
            const isOpen = searchInput.classList.contains("active");

            if (!isOpen) {
                // Abrir barra de búsqueda
                searchInput.classList.add("active");
                searchInput.focus();
                searchIcon.className = "fa-solid fa-xmark";
            } else {
                if (searchInput.value.trim() !== "") {
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
            
            //ejemplo de redireccion al catálogo pasandole el query string:
            window.location.href = `/ecommerce-tienda-deportiva/frontend/pages/pagina-busqueda.php?search=${encodeURIComponent(termino)}`;
        }
    });
</script>