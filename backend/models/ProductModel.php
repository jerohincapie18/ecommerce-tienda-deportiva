<?php

require("./config/main-config.php");
class ProductModel
{
  private $db;
  public function __construct()
  {
    global $conn;
    $this->db = $conn;
  }

  public function insertProduct($data)
  {
    $stmt = $this->db->prepare("INSERT INTO productos (nombre, descripcion, precio, stock, imagen_url, categoria) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdiss", $data["nombre"], $data["descripcion"], $data["precio"], $data["stock"], $data["imagen_url"], $data["categoria"]);
    $stmt->execute();
    $affected = $stmt->affected_rows;
    $stmt->close();
    return $affected;
  }

  //rescata los productos del carrusel
  public function getCarouselProducts()
  {
    $query = "SELECT id, nombre, precio, imagen_url FROM productos ORDER BY id DESC LIMIT 5";
    $result = $this->db->query($query);
    if($result)
      return $result->fetch_all(MYSQLI_ASSOC);
    return [];
  }

  //consigue los productos para el catalogo (en orden de creacion)
  public function getAllProducts()
  {
      $query = "SELECT * FROM productos ORDER BY fecha_creacion DESC";
      $result = $this->db->query($query);
      return $result->fetch_all(MYSQLI_ASSOC);
  }

  //consigue un solo producto para mostrarlo en la pagina
  public function getProductById($id)
  {
      $stmt = $this->db->prepare("SELECT * FROM productos WHERE id = ?");
      $stmt->bind_param("i", $id);
      $stmt->execute();
      $result = $stmt->get_result();
      $stmt->close();
      return $result->fetch_assoc(); // Devuelve una sola fila (array asociativo)
  }

  //funcion para rescatar con un offset para mostrarlas en la pestana de catalogo
  public function getProductsPaginated($limit, $offset)
  {
    $stmt = $this->db->prepare("SELECT id, nombre, precio, imagen_url FROM productos ORDER BY id DESC LIMIT ? OFFSET ?");
    $stmt->bind_param("ii", $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $data;
  }

  //rescata los productos segun la categoria
  public function getProductByCategory($categoria)
  {
    $stmt = $this->db->prepare("SELECT id, nombre, precio, imagen_url FROM productos WHERE categoria = ?");
    $stmt->bind_param("s", $categoria);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $data = $resultado->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $data;
  }

  //rescata todos los productos sin orden de creacion
  public function getIndexProducts()
  {
    $stmt = $this->db->prepare("SELECT id, nombre, precio, imagen_url FROM productos");
    $stmt->execute();
    $resultado = $stmt->get_result(); //rescato el resultado
    $data = $resultado->fetch_all(MYSQLI_ASSOC); //lo guardo en un arreglo asociativo
    $stmt->close();
    return $data;
  }

  //actualizar producto
  public function updateProduct($pData)
  {
    $stmt = $this->db->prepare("UPDATE productos SET nombre = ?, categoria = ?, descripcion = ?, precio = ?, stock = ? WHERE id = ?");
    $nombre = $pData["nombre"];
    $categoria = $pData["categoria"];
    $descripcion = $pData["descripcion"];
    $id = $pData["id"];
    $stock = $pData["stock"];
    $precio = floatval($pData["precio"]);
    $stmt->bind_param("sssdii", $nombre, $categoria, $descripcion,  $precio, $stock, $id);
    $resultado = $stmt->execute();
    $stmt->close();
    return $resultado;
  }
  
  //borrar producto
  public function deleteProduct($idEliminar)
  {
    $stmt = $this->db->prepare("DELETE FROM productos WHERE id = ?");
    $stmt->bind_param("i", $idEliminar);
    //rescato si la comnsulta fue exitosa o no
    $resultado = $stmt->execute();
    $stmt->close();
    return $resultado;
  }

  //para el admin dashboar
  public function getProductsFullData()
  {
    $stmt = $this->db->prepare("SELECT id, nombre, categoria, precio, stock, imagen_url FROM productos");
    $stmt->execute();
    $resultado = $stmt->get_result(); //rescato el resultado
    $data = $resultado->fetch_all(MYSQLI_ASSOC); //lo guardo en un arreglo asociativo
    $stmt->close();
    return $data;
  }

  //consulta para la barra de busqueda
  public function doModelSearch($busqueda)
  {
    //consulta para buscar por coincidencia en la descripcion o nombre
    $sql = "SELECT id, nombre, descripcion, precio, stock, imagen_url, categoria 
            FROM productos 
            WHERE nombre LIKE ? OR descripcion LIKE ?";
    $stmt = $this->db->prepare($sql);
    $busquedaFinal = "%" . $busqueda . "%";
    $stmt->bind_param("ss", $busquedaFinal, $busquedaFinal);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $data = $resultado->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $data;
  }
}
