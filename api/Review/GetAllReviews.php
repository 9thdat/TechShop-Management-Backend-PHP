<?php
header('Access-Control-Allow-Origin: *');  // Replace with the actual origin of your frontend application
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json; charset=utf-8'); // Thêm header để chỉ định kiểu ký tự là UTF-8

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include_once '../../config/db_azure.php'; // Adjust the path as needed
include_once '../../model/Review.php';
include_once '../../model/User.php';

$database = new db();
$db = $database->connect();

$user = new User($db);
$review = new Review($db);

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

    // Proceed to fetch all reviews
    $allReviews = $review->GetAllReviews();

    $num = $allReviews->rowCount();

    if ($num > 0) {
        $reviews_arr = array();

        foreach ($allReviews as $row) {
            extract($row);
            $review_item = array(
                'id' => $ID,
                'productId' => $PRODUCT_ID,
                'customerEmail' => $CUSTOMER_EMAIL,
                'rating' => $RATING,
                'content' => $CONTENT,
                'adminReply' => $ADMIN_REPLY,
                'createdAt' => $CREATED_AT,
                'updatedAt' => $UPDATED_AT
            );

            array_push($reviews_arr, $review_item);
        }

        http_response_code(200);
        echo json_encode(['status' => 200, 'message' => 'OK', 'data' => $reviews_arr]);
    } else {
        http_response_code(404);
        echo json_encode(['status' => 404, 'message' => 'No reviews found']);
    }
} catch (Exception $e) {
    // Handle exceptions, you may want to log or handle differently
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
}

?>
