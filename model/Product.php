<?php

class Product
{
    private $conn;
    private $ID;
    private $NAME;
    private $PRICE;
    private $DESCRIPTION;
    private $IMAGE;
    private $CATEGORY;
    private $BRAND;
    private $PRE_DISCOUNT;
    private $DISCOUNT_PERCENT;

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
    public function getPRICE()
    {
        return $this->PRICE;
    }

    /**
     * @param mixed $PRICE
     */
    public function setPRICE($PRICE)
    {
        $this->PRICE = $PRICE;
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
    public function getCATEGORY()
    {
        return $this->CATEGORY;
    }

    /**
     * @param mixed $CATEGORY
     */
    public function setCATEGORY($CATEGORY)
    {
        $this->CATEGORY = $CATEGORY;
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

    /**
     * @return mixed
     */
    public function getPRE_DISCOUNT()
    {
        return $this->PRE_DISCOUNT;
    }

    /**
     * @param mixed $PRE_DISCOUNT
     */
    public function setPRE_DISCOUNT($PRE_DISCOUNT)
    {
        $this->PRE_DISCOUNT = $PRE_DISCOUNT;
    }

    /**
     * @return mixed
     */
    public function getDISCOUNT_PERCENT()
    {
        return $this->DISCOUNT_PERCENT;
    }

    /**
     * @param mixed $DISCOUNT_PERCENT
     */
    public function setDISCOUNT_PERCENT($DISCOUNT_PERCENT)
    {
        $this->DISCOUNT_PERCENT = $DISCOUNT_PERCENT;
    }

    public function getProduct($id)
    {
        try {
            $query = "SELECT * FROM product WHERE ID = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            return $stmt;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getProductsAndQuantity()
    {
        $query = "SELECT p.Id, p.Name, p.Price, p.Description, p.Image, p.Category, p.Brand, 
                         p.PRE_DISCOUNT, p.DISCOUNT_PERCENT, 
                         SUM(pq.Quantity) as Quantity
                  FROM product p
                  LEFT JOIN product_quantity pq ON p.Id = pq.PRODUCT_ID
                  GROUP BY p.Id";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function getLastId()
    {
        $query = "SELECT ID FROM product ORDER BY ID DESC LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['ID'];
    }

    public function addProduct($data)
    {
        try {
            // Thiết lập các thuộc tính sản phẩm từ dữ liệu đầu vào
            $this->NAME = $data->name;
            $this->PRICE = $data->price;
            $this->DESCRIPTION = $data->description;
            $this->IMAGE = base64_decode($data->image) ?? "";
            $this->CATEGORY = $data->category;
            $this->BRAND = $data->brand;
            $this->PRE_DISCOUNT = $data->preDiscount;
            $this->DISCOUNT_PERCENT = $data->discountPercent;

            // Thêm sản phẩm vào cơ sở dữ liệu
            $query = "INSERT INTO product 
                      (NAME, PRICE, DESCRIPTION, IMAGE, CATEGORY, BRAND, PRE_DISCOUNT, DISCOUNT_PERCENT) 
                      VALUES 
                      (:NAME, :PRICE, :DESCRIPTION, :IMAGE, :CATEGORY, :BRAND, :PRE_DISCOUNT, :DISCOUNT_PERCENT)";

            $stmt = $this->conn->prepare($query);

            // Bind các tham số
            $stmt->bindParam(':NAME', $this->NAME);
            $stmt->bindParam(':PRICE', $this->PRICE);
            $stmt->bindParam(':DESCRIPTION', $this->DESCRIPTION);
            $stmt->bindParam(':IMAGE', $this->IMAGE);
            $stmt->bindParam(':CATEGORY', $this->CATEGORY);
            $stmt->bindParam(':BRAND', $this->BRAND);
            $stmt->bindParam(':PRE_DISCOUNT', $this->PRE_DISCOUNT);
            $stmt->bindParam(':DISCOUNT_PERCENT', $this->DISCOUNT_PERCENT);

            // Thực thi câu lệnh
            $stmt->execute();

            return true; // Trả về true nếu sản phẩm được thêm thành công
        } catch (Exception $ex) {
            // Ghi log lỗi cho mục đích debug
            error_log($ex->getMessage());
            return false; // Trả về false nếu có lỗi
        }
    }

    public function deleteProduct($id)
    {
        $query = "UPDATE product_quantity SET QUANTITY = 0 WHERE PRODUCT_ID = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true; // Return true if the product is deleted successfully
        } else {
            return false; // Return false if there's an error
        }
    }

    public function updateProduct($id, $product)
    {
        try {
            // Set product properties
            $this->ID = $id;
            $this->NAME = $product->name;
            $this->PRICE = $product->price ?? "";
            $this->DESCRIPTION = $product->description ?? "";
            $this->IMAGE = base64_decode($product->image) ?? "";
            $this->CATEGORY = $product->category ?? 1;
            $this->BRAND = $product->brand ?? "";
            $this->PRE_DISCOUNT = $product->preDiscount ?? "";
            $this->DISCOUNT_PERCENT = $product->discountPercent ?? "";

            // Update the product in the database
            $query = "UPDATE product 
                      SET NAME = :NAME, PRICE = :PRICE, DESCRIPTION = :DESCRIPTION, IMAGE = :IMAGE, 
                          CATEGORY = :CATEGORY, BRAND = :BRAND, PRE_DISCOUNT = :PRE_DISCOUNT, DISCOUNT_PERCENT = :DISCOUNT_PERCENT 
                      WHERE ID = :ID";

            $stmt = $this->conn->prepare($query);

            // Bind parameters
            $stmt->bindParam(':ID', $this->ID);
            $stmt->bindParam(':NAME', $this->NAME);
            $stmt->bindParam(':PRICE', $this->PRICE);
            $stmt->bindParam(':DESCRIPTION', $this->DESCRIPTION);
            $stmt->bindParam(':IMAGE', $this->IMAGE);
            $stmt->bindParam(':CATEGORY', $this->CATEGORY);
            $stmt->bindParam(':BRAND', $this->BRAND);
            $stmt->bindParam(':PRE_DISCOUNT', $this->PRE_DISCOUNT);
            $stmt->bindParam(':DISCOUNT_PERCENT', $this->DISCOUNT_PERCENT);

            // Execute the statement
            $stmt->execute();

            return true; // Return true if the product is updated successfully
        } catch (Exception $ex) {
            // Log the exception for debugging purposes
            throw $ex;
            return false; // Return false if there's an error
        }
    }
}

?>
