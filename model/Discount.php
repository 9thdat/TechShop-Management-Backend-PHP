<?php

class Discount
{
    private $conn;
    private $ID;
    private $CODE;
    private $TYPE;
    private $VALUE;
    private $DESCRIPTION;
    private $START_DATE;
    private $END_DATE;
    private $MIN_APPLY;
    private $MAX_SPEED;
    private $QUANTITY;
    private $STATUS;
    private $CREATED_AT;
    private $UPDATED_AT;
    private $DISABLED_AT;

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
    public function getCODE()
    {
        return $this->CODE;
    }

    /**
     * @param mixed $CODE
     */
    public function setCODE($CODE)
    {
        $this->CODE = $CODE;
    }

    /**
     * @return mixed
     */
    public function getTYPE()
    {
        return $this->TYPE;
    }

    /**
     * @param mixed $TYPE
     */
    public function setTYPE($TYPE)
    {
        $this->TYPE = $TYPE;
    }

    /**
     * @return mixed
     */
    public function getVALUE()
    {
        return $this->VALUE;
    }

    /**
     * @param mixed $VALUE
     */
    public function setVALUE($VALUE)
    {
        $this->VALUE = $VALUE;
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
    public function getSTART_DATE()
    {
        return $this->START_DATE;
    }

    /**
     * @param mixed $START_DATE
     */
    public function setSTART_DATE($START_DATE)
    {
        $this->START_DATE = $START_DATE;
    }

    /**
     * @return mixed
     */
    public function getEND_DATE()
    {
        return $this->END_DATE;
    }

    /**
     * @param mixed $END_DATE
     */
    public function setEND_DATE($END_DATE)
    {
        $this->END_DATE = $END_DATE;
    }

    /**
     * @return mixed
     */
    public function getMIN_APPLY()
    {
        return $this->MIN_APPLY;
    }

    /**
     * @param mixed $MIN_APPLY
     */
    public function setMIN_APPLY($MIN_APPLY)
    {
        $this->MIN_APPLY = $MIN_APPLY;
    }

    /**
     * @return mixed
     */
    public function getMAX_SPEED()
    {
        return $this->MAX_SPEED;
    }

    /**
     * @param mixed $MAX_SPEED
     */
    public function setMAX_SPEED($MAX_SPEED)
    {
        $this->MAX_SPEED = $MAX_SPEED;
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
    public function getSTATUS()
    {
        return $this->STATUS;
    }

    /**
     * @param mixed $STATUS
     */
    public function setSTATUS($STATUS)
    {
        $this->STATUS = $STATUS;
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

    /**
     * @return mixed
     */
    public function getDISABLED_AT()
    {
        return $this->DISABLED_AT;
    }

    /**
     * @param mixed $DISABLED_AT
     */
    public function setDISABLED_AT($DISABLED_AT)
    {
        $this->DISABLED_AT = $DISABLED_AT;
    }

    public function getAllDiscounts()
    {
        $query = "SELECT * FROM Discount";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function getDiscountById($id)
    {
        $query = 'SELECT * FROM Discount WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt;
    }

    public function getDiscountByCode($code)
    {
        $query = "SELECT * FROM Discount WHERE CODE = :code";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':code', $code);
        $stmt->execute();

        // Check if the Discount with the given code exists
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return [];
        }
    }

    public function getLastId()
    {
        $query = "SELECT id FROM Discount ORDER BY id DESC LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        // Check if there are rows
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['id'];
        } else {
            return null;
        }
    }

    public function createDiscount($data)
    {
        $query = "INSERT INTO Discount (CODE, TYPE, VALUE, DESCRIPTION, START_DATE, END_DATE, MIN_APPLY, MAX_SPEED, QUANTITY, STATUS, CREATED_AT, UPDATED_AT, DISABLED_AT) VALUES (:code, :type, :value, :description, :start_date, :end_date, :min_apply, :max_speed, :quantity, :status, :created_at,:updated_at, :disabled_at)";

        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':code', $data->code);
        $stmt->bindParam(':type', $data->type);
        $stmt->bindParam(':value', $data->value);
        $stmt->bindParam(':description', $data->description);
        $stmt->bindParam(':start_date', $data->startDate);
        $stmt->bindParam(':end_date', $data->endDate);
        $stmt->bindParam(':min_apply', $data->minApply);
        $stmt->bindParam(':max_speed', $data->maxSpeed);
        $stmt->bindParam(':quantity', $data->quantity);
        $stmt->bindParam(':status', $data->status);
        $stmt->bindParam(':created_at', $data->createdAt);
        $stmt->bindParam(':updated_at', $data->updatedAt);
        $stmt->bindParam(':disabled_at', $data->disabledAt);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateDiscount($data)
    {
        try {
            $currentDate = date('Y-m-d H:i:s');

            // Check if the Discount is existed

            $query = "UPDATE Discount SET 
                  code = :code,
                  type = :type,
                  value = :value,
                  description = :description,
                  start_date = :start_date,
                  end_date = :end_date,
                  min_apply = :min_apply,
                  max_speed = :max_speed,
                  quantity = :quantity,
                  status = :status,
                  updated_at = :updated_at,
                  disabled_at = :disabled_at
                  WHERE id = :id";

            $stmt = $this->conn->prepare($query);

            if ($data['status'] != "inactive") {
                if ($data['endDate'] <= $currentDate) {
                    $data['status'] = "expired";
                    $data['disableAt'] = $data['endDate'];
                } else {
                    $data['status'] = "active";
                }
            }

            $stmt->bindParam(':id', $data['id']);
            $stmt->bindParam(':code', $data['code']);
            $stmt->bindParam(':type', $data['type']);
            $stmt->bindParam(':value', $data['value']);
            $stmt->bindParam(':description', $data['description']);
            $stmt->bindParam(':start_date', $data['startDate']);
            $stmt->bindParam(':end_date', $data['endDate']);
            $stmt->bindParam(':min_apply', $data['minApply']);
            $stmt->bindParam(':max_speed', $data['maxSpeed']);
            $stmt->bindParam(':quantity', $data['quantity']);
            $stmt->bindParam(':status', $data['status']);
            $stmt->bindParam(':updated_at', $currentDate);
            $stmt->bindParam(':disabled_at', $data['endDate']);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }
}

?>
