<?php
class db {
    private $servername = "9thdat.mysql.database.azure.com";
    private $username = "dat";
    private $password = "techshopuit@2003";
    private $db = "techshop";
    private $conn;

    public function connect() {
        $this->conn = null;
        try {
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::MYSQL_ATTR_SSL_CA       => '/path/to/BaltimoreCyberTrustRoot.crt.pem',
                PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
            ];

            $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->db", $this->username, $this->password, $options);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//            echo "Kết nối thành công! \n";
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        return $this->conn;
    }
}
?>
