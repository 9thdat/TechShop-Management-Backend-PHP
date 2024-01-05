<?php

class Review
{
    private $conn;
    private $ID;
    private $PRODUCT_ID;
    private $CUSTOMER_EMAIL;
    private $RATING;
    private $CONTENT;
    private $ADMIN_REPLY;
    private $CREATED_AT;
    private $UPDATED_AT;

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
    public function getRATING()
    {
        return $this->RATING;
    }

    /**
     * @param mixed $RATING
     */
    public function setRATING($RATING)
    {
        $this->RATING = $RATING;
    }

    /**
     * @return mixed
     */
    public function getCONTENT()
    {
        return $this->CONTENT;
    }

    /**
     * @param mixed $CONTENT
     */
    public function setCONTENT($CONTENT)
    {
        $this->CONTENT = $CONTENT;
    }

    /**
     * @return mixed
     */
    public function getADMIN_REPLY()
    {
        return $this->ADMIN_REPLY;
    }

    /**
     * @param mixed $ADMIN_REPLY
     */
    public function setADMIN_REPLY($ADMIN_REPLY)
    {
        $this->ADMIN_REPLY = $ADMIN_REPLY;
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

    public function GetAllReviews()
    {
        $query = "SELECT * FROM review ORDER BY ID DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function updateReview($id, $adminReply)
    {
        try {
            $query = "UPDATE review SET ADMIN_REPLY = :adminReply, UPDATED_AT = NOW() WHERE ID = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':adminReply', $adminReply);
            $stmt->bindParam(':id', $id);

            $stmt->execute();

            return true;
        } catch (Exception $ex) {
            error_log($ex->getMessage());
            return false;
        }
    }
}

?>
