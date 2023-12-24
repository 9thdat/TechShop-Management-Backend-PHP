<?php

class Discount
{
    private $conn;
    private $ID;
    private $CODE;
    private $TYPE;
    private $VALUE;
    private $DESCRIPTION;
    private $START_DATE;
    private $END_DATE;
    private $MIN_APPLY;
    private $MAX_SPEED;
    private $QUANTITY;
    private $STATUS;
    private $CREATED_AT;
    private $UPDATED_AT;
    private $DISABLED_AT;

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
    public function getCODE()
    {
        return $this->CODE;
    }

    /**
     * @param mixed $CODE
     */
    public function setCODE($CODE)
    {
        $this->CODE = $CODE;
    }

    /**
     * @return mixed
     */
    public function getTYPE()
    {
        return $this->TYPE;
    }

    /**
     * @param mixed $TYPE
     */
    public function setTYPE($TYPE)
    {
        $this->TYPE = $TYPE;
    }

    /**
     * @return mixed
     */
    public function getVALUE()
    {
        return $this->VALUE;
    }

    /**
     * @param mixed $VALUE
     */
    public function setVALUE($VALUE)
    {
        $this->VALUE = $VALUE;
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
    public function getSTART_DATE()
    {
        return $this->START_DATE;
    }

    /**
     * @param mixed $START_DATE
     */
    public function setSTART_DATE($START_DATE)
    {
        $this->START_DATE = $START_DATE;
    }

    /**
     * @return mixed
     */
    public function getEND_DATE()
    {
        return $this->END_DATE;
    }

    /**
     * @param mixed $END_DATE
     */
    public function setEND_DATE($END_DATE)
    {
        $this->END_DATE = $END_DATE;
    }

    /**
     * @return mixed
     */
    public function getMIN_APPLY()
    {
        return $this->MIN_APPLY;
    }

    /**
     * @param mixed $MIN_APPLY
     */
    public function setMIN_APPLY($MIN_APPLY)
    {
        $this->MIN_APPLY = $MIN_APPLY;
    }

    /**
     * @return mixed
     */
    public function getMAX_SPEED()
    {
        return $this->MAX_SPEED;
    }

    /**
     * @param mixed $MAX_SPEED
     */
    public function setMAX_SPEED($MAX_SPEED)
    {
        $this->MAX_SPEED = $MAX_SPEED;
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

    /**
     * @return mixed
     */
    public function getCREATED_AT()
    {
        return $this->CREATED_AT;
    }

    /**
     * @param mixed $CREATED_AT
     */
    public function setCREATED_AT($CREATED_AT)
    {
        $this->CREATED_AT = $CREATED_AT;
    }

    /**
     * @return mixed
     */
    public function getUPDATED_AT()
    {
        return $this->UPDATED_AT;
    }

    /**
     * @param mixed $UPDATED_AT
     */
    public function setUPDATED_AT($UPDATED_AT)
    {
        $this->UPDATED_AT = $UPDATED_AT;
    }

    /**
     * @return mixed
     */
    public function getDISABLED_AT()
    {
        return $this->DISABLED_AT;
    }

    /**
     * @param mixed $DISABLED_AT
     */
    public function setDISABLED_AT($DISABLED_AT)
    {
        $this->DISABLED_AT = $DISABLED_AT;
    }

    public function getAllDiscounts()
    {
        $query = "SELECT * FROM discount";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}

?>
