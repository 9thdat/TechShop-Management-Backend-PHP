<?php

class ImageDetail
{
    private $conn;
    private $ID;
    private $PRODUCT_ID;
    private $COLOR;
    private $ORDINAL;
    private $IMAGE;

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
    public function getORDINAL()
    {
        return $this->ORDINAL;
    }

    /**
     * @param mixed $ORDINAL
     */
    public function setORDINAL($ORDINAL)
    {
        $this->ORDINAL = $ORDINAL;
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

    public function getAllImageDetails()
    {
        $query = "SELECT * FROM image_detail";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}

?>
