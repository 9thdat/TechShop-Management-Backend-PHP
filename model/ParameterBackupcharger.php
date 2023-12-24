<?php

class ParameterBackupcharger
{
    private $conn;
    private $ID;
    private $PRODUCT_ID;
    private $EFFICIENCY;
    private $CAPACITY;
    private $TIMEFULLCHARGE;
    private $INPUT;
    private $OUTPUT;
    private $CORE;
    private $TECH;
    private $SIZE;
    private $WEIGHT;
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
    public function getEFFICIENCY()
    {
        return $this->EFFICIENCY;
    }

    /**
     * @param mixed $EFFICIENCY
     */
    public function setEFFICIENCY($EFFICIENCY)
    {
        $this->EFFICIENCY = $EFFICIENCY;
    }

    /**
     * @return mixed
     */
    public function getCAPACITY()
    {
        return $this->CAPACITY;
    }

    /**
     * @param mixed $CAPACITY
     */
    public function setCAPACITY($CAPACITY)
    {
        $this->CAPACITY = $CAPACITY;
    }

    /**
     * @return mixed
     */
    public function getTIMEFULLCHARGE()
    {
        return $this->TIMEFULLCHARGE;
    }

    /**
     * @param mixed $TIMEFULLCHARGE
     */
    public function setTIMEFULLCHARGE($TIMEFULLCHARGE)
    {
        $this->TIMEFULLCHARGE = $TIMEFULLCHARGE;
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
    public function getCORE()
    {
        return $this->CORE;
    }

    /**
     * @param mixed $CORE
     */
    public function setCORE($CORE)
    {
        $this->CORE = $CORE;
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
    public function getWEIGHT()
    {
        return $this->WEIGHT;
    }

    /**
     * @param mixed $WEIGHT
     */
    public function setWEIGHT($WEIGHT)
    {
        $this->WEIGHT = $WEIGHT;
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

    public function getAllParameterBackupchargers()
    {
        $query = "SELECT * FROM parameter_backupcharger";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}

?>
