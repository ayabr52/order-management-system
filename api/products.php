<?php
header("Content-Type: application/json");

require_once __DIR__ . '/../models/Product.php';

$productModel = new Product();
$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents("php://input"), true);
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

try {
    switch ($method) {
        case 'GET':
            if ($id) {
                $product = $productModel->find($id);
                echo json_encode($product ?: ["error" => "المنتج غير موجود"]);
            } else {
                $products = $productModel->getAll();
                echo json_encode($products);
            }
            break;

        case 'POST':
            if (!isset($input['name'], $input['description'], $input['price'], $input['type'])) {
                http_response_code(400);
                echo json_encode(["error" => "بيانات غير مكتملة"]);
                exit;
            }
            $created = $productModel->create($input);
            echo json_encode(["message" => $created ? " تم إنشاء المنتج" : " فشل الإنشاء"]);
            break;

        case 'PUT':
            if (!$id || !isset($input['name'], $input['description'], $input['price'], $input['type'])) {
                http_response_code(400);
                echo json_encode(["error" => "بيانات غير مكتملة أو ID مفقود"]);
                exit;
            }
            $stmt = $productModel->db->prepare("
                UPDATE products SET name = ?, description = ?, price = ?, type = ? WHERE id = ?
            ");
            $updated = $stmt->execute([
                $input['name'],
                $input['description'],
                $input['price'],
                $input['type'],
                $id
            ]);
            echo json_encode(["message" => $updated ? " تم التحديث" : " فشل التحديث"]);
            break;

        case 'DELETE':
            if (!$id) {
                http_response_code(400);
                echo json_encode(["error" => "ID مفقود"]);
                exit;
            }
            $stmt = $productModel->db->prepare("DELETE FROM products WHERE id = ?");
            $deleted = $stmt->execute([$id]);
            echo json_encode(["message" => $deleted ? " تم الحذف" : " فشل الحذف"]);
            break;

        default:
            http_response_code(405);
            echo json_encode(["error" => "  هناك خطأ ما أية"]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}
