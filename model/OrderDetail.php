<?php

class OrderDetail
{
    private $conn;
    private $ID;
    private $ORDER_ID;
    private $PRODUCT_ID;
    private $COLOR;
    private $QUANTITY;
    private $PRICE;

    public function __construct($connect)
    {
        $this->conn = $connect;
    }

    /**
     * @return mixed
     */
    public function getConn()
    {
        return $this->conn;
    }

    /**
     * @param mixed $conn
     */
    public function setConn($conn)
    {
        $this->conn = $conn;
    }

    /**
     * @return mixed
     */
    public function getID()
    {
        return $this->ID;
    }

    /**
     * @param mixed $ID
     */
    public function setID($ID)
    {
        $this->ID = $ID;
    }

    /**
     * @return mixed
     */
    public function getORDER_ID()
    {
        return $this->ORDER_ID;
    }

    /**
     * @param mixed $ORDER_ID
     */
    public function setORDER_ID($ORDER_ID)
    {
        $this->ORDER_ID = $ORDER_ID;
    }

    /**
     * @return mixed
     */
    public function getPRODUCT_ID()
    {
        return $this->PRODUCT_ID;
    }

    /**
     * @param mixed $PRODUCT_ID
     */
    public function setPRODUCT_ID($PRODUCT_ID)
    {
        $this->PRODUCT_ID = $PRODUCT_ID;
    }

    /**
     * @return mixed
     */
    public function getCOLOR()
    {
        return $this->COLOR;
    }

    /**
     * @param mixed $COLOR
     */
    public function setCOLOR($COLOR)
    {
        $this->COLOR = $COLOR;
    }

    /**
     * @return mixed
     */
    public function getQUANTITY()
    {
        return $this->QUANTITY;
    }

    /**
     * @param mixed $QUANTITY
     */
    public function setQUANTITY($QUANTITY)
    {
        $this->QUANTITY = $QUANTITY;
    }

    /**
     * @return mixed
     */
    public function getPRICE()
    {
        return $this->PRICE;
    }

    /**
     * @param mixed $PRICE
     */
    public function setPRICE($PRICE)
    {
        $this->PRICE = $PRICE;
    }

    public function getOrderDetailsByOrderId($orderId)
    {
        $query = "SELECT * FROM order_detail WHERE ORDER_ID = :orderId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':orderId', $orderId);
        $stmt->execute();
        return $stmt;
    }

    public function getLastId()
    {
        $query = "SELECT * FROM order_detail ORDER BY ID DESC LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addOrderDetail($orderDetail)
    {
        try {
            // Set order detail properties
            $this->ORDER_ID = $orderDetail->OrderId;
            $this->PRODUCT_ID = $orderDetail->ProductId;
            $this->COLOR = $orderDetail->Color;
            $this->QUANTITY = $orderDetail->Quantity;
            $this->PRICE = $orderDetail->Price;

            // Create new OrderDetail object
            $newOrderDetail = new OrderDetail($this->conn);

            // Set properties
            $newOrderDetail->setORDER_ID($this->ORDER_ID);
            $newOrderDetail->setPRODUCT_ID($this->PRODUCT_ID);
            $newOrderDetail->setCOLOR($this->COLOR);
            $newOrderDetail->setQUANTITY($this->QUANTITY);
            $newOrderDetail->setPRICE($this->PRICE);

            // Update product quantity in the database
            $query = "SELECT * FROM product_quantity WHERE PRODUCT_ID = :PRODUCT_ID AND COLOR = :COLOR";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':PRODUCT_ID', $this->PRODUCT_ID);
            $stmt->bindParam(':COLOR', $this->COLOR);
            $stmt->execute();

            $productQuantityInDb = $stmt->fetch(PDO::FETCH_ASSOC);

            $quantity = $productQuantityInDb['QUANTITY'] - $this->QUANTITY;
            $sold = $productQuantityInDb['SOLD'] + $this->QUANTITY;

            $query = "UPDATE product_quantity SET QUANTITY = :QUANTITY, SOLD = :SOLD WHERE PRODUCT_ID = :PRODUCT_ID AND COLOR = :COLOR";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':QUANTITY', $quantity);
            $stmt->bindParam(':SOLD', $sold);
            $stmt->bindParam(':PRODUCT_ID', $this->PRODUCT_ID);
            $stmt->bindParam(':COLOR', $this->COLOR);
            $stmt->execute();

            // Add order detail to the database
            $query = "INSERT INTO order_detail (ORDER_ID, PRODUCT_ID, COLOR, QUANTITY, PRICE) VALUES (:ORDER_ID, :PRODUCT_ID, :COLOR, :QUANTITY, :PRICE)";
            $stmt = $this->conn->prepare($query);

            // Bind parameters
            $stmt->bindParam(':ORDER_ID', $this->ORDER_ID);
            $stmt->bindParam(':PRODUCT_ID', $this->PRODUCT_ID);
            $stmt->bindParam(':COLOR', $this->COLOR);
            $stmt->bindParam(':QUANTITY', $this->QUANTITY);
            $stmt->bindParam(':PRICE', $this->PRICE);

            // Execute the statement
            $stmt->execute();

            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function cancelOrderDetail($orderId)
    {
        try {
            // Lấy thông tin đơn hàng chi tiết từ cơ sở dữ liệu
            $query = "SELECT * FROM order_detail WHERE ORDER_ID = :orderId";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':orderId', $orderId);
            $stmt->execute();

            $orderDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Kiểm tra xem đơn hàng chi tiết có tồn tại hay không
            if (!$orderDetails) {
                return false;
            }


            // ...

            $quantity = 0;
            $sold = 0;

            foreach ($orderDetails as $orderDetail) {
                extract($orderDetail);
                // Lấy thông tin số lượng sản phẩm từ cơ sở dữ liệu
                $queryProductQuantity = "SELECT * FROM product_quantity WHERE PRODUCT_ID = :productId AND Color = :color";
                $stmtProductQuantity = $this->conn->prepare($queryProductQuantity);
                $stmtProductQuantity->bindParam(':productId', $orderDetail['PRODUCT_ID']);
                $stmtProductQuantity->bindParam(':color', $orderDetail['COLOR']);
                $stmtProductQuantity->execute();

                $productQuantityInDb = $stmtProductQuantity->fetch(PDO::FETCH_ASSOC);

                // Kiểm tra xem số lượng sản phẩm có tồn tại hay không
                if (!$productQuantityInDb) {
                    return false;
                }

                // Tính toán giá trị mới của $quantity và $sold
                $quantity = $productQuantityInDb['QUANTITY'] + $orderDetail['QUANTITY'];
                $sold = $productQuantityInDb['SOLD'] - $orderDetail['QUANTITY'];

                $queryUpdateProductQuantity = "UPDATE product_quantity SET Quantity = :quantity, Sold = :sold WHERE PRODUCT_ID = :productId AND Color = :color";
                $stmtUpdateProductQuantity = $this->conn->prepare($queryUpdateProductQuantity);
                $stmtUpdateProductQuantity->bindParam(':quantity', $quantity);
                $stmtUpdateProductQuantity->bindParam(':sold', $sold);
                $stmtUpdateProductQuantity->bindParam(':productId', $orderDetails[0]['PRODUCT_ID']); // Lấy PRODUCT_ID từ một trong các orderDetail
                $stmtUpdateProductQuantity->bindParam(':color', $orderDetails[0]['COLOR']); // Lấy COLOR từ một trong các orderDetail
                $stmtUpdateProductQuantity->execute();
            }

            return true;
        } catch (Exception $ex) {
            // Ghi log hoặc xử lý ngoại lệ khác nếu cần
            throw new Exception('Error: ' . $ex->getMessage());
            return false;
        }
    }


}

?>
