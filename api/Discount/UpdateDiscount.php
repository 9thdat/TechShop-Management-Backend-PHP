<?php
header('Access-Control-Allow-Origin: http://localhost:3000');  // Replace with the actual origin of your frontend application
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include_once '../../config/db_azure.php';
include_once '../../model/Discount.php';
include_once '../../model/User.php';

$database = new db();
$db = $database->connect();

$user = new User($db);
$discount = new Discount($db);

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

    // Get posted data
    $data = json_decode(file_get_contents("php://input"), true);

    // Check if data is not empty
    if (!empty($data['id']) &&
        !empty($data['code']) &&
        !empty($data['type']) &&
        isset($data['value']) &&
        !empty($data['description']) &&
        !empty($data['startDate']) &&
        !empty($data['endDate']) &&
        isset($data['minApply']) &&
        isset($data['maxSpeed']) &&
        isset($data['quantity']) &&
        !empty($data['status'])
    ) {
        // Set Discount properties
        $discount->setId($data['id']);
        $discount->setCode($data['code']);
        $discount->setType($data['type']);
        $discount->setValue($data['value']);
        $discount->setDescription($data['description']);
        $discount->setSTART_DATE($data['startDate']);
        $discount->setEND_DATE($data['endDate']);
        $discount->setMIN_APPLY($data['minApply']);
        $discount->setMAX_SPEED($data['maxSpeed']);
        $discount->setQuantity($data['quantity']);
        $discount->setStatus($data['status']);

        $discountQuery = "SELECT * FROM Discount WHERE id = :id";
        $discountStmt = $db->prepare($discountQuery);
        $discountStmt->bindParam(':id', $data['id']);
        $discountStmt->execute();
        $discountToUpdate = $discountStmt->fetch(PDO::FETCH_ASSOC);
        if (!$discountToUpdate) {
            http_response_code(404);
            echo json_encode(['status' => 404, 'message' => 'Discount not found']);
            exit();
        } else {
            // Update the Discount
            $result = $discount->updateDiscount($data);

            if ($result) {
                http_response_code(200);
                echo json_encode(['status' => 200, 'message' => 'Discount updated successfully']);
            } else {
                http_response_code(500);
                echo json_encode(['status' => 500, 'message' => 'Internal Server Error']);
            }
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
