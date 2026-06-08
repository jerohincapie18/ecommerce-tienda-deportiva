const selectRol = document.getElementById("roles");
const nombre = document.getElementById("nombre");
const email = document.getElementById("email");
const contrasena = document.getElementById("contrasena");
const mainForm = document.getElementById("mainForm");
const logNombre = document.getElementById("logNombre");
const logEmail = document.getElementById("logEmail");
const logCont = document.getElementById("logPassword");
const logRol = document.getElementById("logRol");
const finalStatus = document.getElementById("finalStatus");

mainForm.addEventListener("submit", realizarRegistro);

function realizarRegistro(e)
{
  e.preventDefault();
  //const datos = {nombre: nombre.value, email: email.value, contrasena: contrasena.value, rol: selectRol.value};
  let datosArreglo = [nombre.value, email.value, contrasena.value, selectRol.value];
  console.log(datosArreglo);
  let vNombre = validarDatos(datosArreglo[0], "Ingrese un nombre", logNombre);
  let vEmail = validarDatos(datosArreglo[1], "Ingrese un email", logEmail);
  let vContrasena = validarDatos(datosArreglo[2], "Ingrese una contraseña", logCont);
  let vRol = validarDatos(datosArreglo[3], "Ingrese un rol", logRol);
  if((vNombre && vEmail) && (vContrasena &&vRol))
  {
    console.log("contenido leido");
    const datos = {nombre: nombre.value, email: email.value, password: contrasena.value, rol: selectRol.value};
    fetch("../../backend/index.php?action=register", {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify(datos)
      }).then((respuesta) => respuesta.json()).then((result) => {
        console.log(result);
      if(result.success)
      {
         //window.location.href = result.reditect;
        finalStatus.innerHTML = `<p style="color: green;">${result.message}: <span><a href="./login.php">Iniciar sesion</a></span></p>`;
      }
      else
      {
        finalStatus.innerHTML = `<p style="color:red;">${result.message}</p>`;
      }
      });
  }
  else
  {
    console.log("error en los datos");
    finalStatus.innerHTML = "Datos incorrectos";
  }
}

function validarDatos(datoRecibido, msg, log)
{
  if(datoRecibido == "")
  {
    log.innerHTML = msg;
    log.style.color = "red";
    return false;
  }
  return true;
}

/* const btn = document.getElementById("rgButton");
 btn.addEventListener("click", () => {
  const datos = {nombre: nombre.value, email: email.value, contrasena: contrasena.value, rol: selectRol.value};
  console.log(datos);
  logNombre.innerHTML = "hoe";
  logEmail.innerHTML = "i love LA";
  logCont.innerHTML = "to live n die in LA";
  logRol.innerHTML = "nigga";
}); */
