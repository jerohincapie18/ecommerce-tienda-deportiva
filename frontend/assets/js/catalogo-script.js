const btnMostrarMas = document.getElementById("showMore");
const storeGrid = document.getElementById("ulStoreGrid");
let paginaOffset = 0;
const limiteProductos = 5;

let indice = 0;
document.addEventListener("DOMContentLoaded", () => {
  //cargarCarrusel();
  cargarProductos();
});

btnMostrarMas.addEventListener("click", cargarProductos);

function cargarProductos()
{
  // Se le manda el offset por URL al PHP
  fetch(`../../backend/index.php?action=getProducts&offset=${paginaOffset}`)
    .then(data => data.text())
    .then((rawData) => {
      const productos = JSON.parse(rawData);
      console.log(productos);

      if (productos.length === 0) {
          if (paginaOffset === 0) {
              storeGrid.innerHTML = "<p style='text-align:center; width:100%; grid-column: 1/-1;'>No hay productos en inventario.</p>";
          }
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
                            <div style="font-weight: bold; text-transform: capitalize;">${producto.nombre}</div>
                            <div style="color: #28a745; font-weight: 500;">$${parseFloat(producto.precio).toLocaleString('es-CO')}</div>
                        </div>
                        <button style="padding: 2px 8px; align-self: center;">favorito</button>
                        <button style="padding: 2px 8px; align-self: center;">+ carrito</button>
                    </div>
                </article>
            </li>
          `;
          storeGrid.innerHTML += productoHTML;
      });

      //se incrementa el offset para el proxmio clic del mostrar mas
      paginaOffset += limiteProductos;
    })
    .catch(error => console.error("Error al cargar productos:", error));
}

function cargarCarrusel() {
  let carouselContainer = document.getElementById("carousel");
  
  fetch("../../backend/index.php?action=getCarousel")
    .then((respuesta) => respuesta.json())
    .then((productos) => {
      if (productos.length === 0) {
        carouselContainer.innerHTML = "<p style='color:white; padding-top:180px; text-align:center;'>No hay productos disponibles.</p>";
        return;
      }

      productos.forEach((producto, index) => {
        // 🔑 CORRECCIÓN: Aseguramos que la clase 'active' sea un string real para el primer elemento
        const claseActive = (index === 0) ? 'active' : '';
        
        const slideHTML = `
          <div class="slide ${claseActive}">
              <a href="/ecommerce-tienda-deportiva/frontend/pages/producto.php?id=${producto.id}">
                  <img src="${producto.imagen_url}" alt="${producto.nombre}">
              </a>
              <div class="slide-info" style="position:absolute; bottom:20px; left:20px; background:rgba(0,0,0,0.7); color:white; padding:10px; border-radius:5px; z-index:10;">
                ${producto.nombre} - $${parseFloat(producto.precio).toLocaleString('es-CO')}
              </div>
          </div>
        `;
        carouselContainer.innerHTML += slideHTML;
      });
    })
    .catch(error => {
        console.error("Error cargando el carrusel:", error);
    });
}


function mover(paso)
{
    // Seleccionamos los DIVS (el contenedor de la imagen + botón), no solo la imagen
    const slides = document.querySelectorAll('.slide'); // se selecciona todo el div
    // contenedor + imagen para poder manipularlo mejor
    if (slides.length === 0) return;

    // Quitamos la clase active al contenedor actual
    slides[indice].classList.remove('active');
    
    // Calculamos el nuevo índice
    indice = (indice + paso + slides.length) % slides.length;
    
    // Ponemos la clase active al nuevo contenedor
    slides[indice].classList.add('active');
}

setInterval(() => mover(1), 5000);
