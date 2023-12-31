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

    public function getImageDetailByProductId($productId)
    {
        $query = "SELECT * FROM image_detail WHERE PRODUCT_ID = :productId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt;
    }

    public function addImageDetail($data)
    {
        // Check if required data is provided
        if (
            !empty($data['productId'])
        ) {
            // Set properties
            $this->setPRODUCT_ID($data['productId']);
            $this->setColor($data['color']);
            $this->setOrdinal($data['ordinal']);
            $this->setImage($data['image']);

            // Perform the insert query
            $query = "INSERT INTO image_detail (PRODUCT_ID, COLOR, ORDINAL, IMAGE) 
                      VALUES (:PRODUCT_ID, :COLOR, :ORDINAL, :IMAGE)";

            $stmt = $this->conn->prepare($query);

            // Bind parameters
            $stmt->bindParam(':PRODUCT_ID', $this->PRODUCT_ID);
            $stmt->bindParam(':COLOR', $this->COLOR);
            $stmt->bindParam(':ORDINAL', $this->ORDINAL);
            $stmt->bindParam(':IMAGE', base64_decode($this->IMAGE));

            // Execute the query
            if ($stmt->execute()) {
                return true; // Image detail added successfully
            } else {
                return false; // Failed to add image detail
            }
        } else {
            return false; // Incomplete data provided
        }
    }

    public function updateImageDetail($id, $imageDetail)
    {
        $query = "UPDATE image_detail 
                  SET PRODUCT_ID = :PRODUCT_ID, 
                      COLOR = :COLOR, 
                      ORDINAL = :ORDINAL, 
                      IMAGE = :IMAGE 
                  WHERE ID = :ID";

        $stmt = $this->conn->prepare($query);

        // Set properties
        $this->setPRODUCT_ID($imageDetail->PRODUCT_ID);
        $this->setColor($imageDetail->COLOR);
        $this->setOrdinal($imageDetail->ORDINAL);
        $this->setImage($imageDetail->IMAGE);

        // Bind parameters
        $stmt->bindParam(':PRODUCT_ID', $this->getPRODUCT_ID());
        $stmt->bindParam(':COLOR', $this->getColor());
        $stmt->bindParam(':ORDINAL', $this->getOrdinal());
        $stmt->bindParam(':IMAGE', $this->getImage());
        $stmt->bindParam(':ID', $id);

        // Execute the query
        return $stmt->execute();
    }

    public function deleteImageDetail($id)
    {
        $query = "DELETE FROM image_detail WHERE ID = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return ['status' => 200, 'message' => 'Image detail deleted successfully.'];
        } else {
            return ['status' => 500, 'message' => 'Unable to delete image detail.'];
        }
    }
}

?>
