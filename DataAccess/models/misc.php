<?php
class Misc
{
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

    public function getAll()
    {
        // Referes to private properites ^
        switch (isset($_GET)) {
            case isset($_GET["search"]):
                $search = $_GET["search"];
                $query = $this->select_all . $this->table_name . " WHERE price LIKE '%$search%' OR date LIKE '%$search%'";
                break;
            case isset($_GET["userId"]) && isset($_GET["search"]):
                $search = $_GET["search"];
                $this->userId = $_GET["userId"];
                $query = $this->select_all . $this->table_name . " WHERE price LIKE '%$search%' OR date LIKE '%$search%' AND userId = " . $this->userId;
                break;
            case isset($_GET["storeId"]) && isset($_GET["search"]):
                $search = $_GET["search"];
                $this->storeId = $_GET["storeId"];
                $query = $this->select_all . $this->table_name . " WHERE price LIKE '%$search%' OR date LIKE '%$search%' AND storeId = " . $this->storeId;
                break;
            case isset($_GET["userId"]) && isset($_GET["storeId"]) && isset($_GET["search"]):
                $search = $_GET["search"];
                $this->userId = $_GET["userId"];
                $this->storeId = $_GET["storeId"];
                $query = $this->select_all . $this->table_name . " WHERE price LIKE '%$search%' OR date LIKE '%$search%' AND userId = " . $this->userId . " AND storeId = " . $this->storeId;
                break;
            default:
                $query = $this->select_all . $this->table_name;
                break;
        }

        $stmt = $this->conn->prepare($query . $this->order_by);

        $stmt->execute();

        return $stmt;
    }

    public function getbyId()
    {
        $query = $this->select_all . $this->table_name . " WHERE miscId = " . $this->miscId;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->miscId = $row["miscId"] ?? null;
        $this->price = $row["price"] ?? null;
        $this->date = $row["date"] ?? null;
        $this->storeId = $row["storeId"] ?? null;
        $this->userId = $row["userId"] ?? null;
    }

    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . "
            SET
                price = :price,
                date = :date,
                userId = :userId,
                storeId = :userId";

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

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function update()
    {
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

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE miscId = " . $this->miscId;

        $stmt = $this->conn->prepare($query);

        if ($stmt->exeucte()) {
            return true;
        }

        return false;
    }
}
