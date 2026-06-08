const mainForm = document.getElementById("uploadProduct");
const finalStatus = document.getElementById("finalStatus");

mainForm.addEventListener("submit", subirProducto);

function subirProducto(e)
{
  e.preventDefault();
  const formData = new FormData(this); // captura todo el formulario (por eso no se recojen mas getElementById)
  fetch("../../backend/index.php?action=createProduct", {
    method: "POST",
    body: formData //no lleva headers de content type porque fetch lo pone automaticamente
  }).then((respuesta) => respuesta.json()).then((result) => {
    if(result.success)
    {
        finalStatus.innerHTML = `${result.message}`;
        finalStatus.style.color = "green";
        console.log(result.message);
        this.reset();
    }
    else
    {
      finalStatus.innerHTML = `${result.message}`;
      finalStatus.style.color = "red";
      console.log("error " + result.message);
    }
    }).catch(error => console.error("Error en la peticion: " + error))
}
