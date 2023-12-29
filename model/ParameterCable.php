<?php

class ParameterCable
{
    private $conn;
    private $ID;
    private $PRODUCT_ID;
    private $TECH;
    private $FUNCTION;
    private $INPUT;
    private $OUTPUT;
    private $LENGTH;
    private $MAXIMUM;
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
    public function getLENGTH()
    {
        return $this->LENGTH;
    }

    /**
     * @param mixed $LENGTH
     */
    public function setLENGTH($LENGTH)
    {
        $this->LENGTH = $LENGTH;
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

    public function getParameterCableByProductId($productId)
    {
        $query = "SELECT * FROM parameter_cable WHERE PRODUCT_ID = :productId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':productId', $productId);
        $stmt->execute();

        return $stmt;
    }

    public function addParameterCable($parameterCable)
    {
        try {
            // Set parameterCable properties
            $this->PRODUCT_ID = $parameterCable->PRODUCT_ID;
            $this->TECH = $parameterCable->TECH;
            $this->FUNCTION = $parameterCable->FUNCTION;
            $this->INPUT = $parameterCable->INPUT;
            $this->OUTPUT = $parameterCable->OUTPUT;
            $this->LENGTH = $parameterCable->LENGTH;
            $this->MAXIMUM = $parameterCable->MAXIMUM;
            $this->MADEIN = $parameterCable->MADEIN;
            $this->BRANDOF = $parameterCable->BRANDOF;
            $this->BRAND = $parameterCable->BRAND;

            // Add parameterCable to the database
            $query = "INSERT INTO parameter_cable 
                      (PRODUCT_ID, TECH, `FUNCTION`, INPUT, OUTPUT, LENGTH, MAXIMUM, MADEIN, BRANDOF, BRAND) 
                      VALUES 
                      (:PRODUCT_ID, :TECH, :FUNCTION, :INPUT, :OUTPUT, :LENGTH, :MAXIMUM, :MADEIN, :BRANDOF, :BRAND)";

            $stmt = $this->conn->prepare($query);

            // Bind parameters
            $stmt->bindParam(':PRODUCT_ID', $this->PRODUCT_ID);
            $stmt->bindParam(':TECH', $this->TECH);
            $stmt->bindParam(':FUNCTION', $this->FUNCTION);
            $stmt->bindParam(':INPUT', $this->INPUT);
            $stmt->bindParam(':OUTPUT', $this->OUTPUT);
            $stmt->bindParam(':LENGTH', $this->LENGTH);
            $stmt->bindParam(':MAXIMUM', $this->MAXIMUM);
            $stmt->bindParam(':MADEIN', $this->MADEIN);
            $stmt->bindParam(':BRANDOF', $this->BRANDOF);
            $stmt->bindParam(':BRAND', $this->BRAND);

            // Execute the statement
            $stmt->execute();

            return true; // Return true if the parameterCable is added successfully
        } catch (Exception $ex) {
            // Log the exception for debugging purposes
            error_log($ex->getMessage());
            return false; // Return false if there's an error
        }
    }

    public function updateParameterCable($parameterCable)
    {
        try {
            // Set các thuộc tính của ParameterCable
            $this->ID = $parameterCable->ID;
            $this->PRODUCT_ID = $parameterCable->PRODUCT_ID;
            $this->TECH = $parameterCable->TECH;
            $this->FUNCTION = $parameterCable->FUNCTION;
            $this->INPUT = $parameterCable->INPUT;
            $this->OUTPUT = $parameterCable->OUTPUT;
            $this->LENGTH = $parameterCable->LENGTH;
            $this->MAXIMUM = $parameterCable->MAXIMUM;
            $this->MADEIN = $parameterCable->MADEIN;
            $this->BRANDOF = $parameterCable->BRANDOF;
            $this->BRAND = $parameterCable->BRAND;

            // Cập nhật ParameterCable trong cơ sở dữ liệu
            $query = "UPDATE parameter_cable 
                      SET PRODUCT_ID = :PRODUCT_ID, TECH = :TECH, `FUNCTION` = :FUNCTION,
                          INPUT = :INPUT, OUTPUT = :OUTPUT, LENGTH = :LENGTH,
                          MAXIMUM = :MAXIMUM, MADEIN = :MADEIN, BRANDOF = :BRANDOF,
                          BRAND = :BRAND
                      WHERE ID = :ID";

            $stmt = $this->conn->prepare($query);

            // Bind các tham số
            $stmt->bindParam(':PRODUCT_ID', $this->PRODUCT_ID);
            $stmt->bindParam(':TECH', $this->TECH);
            $stmt->bindParam(':FUNCTION', $this->FUNCTION);
            $stmt->bindParam(':INPUT', $this->INPUT);
            $stmt->bindParam(':OUTPUT', $this->OUTPUT);
            $stmt->bindParam(':LENGTH', $this->LENGTH);
            $stmt->bindParam(':MAXIMUM', $this->MAXIMUM);
            $stmt->bindParam(':MADEIN', $this->MADEIN);
            $stmt->bindParam(':BRANDOF', $this->BRANDOF);
            $stmt->bindParam(':BRAND', $this->BRAND);
            $stmt->bindParam(':ID', $this->ID);

            // Thực thi câu lệnh
            $stmt->execute();

            return true; // Trả về true nếu cập nhật thành công
        } catch (Exception $ex) {
            // Ghi log lỗi để debug
            error_log($ex->getMessage());
            return false; // Trả về false nếu có lỗi
        }
    }

    public function deleteParameterCable($id)
    {
        try {
            // Tìm parameterCable để xóa
            $query = "SELECT * FROM parameter_cable WHERE ID = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $parameterCable = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$parameterCable) {
                return [
                    'status' => 404,
                    'message' => 'ParameterCable not found'
                ];
            }

            // Xóa parameterCable
            $deleteQuery = "DELETE FROM parameter_cable WHERE ID = :id";
            $deleteStmt = $this->conn->prepare($deleteQuery);
            $deleteStmt->bindParam(':id', $id);
            $deleteStmt->execute();

            return [
                'status' => 204,
                'message' => 'ParameterCable deleted successfully'
            ];
        } catch (Exception $ex) {
            // Ghi log hoặc xử lý exception theo ý bạn
            error_log($ex->getMessage());
            return [
                'status' => 500,
                'message' => 'Internal Server Error: ' . $ex->getMessage()
            ];
        }
    }
}

?>
