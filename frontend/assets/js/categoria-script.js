const storeGrid = document.getElementById("ulStoreGrid");
const categoriaElement = document.getElementById("categoriaPag");
const categoria = categoriaElement.dataset.cat;
console.log(categoria);

document.addEventListener("DOMContentLoaded", () => {
  cargarProductos(); 
});

function cargarProductos()
{
  // Se le manda el offset por URL al PHP
  fetch(`../../backend/index.php?action=getCategory&category=${categoria}`)
    .then(data => data.text())
    .then((rawData) => {
      const productos = JSON.parse(rawData);
      console.log(productos);

      if (productos.length === 0) {
          btnMostrarMas.innerText = "No hay más productos";
          btnMostrarMas.disabled = true;
          btnMostrarMas.style.opacity = "0.5";
          btnMostrarMas.style.cursor = "not-allowed";
          return;
      }

      // se Pintan los nuevos productos sumandolos al contenedor original
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

      //se incrementa el offset para el proxmio clic del mostrar mas
      //paginaOffset += limiteProductos;
    })
    .catch(error => console.error("Error al cargar productos:", error));
}