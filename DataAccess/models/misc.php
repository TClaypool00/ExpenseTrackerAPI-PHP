<?php
class Misc
{
    private $conn;
    private $table_name = "misc ";
    private $select_all = "SELECT misc.miscId, misc.price, misc.date, misc.userId, misc.memo, misc.miscName, misc.storeId, storeunion.storeName, storeunion.website FROM ";
    private $inner_join = "INNER JOIN storeunion ON misc.storeId = storeunion.storeId";
    private $order_by = " ORDER BY date ASC";

    public $miscId;
    public $price;
    public $storeId;
    public $date;
    public $userId;
    public $memo;
    public $miscName;
    public $storeName;
    public $website;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        // Referes to private properites ^
        $query = $this->select_all . $this->table_name . $this->inner_join;

        switch (isset($_GET)) {
            case isset($_GET["search"]):
                $search = $_GET["search"];
                $query = $query . " WHERE price LIKE '%$search%' OR date LIKE '%$search%'";
                break;
            case isset($_GET["userId"]):
                $this->userId = $_GET["userId"];
                $query = $query . " WHERE userId = " . $this->userId . ' AND MONTH(misc.date) = MONTH(CURRENT_DATE()) AND YEAR(misc.date) = YEAR(CURRENT_DATE())';
                break;
            case isset($_GET["userId"]) && isset($_GET["search"]):
                $search = $_GET["search"];
                $this->userId = $_GET["userId"];
                $query = $query . " WHERE price LIKE '%$search%' OR date LIKE '%$search%' AND userId = " . $this->userId;
                break;
            case isset($_GET["storeId"]) && isset($_GET["search"]):
                $search = $_GET["search"];
                $this->storeId = $_GET["storeId"];
                $query = $query . " WHERE price LIKE '%$search%' OR date LIKE '%$search%' AND storeId = " . $this->storeId;
                break;
            case isset($_GET["userId"]) && isset($_GET["storeId"]) && isset($_GET["search"]):
                $search = $_GET["search"];
                $this->userId = $_GET["userId"];
                $this->storeId = $_GET["storeId"];
                $query = $query . " WHERE price LIKE '%$search%' OR date LIKE '%$search%' AND userId = " . $this->userId . " AND storeId = " . $this->storeId;
                break;
            default:
                $query;
                break;
        }

        $stmt = $this->conn->prepare($query . $this->order_by);

        $stmt->execute();

        return $stmt;
    }

    public function getbyId()
    {
        $query = $this->select_all . $this->table_name . $this->inner_join . " WHERE miscId = " . $this->miscId;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->miscId = $row["miscId"] ?? null;
        $this->price = $row["price"] ?? null;
        $this->storeId = $row["storeId"] ?? null;
        $this->storeName = $row["storeName"] ?? null;
        $this->website = $row["website"] ?? null;
        $this->date = $row["date"] ?? null;
        $this->userId = $row["userId"] ?? null;
        $this->memo = $row["memo"] ?? null;
        $this->miscName = $row["miscName"] ?? null;
        
    }

    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . "
            SET
                price = :price,
                storeId = :storeId,
                date = :date,
                userId = :userId,
                memo = :memo,
                miscName = :miscName";

        $stmt = $this->conn->prepare($query);

        // Clean Data
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->storeId = htmlspecialchars(strip_tags($this->storeId));
        $this->date = htmlspecialchars(strip_tags($this->date));
        $this->userId = htmlspecialchars(strip_tags($this->userId));
        $this->memo = htmlspecialchars(strip_tags($this->memo));
        $this->miscName = htmlspecialchars(strip_tags($this->miscName));

        // Bind Data
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":storeId", $this->storeId);
        $stmt->bindParam(":date", $this->date);
        $stmt->bindParam(":userId", $this->userId);
        $stmt->bindParam(":memo", $this->memo);
        $stmt->bindParam(":miscName", $this->miscName);

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
                storeId = :storeId,
                date = :date,
                userId = :userId,
                memo = :memo,
                miscName = :miscName
            WHERE
                miscId = " . $this->miscId;

        $stmt = $this->conn->prepare($query);

        // Clean Data
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->storeId = htmlspecialchars(strip_tags($this->storeId));
        $this->date = htmlspecialchars(strip_tags($this->date));
        $this->userId = htmlspecialchars(strip_tags($this->userId));
        $this->memo = htmlspecialchars(strip_tags($this->memo));
        $this->miscName = htmlspecialchars(strip_tags($this->miscName));

        // Bind Data
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":storeId", $this->storeId);
        $stmt->bindParam(":date", $this->date);
        $stmt->bindParam(":userId", $this->userId);
        $stmt->bindParam(":memo", $this->memo);
        $stmt->bindParam(":miscName", $this->miscName);

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
