<?php
class Subscriptions {
    private $conn;
    private $table_name = "subscriptions";

    public $subId;
    public $dueDate;
    public $amountDue;
    public $userId;
    public $storeId;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table_name . "
            ORDER BY dueDate ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function getById() {
        $query = "SELECT
            s.dueDate,
            s.amountDue,
            s.userId,
            s.storeId
            FROM " . $this->table_name . " s
                WHERE
                    s.subId = ? 
                    LIMIT 0,1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->subId);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->dueDate = $row["dueDate"] ?? null;
        $this->amountDue = $row["amountDue"] ?? null;
        $this->userId = $row["userId"] ?? null;
        $this->storeId = $row["storeId"] ?? null;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
            SET
                dueDate = :dueDate,
                amountDue = :amountDue,
                userId = :userId,
                storeId = :storeId";
        
        $stmt = $this->conn->prepare($query);

        // Clean Data
        $this->dueDate = htmlspecialchars(strip_tags($this->dueDate));
        $this->amountDue = htmlspecialchars(strip_tags($this->amountDue));
        $this->userId = htmlspecialchars(strip_tags($this->userId));
        $this->storeId = htmlspecialchars(strip_tags($this->storeId));

        // Bind data
        $stmt->bindParam(":dueDate", $this->dueDate);
        $stmt->bindParam(":amountDue", $this->amountDue);
        $stmt->bindParam(":userId", $this->userId);
        $stmt->bindParam(":storeId", $this->storeId);

        if($stmt->execute())
            return true;
        
        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . "
            SET
                dueDate = :dueDate,
                amountDue = :amountDue,
                userId = :userId,
                storeId = :storeId
            WHERE
                subId = " . $this->subId;
        
        $stmt = $this->conn->prepare($query);

        // Clean Data
        $this->dueDate = htmlspecialchars(strip_tags($this->dueDate));
        $this->amountDue = htmlspecialchars(strip_tags($this->amountDue));
        $this->userId = htmlspecialchars(strip_tags($this->userId));
        $this->storeId = htmlspecialchars(strip_tags($this->storeId));

        // Bind data
        $stmt->bindParam(":dueDate", $this->dueDate);
        $stmt->bindParam(":amountDue", $this->amountDue);
        $stmt->bindParam(":userId", $this->userId);
        $stmt->bindParam(":storeId", $this->storeId);

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