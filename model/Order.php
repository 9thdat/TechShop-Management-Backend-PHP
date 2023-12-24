<?php

class Order
{
    private $conn;
    private $ID;
    private $CUSTOMER_EMAIL;
    private $NAME;
    private $ADDRESS;
    private $WARD;
    private $DISTRICT;
    private $CITY;
    private $PHONE;
    private $DISCOUNT_ID;
    private $SHIPPING_FEE;
    private $TOTAL_PRICE;
    private $NOTE;
    private $ORDER_DATE;
    private $CANCELED_DATE;
    private $COMPLETED_DATE;
    private $DELIVERY_TYPE;
    private $PAYMENT_TYPE;
    private $STATUS;

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
    public function getCUSTOMER_EMAIL()
    {
        return $this->CUSTOMER_EMAIL;
    }

    /**
     * @param mixed $CUSTOMER_EMAIL
     */
    public function setCUSTOMER_EMAIL($CUSTOMER_EMAIL)
    {
        $this->CUSTOMER_EMAIL = $CUSTOMER_EMAIL;
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
    public function getADDRESS()
    {
        return $this->ADDRESS;
    }

    /**
     * @param mixed $ADDRESS
     */
    public function setADDRESS($ADDRESS)
    {
        $this->ADDRESS = $ADDRESS;
    }

    /**
     * @return mixed
     */
    public function getWARD()
    {
        return $this->WARD;
    }

    /**
     * @param mixed $WARD
     */
    public function setWARD($WARD)
    {
        $this->WARD = $WARD;
    }

    /**
     * @return mixed
     */
    public function getDISTRICT()
    {
        return $this->DISTRICT;
    }

    /**
     * @param mixed $DISTRICT
     */
    public function setDISTRICT($DISTRICT)
    {
        $this->DISTRICT = $DISTRICT;
    }

    /**
     * @return mixed
     */
    public function getCITY()
    {
        return $this->CITY;
    }

    /**
     * @param mixed $CITY
     */
    public function setCITY($CITY)
    {
        $this->CITY = $CITY;
    }

    /**
     * @return mixed
     */
    public function getPHONE()
    {
        return $this->PHONE;
    }

    /**
     * @param mixed $PHONE
     */
    public function setPHONE($PHONE)
    {
        $this->PHONE = $PHONE;
    }

    /**
     * @return mixed
     */
    public function getDISCOUNT_ID()
    {
        return $this->DISCOUNT_ID;
    }

    /**
     * @param mixed $DISCOUNT_ID
     */
    public function setDISCOUNT_ID($DISCOUNT_ID)
    {
        $this->DISCOUNT_ID = $DISCOUNT_ID;
    }

    /**
     * @return mixed
     */
    public function getSHIPPING_FEE()
    {
        return $this->SHIPPING_FEE;
    }

    /**
     * @param mixed $SHIPPING_FEE
     */
    public function setSHIPPING_FEE($SHIPPING_FEE)
    {
        $this->SHIPPING_FEE = $SHIPPING_FEE;
    }

    /**
     * @return mixed
     */
    public function getTOTAL_PRICE()
    {
        return $this->TOTAL_PRICE;
    }

    /**
     * @param mixed $TOTAL_PRICE
     */
    public function setTOTAL_PRICE($TOTAL_PRICE)
    {
        $this->TOTAL_PRICE = $TOTAL_PRICE;
    }

    /**
     * @return mixed
     */
    public function getNOTE()
    {
        return $this->NOTE;
    }

    /**
     * @param mixed $NOTE
     */
    public function setNOTE($NOTE)
    {
        $this->NOTE = $NOTE;
    }

    /**
     * @return mixed
     */
    public function getORDER_DATE()
    {
        return $this->ORDER_DATE;
    }

    /**
     * @param mixed $ORDER_DATE
     */
    public function setORDER_DATE($ORDER_DATE)
    {
        $this->ORDER_DATE = $ORDER_DATE;
    }

    /**
     * @return mixed
     */
    public function getCANCELED_DATE()
    {
        return $this->CANCELED_DATE;
    }

    /**
     * @param mixed $CANCELED_DATE
     */
    public function setCANCELED_DATE($CANCELED_DATE)
    {
        $this->CANCELED_DATE = $CANCELED_DATE;
    }

    /**
     * @return mixed
     */
    public function getCOMPLETED_DATE()
    {
        return $this->COMPLETED_DATE;
    }

    /**
     * @param mixed $COMPLETED_DATE
     */
    public function setCOMPLETED_DATE($COMPLETED_DATE)
    {
        $this->COMPLETED_DATE = $COMPLETED_DATE;
    }

    /**
     * @return mixed
     */
    public function getDELIVERY_TYPE()
    {
        return $this->DELIVERY_TYPE;
    }

    /**
     * @param mixed $DELIVERY_TYPE
     */
    public function setDELIVERY_TYPE($DELIVERY_TYPE)
    {
        $this->DELIVERY_TYPE = $DELIVERY_TYPE;
    }

    /**
     * @return mixed
     */
    public function getPAYMENT_TYPE()
    {
        return $this->PAYMENT_TYPE;
    }

    /**
     * @param mixed $PAYMENT_TYPE
     */
    public function setPAYMENT_TYPE($PAYMENT_TYPE)
    {
        $this->PAYMENT_TYPE = $PAYMENT_TYPE;
    }

    /**
     * @return mixed
     */
    public function getSTATUS()
    {
        return $this->STATUS;
    }

    /**
     * @param mixed $STATUS
     */
    public function setSTATUS($STATUS)
    {
        $this->STATUS = $STATUS;
    }

    public function getAllOrders()
    {
        $query = "SELECT * FROM orders";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}

?>
