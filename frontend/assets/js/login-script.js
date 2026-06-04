function leerDatos()
{
  //por ahora solo hago una lectura porq quiero ver si la conexion es exitosa
  fetch("../../backend/helpers/leer.php")
    .then(datos => datos.json())
      .then(resultado => console.log(resultado));
}

leerDatos();
