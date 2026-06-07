const mainForm = document.getElementById("main-form");
const email = document.getElementById("email");
const contrasena = document.getElementById("contrasena");

mainForm.addEventListener("submit", checkLogin);

function checkLogin(e)
{
  e.preventDefault();
  const datos = {email: email.value, password: contrasena.value};
  fetch("../../backend/index.php?action=login", {
    method: "POST",
    headers: {"Content-Type": "application/json"},
    body: JSON.stringify(datos)
  }).then((respuesta) => respuesta.json()).then((result) => {window.location.href = result.redirect});
}

function leerDatos()
{
  //por ahora solo hago una lectura porq quiero ver si la conexion es exitosa
  fetch("../../backend/helpers/leer.php")
    .then(datos => datos.json())
      .then(resultado => console.log(resultado));
}
