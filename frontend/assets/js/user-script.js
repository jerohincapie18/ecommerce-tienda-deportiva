document.addEventListener("DOMContentLoaded", () => {
    const btnEditar = document.getElementById("btnEditar");
    const btnGuardar = document.getElementById("btnGuardar");
    const inputNombre = document.getElementById("inputNombre");
    const inputEmail = document.getElementById("inputEmail");
    const inputPassword = document.getElementById("inputPassword");
    const wrapperPassword = document.getElementById("wrapperPassword");
    const formPerfil = document.getElementById("formEditarPerfil");
    const statusPerfil = document.getElementById("statusPerfil");

    //al darle clic a "Editar perfil"
    btnEditar.addEventListener("click", () => {
        // se habilitanS los campos de texto normales
        inputNombre.removeAttribute("disabled");
        inputEmail.removeAttribute("disabled");
        inputNombre.style.border = "1px solid #d9bcbc";
        inputEmail.style.border = "1px solid #d9bcbc";
        inputNombre.style.background = "#fff";
        inputEmail.style.background = "#fff";
        
        // se revela el contenedor de la contraseña
        wrapperPassword.style.display = "block";
        
        // Alternamos las botones
        btnEditar.style.display = "none";
        btnGuardar.style.display = "inline-block";
    });

    formPerfil.addEventListener("submit", (e) => {
        e.preventDefault();

        //estructura para el json
        const formData = {
            nombre: inputNombre.value.trim(),
            email: inputEmail.value.trim(),
            password: inputPassword.value
        };

        fetch("../../backend/index.php?action=updateProfile", {
            method: "POST",
            headers: { "Content-Type": "application/json; charset=UTF-8" },
            body: JSON.stringify(formData)
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                statusPerfil.style.color = "#28a745";
                statusPerfil.innerText = "Melo Perfil actualizado correctamente.";
                
                // se bloquean de nuebvo los campos y limpiamos el de password
                inputNombre.setAttribute("disabled", "true");
                inputEmail.setAttribute("disabled", "true");
                inputNombre.style.border = "none";
                inputEmail.style.border = "none";
                inputNombre.style.background = "transparent";
                inputEmail.style.background = "transparent";
                
                //ocultamos de nuevo el campo de contraseña y lo vaciamos
                inputPassword.value = "";
                wrapperPassword.style.display = "none";
                
                btnEditar.style.display = "inline-block";
                btnGuardar.style.display = "none";
            } else {
                statusPerfil.style.color = "#b04a4a";
                statusPerfil.innerText = data.message || "Error al actualizar.";
            }
        })
        .catch(err => {
            console.error("Error actualizando perfil:", err);
            statusPerfil.style.color = "#b04a4a";
            statusPerfil.innerText = "Error de comunicación con el backend.";
        });
    });
});