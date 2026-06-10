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
            precio: editPrecio.value
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
        btnActualizar.setAttribute("disabled", "true");
        btnEliminar.setAttribute("disabled", "true");
    }
});