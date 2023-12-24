<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/db_azure.php';
include_once '../../model/Customer.php';

$database = new db();
$db = $database->connect();

$customer = new Customer($db);

// Check if the required data is provided
$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data['email']) && !empty($data['name'])) {
    // Assuming that 'email' and 'name' are required fields
    $customer->setEmail($data['email']);
    $customer->setName($data['name']);

    // Set other fields if needed
    $customer->setPhone($data['phone'] ?? null);
    $customer->setGender($data['gender'] ?? null);
    $customer->setBirthday($data['birthday'] ?? null);
    $customer->setAddress($data['address'] ?? null);
    $customer->setWard($data['ward'] ?? null);
    $customer->setDistrict($data['district'] ?? null);
    $customer->setCity($data['city'] ?? null);
    $customer->setImage($data['image'] ?? null);
    $customer->setStatus($data['status'] ?? null);

    // Perform the update
    if ($customer->updateCustomer($data)) {
        echo json_encode(array('message' => 'Customer updated successfully.'));
    } else {
        echo json_encode(array('message' => 'Unable to update customer.'));
    }
} else {
    echo json_encode(array('message' => 'Email and name are required.'));
}

?>
