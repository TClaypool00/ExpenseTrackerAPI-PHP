<?php
class Subscriptions {
    private $conn;
    private $table_name = "subscriptions";

    public $subId;
    public $dueDate;
    public $amountDue;
    public $budgetId;
    public $storeId;
    public $subName;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll() {
        $select_all = "SELECT * FROM " . $this->table_name;

        switch (isset($_GET)) {
            case isset($_GET["search"]):
                $search = $_GET["search"];
                $query = $select_all . "
                    WHERE dueDate LIKE '%$search%' OR amountDue LIKE '%$search%' OR subName LIKE %$search%";
                break;
            case isset($_GET["budgetId"]):
                $this->budgetId = $_GET["budgetId"];
                $query = $select_all . " WHERE budgetId = " . $this->budgetId;
                break;
            case isset($_GET["storeId"]):
                $this->storeId = $_GET["storeId"];
                $query = $select_all . " WHERE storeId = " . $this->storeId;
                break;
            case isset($_GET["dueDate"]):
                $this->dueDate = $_GET["dueDate"];
                $query = $select_all . " WHERE dueDate = " . $this->dueDate;
                break;
            case isset($_GET["amountDue"]):
                $this->amountDue = $_GET["amountDue"];
                $query = $select_all . " WHERE amountDue = " . $this->amountDue;
                break;
            case isset($_GET["subName"]):
                $this->subName = $_GET["subName"];
                $query = $select_all . " WHERE subName = " . $this->subName;
                break;
            default:
                $query = $select_all;
                break;
        }

        $order_by = "ORDER BY dueDate ASC";
        $stmt = $this->conn->prepare($query . $order_by);
        $stmt->execute();

        return $stmt;
    }

    public function getById() {
        $query = "SELECT
            s.dueDate,
            s.budgetId,
            s.storeId,
            s.amountDue,
            s.subName,
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
        $this->budgetId = $row["budgetId"] ?? null;
        $this->storeId = $row["storeId"] ?? null;
        $this->subName = $row["subName"] ?? null;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
            SET
                dueDate = :dueDate,
                amountDue = :amountDue,
                budgetId = :budgetId,
                storeId = :storeId,
                subName = :subName,";
        
        $stmt = $this->conn->prepare($query);

        // Clean Data
        $this->dueDate = htmlspecialchars(strip_tags($this->dueDate));
        $this->amountDue = htmlspecialchars(strip_tags($this->amountDue));
        $this->budgetId = htmlspecialchars(strip_tags($this->budgetId));
        $this->storeId = htmlspecialchars(strip_tags($this->storeId));
        $this->subName = htmlspecialchars(strip_tags($this->subName));

        // Bind data
        $stmt->bindParam(":dueDate", $this->dueDate);
        $stmt->bindParam(":amountDue", $this->amountDue);
        $stmt->bindParam(":budgetId", $this->budgetId);
        $stmt->bindParam(":storeId", $this->storeId);
        $stmt->bindParam(":subName", $this->subName);

        if($stmt->execute())
            return true;
        
        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . "
            SET
                dueDate = :dueDate,
                amountDue = :amountDue,
                budgetId = :budgetId,
                storeId = :storeId,
                subName = :subName
            WHERE
                subId = " . $this->subId;
        
        $stmt = $this->conn->prepare($query);

        // Clean Data
        $this->dueDate = htmlspecialchars(strip_tags($this->dueDate));
        $this->amountDue = htmlspecialchars(strip_tags($this->amountDue));
        $this->budgetId = htmlspecialchars(strip_tags($this->budgetId));
        $this->storeId = htmlspecialchars(strip_tags($this->storeId));
        $this->subName = htmlspecialchars(strip_tags($this->subName));

        // Bind data
        $stmt->bindParam(":dueDate", $this->dueDate);
        $stmt->bindParam(":amountDue", $this->amountDue);
        $stmt->bindParam(":budgetId", $this->budgetId);
        $stmt->bindParam(":storeId", $this->storeId);
        $stmt->bindParam(":subName", $this->subName);

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