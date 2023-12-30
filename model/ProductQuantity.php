<?php

class ProductQuantity
{
    private $conn;
    private $ID;
    private $PRODUCT_ID;
    private $COLOR;
    private $QUANTITY;
    private $SOLD;

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
    public function getSOLD()
    {
        return $this->SOLD;
    }

    /**
     * @param mixed $SOLD
     */
    public function setSOLD($SOLD)
    {
        $this->SOLD = $SOLD;
    }

    public function getProductQuantity($productId)
    {
        $query = "SELECT * FROM product_quantity WHERE PRODUCT_ID = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $productId);
        $stmt->execute();

        return $stmt;
    }

    public function getTotalQuantity($productId, $color)
    {
        $query = "SELECT SUM(QUANTITY) as totalQuantity FROM product_quantity WHERE PRODUCT_ID = :productId AND COLOR = :color";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
        $stmt->bindParam(':color', $color, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt;
    }

    public function addProductQuantity($productQuantity)
    {
        try {

            // Add product quantity to the database
            $query = "INSERT INTO product_quantity (PRODUCT_ID, COLOR, QUANTITY, SOLD) 
                      VALUES (:PRODUCT_ID, :COLOR, :QUANTITY, :SOLD)";

            // Prepare the statement
            $stmt = $this->conn->prepare($query);

            // Bind parameters
            $stmt->bindParam(':PRODUCT_ID', $productQuantity->productId);
            $stmt->bindParam(':COLOR', $productQuantity->color);
            $stmt->bindParam(':QUANTITY', $productQuantity->quantity);
            $stmt->bindParam(':SOLD', $productQuantity->sold);

            // Execute the statement
            $stmt->execute();

            return true; // Return true if the product quantity is added successfully
        } catch (Exception $ex) {
            // Log the exception for debugging purposes
            throw new Exception($ex->getMessage());
            return false; // Return false if there's an error
        }
    }

    public function updateProductQuantity($id, $productQuantity)
    {
        try {
            $productQuantityInDb = $this->getProductQuantity($id);

            if (!$productQuantityInDb) {
                return [
                    'status' => 404,
                    'message' => 'Product Quantity not found'
                ];
            }

            // Update product quantity
            $query = "UPDATE product_quantity 
                      SET COLOR = :color, QUANTITY = :quantity 
                      WHERE ID = :id";

            $stmt = $this->conn->prepare($query);

            // Bind parameters
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':color', $productQuantity->color);
            $stmt->bindParam(':quantity', $productQuantity->quantity);

            // Execute the statement
            $stmt->execute();

            return [
                'status' => 200,
                'message' => 'Product Quantity updated successfully.'
            ];
        } catch (Exception $ex) {
            return [
                'status' => 500,
                'message' => 'Internal Server Error: ' . $ex->getMessage()
            ];
        }
    }

    public function deleteProductQuantity($id)
    {
        $query = "DELETE FROM product_quantity WHERE ID = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);

        // Execute the statement
        $stmt->execute();

        return true; // Return true if deletion is successful
    }
}

?>
