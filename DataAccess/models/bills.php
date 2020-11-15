<?php
class Bills
{
    private $conn;
    private $table_name = "bills";
    private $select_all = "SELECT bills.billId, bills.billName, bills.billDate, bills.billPrice, bills.endDate, bills.isLate, bills.userId, bills.storeId, storeunion.storeName, storeunion.website FROM ";
    private $inner_join = " INNER JOIN storeunion ON bills.storeId = storeunion.storeId";
    private $order_by = " ORDER BY billDate ASC";
    private $and_user = " AND userId =";

    // Properties
    public $billId;
    public $billName;
    public $billDate;
    public $billPrice;
    public $isLate;
    public $userId;
    public $storeId;
    public $storeName;
    public $website;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        switch (isset($_GET)) {
            case isset($_GET["search"]):
                $search = $_GET["search"];
                $query = $this->select_all . $this->table_name . $this->inner_join . "WHERE billName LIKE '%$search%' OR billDate LIKE '%$search%' OR billPrice LIKE '%$search%' OR isLate LIKE '%$search%' OR endDate LIKE '%$search%'";
                break;
            case isset($_GET["userId"]):
                $this->userId = $_GET["userId"];
                $query = $this->select_all . $this->table_name . $this->inner_join . " 
                WHERE userId = " . $this->userId;
                break;
            case isset($_GET["userId"]) && isset($_GET["search"]):
                $this->userId = $_GET["userId"];
                $search = $_GET["search"];
                $query = $this->select_all . $this->table_name . $this->inner_join . " WHERE billName LIKE '%$search%' OR billDate LIKE '%$search%' OR billPrice LIKE '%$search%' OR OR isLate LIKE '%$search%' AND userId = " . $this->userId;
                break;
            case isset($_GET["storeId"]):
                $this->storeId = $_GET["storeId"];
                $query = $this->select_all . $this->table_name . $this->inner_join . " 
                WHERE storeId = " . $this->storeId;
                break;
            case isset($_GET["storeId"]) && isset($_GET["userId"]):
                $this->storeId = $_GET["storeId"];
                $this->userId = $_GET["userId"];
                $query = $this->select_all . $this->table_name . $this->inner_join .  " 
                WHERE storeId = " . $this->storeId . $this->and_user . $this->userId;
                break;
            case isset($_GET["storeId"]) && isset($_GET["userId"]) && isset($_GET["search"]):
                $search = $_GET["search"];
                $this->storeId = $_GET["storeId"];
                $this->userId = $_GET["userId"];
                $query = $this->select_all . $this->table_name . $this->inner_join . " WHERE billName LIKE '%$search%' OR billDate LIKE '%$search%' OR billPrice LIKE '%$search%' OR OR isLate LIKE '%$search%' AND storeId = " . $this->storeId . $this->and_user . $this->userId;
                break;
            case isset($_GET["billName"]):
                $this->billName = $_GET["billName"];
                $query = $this->select_all . $this->table_name . $this->inner_join . " 
                WHERE billName LIKE '%" . $this->billName . "%'";
                break;
            case isset($_GET["billDate"]):
                $this->billDate = $_GET["billDate"];
                $query = $this->select_all . $this->table_name . $this->inner_join . " 
                WHERE billDate LIKE '%" . $this->billDate . "%'";
                break;
            case isset($_GET["billPrice"]):
                $this->billPrice = $_GET["billPrice"];
                $query = $this->select_all . $this->table_name . $this->inner_join . " 
                WHERE billPrice LIKE '%" . $this->billPrice . "%'";
                break;
            case isset($_GET["isLate"]) && isset($_GET["userId"]):
                $this->isLate = $_GET["isLate"];
                $this->userId = $_GET["userId"];
                $query = $this->select_all . $this->table_name . $this->inner_join . " 
                WHERE isLate =" . $this->isLate . $this->userId . $this->userId;
                break;
            default:
                $query = $this->select_all . $this->table_name . $this->inner_join;
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
        $query = $this->select_all . $this->table_name . $this->inner_join . "
        WHERE
            billId = " . $this->billId;

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
        $this->storeName = $row["storeName"] ?? null;
        $this->webiste = $row["website"] ?? null;
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

    public function patch($column, $value) {
        $query = "UPDATE " . $this->table_name . " SET " . $this->table_name . "."  . $column . "= " . $value . " WHERE billId = " . $this->billId;
        $stmt = $this->conn->prepare($query);

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
