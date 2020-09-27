<?php
class Bills {
    private $conn;
    private $table_name = "bills";
    private $select_all = "SELECT * FROM ";
    private $order_by = "ORDER BY billName ASC";

    // Properties
    public $billId;
    public $billName;
    public $billDate;
    public $billPrice;
    public $isLate;
    public $budgetId;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll() {     
        switch ($_GET) {
            case isset($_GET["search"]):
                $search = $_GET["search"];
                $query = $this->select_all . $this->table_name . "WHERE billName LIKE '%$search%' OR billDate LIKE '%$search%' OR billPrice LIKE '%$search%' OR OR isLate LIKE '%$search%'";
                break;
            case isset($_GET["budgetId"]):
                $this->budgetId = $_GET["budgetId"];
                $query = $this->select_all . $this->table_name . " 
                WHERE budgetId = " . $this->budgetId;
                break;
            case isset($_GET["budgetId"]) and isset($_GET["search"]):
                $this->budgetId = $_GET["budgetId"];
                $search = $_GET["search"];
                $query = $this->select_all . $this->table_name . "WHERE billName LIKE '%$search%' OR billDate LIKE '%$search%' OR billPrice LIKE '%$search%' OR OR isLate LIKE '%$search%' AND budgetId = " . $this->budgetId;
                break;
            case isset($_GET["billName"]):
                $this->billName = $_GET["billName"];
                $query = $this->select_all . $this->table_name . " 
                WHERE billName LIKE '%" . $this->billName . "%'";
                break;
            case isset($_GET["billDate"]):
                $this->billDate = $_GET["billDate"];
                $query = $this->select_all . $this->table_name . " 
                WHERE billDate LIKE '%" . $this->billDate . "%'";
                break;
            case isset($_GET["billPrice"]):
                $this->billPrice = $_GET["billPrice"];
                $query = $this->select_all . $this->table_name . " 
                WHERE billPrice LIKE '%" . $this->billPrice . "%'";
            case isset($_GET["isLate"]):
                $this->isLate = $_GET["isLate"];
                $query = $this->select_all . $this->table_name . " 
                WHERE isLate LIKE '%" . $this->isLate . "%'";
                break;
            default:
                $query = $this->select_all . $this->table_name;
                break;
        }

        // Prepare statement
        $stmt = $this->conn->prepare($query . $this->order_by);

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
        b.budgetId
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
        $this->budgetId = $row["budgetId"] ?? null;
    }

    public function create() {
        $query = 'INSERT INTO ' . $this->table_name . '
            SET
                billName = :billName,
                billPrice = :billPrice,
                billDate = :billDate,
                isLate = :isLate,
                budgetId = :budgetId';
            
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->billName = htmlspecialchars(strip_tags($this->billName));
        $this->billPrice = htmlspecialchars(strip_tags($this->billPrice));
        $this->billDate = htmlspecialchars(strip_tags($this->billDate));
        $this->isLate = htmlspecialchars(strip_tags($this->isLate));
        $this->budgetId = htmlspecialchars(strip_tags($this->budgetId));

        $stmt->bindParam(':billName', $this->billName);
        $stmt->bindParam(':billPrice', $this->billPrice);
        $stmt->bindParam(':billDate', $this->billDate);
        $stmt->bindParam(':isLate', $this->isLate);
        $stmt->bindParam(':budgetId', $this->budgetId);

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
                budgetId = :budgetId
            WHERE
                billId= :billId";
        
                $stmt = $this->conn->prepare($query);

                // Clean data
                $this->billId = htmlspecialchars(strip_tags($this->billId));
                $this->billName = htmlspecialchars(strip_tags($this->billName));
                $this->billPrice = htmlspecialchars(strip_tags($this->billPrice));
                $this->billDate = htmlspecialchars(strip_tags($this->billDate));
                $this->isLate = htmlspecialchars(strip_tags($this->isLate));
                $this->budgetId = htmlspecialchars(strip_tags($this->budgetId));

                // Bind data
                $stmt->bindParam(':billId', $this->billId);
                $stmt->bindParam(':billName', $this->billName);
                $stmt->bindParam(':billPrice', $this->billPrice);
                $stmt->bindParam(':billDate', $this->billDate);
                $stmt->bindParam(':isLate', $this->isLate);
                $stmt->bindParam(':budgetId', $this->budgetId);
        
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