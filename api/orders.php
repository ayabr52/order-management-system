<?php
header("Content-Type: application/json");

require_once __DIR__ . '/../repositories/OrderRepository.php';
require_once __DIR__ . '/../facades/OrderFacade.php';

$repo = new OrderRepository();
$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents("php://input"), true);

// استخراج ID من الرابط إن وجد
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

try {
    switch ($method) {
        case 'GET':
            if ($id) {
                $order = $repo->getById($id);
                echo json_encode($order ?: ["error" => "الطلب غير موجود"]);
            } else {
                $orders = $repo->all();
                echo json_encode($orders);
            }
            break;

        case 'POST':
            if (!isset($input['customer_name']) || !isset($input['items'])) {
                http_response_code(400);
                echo json_encode(["error" => "بيانات غير مكتملة"]);
                exit;
            }
            $orderId = OrderFacade::createOrder($input['customer_name'], $input['items']);
            echo json_encode(["message" => "تم إنشاء الطلب", "order_id" => $orderId]);
            break;

        case 'PUT':
            if (!$id || !isset($input['customer_name']) || !isset($input['status']) || !isset($input['total_price'])) {
                http_response_code(400);
                echo json_encode(["error" => "بيانات غير مكتملة أو ID مفقود"]);
                exit;
            }
            $updated = $repo->update($id, [
                'customer_name' => $input['customer_name'],
                'status' => $input['status'],
                'total_price' => $input['total_price']
            ]);
            echo json_encode(["message" => $updated ? "تم التحديث" : "فشل التحديث"]);
            break;

        case 'DELETE':
            if (!$id) {
                http_response_code(400);
                echo json_encode(["error" => "ID مفقود"]);
                exit;
            }
            $deleted = $repo->delete($id);
            echo json_encode(["message" => $deleted ? "تم الحذف" : "فشل الحذف"]);
            break;

        default:
            http_response_code(405);
            echo json_encode(["error" => "طريقة غير مدعومة"]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}
