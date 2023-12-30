<?php

class ProductQuantity
{
    private $conn;
    private $ID;
    private $PRODUCT_ID;
    private $COLOR;
    private $QUANTITY;
    private $SOLD;

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
    public function getSOLD()
    {
        return $this->SOLD;
    }

    /**
     * @param mixed $SOLD
     */
    public function setSOLD($SOLD)
    {
        $this->SOLD = $SOLD;
    }

    public function getProductQuantity($productId)
    {
        $query = "SELECT * FROM product_quantity WHERE PRODUCT_ID = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $productId);
        $stmt->execute();

        return $stmt;
    }

    public function getTotalQuantity($productId, $color)
    {
        $query = "SELECT SUM(QUANTITY) as totalQuantity FROM product_quantity WHERE PRODUCT_ID = :productId AND COLOR = :color";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
        $stmt->bindParam(':color', $color, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt;
    }
}

?>
