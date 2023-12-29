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

    public function getParameterBackupchargerByProductId($productId)
    {
        $query = "SELECT * FROM parameter_backupcharger WHERE PRODUCT_ID = :productId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
        $stmt->execute();

        $parameterBackupcharger = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $parameterBackupcharger;
    }

    public function addParameterBackupcharger($parameterBackupcharger)
    {
        try {
            // Set ParameterBackupcharger properties
            $this->PRODUCT_ID = $parameterBackupcharger->PRODUCT_ID;
            $this->EFFICIENCY = $parameterBackupcharger->EFFICIENCY;
            $this->CAPACITY = $parameterBackupcharger->CAPACITY;
            $this->TIMEFULLCHARGE = $parameterBackupcharger->TIMEFULLCHARGE;
            $this->INPUT = $parameterBackupcharger->INPUT;
            $this->OUTPUT = $parameterBackupcharger->OUTPUT;
            $this->CORE = $parameterBackupcharger->CORE;
            $this->TECH = $parameterBackupcharger->TECH;
            $this->SIZE = $parameterBackupcharger->SIZE;
            $this->WEIGHT = $parameterBackupcharger->WEIGHT;
            $this->MADEIN = $parameterBackupcharger->MADEIN;
            $this->BRANDOF = $parameterBackupcharger->BRANDOF;
            $this->BRAND = $parameterBackupcharger->BRAND;

            // Add ParameterBackupcharger to the database
            $query = "INSERT INTO parameter_backupcharger 
                      (PRODUCT_ID, EFFICIENCY, CAPACITY, TIMEFULLCHARGE, INPUT, OUTPUT, CORE, TECH, SIZE, WEIGHT, MADEIN, BRANDOF, BRAND) 
                      VALUES 
                      (:PRODUCT_ID, :EFFICIENCY, :CAPACITY, :TIMEFULLCHARGE, :INPUT, :OUTPUT, :CORE, :TECH, :SIZE, :WEIGHT, :MADEIN, :BRANDOF, :BRAND)";

            $stmt = $this->conn->prepare($query);

            // Bind parameters
            $stmt->bindParam(':PRODUCT_ID', $this->PRODUCT_ID);
            $stmt->bindParam(':EFFICIENCY', $this->EFFICIENCY);
            $stmt->bindParam(':CAPACITY', $this->CAPACITY);
            $stmt->bindParam(':TIMEFULLCHARGE', $this->TIMEFULLCHARGE);
            $stmt->bindParam(':INPUT', $this->INPUT);
            $stmt->bindParam(':OUTPUT', $this->OUTPUT);
            $stmt->bindParam(':CORE', $this->CORE);
            $stmt->bindParam(':TECH', $this->TECH);
            $stmt->bindParam(':SIZE', $this->SIZE);
            $stmt->bindParam(':WEIGHT', $this->WEIGHT);
            $stmt->bindParam(':MADEIN', $this->MADEIN);
            $stmt->bindParam(':BRANDOF', $this->BRANDOF);
            $stmt->bindParam(':BRAND', $this->BRAND);

            // Execute the statement
            $stmt->execute();

            return true; // Return true if the ParameterBackupcharger is added successfully
        } catch (Exception $ex) {
            throw new Exception('Error: ' . $ex->getMessage());
            return false; // Return false if there's an error
        }
    }

    public function updateParameterBackupcharger($id, $parameterBackupcharger)
    {
        try {
            // Set properties from the request
            $this->ID = $id;
            $this->PRODUCT_ID = $parameterBackupcharger->PRODUCT_ID;
            $this->EFFICIENCY = $parameterBackupcharger->EFFICIENCY;
            $this->CAPACITY = $parameterBackupcharger->CAPACITY;
            $this->TIMEFULLCHARGE = $parameterBackupcharger->TIMEFULLCHARGE;
            $this->INPUT = $parameterBackupcharger->INPUT;
            $this->OUTPUT = $parameterBackupcharger->OUTPUT;
            $this->CORE = $parameterBackupcharger->CORE;
            $this->TECH = $parameterBackupcharger->TECH;
            $this->SIZE = $parameterBackupcharger->SIZE;
            $this->WEIGHT = $parameterBackupcharger->WEIGHT;
            $this->MADEIN = $parameterBackupcharger->MADEIN;
            $this->BRANDOF = $parameterBackupcharger->BRANDOF;
            $this->BRAND = $parameterBackupcharger->BRAND;

            // Update the database
            $query = "UPDATE parameter_backupcharger
                      SET
                        PRODUCT_ID = :PRODUCT_ID,
                        EFFICIENCY = :EFFICIENCY,
                        CAPACITY = :CAPACITY,
                        TIMEFULLCHARGE = :TIMEFULLCHARGE,
                        INPUT = :INPUT,
                        OUTPUT = :OUTPUT,
                        CORE = :CORE,
                        TECH = :TECH,
                        SIZE = :SIZE,
                        WEIGHT = :WEIGHT,
                        MADEIN = :MADEIN,
                        BRANDOF = :BRANDOF,
                        BRAND = :BRAND
                      WHERE
                        ID = :ID";

            $stmt = $this->conn->prepare($query);

            // Bind parameters
            $stmt->bindParam(':PRODUCT_ID', $this->PRODUCT_ID);
            $stmt->bindParam(':EFFICIENCY', $this->EFFICIENCY);
            $stmt->bindParam(':CAPACITY', $this->CAPACITY);
            $stmt->bindParam(':TIMEFULLCHARGE', $this->TIMEFULLCHARGE);
            $stmt->bindParam(':INPUT', $this->INPUT);
            $stmt->bindParam(':OUTPUT', $this->OUTPUT);
            $stmt->bindParam(':CORE', $this->CORE);
            $stmt->bindParam(':TECH', $this->TECH);
            $stmt->bindParam(':SIZE', $this->SIZE);
            $stmt->bindParam(':WEIGHT', $this->WEIGHT);
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

    public function deleteParameterBackupcharger($id)
    {
        try {
            $query = "DELETE FROM parameter_backupcharger WHERE ID = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            return true; // Trả về true nếu xóa thành công
        } catch (Exception $ex) {
            // Ghi log lỗi để debug
            error_log($ex->getMessage());
            return false; // Trả về false nếu có lỗi
        }
    }
}

?>
