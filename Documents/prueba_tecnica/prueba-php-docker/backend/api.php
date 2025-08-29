<?php
// Permitir peticiones desde cualquier origen (CORS)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header('Content-Type: application/json');

require 'db.php';

$method = $_SERVER['REQUEST_METHOD'];

// Manejo de peticiones OPTIONS pre-vuelo para CORS
if ($method == 'OPTIONS') {
    http_response_code(200);
    exit();
}

switch ($method) {
    case 'GET':
        // Obtener todos los productos
        $stmt = $pdo->query('SELECT * FROM products');
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        break;

    case 'POST':
        // Crear un nuevo producto
        $data = json_decode(file_get_contents('php://input'));
        
        // Validación de entradas
        if (empty($data->name) || !isset($data->price) || !is_numeric($data->price) || $data->price < 0) {
            http_response_code(400); // Bad Request
            echo json_encode(['error' => 'Invalid input. Name cannot be empty and price must be a positive number.']);
            exit;
        }

        $sql = "INSERT INTO products (name, price) VALUES (?, ?)";
        $stmt= $pdo->prepare($sql);
        $stmt->execute([$data->name, $data->price]);
        
        $data->id = $pdo->lastInsertId();
        http_response_code(201); // Created
        echo json_encode($data);
        break;

    case 'PUT':
        // Actualizar un producto
        $data = json_decode(file_get_contents('php://input'));
        $id = $_GET['id'] ?? null;

        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'Product ID is required.']);
            exit;
        }

        $sql = "UPDATE products SET name = ?, price = ? WHERE id = ?";
        $stmt= $pdo->prepare($sql);
        $stmt->execute([$data->name, $data->price, $id]);

        echo json_encode(['message' => 'Product updated successfully.']);
        break;

    case 'DELETE':
        // Eliminar un producto
        $id = $_GET['id'] ?? null;
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'Product ID is required.']);
            exit;
        }

        $sql = "DELETE FROM products WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

        echo json_encode(['message' => 'Product deleted successfully.']);
        break;
    
    default:
        http_response_code(405); // Method Not Allowed
        echo json_encode(['error' => 'Method not supported.']);
        break;
}