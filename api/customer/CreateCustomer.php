<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/db_azure.php';
    include_once '../../model/Customer.php';

    $database = new db();
    $db = $database->connect();

    $customer = new Customer($db);

    // Get posted data
    $data = json_decode(file_get_contents("php://input"));

    // Check if data is not empty
    if (!empty($data->email) &&
        !empty($data->name) &&
        !empty($data->password) &&
        !empty($data->phone) &&
        !empty($data->gender) &&
        !empty($data->birthday) &&
        !empty($data->address) &&
        !empty($data->ward) &&
        !empty($data->district) &&
        !empty($data->city) &&
        isset($data->image) &&
        !empty($data->status)
    ) {
        // Set customer properties
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

        // Create the customer
        if ($customer->createCustomer()) {
            echo json_encode(array("message" => "Customer created successfully."));
        } else {
            echo json_encode(array("message" => "Unable to create customer."));
        }
    } else {
        echo json_encode(array("message" => "Incomplete data. Please provide all required fields."));
    }
?>
