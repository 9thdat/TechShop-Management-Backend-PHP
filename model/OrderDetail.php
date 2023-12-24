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

    public function getAllOrderDetails()
    {
        $query = "SELECT * FROM order_detail";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}

?>
