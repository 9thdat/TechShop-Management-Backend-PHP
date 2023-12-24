<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/db_azure.php';
include_once '../../model/Customer.php';

$database = new db();
$db = $database->connect();

$customer = new Customer($db);

// Kiểm tra xem có tham số email được truyền vào không
if (isset($_GET['email'])) {
    $customer->setEmail($_GET['email']);
    $result = $customer->getCustomerByEmail();

    $num = $result->rowCount();

    if ($num > 0) {
        $customer_arr = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $customer_item = array(
                'email' => $EMAIL,
                'name' => $NAME,
                'phone' => $PHONE,
                'gender' => $GENDER,
                'birthday' => $BIRTHDAY,
                'address' => $ADDRESS,
                'ward' => $WARD,
                'district' => $DISTRICT,
                'city' => $CITY,
                'image' => $IMAGE ? base64_encode($IMAGE) : null,
                'status' => $STATUS
            );

            $customer_arr[] = $customer_item;
        }

        // Hiển thị dữ liệu dưới dạng JSON
        echo json_encode(array('data' => $customer_arr));
    } else {
        // Nếu không tìm thấy khách hàng
        http_response_code(404);
        echo json_encode(
            array('message' => 'Không tìm thấy khách hàng.')
        );
    }
} else {
    // Nếu không có tham số email được truyền vào
    http_response_code(400);
    echo json_encode(
        array('message' => 'Vui lòng cung cấp địa chỉ email.')
    );
}
?>
