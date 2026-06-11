document.addEventListener("DOMContentLoaded", () => {
    const favoritosGrid = document.getElementById("ulFavoritosGrid");

    fetch("../../backend/index.php?action=getFavoritos")
        .then(respuesta => {
            if (respuesta.status === 401) {
                favoritosGrid.innerHTML = `
                    <div class="text-center w-100 my-5" style="grid-column: 1/-1;">
                        <h3>No has iniciado sesión!</h3>
                        <p>Debes ingresar a tu cuenta para ver tus favoritos.</p>
                        <a href="login.php" class="btn btn-dark mt-2">Ingresar</a>
                    </div>`;
                return null;
            }
            return respuesta.json();
        })
        .then(productos => {
            if (!productos) return;

            if (productos.length === 0) {
                favoritosGrid.innerHTML = `
                    <div class="text-center w-100 my-5" style="grid-column: 1/-1;">
                        <p class="text-muted" style="font-size: 1.2rem;">Aún no tienes productos en tu lista de deseos.</p>
                        <a href="catalogo.php" class="btn btn-outline-dark mt-2">Explorar Catálogo</a>
                    </div>`;
                return;
            }

            // Rendereamos los favoritos con tu estructura CSS nativa
            productos.forEach(producto => {
                const productoHTML = `
                    <li> 
                        <article class="store-article">
                            <a href="/ecommerce-tienda-deportiva/frontend/pages/producto.php?id=${producto.id}">
                                <img src="${producto.imagen_url}" alt="${producto.nombre}">
                            </a>
                            <div class="article-info">
                                <div class="article-text">
                                    <div style="font-weight: bold; text-transform: capitalize;">${producto.nombre}</div>
                                    <div style="color: #28a745; font-weight: 500;">$${parseFloat(producto.precio).toLocaleString('es-CO')}</div>
                                </div>
                                <button onclick="eliminarDeFavoritos(${producto.id})" class="btn btn-sm btn-danger text-white" style="align-self: center;">Eliminar</button>
                            </div>
                        </article>
                    </li>
                `;
                favoritosGrid.innerHTML += productoHTML;
            });
        })
        .catch(error => console.error("Error cargando favoritos:", error));
});

// Función rápida para removerlo directamente desde la misma lista si el usuario se arrepiente
function eliminarDeFavoritos(id) {
    fetch(`../../backend/index.php?action=toggleFavorito&producto_id=${id}`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Recargamos la vista para que desaparezca de inmediato de la pantalla
                window.location.reload();
            }
        });
}