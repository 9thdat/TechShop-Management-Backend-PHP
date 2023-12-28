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
}

?>
