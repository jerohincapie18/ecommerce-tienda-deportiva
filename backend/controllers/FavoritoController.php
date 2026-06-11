<?php
require_once("./models/FavoritoModel.php");

class FavoritoController {
    private $favoritoModel;

    public function __construct() {
        $this->favoritoModel = new FavoritoModel();
    }

    public function toggleFavorito($productoId) {
        session_start();
        
        //CONTROL DE SEGURIDAD: Si no está logueado, rebota de una
        if (!isset($_SESSION["user_id"])) {
            http_response_code(401); // No autorizado
            echo json_encode(["success" => false, "message" => "Debes iniciar sesión para guardar favoritos"]);
            exit();
        }

        $userId = $_SESSION["user_id"];

        //Intentamos agregar el favorito
        $agregado = $this->favoritoModel->agregar($userId, $productoId);

        header("Content-Type: application/json; charset=UTF-8");
        if ($agregado) {
            echo json_encode(["success" => true, "message" => "Agregado a favoritos", "status" => "added"]);
        } else {
            // Si ya existia, asumimos que el usuario lo quiere quitar (efecto toggle)
            $this->favoritoModel->eliminar($userId, $productoId);
            echo json_encode(["success" => true, "message" => "Eliminado de favoritos", "status" => "removed"]);
        }
        exit();
    }

    public function listarFavoritos() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        //si no esta logueado, mandamos un error 401
        if (!isset($_SESSION["user_id"])) {
            http_response_code(401);
            echo json_encode(["success" => false, "message" => "Inicia sesión para ver tus favoritos"]);
            exit();
        }

        $userId = $_SESSION["user_id"];
        $lista = $this->favoritoModel->obtenerPorUsuario($userId);

        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($lista);
        exit();
    }

    public function validarFavoritos($idProd)
    {
        session_start();
        if (!isset($_SESSION["user_id"])) {
            http_response_code(401);
            echo json_encode(["success" => false, "message" => "Sin sesion activa"]);
            exit();
        }

        $userId = $_SESSION["user_id"];
        $esFavorito = $this->favoritoModel->verificarFavorito($idProd, $userId);

        if($esFavorito > 0)
        {
            http_response_code(200);
            echo json_encode(["success" => true, "message" => "Producto en lista de favoritos"]);
        }
        else
        {
            http_response_code(404);
            echo json_encode(["success" => false, "message" => "El producto no esta en favoritos"]);
        }
    }
}