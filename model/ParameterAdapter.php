<?php

class ParameterAdapter
{
    private $conn;
    private $ID;
    private $PRODUCT_ID;
    private $MODEL;
    private $FUNCTION;
    private $INPUT;
    private $OUTPUT;
    private $MAXIMUM;
    private $SIZE;
    private $TECH;
    private $MADEIN;
    private $BRANDOF;
    private $BRAND;

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
    public function getMODEL()
    {
        return $this->MODEL;
    }

    /**
     * @param mixed $MODEL
     */
    public function setMODEL($MODEL)
    {
        $this->MODEL = $MODEL;
    }

    /**
     * @return mixed
     */
    public function getFUNCTION()
    {
        return $this->FUNCTION;
    }

    /**
     * @param mixed $FUNCTION
     */
    public function setFUNCTION($FUNCTION)
    {
        $this->FUNCTION = $FUNCTION;
    }

    /**
     * @return mixed
     */
    public function getINPUT()
    {
        return $this->INPUT;
    }

    /**
     * @param mixed $INPUT
     */
    public function setINPUT($INPUT)
    {
        $this->INPUT = $INPUT;
    }

    /**
     * @return mixed
     */
    public function getOUTPUT()
    {
        return $this->OUTPUT;
    }

    /**
     * @param mixed $OUTPUT
     */
    public function setOUTPUT($OUTPUT)
    {
        $this->OUTPUT = $OUTPUT;
    }

    /**
     * @return mixed
     */
    public function getMAXIMUM()
    {
        return $this->MAXIMUM;
    }

    /**
     * @param mixed $MAXIMUM
     */
    public function setMAXIMUM($MAXIMUM)
    {
        $this->MAXIMUM = $MAXIMUM;
    }

    /**
     * @return mixed
     */
    public function getSIZE()
    {
        return $this->SIZE;
    }

    /**
     * @param mixed $SIZE
     */
    public function setSIZE($SIZE)
    {
        $this->SIZE = $SIZE;
    }

    /**
     * @return mixed
     */
    public function getTECH()
    {
        return $this->TECH;
    }

    /**
     * @param mixed $TECH
     */
    public function setTECH($TECH)
    {
        $this->TECH = $TECH;
    }

    /**
     * @return mixed
     */
    public function getMADEIN()
    {
        return $this->MADEIN;
    }

    /**
     * @param mixed $MADEIN
     */
    public function setMADEIN($MADEIN)
    {
        $this->MADEIN = $MADEIN;
    }

    /**
     * @return mixed
     */
    public function getBRANDOF()
    {
        return $this->BRANDOF;
    }

    /**
     * @param mixed $BRANDOF
     */
    public function setBRANDOF($BRANDOF)
    {
        $this->BRANDOF = $BRANDOF;
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

    public function getAllParameterAdapters()
    {
        $query = "SELECT * FROM parameter_adapter";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}

?>
