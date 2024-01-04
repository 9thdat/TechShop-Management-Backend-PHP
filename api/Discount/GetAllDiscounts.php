<?php
header('Access-Control-Allow-Origin: *');  // Replace with the actual origin of your frontend application
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-type: text/html; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include_once '../../config/db_azure.php'; // Adjust the path as needed
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

    // Fetch all discounts
    $allDiscounts = $discount->getAllDiscounts();

    $num = $allDiscounts->rowCount();

    if ($num > 0) {
        $discounts_arr = array();

        while ($row = $allDiscounts->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            if ($STATUS !== "disabled") {
                if (strtotime($END_DATE) <= time()) {
                    $STATUS = "expired";
                    $discount->setDISABLED_AT(date('Y-m-d H:i:s'));

                    // Save changes to the database
                    $sql = "UPDATE Discount SET status = :status, disabled_at = :disabled_at WHERE id = :id";
                    $stmt = $db->prepare($sql);

                    $stmt->bindParam(':status', $STATUS);
                    $stmt->bindParam(':disabled_at', $DISABLED_AT);
                    $stmt->bindParam(':id', $ID);

                    $stmt->execute();
                } else {
                    $STATUS = "active";

                    // Save changes to the database
                    $sql = "UPDATE Discount SET status = :status WHERE id = :id";
                    $stmt = $db->prepare($sql);

                    $stmt->bindParam(':status', $STATUS);
                    $stmt->bindParam(':id', $ID);

                    $stmt->execute();
                }
            }

            $discount_item = array(
                'id' => $ID,
                'code' => $CODE,
                'type' => $TYPE,
                'value' => $VALUE,
                'description' => $DESCRIPTION,
                'startDate' => $START_DATE,
                'endDate' => $END_DATE,
                'minApply' => $MIN_APPLY,
                'maxSpeed' => $MAX_SPEED,
                'quantity' => $QUANTITY,
                'status' => $STATUS,
                'createdAt' => $CREATED_AT,
                'updatedAt' => $UPDATED_AT,
                'disabledAt' => $DISABLED_AT
            );

            array_push($discounts_arr, $discount_item);
        }
    } else {
        $discounts_arr = [];
    }

    // Return a JSON response with all discounts
    echo json_encode(['status' => 200, 'data' => $discounts_arr], JSON_PRETTY_PRINT);
} catch (Exception $e) {
    // Handle exceptions, you may want to log or handle differently
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
}

?>
