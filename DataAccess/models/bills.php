<?php
class Bills
{
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
    public $userId;
    public $storeId;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        switch (isset($_GET)) {
            case isset($_GET["search"]):
                $search = $_GET["search"];
                $query = $this->select_all . $this->table_name . "WHERE billName LIKE '%$search%' OR billDate LIKE '%$search%' OR billPrice LIKE '%$search%' OR OR isLate LIKE '%$search%'";
                break;
            case isset($_GET["userId"]):
                $this->userId = $_GET["userId"];
                $query = $this->select_all . $this->table_name . " 
                WHERE userId = " . $this->userId;
                break;
            case isset($_GET["userId"]) && isset($_GET["search"]):
                $this->userId = $_GET["userId"];
                $search = $_GET["search"];
                $query = $this->select_all . $this->table_name . "WHERE billName LIKE '%$search%' OR billDate LIKE '%$search%' OR billPrice LIKE '%$search%' OR OR isLate LIKE '%$search%' AND userId = " . $this->userId;
                break;
            case isset($_GET["storeId"]):
                $this->storeId = $_GET["storeId"];
                $query = $this->select_all . $this->table_name . " 
                WHERE storeId = " . $this->storeId;
                break;
            case isset($_GET["storeId"]) && isset($_GET["userId"]):
                $this->storeId = $_GET["storeId"];
                $this->userId = $_GET["userId"];
                $query = $this->select_all . $this->table_name . " 
                WHERE storeId = " . $this->storeId . " AND userId = " . $this->userId;
                break;
            case isset($_GET["storeId"]) && isset($_GET["userId"]) && isset($_GET["search"]):
                $search = $_GET["search"];
                $this->storeId = $_GET["storeId"];
                $this->userId = $_GET["userId"];
                $query = $this->select_all . $this->table_name . "WHERE billName LIKE '%$search%' OR billDate LIKE '%$search%' OR billPrice LIKE '%$search%' OR OR isLate LIKE '%$search%' AND storeId = " . $this->storeId . " AND userId = " . $this->userId;
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
                break;
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

    public function getById()
    {
        $query = "SELECT 
        b.billId,
        b.billName,
        b.billDate,
        b.billPrice,
        b.isLate,
        b.userId,
        b.storeId
        FROM " . $this->table_name . " b
            WHERE
                b.billId = " . $this->billId;

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->billId = $row["billId"] ?? null;
        $this->billName = $row["billName"] ?? null;
        $this->billPrice = $row["billPrice"] ?? null;
        $this->billDate = $row["billDate"] ?? null;
        $this->isLate = $row["isLate"] ?? null;
        $this->userId = $row["userId"] ?? null;
        $this->storeId = $row["storeId"] ?? null;
    }

    public function create()
    {
        $query = 'INSERT INTO ' . $this->table_name . '
            SET
                billName = :billName,
                billPrice = :billPrice,
                billDate = :billDate,
                isLate = :isLate,
                userId = :userId,
                storeId = :storeId';

        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->billName = htmlspecialchars(strip_tags($this->billName));
        $this->billPrice = htmlspecialchars(strip_tags($this->billPrice));
        $this->billDate = htmlspecialchars(strip_tags($this->billDate));
        $this->isLate = htmlspecialchars(strip_tags($this->isLate));
        $this->userId = htmlspecialchars(strip_tags($this->userId));
        $this->storeId = htmlspecialchars(strip_tags($this->storeId));

        $stmt->bindParam(':billName', $this->billName);
        $stmt->bindParam(':billPrice', $this->billPrice);
        $stmt->bindParam(':billDate', $this->billDate);
        $stmt->bindParam(':isLate', $this->isLate);
        $stmt->bindParam(':userId', $this->userId);
        $stmt->bindParam(':storeId', $this->storeId);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function update()
    {
        $query = "UPDATE " . $this->table_name . "
            SET
                billName = :billName,
                billPrice = :billPrice,
                billDate = :billDate,
                isLate = :isLate,
                userId = :userId,
                storeId = :storeId
            WHERE
                billId = " . $this->billId;

        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->billName = htmlspecialchars(strip_tags($this->billName));
        $this->billPrice = htmlspecialchars(strip_tags($this->billPrice));
        $this->billDate = htmlspecialchars(strip_tags($this->billDate));
        $this->isLate = htmlspecialchars(strip_tags($this->isLate));
        $this->userId = htmlspecialchars(strip_tags($this->userId));
        $this->storeId = htmlspecialchars(strip_tags($this->storeId));

        // Bind data
        $stmt->bindParam(':billName', $this->billName);
        $stmt->bindParam(':billPrice', $this->billPrice);
        $stmt->bindParam(':billDate', $this->billDate);
        $stmt->bindParam(':isLate', $this->isLate);
        $stmt->bindParam(':userId', $this->userId);
        $stmt->bindParam(':storeId', $this->storeId);


        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE billId =" . $this->billId;

        $stmt = $this->conn->prepare($query);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
