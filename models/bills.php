<?php
class Bills {
    private $conn;
    private $table_name = "bills";

    // Properties
    public $billId;
    public $billName;
    public $billDate;
    public $billPrice;
    public $isLate;
    public $userId;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table_name . "
            ORDER BY billName ASC";
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Execute statement
        $stmt->execute();

        return $stmt;
    }

    public function getById() {
        $query = "SELECT 
        b.billName,
        b.billDate,
        b.billPrice,
        b.isLate,
        b.userId
        FROM " . $this->table_name . " b
            WHERE
                b.billId = ?
                LIMIT 0,1";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->billId);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->billName = $row["billName"] ?? null;
        $this->billPrice = $row["billPrice"] ?? null;
        $this->billDate = $row["billDate"] ?? null;
        $this->isLate = $row["isLate"] ?? null;
        $this->userId = $row["userId"] ?? null;
    }

    public function create() {
        $query = 'INSERT INTO ' . $this->table_name . '
            SET
                billName = :billName,
                billPrice = :billPrice,
                billDate = :billDate,
                isLate = :isLate,
                userId = :userId';
            
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->billName = htmlspecialchars(strip_tags($this->billName));
        $this->billPrice = htmlspecialchars(strip_tags($this->billPrice));
        $this->billDate = htmlspecialchars(strip_tags($this->billDate));
        $this->isLate = htmlspecialchars(strip_tags($this->isLate));
        $this->userId = htmlspecialchars(strip_tags($this->userId));

        $stmt->bindParam(':billName', $this->billName);
        $stmt->bindParam(':billPrice', $this->billPrice);
        $stmt->bindParam(':billDate', $this->billDate);
        $stmt->bindParam(':isLate', $this->isLate);
        $stmt->bindParam(':userId', $this->userId);

        if($stmt->execute())
            return true;
        
        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . "
            SET
                billName = :billName,
                billPrice = :billPrice,
                billDate = :billDate,
                isLate = :isLate,
                userId = :userId
            WHERE
                billId= :billId";
        
                $stmt = $this->conn->prepare($query);

                // Clean data
                $this->billId = htmlspecialchars(strip_tags($this->billId));
                $this->billName = htmlspecialchars(strip_tags($this->billName));
                $this->billPrice = htmlspecialchars(strip_tags($this->billPrice));
                $this->billDate = htmlspecialchars(strip_tags($this->billDate));
                $this->isLate = htmlspecialchars(strip_tags($this->isLate));
                $this->userId = htmlspecialchars(strip_tags($this->userId));

                // Bind data
                $stmt->bindParam(':billId', $this->billId);
                $stmt->bindParam(':billName', $this->billName);
                $stmt->bindParam(':billPrice', $this->billPrice);
                $stmt->bindParam(':billDate', $this->billDate);
                $stmt->bindParam(':isLate', $this->isLate);
                $stmt->bindParam(':userId', $this->userId);
        
                if($stmt->execute())
                    return true;
                
                return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE billId = :billId";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":billId", $this->billId);

        if($stmt->execute())
            return true;

        return false;
    }
}