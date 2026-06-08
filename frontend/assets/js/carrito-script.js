document.addEventListener("DOMContentLoaded", () => {
    cargarContenidoCarrito();
});

function cargarContenidoCarrito() {
    const tableBody = document.getElementById("cart-table-body");
    const totalProductosTxt = document.getElementById("cart-total-productos");
    const totalPagarTxt = document.getElementById("cart-total-pagar");

    fetch("../../backend/index.php?action=getCart")
        .then(res => res.json())
        .then(data => {
            if (!data.success) return;

            tableBody.innerHTML = "";

            if (data.items.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="5" class="text-center py-4 text-muted">El carrito está vacío. ¡Ve a buscar ropa al catálogo!</td></tr>`;
                totalProductosTxt.innerText = "0";
                totalPagarTxt.innerText = "$0";
                return;
            }

            let cuentaProductos = 0;

            data.items.forEach(item => {
                cuentaProductos += item.cantidad;
                const rowHTML = `
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <img src="${item.imagen_url}" alt="${item.nombre}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                                <span class="fw-bold text-capitalize">${item.nombre}</span>
                            </div>
                        </td>
                        <td>$${parseFloat(item.precio).toLocaleString('es-CO')}</td>
                        <td class="fw-bold">${item.cantidad}</td>
                        <td class="text-success fw-bold">$${parseFloat(item.subtotal).toLocaleString('es-CO')}</td>
                        <td>
                            <button onclick="removerDelCarrito(${item.id})" class="btn btn-sm btn-outline-danger">Eliminar</button>
                        </td>
                    </tr>
                `;
                tableBody.innerHTML += rowHTML;
            });

            totalProductosTxt.innerText = cuentaProductos;
            totalPagarTxt.innerText = `$${parseFloat(data.total_pagar).toLocaleString('es-CO')}`;
        })
        .catch(error => console.error("Error al cargar carrito:", error));
}

function removerDelCarrito(id) {
    fetch(`../../backend/index.php?action=removeFromCart&producto_id=${id}`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                cargarContenidoCarrito(); // Refresca la tabla al vuelo sin recargar la página entera
            }
        });
}