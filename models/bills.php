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
        b.billId,
        b.billName,
        b.billDate,
        b.billPrice,
        b.isLate,
        b.userId
    FROM " . $this->table_name . "b
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
}