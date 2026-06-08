<?php
require_once("./models/ProductModel.php");

class CartController {
    private $productModel;

    public function __construct() {
        $this->productModel = new ProductModel();
    }

    // Asegura que la sesión y la estructura del carrito existan
    private function initCart() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = []; // [ id_producto => cantidad ]
        }
    }

    // ➕ Agregar al carrito
    public function agregar($productoId) {
        $this->initCart();

        if (isset($_SESSION['carrito'][$productoId])) {
            $_SESSION['carrito'][$productoId] += 1; // Le suma uno a la cantidad
        } else {
            $_SESSION['carrito'][$productoId] = 1;  // Lo registra por primera vez
        }

        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode(["success" => true, "message" => "Producto añadido al carrito", "total_items" => array_sum($_SESSION['carrito'])]);
        exit();
    }

    // ❌ Eliminar un producto del carrito
    public function eliminar($productoId) {
        $this->initCart();

        if (isset($_SESSION['carrito'][$productoId])) {
            unset($_SESSION['carrito'][$productoId]);
        }

        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode(["success" => true, "message" => "Producto removido del carrito"]);
        exit();
    }

    // 📋 Listar el contenido del carrito con la info completa de la BD
    public function listar() {
        $this->initCart();
        
        $itemsCompleto = [];
        $totalPagar = 0;

        foreach ($_SESSION['carrito'] as $id => $cantidad) {
            $productoInfo = $this->productModel->getProductById($id);
            if ($productoInfo) {
                $productoInfo['cantidad'] = $cantidad;
                $productoInfo['subtotal'] = $productoInfo['precio'] * $cantidad;
                
                $totalPagar += $productoInfo['subtotal'];
                $itemsCompleto[] = $productoInfo;
            }
        }

        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode([
            "success" => true,
            "items" => $itemsCompleto,
            "total_pagar" => $totalPagar
        ]);
        exit();
    }
}