<?php
class Misc {
    private $conn;
    private $table_name = "misc";
    private $select_all = "SELECT * FROM ";
    private $order_by = " ORDER BY date ASC";

    public $miscId;
    public $price;
    public $date;
    public $storeId;
    public $userId;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll() {
        // Referes to private properites ^
        $stmt = $this->conn->prepare($this->select_all . $this->table_name . $this->order_by);

        $stmt->execute();

        return $stmt;
    }

    public function getbyId() {
        $query = $this->select_all . $this->table_name . " WHERE miscId = " . $this->miscId;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->price = $row["price"] ?? null;
        $this->date = $row["date"] ?? null;
        $this->storeId = $row["storeId"] ?? null;
        $this->userId = $row["userId"] ?? null;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
            SET
                price = :price,
                date = :date,
                userId = :userId,
                storeId = :storeId";

        $stmt = $this->conn->prepare($query);

        // Clean Data
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->date = htmlspecialchars(strip_tags($this->date));
        $this->userId = htmlspecialchars(strip_tags($this->userId));
        $this->storeId = htmlspecialchars(strip_tags($this->storeId));

        // Bind Data
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":date", $this->date);
        $stmt->bindParam(":userId", $this->userId);
        $stmt->bindParam(":storeId", $this->storeId);

        if($stmt->execute())
            return true;

        return false;
    }

    public function update() {
        $query = "UPDATE" . $this->table_name . "
            SET
                price = :price,
                date = :date,
                userId = :userId,
                storeId = :storeId
            WHERE
                miscId = " . $this->miscId;

        $stmt = $this->conn->prepare($query);

        // Clean Data
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->date = htmlspecialchars(strip_tags($this->date));
        $this->userId = htmlspecialchars(strip_tags($this->userId));
        $this->storeId = htmlspecialchars(strip_tags($this->storeId));

        // Bind Data
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":date", $this->date);
        $stmt->bindParam(":userId", $this->userId);
        $stmt->bindParam(":storeId", $this->storeId);

        if($stmt->execute())
            return true;

        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE miscId = " . $this->miscId;

        $stmt = $this->conn->prepare($query);

        if($stmt->exeucte())
            return true;

        return false;
    }
}