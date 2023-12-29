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

    public function GetParameterPhone($productId)
    {
        $query = "SELECT * FROM parameter_phone WHERE PRODUCT_ID = :productId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':productId', $productId);
        $stmt->execute();

        // Check if any parameter phones are found
        if ($stmt->rowCount() > 0) {
            return ['status' => 200, 'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)];
        } else {
            return ['status' => 404, 'message' => 'No parameters found for the given product ID'];
        }
    }

    public function addParameterPhone($data)
    {
        try {
            // Set parameter phone properties
            $this->PRODUCT_ID = $data->productId;
            $this->SCREEN = $data->screen;
            $this->OPERATING_SYSTEM = $data->operatingSystem;
            $this->BACK_CAMERA = $data->backCamera;
            $this->FRONT_CAMERA = $data->frontCamera;
            $this->CHIP = $data->chip;
            $this->RAM = $data->ram;
            $this->ROM = $data->rom;
            $this->SIM = $data->sim;
            $this->BATTERY_CHARGER = $data->batteryCharger;

            // Add parameter phone to the database
            $query = "INSERT INTO parameter_phone 
                      (PRODUCT_ID, SCREEN, OPERATING_SYSTEM, BACK_CAMERA, FRONT_CAMERA, CHIP, RAM, ROM, SIM, BATTERY_CHARGER) 
                      VALUES 
                      (:PRODUCT_ID, :SCREEN, :OPERATING_SYSTEM, :BACK_CAMERA, :FRONT_CAMERA, :CHIP, :RAM, :ROM, :SIM, :BATTERY_CHARGER)";

            $stmt = $this->conn->prepare($query);

            // Bind parameters
            $stmt->bindParam(':PRODUCT_ID', $this->PRODUCT_ID);
            $stmt->bindParam(':SCREEN', $this->SCREEN);
            $stmt->bindParam(':OPERATING_SYSTEM', $this->OPERATING_SYSTEM);
            $stmt->bindParam(':BACK_CAMERA', $this->BACK_CAMERA);
            $stmt->bindParam(':FRONT_CAMERA', $this->FRONT_CAMERA);
            $stmt->bindParam(':CHIP', $this->CHIP);
            $stmt->bindParam(':RAM', $this->RAM);
            $stmt->bindParam(':ROM', $this->ROM);
            $stmt->bindParam(':SIM', $this->SIM);
            $stmt->bindParam(':BATTERY_CHARGER', $this->BATTERY_CHARGER);

            // Execute the statement
            $stmt->execute();

            return true; // Return true if the parameter phone is added successfully
        } catch (Exception $ex) {
            throw new Exception('Error: ' . $ex->getMessage());
            return false; // Return false if there's an error
        }
    }

    public function updateParameterPhone($id, $parameterPhone)
    {
        try {
            $this->ID = $id;
            $this->PRODUCT_ID = $parameterPhone->productId;
            $this->SCREEN = $parameterPhone->screen;
            $this->OPERATING_SYSTEM = $parameterPhone->operatingSystem;
            $this->BACK_CAMERA = $parameterPhone->backCamera;
            $this->FRONT_CAMERA = $parameterPhone->frontCamera;
            $this->CHIP = $parameterPhone->chip;
            $this->RAM = $parameterPhone->ram;
            $this->ROM = $parameterPhone->rom;
            $this->SIM = $parameterPhone->sim;
            $this->BATTERY_CHARGER = $parameterPhone->batteryCharger;

            $query = "UPDATE parameter_phone
                      SET PRODUCT_ID = :PRODUCT_ID,
                          SCREEN = :SCREEN,
                          OPERATING_SYSTEM = :OPERATING_SYSTEM,
                          BACK_CAMERA = :BACK_CAMERA,
                          FRONT_CAMERA = :FRONT_CAMERA,
                          CHIP = :CHIP,
                          RAM = :RAM,
                          ROM = :ROM,
                          SIM = :SIM,
                          BATTERY_CHARGER = :BATTERY_CHARGER
                      WHERE ID = :ID";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':ID', $this->ID);
            $stmt->bindParam(':PRODUCT_ID', $this->PRODUCT_ID);
            $stmt->bindParam(':SCREEN', $this->SCREEN);
            $stmt->bindParam(':OPERATING_SYSTEM', $this->OPERATING_SYSTEM);
            $stmt->bindParam(':BACK_CAMERA', $this->BACK_CAMERA);
            $stmt->bindParam(':FRONT_CAMERA', $this->FRONT_CAMERA);
            $stmt->bindParam(':CHIP', $this->CHIP);
            $stmt->bindParam(':RAM', $this->RAM);
            $stmt->bindParam(':ROM', $this->ROM);
            $stmt->bindParam(':SIM', $this->SIM);
            $stmt->bindParam(':BATTERY_CHARGER', $this->BATTERY_CHARGER);

            $stmt->execute();

            return true;
        } catch (Exception $ex) {
            throw new Exception('Error: ' . $ex->getMessage());
            return false;
        }
    }

    public function deleteParameterPhone($id)
    {
        try {
            $query = "DELETE FROM parameter_phone WHERE ID = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return true; // Return true if deletion is successful
            } else {
                return false; // Return false if there's an error in deletion
            }
        } catch (Exception $ex) {
            error_log($ex->getMessage());
            return false; // Return false in case of an exception
        }
    }

}

?>
