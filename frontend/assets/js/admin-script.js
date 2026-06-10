const formUpload = document.getElementById("uploadProduct");
const finalStatus = document.getElementById("finalStatus");
const btnCargarProd = document.getElementById("btnCargarProd");
const buscarIdProd = document.getElementById("buscarIdProd");
const formGestion = document.getElementById("formGestionProducto");
const gestionStatus = document.getElementById("gestionStatus");
//inputs del formulario de gestión
const editIdProd = document.getElementById("editIdProd");
const editNombre = document.getElementById("editNombre");
const editCategoria = document.getElementById("editCategoria");
const editDescripcion = document.getElementById("editDescripcion");
const editPrecio = document.getElementById("editPrecio");
const editStock = document.getElementById("editStock");
//botones
const btnActualizar = document.getElementById("btnActualizar");
const btnEliminar = document.getElementById("btnEliminar");
//botones de la tabla de productos
const tbodyProductos = document.getElementById("tbodyProductos");
const btnRefrescarTabla = document.getElementById("btnRefrescarTabla");

document.addEventListener("DOMContentLoaded", () => {
    //CREACION DE  UN PRODUCTO NUEVO
    formUpload.addEventListener("submit", (e) => {
        e.preventDefault();
        const formData = new FormData(formUpload);

        fetch("../../backend/index.php?action=createProduct", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                finalStatus.style.color = "#28a745";
                finalStatus.innerText = "🛒 " + data.message;
                formUpload.reset();
                cargarTablaInventario();
            } else {
                finalStatus.style.color = "#b04a4a";
                finalStatus.innerText = "❌ " + data.message;
            }
        })
        .catch(err => {
            console.error("Error al crear:", err);
            finalStatus.style.color = "#b04a4a";
            finalStatus.innerText = "Error de conexión con el servidor.";
        });
    });

    //BUSCAR Y CARGART UN PRODUCTO EN EL PANEL
    btnCargarProd.addEventListener("click", () => {
        const id = buscarIdProd.value.trim();
        if (!id) {
            alert("Escribe un ID válido, mi pez.");
            return;
        }

        fetch(`../../backend/index.php?action=getProductById&id=${id}`)
        .then(res => res.json())
        .then(prod => {
            if (prod.id == id) {
                //const prod = data.producto;
                //asigno los datos al formulario
                editIdProd.value = prod.id;
                editNombre.value = prod.nombre;
                editCategoria.value = prod.categoria;
                editDescripcion.value = prod.descripcion;
                editPrecio.value = prod.precio;
                editStock.value = prod.stock;
                //se habilitan los controles
                editNombre.removeAttribute("disabled");
                editCategoria.removeAttribute("disabled");
                editDescripcion.removeAttribute("disabled");
                editPrecio.removeAttribute("disabled");
                editStock.removeAttribute("disabled");
                btnActualizar.removeAttribute("disabled");
                btnEliminar.removeAttribute("disabled");
                //estilos del resultado
                gestionStatus.style.color = "#28a745";
                gestionStatus.innerText = `Producto #${prod.id} cargado con exito.`;
                cargarTablaInventario();
            } else {
                gestionStatus.style.color = "#b04a4a";
                gestionStatus.innerText = "No se encontró ningún producto con ese ID.";
                formGestion.reset();
                deshabilitarCamposGestion();
            }
        })
        .catch(err => console.error("Error al buscar producto:", err));
    });

    // 🔄 ACTUALIZAR VALORES DEL PRODUCTO
    btnActualizar.addEventListener("click", () => {
        const payload = {
            id: editIdProd.value,
            nombre: editNombre.value,
            categoria: editCategoria.value,
            descripcion: editDescripcion.value,
            precio: editPrecio.value,
            stock: editStock.value
        };

        fetch("../../backend/index.php?action=updateProduct", {
            method: "POST",
            headers: { "Content-Type": "application/json; charset=UTF-8" },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                gestionStatus.style.color = "#28a745";
                gestionStatus.innerText = "Producto actualizado en la base de datos.";
                cargarTablaInventario();
            } else {
                gestionStatus.style.color = "#b04a4a";
                gestionStatus.innerText = data.message;
            }
        })
        .catch(err => console.error("Error actualizando producto:", err));
    });

    //ELIMINAR EL PRODUCTO DEL INVENTARIO
    btnEliminar.addEventListener("click", () => {
        if (!confirm("¿Está seguro de que quiere borrar este producto del sistema?")) return;

        const id = editIdProd.value;

        fetch(`../../backend/index.php?action=deleteProduct&idDelete=${id}`, {
            method: "DELETE"
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert("Producto eliminado correctamente.");
                formGestion.reset();
                buscarIdProd.value = "";
                deshabilitarCamposGestion();
                gestionStatus.style.color = "#28a745";
                gestionStatus.innerText = "Producto eliminado.";
                cargarTablaInventario();
            } else {
                gestionStatus.style.color = "#b04a4a";
                gestionStatus.innerText = data.message;
            }
        })
        .catch(err => console.error("Error eliminando producto:", err));
    });

    function deshabilitarCamposGestion() {
        editNombre.setAttribute("disabled", "true");
        editCategoria.setAttribute("disabled", "true");
        editDescripcion.setAttribute("disabled", "true");
        editPrecio.setAttribute("disabled", "true");
        editStock.setAttribute("disabled", "true");
        btnActualizar.setAttribute("disabled", "true");
        btnEliminar.setAttribute("disabled", "true");
    }

    function cargarTablaInventario() {
        tbodyProductos.innerHTML = `<tr><td colspan="7" class="text-center text-muted py-4"><i class="fa-solid fa-spinner fa-spin"></i> Cargando inventario...</td></tr>`;
        fetch("../../backend/index.php?action=getAdminProducts")
        .then(res => res.json())
        .then(productos => {
            if(productos) {
                tbodyProductos.innerHTML = ""; // Limpiamos el cargando
                
                productos.forEach(prod => {
                    const tr = document.createElement("tr");
                    tr.innerHTML = `
                        <th scope="row" class="fw-bold">#${prod.id}</th>
                        <td>
                            <img src="${prod.imagen_url}" alt="${prod.nombre}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px; border: 1px solid #d9bcbc;">
                        </td>
                        <td class="text-capitalize fw-semibold">${prod.nombre}</td>
                        <td><span class="badge bg-secondary text-uppercase">${prod.categoria}</span></td>
                        <td class="text-success fw-bold">$${parseFloat(prod.precio).toLocaleString('es-CO')}</td>
                        <td>
                            <span class="badge ${parseInt(prod.stock) > 0 ? 'bg-success' : 'bg-danger'}">
                                ${prod.stock} unids
                            </span>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-dark btn-seleccionar-prod" data-id="${prod.id}">
                                <i class="fa-solid fa-pencil"></i> Gestionar
                            </button>
                        </td>
                    `;
                    tbodyProductos.appendChild(tr);
                });

                // Escuchador de clics para los botones "Gestionar" dentro de la tabla
                document.querySelectorAll(".btn-seleccionar-prod").forEach(btn => {
                    btn.addEventListener("click", () => {
                        const idProd = btn.getAttribute("data-id");
                        buscarIdProd.value = idProd;
                        // Forzamos el clic en el botón de buscar original para que cargue los inputs arriba
                        btnCargarProd.click();
                        // Scroll suave hacia el formulario de edición
                        document.getElementById("section-gestion").scrollIntoView({ behavior: 'smooth' });
                    });
                });

            } else {
                tbodyProductos.innerHTML = `<tr><td colspan="7" class="text-center text-muted py-4">No hay productos registrados en este momento.</td></tr>`;
            }
        })
        .catch(err => {
            console.error("Error al cargar la tabla:", err);
            tbodyProductos.innerHTML = `<tr><td colspan="7" class="text-center text-danger py-4">Error al conectar con el servidor.</td></tr>`;
        });
    }

    // Cargar la tabla apenas se abra el dashboard
    cargarTablaInventario();

    btnRefrescarTabla.addEventListener("click", cargarTablaInventario);
});