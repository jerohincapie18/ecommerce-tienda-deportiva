const storeGrid = document.getElementById("ulStoreGrid");
const mainStore = document.getElementById("mainStore");

document.addEventListener("DOMContentLoaded", () => {
    //voy a llamr esta clase para poder recibir la cabecera de otra pagina
    const urlParams = new URLSearchParams(window.location.search);
    const terminoBuscado = urlParams.get('search'); // Retorna la busquda "entre comillas"

    if(terminoBuscado)
    {
        fetch(`../../backend/index.php?action=displaySearch&busqueda=${terminoBuscado}`)
            .then(answer => answer.json())
                .then(productos => {
                    console.log(productos);
                    if(Object.keys(productos).length > 0)
                    {
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
                    }
                    else
                    {
                        console.log(productos.success);
                        mainStore.innerHTML = `<h1>No hay productos relacionados a ${terminoBuscado}. :c</h1>`; 
                    }
                }).catch(err => {
                console.error("Error cargando la búsqueda:", err);
                storeGrid.innerHTML = `<p style="grid-column: 1 / -1; text-align:center; color: red;">Error al conectar con el servidor.</p>`;
            });
    }
});