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

    public function getParameterAdapterByProductId($productId)
    {
        $query = "SELECT * FROM parameter_adapter WHERE PRODUCT_ID = :productId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':productId', $productId);
        $stmt->execute();

        return $stmt;
    }

    public function addParameterAdapter($parameterAdapter)
    {
        try {
            // Set parameter adapter properties
            $this->PRODUCT_ID = $parameterAdapter->getPRODUCT_ID();
            $this->MODEL = $parameterAdapter->getModel();
            $this->FUNCTION = $parameterAdapter->getFunction();
            $this->INPUT = $parameterAdapter->getInput();
            $this->OUTPUT = $parameterAdapter->getOutput();
            $this->MAXIMUM = $parameterAdapter->getMaximum();
            $this->SIZE = $parameterAdapter->getSize();
            $this->TECH = $parameterAdapter->getTech();
            $this->MADEIN = $parameterAdapter->getMadeIn();
            $this->BRANDOF = $parameterAdapter->getBrandOf();
            $this->BRAND = $parameterAdapter->getBrand();

            // Add parameter adapter to the database
            $query = "INSERT INTO parameter_adapter 
                      (PRODUCT_ID, MODEL, `FUNCTION`, INPUT, OUTPUT, MAXIMUM, SIZE, TECH, MADEIN, BRANDOF, BRAND) 
                      VALUES 
                      (:PRODUCT_ID, :MODEL, :FUNCTION, :INPUT, :OUTPUT, :MAXIMUM, :SIZE, :TECH, :MADEIN, :BRANDOF, :BRAND)";

            $stmt = $this->conn->prepare($query);

            // Bind parameters
            $stmt->bindParam(':PRODUCT_ID', $this->PRODUCT_ID);
            $stmt->bindParam(':MODEL', $this->MODEL);
            $stmt->bindParam(':FUNCTION', $this->FUNCTION);
            $stmt->bindParam(':INPUT', $this->INPUT);
            $stmt->bindParam(':OUTPUT', $this->OUTPUT);
            $stmt->bindParam(':MAXIMUM', $this->MAXIMUM);
            $stmt->bindParam(':SIZE', $this->SIZE);
            $stmt->bindParam(':TECH', $this->TECH);
            $stmt->bindParam(':MADEIN', $this->MADEIN);
            $stmt->bindParam(':BRANDOF', $this->BRANDOF);
            $stmt->bindParam(':BRAND', $this->BRAND);

            // Execute the statement
            $stmt->execute();

            return true; // Return true if the parameter adapter is added successfully
        } catch (Exception $ex) {
            // Log the exception for debugging purposes
            throw new Exception($ex->getMessage());
            return false; // Return false if there's an error
        }
    }

    public function updateParameterAdapter()
    {
        try {
            $query = "UPDATE parameter_adapter 
                      SET PRODUCT_ID = :PRODUCT_ID, MODEL = :MODEL, `FUNCTION` = :FUNCTION, 
                          INPUT = :INPUT, OUTPUT = :OUTPUT, MAXIMUM = :MAXIMUM, 
                          SIZE = :SIZE, TECH = :TECH, MADEIN = :MADEIN, 
                          BRANDOF = :BRANDOF, BRAND = :BRAND 
                      WHERE ID = :ID";

            $stmt = $this->conn->prepare($query);

            // Bind parameters
            $stmt->bindParam(':PRODUCT_ID', $this->PRODUCT_ID);
            $stmt->bindParam(':MODEL', $this->MODEL);
            $stmt->bindParam(':FUNCTION', $this->FUNCTION);
            $stmt->bindParam(':INPUT', $this->INPUT);
            $stmt->bindParam(':OUTPUT', $this->OUTPUT);
            $stmt->bindParam(':MAXIMUM', $this->MAXIMUM);
            $stmt->bindParam(':SIZE', $this->SIZE);
            $stmt->bindParam(':TECH', $this->TECH);
            $stmt->bindParam(':MADEIN', $this->MADEIN);
            $stmt->bindParam(':BRANDOF', $this->BRANDOF);
            $stmt->bindParam(':BRAND', $this->BRAND);
            $stmt->bindParam(':ID', $this->ID);

            // Execute the statement
            $stmt->execute();

            return true; // Return true if the update is successful
        } catch (Exception $ex) {
            // Log the exception for debugging purposes
            error_log($ex->getMessage());
            return false; // Return false if there's an error
        }
    }

    public function deleteParameterAdapter()
    {
        try {
            // Check if the parameter adapter with the given ID exists
            $queryCheck = "SELECT * FROM parameter_adapter WHERE ID = :id";
            $stmtCheck = $this->conn->prepare($queryCheck);
            $stmtCheck->bindParam(':id', $this->ID);
            $stmtCheck->execute();

            if ($stmtCheck->rowCount() > 0) {
                // Delete the parameter adapter
                $queryDelete = "DELETE FROM parameter_adapter WHERE ID = :id";
                $stmtDelete = $this->conn->prepare($queryDelete);
                $stmtDelete->bindParam(':id', $this->ID);
                $stmtDelete->execute();

                return ['status' => 200, 'message' => 'Parameter adapter deleted successfully.'];
            } else {
                // Parameter adapter not found
                return ['status' => 404, 'message' => 'Parameter adapter not found.'];
            }
        } catch (Exception $ex) {
            // Log the exception for debugging purposes
            error_log($ex->getMessage());
            return ['status' => 500, 'message' => 'Internal Server Error: ' . $ex->getMessage()];
        }
    }

}

?>
