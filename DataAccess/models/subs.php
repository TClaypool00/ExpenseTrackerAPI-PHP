<?php
class Subscriptions
{
    private $conn;
    private $table_name = "subscriptions ";
    private $select_all = 'SELECT subscriptions.subId, subscriptions.dueDate, subscriptions.amountDue, subscriptions.storeId, subscriptions.subName, subscriptions.userId,  storeunion.storeName, storeunion.website FROM ';
    private $inner_join = "INNER JOIN storeunion ON subscriptions.storeId = storeunion.storeId";

    public $subId;
    public $dueDate;
    public $amountDue;
    public $userId;
    public $storeId;
    public $subName;
    public $storeName;
    public $website;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        $query = $this->select_all . $this->table_name . $this->inner_join;
        switch (isset($_GET)) {
            case isset($_GET["search"]):
                $search = $_GET["search"];
                $query = $query . "
                    WHERE dueDate LIKE '%$search%' OR amountDue LIKE '%$search%' OR subName LIKE '%$search%'";
                break;
            case isset($_GET["userId"]):
                $this->userId = $_GET["userId"];
                $query = $query . " WHERE userId = " . $this->userId;
                break;
            case isset($_GET["storeId"]):
                $this->storeId = $_GET["storeId"];
                $query = $query . " WHERE storeId = " . $this->storeId;
                break;
            case isset($_GET["userId"]) && isset($_GET["search"]):
                $this->userId = $_GET["userId"];
                $search = $_GET["search"];
                $query = $query . "
                    WHERE dueDate LIKE '%$search%' OR amountDue LIKE '%$search%' OR subName LIKE '%$search%' AND userId = " . $this->userId;
                break;
            case isset($_GET["storeId"]) && isset($_GET["search"]):
                $this->storeId = $_GET["storeId"];
                $search = $_GET["search"];
                $query = $query . "
                    WHERE dueDate LIKE '%$search%' OR amountDue LIKE '%$search%' OR subName LIKE '%$search%' AND storeId = " . $this->storeId;
                break;
            case isset($_GET["userId"]) && isset($_GET["storeId"]) && isset($_GET["search"]):
                $this->userId = $_GET["userId"];
                $this->storeId = $_GET["storeId"];
                $search = $_GET["search"];
                $query = $query . "
                    WHERE dueDate LIKE '%$search%' OR amountDue LIKE '%$search%' OR subName LIKE '%$search%' AND userId = " . $this->userId . " AND storeId = " . $this->storeId;
                break;
            default:
                $query;
                break;
        }

        $order_by = " ORDER BY dueDate ASC";
        $stmt = $this->conn->prepare($query . $order_by);
        $stmt->execute();

        return $stmt;
    }

    public function getById()
    {
        $query = $this->select_all . $this->table_name . $this->inner_join . "
                WHERE
                    subId = " . $this->subId;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->subId = $row["subId"] ?? null;
        $this->dueDate = $row["dueDate"] ?? null;
        $this->amountDue = $row["amountDue"] ?? null;
        $this->storeId = $row["storeId"] ?? null;
        $this->subName = $row["subName"] ?? null;
        $this->userId = $row["userId"] ?? null;
        $this->storeName = $row["storeName"] ?? null;
        $this->website = $row["website"] ?? null;
    }

    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . "
            SET
                dueDate = :dueDate,
                amountDue = :amountDue,
                storeId = :storeId,
                subName = :subName,
                userId = :userId";

        $stmt = $this->conn->prepare($query);

        // Clean Data
        $this->dueDate = htmlspecialchars(strip_tags($this->dueDate));
        $this->amountDue = htmlspecialchars(strip_tags($this->amountDue));
        $this->storeId = htmlspecialchars(strip_tags($this->storeId));
        $this->subName = htmlspecialchars(strip_tags($this->subName));
        $this->userId = htmlspecialchars(strip_tags($this->userId));

        // Bind data
        $stmt->bindParam(":dueDate", $this->dueDate);
        $stmt->bindParam(":amountDue", $this->amountDue);
        $stmt->bindParam(":storeId", $this->storeId);
        $stmt->bindParam(":subName", $this->subName);
        $stmt->bindParam(":userId", $this->userId);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function update()
    {
        $query = "UPDATE " . $this->table_name . "
            SET
                dueDate = :dueDate,
                amountDue = :amountDue,
                storeId = :storeId,
                subName = :subName,
                userId = :userId
            WHERE
                subId = " . $this->subId;

        $stmt = $this->conn->prepare($query);

        // Clean Data
        $this->dueDate = htmlspecialchars(strip_tags($this->dueDate));
        $this->amountDue = htmlspecialchars(strip_tags($this->amountDue));
        $this->storeId = htmlspecialchars(strip_tags($this->storeId));
        $this->subName = htmlspecialchars(strip_tags($this->subName));
        $this->userId = htmlspecialchars(strip_tags($this->userId));

        // Bind data
        $stmt->bindParam(":dueDate", $this->dueDate);
        $stmt->bindParam(":amountDue", $this->amountDue);
        $stmt->bindParam(":storeId", $this->storeId);
        $stmt->bindParam(":subName", $this->subName);
        $stmt->bindParam(":userId", $this->userId);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE subId = " . $this->subId;

        $stmt = $this->conn->prepare($query);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
