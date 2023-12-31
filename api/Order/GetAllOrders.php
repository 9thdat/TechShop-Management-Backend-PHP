<?php
header('Access-Control-Allow-Origin: http://localhost:3000');  // Replace with the actual origin of your frontend application
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json; charset=utf-8'); // Thêm header để chỉ định kiểu ký tự là UTF-8

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include_once '../../config/db_azure.php'; // Adjust the path as needed
include_once '../../model/Order.php';
include_once '../../model/User.php';

$database = new db();
$db = $database->connect();

$user = new User($db);
$order = new Order($db);

try {
    // Get the token from the headers
    $allHeaders = getallheaders();
    $token = $allHeaders['Authorization'];

    // Validate the token
    if (!$token || !$user->validateToken($token)) {
        // Invalid or missing token
        http_response_code(401);
        echo json_encode(['status' => 401, 'message' => 'Unauthorized']);
        exit();
    }

    // Proceed to fetch all orders
    $allOrders = $order->getAllOrders();

    $num = $allOrders->rowCount();

    if ($num > 0) {
        $orders_arr = array();

        while ($row = $allOrders->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $order_item = array(
                'id' => $ID,
                'customerEmail' => $CUSTOMER_EMAIL,
                'name' => $NAME,
                'address' => $ADDRESS,
                'ward' => $WARD,
                'district' => $DISTRICT,
                'city' => $CITY,
                'phone' => $PHONE,
                'discountId' => $DISCOUNT_ID,
                'shippingFee' => $SHIPPING_FEE,
                'totalPrice' => $TOTAL_PRICE,
                'note' => $NOTE,
                'orderDate' => $ORDER_DATE,
                'canceledDate' => $CANCELED_DATE, // 'canceledDate' => $canceledDate,
                'completedDate' => $COMPLETED_DATE,
                'deliveryType' => $DELIVERY_TYPE,
                'paymentType' => $PAYMENT_TYPE,
                'status' => $STATUS,

            );

            array_push($orders_arr, $order_item);
        }

        echo json_encode(['status' => 200, 'data' => $orders_arr], JSON_PRETTY_PRINT);
    } else {
        echo json_encode(['status' => 404, 'message' => 'No orders found']);
    }

    // Return a JSON response with all orders
} catch (Exception $e) {
    // Handle exceptions, you may want to log or handle differently
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
}

?>
