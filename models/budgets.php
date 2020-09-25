<?php
class Budgets {
    private $conn;
    private $table_name = "budget";
    private $select_all = "SELECT * FROM ";

    // Properties
    public $budgetId;
    public $totalBills;
    public $moneyLeft;
    public $userId;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll() {
        $query = $this->select_all . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function getById() {
        $query = $this->select_all . $this->table_name . " WHERE budgetId = " . $this->budgetId;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->totalBills = $row["totalBills"] ?? null;
        $this->moneyLeft = $row["moneyLeft"] ?? null;
        $this->userId = $row["userId"] ?? null;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
            SET
                totalBills = :totalBills,
                moneyLeft = :moneyLeft,
                userid = :userId";

        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->totalBills = htmlspecialchars(strip_tags($this->totalBills));
        $this->moneyLeft = htmlspecialchars(strip_tags($this->moneyLeft));
        $this->userId = htmlspecialchars(strip_tags($this->userId));

        // Bind data
        $stmt->bindParam(":totalBills", $this->totalBills);
        $stmt->bindParam(":moneyLeft", $this->moneyLeft);
        $stmt->bindParam(":userId", $this->userId);

        if($stmt->execute())
            return true;

        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . "
            SET
                totalBills = :totalBills,
                moneyLeft = :moneyLeft,
                userid = :userId
            WHERE
                budgetId = " . $this->budgetId;

        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->totalBills = htmlspecialchars(strip_tags($this->totalBills));
        $this->moneyLeft = htmlspecialchars(strip_tags($this->moneyLeft));
        $this->userId = htmlspecialchars(strip_tags($this->userId));

        // Bind data
        $stmt->bindParam(":totalBills", $this->totalBills);
        $stmt->bindParam(":moneyLeft", $this->moneyLeft);
        $stmt->bindParam(":userId", $this->userId);

        if($stmt->execute())
            return true;

        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE budgetId = " . $this->budgetId;

        $stmt = $this->conn->prepare($query);

        if($stmt->execute())
            return true;

        return false;
    }
}