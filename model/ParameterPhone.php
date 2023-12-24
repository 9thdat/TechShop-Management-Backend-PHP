<?php

class ParameterPhone
{
    private $conn;
    private $ID;
    private $PRODUCT_ID;
    private $SCREEN;
    private $OPERATING_SYSTEM;
    private $BACK_CAMERA;
    private $FRONT_CAMERA;
    private $CHIP;
    private $RAM;
    private $ROM;
    private $SIM;
    private $BATTERY_CHARGER;

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
    public function getSCREEN()
    {
        return $this->SCREEN;
    }

    /**
     * @param mixed $SCREEN
     */
    public function setSCREEN($SCREEN)
    {
        $this->SCREEN = $SCREEN;
    }

    /**
     * @return mixed
     */
    public function getOPERATING_SYSTEM()
    {
        return $this->OPERATING_SYSTEM;
    }

    /**
     * @param mixed $OPERATING_SYSTEM
     */
    public function setOPERATING_SYSTEM($OPERATING_SYSTEM)
    {
        $this->OPERATING_SYSTEM = $OPERATING_SYSTEM;
    }

    /**
     * @return mixed
     */
    public function getBACK_CAMERA()
    {
        return $this->BACK_CAMERA;
    }

    /**
     * @param mixed $BACK_CAMERA
     */
    public function setBACK_CAMERA($BACK_CAMERA)
    {
        $this->BACK_CAMERA = $BACK_CAMERA;
    }

    /**
     * @return mixed
     */
    public function getFRONT_CAMERA()
    {
        return $this->FRONT_CAMERA;
    }

    /**
     * @param mixed $FRONT_CAMERA
     */
    public function setFRONT_CAMERA($FRONT_CAMERA)
    {
        $this->FRONT_CAMERA = $FRONT_CAMERA;
    }

    /**
     * @return mixed
     */
    public function getCHIP()
    {
        return $this->CHIP;
    }

    /**
     * @param mixed $CHIP
     */
    public function setCHIP($CHIP)
    {
        $this->CHIP = $CHIP;
    }

    /**
     * @return mixed
     */
    public function getRAM()
    {
        return $this->RAM;
    }

    /**
     * @param mixed $RAM
     */
    public function setRAM($RAM)
    {
        $this->RAM = $RAM;
    }

    /**
     * @return mixed
     */
    public function getROM()
    {
        return $this->ROM;
    }

    /**
     * @param mixed $ROM
     */
    public function setROM($ROM)
    {
        $this->ROM = $ROM;
    }

    /**
     * @return mixed
     */
    public function getSIM()
    {
        return $this->SIM;
    }

    /**
     * @param mixed $SIM
     */
    public function setSIM($SIM)
    {
        $this->SIM = $SIM;
    }

    /**
     * @return mixed
     */
    public function getBATTERY_CHARGER()
    {
        return $this->BATTERY_CHARGER;
    }

    /**
     * @param mixed $BATTERY_CHARGER
     */
    public function setBATTERY_CHARGER($BATTERY_CHARGER)
    {
        $this->BATTERY_CHARGER = $BATTERY_CHARGER;
    }

    public function getAllParameterPhones()
    {
        $query = "SELECT * FROM parameter_phone";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}

?>
