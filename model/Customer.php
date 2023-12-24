<?php

class Customer
{
    private $conn;
    private $EMAIL;
    private $Name;
    private $Password;
    private $Phone;
    private $Gender;
    private $Birthday;
    private $Address;
    private $Ward;
    private $District;
    private $City;
    private $Image;
    private $Status;
    private $ResetTokenHash;
    private $ResetTokenExpiresAt;

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
        return $this->Email;
    }

    /**
     * @param mixed $Email
     */
    public function setEmail($Email)
    {
        $this->Email = $Email;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->Name;
    }

    /**
     * @param mixed $Name
     */
    public function setName($Name)
    {
        $this->Name = $Name;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->Password;
    }

    /**
     * @param mixed $Password
     */
    public function setPassword($Password)
    {
        $this->Password = $Password;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->Phone;
    }

    /**
     * @param mixed $Phone
     */
    public function setPhone($Phone)
    {
        $this->Phone = $Phone;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->Gender;
    }

    /**
     * @param mixed $Gender
     */
    public function setGender($Gender)
    {
        $this->Gender = $Gender;
    }

    /**
     * @return mixed
     */
    public function getBirthday()
    {
        return $this->Birthday;
    }

    /**
     * @param mixed $Birthday
     */
    public function setBirthday($Birthday)
    {
        $this->Birthday = $Birthday;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->Address;
    }

    /**
     * @param mixed $Address
     */
    public function setAddress($Address)
    {
        $this->Address = $Address;
    }

    /**
     * @return mixed
     */
    public function getWard()
    {
        return $this->Ward;
    }

    /**
     * @param mixed $Ward
     */
    public function setWard($Ward)
    {
        $this->Ward = $Ward;
    }

    /**
     * @return mixed
     */
    public function getDistrict()
    {
        return $this->District;
    }

    /**
     * @param mixed $District
     */
    public function setDistrict($District)
    {
        $this->District = $District;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->City;
    }

    /**
     * @param mixed $City
     */
    public function setCity($City)
    {
        $this->City = $City;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->Image;
    }

    /**
     * @param mixed $Image
     */
    public function setImage($Image)
    {
        $this->Image = $Image;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->Status;
    }

    /**
     * @param mixed $Status
     */
    public function setStatus($Status)
    {
        $this->Status = $Status;
    }

    /**
     * @return mixed
     */
    public function getResetTokenHash()
    {
        return $this->ResetTokenHash;
    }

    /**
     * @param mixed $ResetTokenHash
     */
    public function setResetTokenHash($ResetTokenHash)
    {
        $this->ResetTokenHash = $ResetTokenHash;
    }

    /**
     * @return mixed
     */
    public function getResetTokenExpiresAt()
    {
        return $this->ResetTokenExpiresAt;
    }

    /**
     * @param mixed $ResetTokenExpiresAt
     */
    public function setResetTokenExpiresAt($ResetTokenExpiresAt)
    {
        $this->ResetTokenExpiresAt = $ResetTokenExpiresAt;
    }

    public function getAllCustomer()
    {
        $query = "SELECT * FROM customer";

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            // Log or print the error
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function createCustomer($customer)
    {
        $existingCustomer = $this->getCustomerByEmail($customer['Email']);

        if ($existingCustomer == null) {
            // Email is unique, proceed to create the customer
            // Hash the password using SHA-256 (replace "hashPassword" with your actual hashing method)
            $customer['Password'] = hashPassword($customer['Password']);

            $query = "INSERT INTO customer (Email, Name, Password, Phone, Gender, Birthday, Address, Ward, District, City, Image, Status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ssssssssssss", $customer['Email'], $customer['Name'], $customer['Password'], $customer['Phone'], $customer['Gender'], $customer['Birthday'], $customer['Address'], $customer['Ward'], $customer['District'], $customer['City'], $customer['Image'], $customer['Status']);
            $stmt->execute();

            // Return a JSON response with status 201 (Created)
            return array("status" => "201");
        } else {
            // Email already exists, return a response indicating the conflict
            return array("status" => "409", "message" => "Email already exists");
        }
    }

    public function getCustomerByEmail($email)
    {
        $query = "SELECT * FROM customer WHERE Email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    public function updateCustomer($email, $customer)
    {
        $existingCustomer = $this->getCustomerByEmail($email);

        if ($existingCustomer != null) {
            // Email exists, proceed to update the customer
            $query = "UPDATE customer SET Name = ?, Phone = ?, Gender = ?, Birthday = ?, Address = ?, Ward = ?, District = ?, City = ?, Image = ?, Status = ? WHERE Email = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("sssssssssss", $customer['Name'], $customer['Phone'], $customer['Gender'], $customer['Birthday'], $customer['Address'], $customer['Ward'], $customer['District'], $customer['City'], $customer['Image'], $customer['Status'], $email);
            $stmt->execute();

            return array("status" => "204");
        } else {
            // Customer with the given email does not exist
            return array("status" => "404", "message" => "Customer not found");
        }
    }

    public function changeCurrentStatus($email)
    {
        $existingCustomer = $this->getCustomerByEmail($email);

        if ($existingCustomer != null) {
            // Email exists, proceed to change the status
            $newStatus = ($existingCustomer['Status'] == "active") ? "inactive" : "active";

            $query = "UPDATE customer SET Status = ? WHERE Email = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ss", $newStatus, $email);
            $stmt->execute();

            return array("status" => "204");
        } else {
            // Customer with the given email does not exist
            return array("status" => "404", "message" => "Customer not found");
        }
    }
}

?>
