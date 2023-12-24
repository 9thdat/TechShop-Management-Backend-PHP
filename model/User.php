<?php

class User
{
    private $conn;
    private $EMAIL;
    private $NAME;
    private $PASSWORD;
    private $PHONE;
    private $GENDER;
    private $BIRTHDAY;
    private $ADDRESS;
    private $WARD;
    private $DISTRICT;
    private $CITY;
    private $IMAGE;
    private $ROLE;
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
    public function getEMAIL()
    {
        return $this->EMAIL;
    }

    /**
     * @param mixed $EMAIL
     */
    public function setEMAIL($EMAIL)
    {
        $this->EMAIL = $EMAIL;
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
    public function getPASSWORD()
    {
        return $this->PASSWORD;
    }

    /**
     * @param mixed $PASSWORD
     */
    public function setPASSWORD($PASSWORD)
    {
        $this->PASSWORD = $PASSWORD;
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
    public function getGENDER()
    {
        return $this->GENDER;
    }

    /**
     * @param mixed $GENDER
     */
    public function setGENDER($GENDER)
    {
        $this->GENDER = $GENDER;
    }

    /**
     * @return mixed
     */
    public function getBIRTHDAY()
    {
        return $this->BIRTHDAY;
    }

    /**
     * @param mixed $BIRTHDAY
     */
    public function setBIRTHDAY($BIRTHDAY)
    {
        $this->BIRTHDAY = $BIRTHDAY;
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
    public function getROLE()
    {
        return $this->ROLE;
    }

    /**
     * @param mixed $ROLE
     */
    public function setROLE($ROLE)
    {
        $this->ROLE = $ROLE;
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

    public function getAllUsers()
    {
        $query = "SELECT * FROM user";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}

?>
