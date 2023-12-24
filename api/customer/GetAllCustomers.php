<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/db_azure.php';
include_once '../../model/Customer.php';

$database = new db();
$db = $database->connect();

$customer = new Customer($db);

$result = $customer->getAllCustomer();

$num = $result->rowCount();

if ($num > 0){
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/db_azure.php';
    include_once '../../model/Customer.php';

    $database = new db();
    $db = $database->connect();

    $customer = new Customer($db);

    $result = $customer->getAllCustomer();

    $num = $result->rowCount();

    if ($num > 0) {
        $customers_arr = array();
        $customers_arr['data'] = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $customer_item = array(
                'Email' => $EMAIL,
                'Name' => $NAME,
                'Password' => $PASSWORD,
                'Phone' => $PHONE,
                'Gender' => $GENDER,
                'Birthday' => $BIRTHDAY,
                'Address' => $ADDRESS,
                'Ward' => $WARD,
                'District' => $DISTRICT,
                'City' => $CITY,
                'Image' => $IMAGE,
                'Status' => $STATUS,
            );

            array_push($customers_arr['data'], $customer_item);
        }

        echo json_encode($customers_arr);
    } else {
        echo json_encode(
            array('message' => 'No customers found')
        );
    }


}
?>
