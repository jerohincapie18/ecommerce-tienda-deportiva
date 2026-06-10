const storeGrid = document.getElementById("ulStoreGrid");
const btnShowMore = document.getElementById("showMore");

document.addEventListener("DOMContentLoaded", () => {
  cargarProductos(); 
});

function cargarProductos()
{
  // Se le manda el offset por URL al PHP
  fetch("/ecommerce-tienda-deportiva/backend/index.php?action=getIndexProducts")
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

/* 
btnShowMore.addEventListener("click", showMore);

function showMore() // usara prevent default con una query?? 
{
    for(i=0; i<10; i++)
    {
        //cuando se escale, se puede usar un arreglo para rescatar, img, nombre y precio
        ulStoreGrid.insertAdjacentHTML("beforeend", 
            `
                <li> 
                    <article class="store-article">
                        <img src="./assets/img/profilepic.png" alt="">
                        <div class="article-info">
                            <div class="article-text">
                                <div>Nombre</div>
                                <div>Precio</div>
                            </div>
                            <button>favorito</button>
                        </div>
                    </article>
                </li>
            `
        );
    }
} */