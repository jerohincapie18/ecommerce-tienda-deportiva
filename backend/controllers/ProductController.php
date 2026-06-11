<?php 

require_once ("./models/ProductModel.php");
class ProductController
{
  private $productModel;

  public function __construct()
  {
    $this->productModel = new ProductModel();
  }

  //crear producto
  public function create($data, $files)
  {
    //valida que los campos esten llenos
    if(empty($data["nombre"]) || empty($data["precio"]) || empty($data["categoria"]))
    {
      http_response_code(400);
      echo json_encode(["success" => false, "message" => "Datos de texto incompletos"]);
      exit();
    }

    //validar que las imagenes se subieron correctamente
    if(!isset($files["imagen"]) || $files["imagen"]["error"] !== UPLOAD_ERR_OK)
    {
      http_response_code(400);
      echo json_encode(["success" => false, "message" => "Error al cargar el archivo de imagen"]);
      exit();
    }

    //recibo solamente la informacion de la imagen
    $file = $files["imagen"];
    $fileName = $file["name"];
    $fileTmp = $file["tmp_name"];
  
    $finalName = uniqid() . $fileName;
    $rutaFinal = "./uploads/" . $finalName;

    //validar que es una imagen real para poder subirla
    $imgSize = getimagesize($fileTmp);
    if($imgSize !== false)
    {
      if(move_uploaded_file($fileTmp, $rutaFinal))
      {
        $urlDB = "/ecommerce-tienda-deportiva/backend/uploads/" . $finalName;
        $productArray = [
          "nombre" => $data["nombre"],
          "descripcion" => $data["descripcion"],
          "precio" => floatval($data["precio"]),
          "stock" => $data["stock"],
          "categoria" => $data["categoria"],
          "imagen_url" => $urlDB
        ];
        //comunicacioncon model
        $resultado = $this->productModel->insertProduct($productArray);
        if($resultado == 1)
        {
          http_response_code(201);
          echo json_encode(["success" => true, "message" => "Producto creado con exito"]);
          exit();
        }
        else
        {
          http_response_code(500);
          echo json_encode(["success" => true, "message" => "Error en el servidor"]);
          exit();
        }
      }
      else
      {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "No se pudo mover el archivo al directorio"]);
        exit();
      }
    }
  }

  //para el carrusel (roto)
  public function getCarousel()
  {
    $carouselProducts = $this->productModel->getCarouselProducts();
    echo json_encode($carouselProducts);
    exit();
  }

  //tomar los productos con un offset para mostrarlos en catalogo
  public function getProducts($limit, $offset)
  {
    $productosPaginados = $this->productModel->getProductsPaginated($limit, $offset);
    echo json_encode($productosPaginados);
    exit();
  }

  //buscar productos por id para la pagina individual de cada producto
  public function getProductById($id)
  {
    $producto = $this->productModel->getProductById($id);
    
    if (!$producto) {
        http_response_code(404);
        echo json_encode(["success" => false, "message" => "Producto no encontrado"]);
        exit();
    }

    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode($producto);
    exit();
  }

  //buscar los productos por categoria para hombre y mujer
  public function getProductsByCategory($categoria)
  {
    $productos = $this->productModel->getProductByCategory($categoria);
    echo json_encode($productos);
    exit();
  }

  //toma todos los productos para mostrarlos en el index
  public function getAllProducts()
  {
    $productos = $this->productModel->getIndexProducts();
    echo json_encode($productos);
    exit();
  }

  public function updateProduct($pData)
  {
    $resultado = $this->productModel->updateProduct($pData);
    if($resultado)
    {
      http_response_code(201);
      echo json_encode(["success" => true, "message" => "Producto actualizado con exito"]);
    }
    else
    {
      http_response_code(500);
      echo json_encode(["success" => false, "message" => "Error al actualizar el producto"]);

    }
  }

  public function deleteProduct($idEliminar)
  {
    $resultado = $this->productModel->deleteProduct($idEliminar);
    if($resultado)
    {
      http_response_code(201);
      echo json_encode(["success" => true, "message" => "Producto eliminado con exito"]);
    }
    else
    {
      http_response_code(500);
      echo json_encode(["success" => false, "message" => "Error al eliminar el producto"]);

    }
  }

  public function getProductsFullData()
  {
    $productos = $this->productModel->getProductsFullData();
    http_response_code(201);
    echo json_encode($productos);
    exit();
  }

  public function doSearch($busqueda)
  {
    $productos = $this->productModel->doModelSearch($busqueda);
    if($productos)
    {
      http_response_code(201);
      echo json_encode($productos);
      exit();
    }
    else
    {
      echo json_encode([]);
      exit();
    }
  }
}
