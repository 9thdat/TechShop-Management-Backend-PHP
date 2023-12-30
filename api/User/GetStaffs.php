<?php
header('Access-Control-Allow-Origin: http://localhost:3000');  // Replace with the actual origin of your frontend application
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

include_once '../../config/db_azure.php'; // Adjust the path as needed
include_once '../../model/User.php';

$database = new db();
$db = $database->connect();

$user = new User($db);
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

    // Proceed to fetch staffs
    $staffs = $user->getStaffs();

    $num = $staffs->rowCount();

    if ($num > 0) {
        $staffsArray = array();

        foreach ($staffs as $row) {
            extract($row);

            // Encode the binary image data to base64
            $encodedImage = base64_encode($IMAGE);

            $staff_item = array(
                'email' => $EMAIL,
                'name' => $NAME,
                'password' => "",
                'phone' => $PHONE,
                'gender' => $GENDER,
                'birthday' => $BIRTHDAY,
                'address' => $ADDRESS,
                'ward' => $WARD,
                'district' => $DISTRICT,
                'city' => $CITY,
                'image' => $encodedImage, // Use the encoded image data
                'role' => $ROLE,
                'status' => $STATUS
            );

            array_push($staffsArray, $staff_item);
        }

        http_response_code(200);
        echo json_encode(['status' => 200, 'message' => 'OK', 'data' => $staffsArray]);
    } else {
        http_response_code(404);
        echo json_encode(['status' => 404, 'message' => 'No staffs found']);
    }
} catch (Exception $e) {
    // Handle exceptions, you may want to log or handle differently
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal Server Error: ' . $e->getMessage()]);
}

?>
