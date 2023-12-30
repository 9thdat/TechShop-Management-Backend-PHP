<?php

class Order
{
    private $conn;
    private $ID;
    private $CUSTOMER_EMAIL;
    private $NAME;
    private $ADDRESS;
    private $WARD;
    private $DISTRICT;
    private $CITY;
    private $PHONE;
    private $DISCOUNT_ID;
    private $SHIPPING_FEE;
    private $TOTAL_PRICE;
    private $NOTE;
    private $ORDER_DATE;
    private $CANCELED_DATE;
    private $COMPLETED_DATE;
    private $DELIVERY_TYPE;
    private $PAYMENT_TYPE;
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
    public function getCUSTOMER_EMAIL()
    {
        return $this->CUSTOMER_EMAIL;
    }

    /**
     * @param mixed $CUSTOMER_EMAIL
     */
    public function setCUSTOMER_EMAIL($CUSTOMER_EMAIL)
    {
        $this->CUSTOMER_EMAIL = $CUSTOMER_EMAIL;
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
    public function getDISCOUNT_ID()
    {
        return $this->DISCOUNT_ID;
    }

    /**
     * @param mixed $DISCOUNT_ID
     */
    public function setDISCOUNT_ID($DISCOUNT_ID)
    {
        $this->DISCOUNT_ID = $DISCOUNT_ID;
    }

    /**
     * @return mixed
     */
    public function getSHIPPING_FEE()
    {
        return $this->SHIPPING_FEE;
    }

    /**
     * @param mixed $SHIPPING_FEE
     */
    public function setSHIPPING_FEE($SHIPPING_FEE)
    {
        $this->SHIPPING_FEE = $SHIPPING_FEE;
    }

    /**
     * @return mixed
     */
    public function getTOTAL_PRICE()
    {
        return $this->TOTAL_PRICE;
    }

    /**
     * @param mixed $TOTAL_PRICE
     */
    public function setTOTAL_PRICE($TOTAL_PRICE)
    {
        $this->TOTAL_PRICE = $TOTAL_PRICE;
    }

    /**
     * @return mixed
     */
    public function getNOTE()
    {
        return $this->NOTE;
    }

    /**
     * @param mixed $NOTE
     */
    public function setNOTE($NOTE)
    {
        $this->NOTE = $NOTE;
    }

    /**
     * @return mixed
     */
    public function getORDER_DATE()
    {
        return $this->ORDER_DATE;
    }

    /**
     * @param mixed $ORDER_DATE
     */
    public function setORDER_DATE($ORDER_DATE)
    {
        $this->ORDER_DATE = $ORDER_DATE;
    }

    /**
     * @return mixed
     */
    public function getCANCELED_DATE()
    {
        return $this->CANCELED_DATE;
    }

    /**
     * @param mixed $CANCELED_DATE
     */
    public function setCANCELED_DATE($CANCELED_DATE)
    {
        $this->CANCELED_DATE = $CANCELED_DATE;
    }

    /**
     * @return mixed
     */
    public function getCOMPLETED_DATE()
    {
        return $this->COMPLETED_DATE;
    }

    /**
     * @param mixed $COMPLETED_DATE
     */
    public function setCOMPLETED_DATE($COMPLETED_DATE)
    {
        $this->COMPLETED_DATE = $COMPLETED_DATE;
    }

    /**
     * @return mixed
     */
    public function getDELIVERY_TYPE()
    {
        return $this->DELIVERY_TYPE;
    }

    /**
     * @param mixed $DELIVERY_TYPE
     */
    public function setDELIVERY_TYPE($DELIVERY_TYPE)
    {
        $this->DELIVERY_TYPE = $DELIVERY_TYPE;
    }

    /**
     * @return mixed
     */
    public function getPAYMENT_TYPE()
    {
        return $this->PAYMENT_TYPE;
    }

    /**
     * @param mixed $PAYMENT_TYPE
     */
    public function setPAYMENT_TYPE($PAYMENT_TYPE)
    {
        $this->PAYMENT_TYPE = $PAYMENT_TYPE;
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

    public function getAllOrders()
    {
        $query = "SELECT * FROM orders";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderById($id)
    {
        $query = "SELECT * FROM orders WHERE ID = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return [
                'status' => 200,
                'data' => $stmt->fetch(PDO::FETCH_ASSOC),
            ];
        } else {
            return [
                'status' => 404,
                'message' => 'Order not found',
            ];
        }
    }

    public function getProcessingOrdersCount()
    {
        $query = "SELECT COUNT(*) as processingCount FROM orders WHERE status = 'processing'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['processingCount'];
    }

    public function getTodayCompletedCount()
    {
        $today = new DateTime('today');
        $completedStatus = 'Done';

        $query = "SELECT COUNT(*) as completedCount FROM orders WHERE STATUS = :status AND COMPLETED_DATE IS NOT NULL AND COMPLETED_DATE = CURRENT_DATE";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $completedStatus, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['completedCount'];
        } else {
            return 0;
        }
    }


    public function getRevenueToday()
    {
        try {
            $query = "SELECT COALESCE(SUM(total_price), 0) as revenueToday
                      FROM orders
                      WHERE completed_date IS NOT NULL
                        AND completed_date = CURRENT_DATE";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['revenueToday'];
        } catch (PDOException $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    public function getRevenueThisMonth()
    {
        $currentMonth = date('m');
        $query = "SELECT SUM(total_price) as revenueThisMonth FROM orders WHERE MONTH(completed_date) = :currentMonth";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':currentMonth', $currentMonth, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['revenueThisMonth'];
    }

    public function getRevenueEachDayThisMonth()
    {
        $currentMonth = date('m');
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));

        $revenueEachDayThisMonth = array_fill(0, $daysInMonth, 0);

        $query = "SELECT DAY(completed_date) as day, SUM(total_price) as revenue
                  FROM orders
                  WHERE MONTH(completed_date) = :currentMonth
                  GROUP BY DAY(completed_date)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':currentMonth', $currentMonth, PDO::PARAM_INT);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $day = (int)$row['day'] - 1;
            $revenueEachDayThisMonth[$day] = (double)$row['revenue'];
        }

        $result = array_map(function ($revenue, $day) {
            return ['day' => $day + 1, 'revenue' => $revenue];
        }, $revenueEachDayThisMonth, range(0, $daysInMonth - 1));

        return $result;
    }

    public function getLastOrderId()
    {
        $query = "SELECT Id FROM orders ORDER BY Id DESC LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        // Check if any rows were returned
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['Id'];
        }

        return null;
    }

    public function getMonthlyRevenue($startMonth, $startYear, $endMonth, $endYear)
    {
        // Calculate the last day of the month
        $lastDayOfMonth = date('t', strtotime("$endYear-$endMonth-01"));
        $endDate = new DateTimeImmutable("$endYear-$endMonth-$lastDayOfMonth");

        $query = "SELECT DATE_FORMAT(completed_date, '%Y-%m-%d') as Date, SUM(total_price) as Revenue
                  FROM orders
                  WHERE completed_date BETWEEN :startDate AND :endDate
                  GROUP BY Date";

        $startDate = new DateTimeImmutable("$startYear-$startMonth-01");

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':startDate', $startDate->format('Y-m-d'));
        $stmt->bindParam(':endDate', $endDate->format('Y-m-d'));
        $stmt->execute();

        $monthlyRevenue = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $monthlyRevenue;
    }

    public function getMonthlyRevenueByProduct($startMonth, $startYear, $endMonth, $endYear, $productId)
    {
        $startDate = "{$startYear}-{$startMonth}-01";
        $endDate = date('Y-m-t', strtotime("{$endYear}-{$endMonth}-01"));

        $query = "SELECT DATE(o.completed_date) AS Date, SUM(od.quantity * od.price) AS Revenue
              FROM order_detail od
              JOIN orders o ON od.order_id = o.id
              WHERE o.completed_date >= :startDate
                    AND o.completed_date <= :endDate
                    AND (:productId IS NULL OR od.product_id = :productId)
              GROUP BY Date
              ORDER BY Date";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':startDate', $startDate, PDO::PARAM_STR);
        $stmt->bindParam(':endDate', $endDate, PDO::PARAM_STR);
        $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMonthlyProductsSold($startMonth, $startYear, $endMonth, $endYear, $productId)
    {
        $startDate = "{$startYear}-{$startMonth}-01";
        $endDate = date('Y-m-t', strtotime("{$endYear}-{$endMonth}-01"));

        $query = "SELECT DATE(o.completed_date) as Date, SUM(od.quantity) as ProductsSold
              FROM order_detail od
              JOIN orders o ON od.order_id = o.id
              WHERE o.completed_date BETWEEN :startDate AND :endDate
                AND (:productId IS NULL OR od.product_id = :productId)
              GROUP BY DATE(o.completed_date)
              ORDER BY Date";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':startDate', $startDate, PDO::PARAM_STR);
        $stmt->bindParam(':endDate', $endDate, PDO::PARAM_STR);
        $stmt->bindParam(':productId', $productId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addOrder($order)
    {
        try {
            // Set order properties
            $this->ID = $order->id;
            $this->CUSTOMER_EMAIL = $order->customerEmail;
            $this->NAME = $order->name;
            $this->ADDRESS = $order->address;
            $this->WARD = $order->ward;
            $this->DISTRICT = $order->district;
            $this->CITY = $order->city;
            $this->PHONE = $order->phone;
            $this->DISCOUNT_ID = $order->discountId;
            $this->SHIPPING_FEE = $order->shippingFee;
            $this->TOTAL_PRICE = $order->totalPrice;
            $this->NOTE = $order->note;
            $this->ORDER_DATE = $order->orderDate;
            $this->CANCELED_DATE = $order->canceledDate;
            $this->COMPLETED_DATE = $order->completedDate;
            $this->DELIVERY_TYPE = $order->deliveryType;
            $this->PAYMENT_TYPE = $order->paymentType;
            $this->STATUS = $order->status;

            // Update discount quantity if applicable
            if ($this->DISCOUNT_ID !== null) {
                $query = "UPDATE discount SET QUANTITY = QUANTITY - 1 WHERE ID = :discountId";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':discountId', $this->DISCOUNT_ID);
                $stmt->execute();
            }

            // Add order to the database
            $query = "INSERT INTO orders 
                      (ID, CUSTOMER_EMAIL, NAME, ADDRESS, WARD, DISTRICT, CITY, PHONE, DISCOUNT_ID, SHIPPING_FEE, TOTAL_PRICE, 
                      NOTE, ORDER_DATE, CANCELED_DATE, COMPLETED_DATE, DELIVERY_TYPE, PAYMENT_TYPE, STATUS) 
                      VALUES 
                      (:ID, :CUSTOMER_EMAIL, :NAME, :ADDRESS, :WARD, :DISTRICT, :CITY, :PHONE, :DISCOUNT_ID, :SHIPPING_FEE, :TOTAL_PRICE, 
                      :NOTE, :ORDER_DATE, :CANCELED_DATE, :COMPLETED_DATE, :DELIVERY_TYPE, :PAYMENT_TYPE, :STATUS)";

            $stmt = $this->conn->prepare($query);

            // Bind parameters
            $stmt->bindParam(':ID', $this->ID);
            $stmt->bindParam(':CUSTOMER_EMAIL', $this->CUSTOMER_EMAIL);
            $stmt->bindParam(':NAME', $this->NAME);
            $stmt->bindParam(':ADDRESS', $this->ADDRESS);
            $stmt->bindParam(':WARD', $this->WARD);
            $stmt->bindParam(':DISTRICT', $this->DISTRICT);
            $stmt->bindParam(':CITY', $this->CITY);
            $stmt->bindParam(':PHONE', $this->PHONE);
            $stmt->bindParam(':DISCOUNT_ID', $this->DISCOUNT_ID);
            $stmt->bindParam(':SHIPPING_FEE', $this->SHIPPING_FEE);
            $stmt->bindParam(':TOTAL_PRICE', $this->TOTAL_PRICE);
            $stmt->bindParam(':NOTE', $this->NOTE);
            $stmt->bindParam(':ORDER_DATE', $this->ORDER_DATE);
            $stmt->bindParam(':CANCELED_DATE', $this->CANCELED_DATE);
            $stmt->bindParam(':COMPLETED_DATE', $this->COMPLETED_DATE);
            $stmt->bindParam(':DELIVERY_TYPE', $this->DELIVERY_TYPE);
            $stmt->bindParam(':PAYMENT_TYPE', $this->PAYMENT_TYPE);
            $stmt->bindParam(':STATUS', $this->STATUS);

            // Execute the statement
            $stmt->execute();

            return true; // Return true if the order is added successfully
        } catch (Exception $ex) {
            throw new Exception('Error: ' . $ex->getMessage());
            return false; // Return false if there's an error
        }
    }

    public function changeStatus($id, $status)
    {
        try {
            // Find the order in the database
            $query = "SELECT * FROM orders WHERE ID = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $orderInDb = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$orderInDb) {
                return false; // Order not found
            }

            // Update the status and relevant dates
            $query = "UPDATE orders 
                      SET STATUS = :status, 
                          COMPLETED_DATE = CASE WHEN :status = 'Done' THEN :completedDate ELSE COMPLETED_DATE END,
                          CANCELED_DATE = CASE WHEN :status = 'Cancelled' THEN :canceledDate ELSE CANCELED_DATE END
                      WHERE ID = :id";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':completedDate', date('Y-m-d'));
            $stmt->bindParam(':canceledDate', date('Y-m-d'));
            $stmt->execute();

            return true; // Status changed successfully
        } catch (Exception $ex) {
            // Log the exception for debugging purposes
            error_log($ex->getMessage());
            return false; // Return false if there's an error
        }
    }
}

?>
