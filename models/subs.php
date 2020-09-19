<?php
class Subscriptions {
    private $conn;
    private $table_name = "subscriptions";

    public $subId;
    public $companyName;
    public $dueDate;
    public $amountDue;
    public $userId;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table_name . "
            ORDER BY companyName ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function getById() {
        $query = "SELECT
            s.companyName,
            s.dueDate,
            s.amountDue,
            s.userId
            FROM " . $this->table_name . " s
                WHERE
                    s.subId = ? 
                    LIMIT 0,1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->subId);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->companyName = $row["companyName"] ?? null;
        $this->dueDate = $row["dueDate"] ?? null;
        $this->amountDue = $row["amountDue"] ?? null;
        $this->userId = $row["userId"] ?? null;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
            SET
                companyName = :companyName,
                dueDate = :dueDate,
                amountDue = :amountDue,
                userId = :userId";
        
        $stmt = $this->conn->prepare($query);

        // Clean Data
        $this->companyName = htmlspecialchars(strip_tags($this->companyName));
        $this->dueDate = htmlspecialchars(strip_tags($this->dueDate));
        $this->amountDue = htmlspecialchars(strip_tags($this->amountDue));
        $this->userId = htmlspecialchars(strip_tags($this->userId));

        // Bind data
        $stmt->bindParam(":companyName", $this->companyName);
        $stmt->bindParam(":dueDate", $this->dueDate);
        $stmt->bindParam(":amountDue", $this->amountDue);
        $stmt->bindParam(":userId", $this->userId);

        if($stmt->execute())
            return true;
        
        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . "
            SET
                companyName = :companyName,
                dueDate = :dueDate,
                amountDue = :amountDue,
                userId = :userId
            WHERE
                subId = " . $this->subId;
        
        $stmt = $this->conn->prepare($query);

        // Clean Data
        $this->companyName = htmlspecialchars(strip_tags($this->companyName));
        $this->dueDate = htmlspecialchars(strip_tags($this->dueDate));
        $this->amountDue = htmlspecialchars(strip_tags($this->amountDue));
        $this->userId = htmlspecialchars(strip_tags($this->userId));

        // Bind data
        $stmt->bindParam(":companyName", $this->companyName);
        $stmt->bindParam(":dueDate", $this->dueDate);
        $stmt->bindParam(":amountDue", $this->amountDue);
        $stmt->bindParam(":userId", $this->userId);

        if($stmt->execute())
            return true;
        
        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE subId = " . $this->subId;

        $stmt = $this->conn->prepare($query);

        if($stmt->execute())
            return true;

        return false;
    }
}