<?php

class Customer
{
    private $conn;
    private $email;
    private $name;
    private $password;
    private $phone;
    private $gender;
    private $birthday;
    private $address;
    private $ward;
    private $district;
    private $city;
    private $image;
    private $status;

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
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param mixed $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return mixed
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @param mixed $birthday
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getWard()
    {
        return $this->ward;
    }

    /**
     * @param mixed $ward
     */
    public function setWard($ward)
    {
        $this->ward = $ward;
    }

    /**
     * @return mixed
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * @param mixed $district
     */
    public function setDistrict($district)
    {
        $this->district = $district;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }


    public function GetAllCustomers()
    {
        $query = "SELECT * FROM Customer";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function GetCustomerByEmail($email)
    {
        $query = "SELECT * FROM Customer WHERE EMAIL = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt;
    }

    public function createCustomer()
    {
        // Hash the password using SHA-256 (replace "hash" with your actual hashing method)
        $this->setPassword(hash('sha256', $this->getPassword()));

        $email = $this->getEmail();
        $name = $this->getName();
        $password = $this->getPassword();
        $phone = $this->getPhone();
        $gender = $this->getGender();
        $birthday = $this->getBirthday();
        $address = $this->getAddress();
        $ward = $this->getWard();
        $district = $this->getDistrict();
        $city = $this->getCity();
        $image = base64_decode($this->getImage());
        $status = $this->getStatus();

        try {
            $query = "SELECT * FROM Customer WHERE EMAIL = :email";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            $existingCustomer = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$existingCustomer) {
                // Insert Customer data into the database
                $query = "INSERT INTO Customer (EMAIL, NAME, PASSWORD, PHONE, GENDER, BIRTHDAY, ADDRESS, WARD, DISTRICT, CITY, IMAGE, STATUS) 
                          VALUES (:email, :name, :password, :phone, :gender, :birthday, :address, :ward, :district, :city, :image, :status)";

                $stmt = $this->conn->prepare($query);

                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':phone', $phone);
                $stmt->bindParam(':gender', $gender);
                $stmt->bindParam(':birthday', $birthday);
                $stmt->bindParam(':address', $address);
                $stmt->bindParam(':ward', $ward);
                $stmt->bindParam(':district', $district);
                $stmt->bindParam(':city', $city);
                $stmt->bindParam(':image', $image);
                $stmt->bindParam(':status', $status);

                $stmt->execute();

                // Return a JWT token on successful creation
                return [
                    'status' => 201,
                    'email' => $this->getEmail(),
                ];
            } else {
                // Email already exists, return false
                return [
                    'status' => 409,
                    'message' => 'Email already exists',
                ];
            }
        } catch (Exception $e) {
            // Handle exceptions, log errors, or return false as needed
            return [
                'status' => 500,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function getTop5Customers()
    {
        $currentMonth = date('m');
        $query = "SELECT c.email as customerEmail, c.name, c.image, c.phone, SUM(o.total_price) as revenue
                  FROM orders o
                  JOIN Customer c ON o.customer_email = c.email
                  WHERE MONTH(o.completed_date) = :currentMonth
                  GROUP BY o.customer_email
                  ORDER BY revenue DESC
                  LIMIT 5";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':currentMonth', $currentMonth, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function changeStatus($email)
    {
        $query = "UPDATE Customer SET status = CASE WHEN status = 'active' THEN 'inactive' ELSE 'active' END WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        return $stmt->execute();
    }
}

?>
