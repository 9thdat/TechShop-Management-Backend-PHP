<?php
header('Access-Control-Allow-Origin: http://localhost:3000');  // Replace with the actual origin of your frontend application
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

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

    // Get the review ID and content from the request
    $id = $_GET['id'] ?? null;
    $adminReply = $_GET['content'] ?? null;

    // Check if required data is provided
    if ($id !== null && $adminReply !== null) {
        // Update the review
        if ($review->updateReview($id, $adminReply)) {
            echo json_encode(['status' => 200, 'message' => 'Review updated successfully.']);
        } else {
            echo json_encode(['status' => 500, 'message' => 'Unable to update review.']);
        }
    } else {
        echo json_encode(['status' => 400, 'message' => 'Incomplete data. Please provide all required fields.']);
    }
} catch (Exception $e) {
    // Handle exceptions, you may want to log or handle differently
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
}

?>
