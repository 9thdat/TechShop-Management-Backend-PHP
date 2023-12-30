<?php
require '../../vendor/autoload.php';

use \Firebase\JWT\JWT;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\Key;

class User
{
    private $conn;
    private $EMAIL;
    private $NAME;
    private $PASSWORD;
    private $PHONE;
    private $GENDER;
    private $BIRTHDAY;
    private $ADDRESS;
    private $WARD;
    private $DISTRICT;
    private $CITY;
    private $IMAGE;
    private $ROLE;
    private $STATUS;

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
    public function getPASSWORD()
    {
        return $this->PASSWORD;
    }

    /**
     * @param mixed $PASSWORD
     */
    public function setPASSWORD($PASSWORD)
    {
        $this->PASSWORD = $PASSWORD;
    }

    /**
     * @return mixed
     */
    public function getPHONE()
    {
        return $this->PHONE;
    }

    /**
     * @param mixed $PHONE
     */
    public function setPHONE($PHONE)
    {
        $this->PHONE = $PHONE;
    }

    /**
     * @return mixed
     */
    public function getGENDER()
    {
        return $this->GENDER;
    }

    /**
     * @param mixed $GENDER
     */
    public function setGENDER($GENDER)
    {
        $this->GENDER = $GENDER;
    }

    /**
     * @return mixed
     */
    public function getBIRTHDAY()
    {
        return $this->BIRTHDAY;
    }

    /**
     * @param mixed $BIRTHDAY
     */
    public function setBIRTHDAY($BIRTHDAY)
    {
        $this->BIRTHDAY = $BIRTHDAY;
    }

    /**
     * @return mixed
     */
    public function getADDRESS()
    {
        return $this->ADDRESS;
    }

    /**
     * @param mixed $ADDRESS
     */
    public function setADDRESS($ADDRESS)
    {
        $this->ADDRESS = $ADDRESS;
    }

    /**
     * @return mixed
     */
    public function getWARD()
    {
        return $this->WARD;
    }

    /**
     * @param mixed $WARD
     */
    public function setWARD($WARD)
    {
        $this->WARD = $WARD;
    }

    /**
     * @return mixed
     */
    public function getDISTRICT()
    {
        return $this->DISTRICT;
    }

    /**
     * @param mixed $DISTRICT
     */
    public function setDISTRICT($DISTRICT)
    {
        $this->DISTRICT = $DISTRICT;
    }

    /**
     * @return mixed
     */
    public function getCITY()
    {
        return $this->CITY;
    }

    /**
     * @param mixed $CITY
     */
    public function setCITY($CITY)
    {
        $this->CITY = $CITY;
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
    public function getEMAIL()
    {
        return $this->EMAIL;
    }

    /**
     * @param mixed $EMAIL
     */
    public function setEMAIL($EMAIL)
    {
        $this->EMAIL = $EMAIL;
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
    public function getROLE()
    {
        return $this->ROLE;
    }

    /**
     * @param mixed $ROLE
     */
    public function setROLE($ROLE)
    {
        $this->ROLE = $ROLE;
    }

    public function getAllUsers()
    {
        $query = "SELECT * FROM User";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function validateUser($credentials)
    {
        if ($credentials == null || empty($credentials['email']) || empty($credentials['password'])) {
            return json_encode(["error" => "Invalid client request"]);
        }

        $email = $credentials['email'];
        $password = $credentials['password'];

        $query = "SELECT * FROM User WHERE Email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $stmt->execute();
        if (!$stmt) {
            die(json_encode(["error" => "Query execution failed."]));
        }
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

//        var_dump($User);
//        die(); // This will stop the execution to see the output

        if (!$user) {
            return json_encode(["error" => "User not found"]);
        }

        // Check if the password is correct
        if ($password !== $user['PASSWORD']) {
            return json_encode(["error" => "Invalid password"]);
        }

        $role = $user['ROLE'];
        $status = $user['STATUS'];
        $token = $this->generateToken($user);

        return json_encode([
            "role" => $role,
            "status" => $status,
            "token" => $token
        ]);
    }


    private function generateToken($user)
    {
        $key = "techshopmanagementby9thdat9thdat";

        $payload = [
            "iat" => time(), // Thời gian token được tạo
            "nbf" => time(), // Token có hiệu lực từ thời điểm nào
            "exp" => time() + (60 * 60 * 24), // Token hết hạn sau 1 ngày
            "data" => [
                "email" => $user['EMAIL'],
                "name" => $user['NAME'],
                "role" => $user['ROLE'],
            ],
        ];

        return JWT::encode($payload, $key, 'HS256'); // Add 'HS256' as the third argument
    }

    public function validateToken($token)
    {
        $key = "techshopmanagementby9thdat9thdat";

        try {
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
            return $decoded;
        } catch (Exception $e) {
            return false;
        }
    }

    public function getStaffs()
    {
        $query = "SELECT * FROM user WHERE ROLE = 'staff'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function IsEmailStaffExist($email)
    {
        $query = "SELECT * FROM user WHERE EMAIL = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Check if the email exists
        if ($stmt->rowCount() > 0) {
            return [
                'status' => 409,
                'message' => 'Email already exists'
            ];
        } else {
            return [
                'status' => 200,
                'message' => 'Email is valid'
            ];
        }
    }

    public function createStaff()
    {
        try {
            // Set user properties
            $this->EMAIL = htmlspecialchars(strip_tags($this->EMAIL));
            $this->NAME = htmlspecialchars(strip_tags($this->NAME));
            $this->PASSWORD = htmlspecialchars(strip_tags($this->PASSWORD));
            $this->PHONE = htmlspecialchars(strip_tags($this->PHONE));
            $this->GENDER = htmlspecialchars(strip_tags($this->GENDER));
            $this->BIRTHDAY = htmlspecialchars(strip_tags($this->BIRTHDAY));
            $this->ADDRESS = htmlspecialchars(strip_tags($this->ADDRESS));
            $this->WARD = htmlspecialchars(strip_tags($this->WARD));
            $this->DISTRICT = htmlspecialchars(strip_tags($this->DISTRICT));
            $this->CITY = htmlspecialchars(strip_tags($this->CITY));
            $this->ROLE = htmlspecialchars(strip_tags($this->ROLE));
            $this->STATUS = htmlspecialchars(strip_tags($this->STATUS));

            // Check if email already exists
            $emailExists = $this->emailExists($this->EMAIL);
            if ($emailExists) {
                return false; // Email already exists
            }

            // Hash the password
            $this->PASSWORD = hash('sha256', $this->PASSWORD);

            // Add user to the database
            $query = "INSERT INTO user 
                      (EMAIL, NAME, PASSWORD, PHONE, GENDER, BIRTHDAY, ADDRESS, WARD, DISTRICT, CITY, ROLE, STATUS) 
                      VALUES 
                      (:EMAIL, :NAME, :PASSWORD, :PHONE, :GENDER, :BIRTHDAY, :ADDRESS, :WARD, :DISTRICT, :CITY, :ROLE, :STATUS)";

            $stmt = $this->conn->prepare($query);

            // Bind parameters
            $stmt->bindParam(':EMAIL', $this->EMAIL);
            $stmt->bindParam(':NAME', $this->NAME);
            $stmt->bindParam(':PASSWORD', $this->PASSWORD);
            $stmt->bindParam(':PHONE', $this->PHONE);
            $stmt->bindParam(':GENDER', $this->GENDER);
            $stmt->bindParam(':BIRTHDAY', $this->BIRTHDAY);
            $stmt->bindParam(':ADDRESS', $this->ADDRESS);
            $stmt->bindParam(':WARD', $this->WARD);
            $stmt->bindParam(':DISTRICT', $this->DISTRICT);
            $stmt->bindParam(':CITY', $this->CITY);
            $stmt->bindParam(':ROLE', $this->ROLE);
            $stmt->bindParam(':STATUS', $this->STATUS);

            // Execute the statement
            if ($stmt->execute()) {
                return true; // User created successfully
            } else {
                return false; // Unable to create user
            }
        } catch (Exception $ex) {
            // Log the exception for debugging purposes
            error_log($ex->getMessage());
            return false; // Return false if there's an error
        }
    }

    // Check if the email already exists
    private function emailExists($email)
    {
        $query = "SELECT * FROM user WHERE EMAIL = :EMAIL";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':EMAIL', $email);
        $stmt->execute();

        return $stmt->rowCount() > 0; // Return true if email exists, false otherwise
    }

    public function updateStaff()
    {
        try {
            // Find the staff by email
            $query = "SELECT * FROM user WHERE EMAIL = :email";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':email', $this->EMAIL);
            $stmt->execute();
            $num = $stmt->rowCount();

            // Check if the staff exists
            if ($num > 0) {
                // Staff exists, proceed to update
                $query = "UPDATE user 
                          SET 
                          NAME = :name,
                          PHONE = :phone,
                          ADDRESS = :address,
                          GENDER = :gender,
                          BIRTHDAY = :birthday,
                          WARD = :ward,
                          DISTRICT = :district,
                          CITY = :city,
                          IMAGE = :image,
                          STATUS = :status
                          WHERE EMAIL = :email";

                $stmt = $this->conn->prepare($query);

                // Bind parameters
                $stmt->bindParam(':name', $this->NAME);
                $stmt->bindParam(':phone', $this->PHONE);
                $stmt->bindParam(':address', $this->ADDRESS);
                $stmt->bindParam(':gender', $this->GENDER);
                $stmt->bindParam(':birthday', $this->BIRTHDAY);
                $stmt->bindParam(':ward', $this->WARD);
                $stmt->bindParam(':district', $this->DISTRICT);
                $stmt->bindParam(':city', $this->CITY);
                $stmt->bindParam(':image', $this->IMAGE);
                $stmt->bindParam(':status', $this->STATUS);
                $stmt->bindParam(':email', $this->EMAIL);

                // Execute the statement
                $stmt->execute();

                return true; // Return true if staff is updated successfully
            } else {
                return false; // Return false if staff is not found
            }
        } catch (Exception $ex) {
            // Log the exception for debugging purposes
            error_log($ex->getMessage());
            return false; // Return false if there's an error
        }
    }

    public function changePassword()
    {
        try {
            // Hash the password
            $this->PASSWORD = hash('sha256', $this->PASSWORD);

            // Update the password in the database
            $query = "UPDATE user SET PASSWORD = :password WHERE EMAIL = :email";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':password', $this->PASSWORD);
            $stmt->bindParam(':email', $this->EMAIL);
            $stmt->execute();

            return true; // Return true if the password is changed successfully
        } catch (Exception $ex) {
            // Log the exception for debugging purposes
            error_log($ex->getMessage());
            return false; // Return false if there's an error
        }
    }
}

?>
