<?php
header('Access-Control-Allow-Origin: *');  // Replace with the actual origin of your frontend application
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include_once '../../config/db_azure.php';
include_once '../../model/Customer.php';
include_once '../../model/User.php'; // Include the User model

$database = new db();
$db = $database->connect();

$user = new User($db);
$customer = new Customer($db);

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
$data = json_decode(file_get_contents("php://input"));

// Check if data is not empty
if (
    !empty($data->email)
) {
    // Set Customer properties
    $customer->setEmail($data->email);
    $customer->setName($data->name);
    $customer->setPassword($data->password);
    $customer->setPhone($data->phone);
    $customer->setGender($data->gender);
    $customer->setBirthday($data->birthday);
    $customer->setAddress($data->address);
    $customer->setWard($data->ward);
    $customer->setDistrict($data->district);
    $customer->setCity($data->city);
    $customer->setImage($data->image);
    $customer->setStatus($data->status);

    // Create the Customer
    $result = $customer->createCustomer();

    echo json_encode($result);
} else {
    echo [
        'status' => 400,
        'message' => 'Unable to create Customer. Data is incomplete.'
    ];
}

?>
