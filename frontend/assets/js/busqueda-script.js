const storeGrid = document.getElementById("ulStoreGrid");

document.addEventListener("DOMContentLoaded", () => {
    //voy a llamr esta clase para poder recibir la cabecera de otra pagina
    const urlParams = new URLSearchParams(window.location.search);
    const terminoBuscado = urlParams.get('search'); // Retorna la busquda "entre comillas"

    if(terminoBuscado)
    {
        fetch(`../../backend/index.php?action=displaySearch&busqueda=${terminoBuscado}`)
            .then(answer => answer.json())
                .then(productos => {
                    productos.forEach(producto => {
                    const productoHTML = `
                        <li> 
                            <article class="store-article">
                                <a href="/ecommerce-tienda-deportiva/frontend/pages/producto.php?id=${producto.id}">
                                    <img src="${producto.imagen_url}" alt="${producto.nombre}">
                                </a>
                                <div class="article-info">
                                    <div class="article-text">
                                        <a href="/ecommerce-tienda-deportiva/frontend/pages/producto.php?id=${producto.id}" style="text-decoration: none; color: black;">
                                        <div style="font-weight: bold; text-transform: capitalize;">${producto.nombre}</div>
                                        <div style="color: #28a745; font-weight: 500;">$${parseFloat(producto.precio).toLocaleString('es-CO')}</div>
                                        </a>
                                    </div>
                                    <button style="padding: 2px 8px; align-self: center;">❤</button>
                                    <button style="padding: 2px 8px; align-self: center;">🛒</button>
                                </div>
                            </article>
                        </li>
                    `;
                    storeGrid.innerHTML += productoHTML;
                });
            });
    }
});