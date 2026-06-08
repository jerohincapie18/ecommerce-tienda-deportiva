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
    $stmt = $this->db->prepare("INSERT INTO productos (nombre, descripcion, precio, imagen_url, categoria) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdss", $data["nombre"], $data["descripcion"], $data["precio"], $data["imagen_url"], $data["categoria"]);
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

}
