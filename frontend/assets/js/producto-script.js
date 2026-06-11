const btnFavorito = document.getElementById("btn-add-favorito");
document.addEventListener("DOMContentLoaded", () => {
    //extraer el ID de la URL (?id=X)
    const params = new URLSearchParams(window.location.search);
    const productoId = params.get("id");

    if (!productoId) {
        alert("Producto no especificado.");
        window.location.href = "../index.php";
        return;
    }

    //pedir la informacion del producto al backend
    fetch(`../../backend/index.php?action=getProductById&id=${productoId}`)
        .then(respuesta => respuesta.json())
        .then(producto => {
            if (producto.success === false) {
                document.body.innerHTML = `<div class="text-center my-5"><h2>${producto.message}</h2><a href="../index.php">Volver al catálogo</a></div>`;
                return;
            }

            //Sembrar los datos en el HTML
            document.getElementById("det-nombre").innerText = producto.nombre;
            document.getElementById("det-categoria").innerText = producto.categoria;
            document.getElementById("det-descripcion").innerText = producto.descripcion ? producto.descripcion : "Sin descripción disponible para este artículo.";
            document.getElementById("det-stock").innerText = producto.stock;
            document.getElementById("det-precio").innerText = `$${parseFloat(producto.precio).toLocaleString('es-CO')}`;
            document.getElementById("det-imagen").src = producto.imagen_url;
            document.getElementById("det-imagen").alt = producto.nombre;
            document.title = `${producto.nombre} - Tienda Deportiva`;

            //scuchadores temporales para los botones (los programamos en el siguiente paso)
            document.getElementById("btn-add-carrito").addEventListener("click", () => agregarAlCarrito(producto.id));
            document.getElementById("btn-add-favorito").addEventListener("click", () => agregarAFavoritos(producto.id));
        })
        .catch(error => {
            console.error("Error obteniendo el detalle del producto:", error);
        });

        //verifica que el producto sea favorito
        validarFavoritos(productoId);
});

function agregarAlCarrito(id) {
    fetch(`../../backend/index.php?action=addToCart&producto_id=${id}`)
        .then(respuesta => respuesta.json())
        .then(data => {
            if (data.success) {
                alert("🛒 Producto añadido al carrito.");
                console.log("Total productos en carrito:", data.total_items);
            }
        })
        .catch(error => console.error("Error añadiendo al carrito:", error));
}

function agregarAFavoritos(id) {

    fetch(`../../backend/index.php?action=toggleFavorito&producto_id=${id}`)
        .then(respuesta => {
            // Si devuelve 401 significa que no está logueado
            if (respuesta.status === 401) {
                alert("¡Tienes que iniciar sesión para guardar tus favoritos!");
                //se podria redireccionarl al login
                // window.location.href = "../pages/login.php";
                return null;
            }
            return respuesta.json();
        })
        .then(data => {
            if (!data) return;

            if (data.success) {
                //cambio visual dinamico en el botón según la respuesta
                if (data.status === "added") {
                    btnFavorito.innerText = "❤️ En Favoritos";
                    btnFavorito.classList.remove("btn-outline-danger");
                    btnFavorito.classList.add("btn-danger");
                } else {
                    btnFavorito.innerText = "❤ Favorito";
                    btnFavorito.classList.remove("btn-danger");
                    btnFavorito.classList.add("btn-outline-danger");
                }
                console.log(data.message);
            }
        })
        .catch(error => console.error("Error al gestionar favorito:", error));
}

function validarFavoritos(idProd)
{
    fetch(`../../backend/index.php?action=checkFavs&prodId=${idProd}`).then(raw => raw.json()).then(favoritos => {
        if(favoritos.success)
        {
            btnFavorito.innerText = "❤️ En Favoritos";
            btnFavorito.classList.remove("btn-outline-danger");
            btnFavorito.classList.add("btn-danger");
        }
        console.log(favoritos.message);
    });
}
