<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/db_azure.php'; // Adjust the path as needed
include_once '../../model/ProductQuantity.php';
include_once '../../model/User.php';
include_once '../../model/ImageDetail.php';

$database = new db();
$db = $database->connect();

$user = new User($db);
$productQuantity = new ProductQuantity($db);

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

    // Get the ID from the URL parameter
    $id = isset($_GET['id']) ? $_GET['id'] : die();

    // Get the product quantity
    $ProductQuantityInDb = "SELECT * FROM product_quantity WHERE ID = :id";
    $stmt = $db->prepare($ProductQuantityInDb);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $num = $stmt->rowCount();

    if ($num > 0) {
        $productQuantityInDb = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        // Product quantity not found
        http_response_code(404);
        echo json_encode(['status' => 404, 'message' => 'Product quantity not found.']);
        exit();
    }
//     Delete the image detail
    $ImageDetailQuery = "DELETE FROM image_detail WHERE PRODUCT_ID = :ProductId AND COLOR = :Color";
    $stmt = $db->prepare($ImageDetailQuery);
    $stmt->bindParam(':ProductId', $productQuantityInDb['PRODUCT_ID']);
    $stmt->bindParam(':Color', $productQuantityInDb['COLOR']);
    $stmt->execute();

    // Delete the product quantity
    if ($productQuantity->deleteProductQuantity($id) && $stmt->rowCount() > 0) {
        echo json_encode(['status' => 200, 'message' => 'Product quantity deleted successfully.']);
    } else {
        echo json_encode(['status' => 500, 'message' => 'Unable to delete product quantity.']);
    }
} catch (Exception $e) {
    // Handle exceptions, you may want to log or handle differently
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
}

?>
