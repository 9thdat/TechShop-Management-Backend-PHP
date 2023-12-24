<?php

class Product
{
    private $conn;
    private $ID;
    private $NAME;
    private $PRICE;
    private $DESCRIPTION;
    private $IMAGE;
    private $CATEGORY;
    private $BRAND;
    private $PRE_DISCOUNT;
    private $DISCOUNT_PERCENT;

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
    public function getNAME()
    {
        return $this->NAME;
    }

    /**
     * @param mixed $NAME
     */
    public function setNAME($NAME)
    {
        $this->NAME = $NAME;
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

    /**
     * @return mixed
     */
    public function getDESCRIPTION()
    {
        return $this->DESCRIPTION;
    }

    /**
     * @param mixed $DESCRIPTION
     */
    public function setDESCRIPTION($DESCRIPTION)
    {
        $this->DESCRIPTION = $DESCRIPTION;
    }

    /**
     * @return mixed
     */
    public function getIMAGE()
    {
        return $this->IMAGE;
    }

    /**
     * @param mixed $IMAGE
     */
    public function setIMAGE($IMAGE)
    {
        $this->IMAGE = $IMAGE;
    }

    /**
     * @return mixed
     */
    public function getCATEGORY()
    {
        return $this->CATEGORY;
    }

    /**
     * @param mixed $CATEGORY
     */
    public function setCATEGORY($CATEGORY)
    {
        $this->CATEGORY = $CATEGORY;
    }

    /**
     * @return mixed
     */
    public function getBRAND()
    {
        return $this->BRAND;
    }

    /**
     * @param mixed $BRAND
     */
    public function setBRAND($BRAND)
    {
        $this->BRAND = $BRAND;
    }

    /**
     * @return mixed
     */
    public function getPRE_DISCOUNT()
    {
        return $this->PRE_DISCOUNT;
    }

    /**
     * @param mixed $PRE_DISCOUNT
     */
    public function setPRE_DISCOUNT($PRE_DISCOUNT)
    {
        $this->PRE_DISCOUNT = $PRE_DISCOUNT;
    }

    /**
     * @return mixed
     */
    public function getDISCOUNT_PERCENT()
    {
        return $this->DISCOUNT_PERCENT;
    }

    /**
     * @param mixed $DISCOUNT_PERCENT
     */
    public function setDISCOUNT_PERCENT($DISCOUNT_PERCENT)
    {
        $this->DISCOUNT_PERCENT = $DISCOUNT_PERCENT;
    }

    public function getAllProducts()
    {
        $query = "SELECT * FROM product";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}

?>
