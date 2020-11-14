<?php
class StoreUnion
{
    private $conn;
    private $table_name = "storeunion";
    private $select_all = "SELECT * FROM ";

    // Properties
    public $storeId;
    public $storeName;
    public $address;
    public $city;
    public $state;
    public $zip;
    public $phoneNum;
    public $email;
    public $website;
    public $isCreditUnion;
    public $isCompleted;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        switch (isset($_GET)) {
            case isset($_GET["search"]):
                $search = $_GET["search"];
                $query = $this->select_all . $this->table_name . "
                    WHERE storeName LIKE '%$search%' OR address LIKE '%$search%' OR city LIKE '%$search%' OR state LIKE '%$search%' OR zip LIKE '%$search%'";
                break;
            case isset($_GET["storeName"]):
                $this->storeName = $_GET["storeName"];
                $query = $this->select_all . $this->table_name . "
                        WHERE storeName LIKE '%" . $this->storeName . "%'";
                break;
            case isset($_GET["address"]):
                $this->address = $_GET["address"];
                $query = $this->select_all . $this->table_name . "
                        WHERE address LIKE '%" . $this->address . "%'";
                break;
            case isset($_GET["city"]):
                $this->city = $_GET["city"];
                $query = $this->select_all . $this->table_name . "
                        WHERE city LIKE '%" . $this->city . "%'";
                break;
            case isset($_GET["state"]):
                $this->state = $_GET["state"];
                $query = $this->select_all . $this->table_name . "
                        WHERE state LIKE '%" . $this->state . "%'";
                break;
            case isset($_GET["zip"]):
                $this->zip = $_GET["zip"];
                $query = $this->select_all . $this->table_name . "
                        WHERE zip LIKE '%" . $this->zip . "%'";
                break;
            case isset($_GET["isUnion"]):
                $this->isCreditUnion = $_GET["isUnion"];
                $query = $this->select_all . $this->table_name . "
                WHERE isCreditUnion LIKE '%" . $this->isCreditUnion . "%'";
                break;
            case isset($_GET["isUnion"]) && isset($_GET["search"]):
                $this->isCreditUnion = $_GET["isUnion"];
                $search = $_GET["search"];
                $query = $this->select_all . $this->table_name . "
                WHERE storeName LIKE '%$search%' OR address LIKE '%$search%' OR city LIKE '%$search%' OR state LIKE '%$search%' OR zip LIKE '%$search%' AND isCreditUnion LIKE '%" . $this->isCreditUnion . "%'";
                break;
            case isset($_GET["isCompleted"]):
                $this->isCompleted = $_GET["isCompleted"];
                $query = $this->select_all . $this->table_name . "
                WHERE isCompleted LIKE '%" . $this->isCompleted . "%'";
                break;
            case isset($_GET["isCompleted"]) && isset($_GET["search"]):
                $this->isCompleted = $_GET["isCompleted"];
                $search = $_GET["search"];
                $query = $this->select_all . $this->table_name . "
                WHERE storeName LIKE '%$search%' OR address LIKE '%$search%' OR city LIKE '%$search%' OR state LIKE '%$search%' OR zip LIKE '%$search%' AND isCompleted LIKE '%" . $this->isCompleted . "%'";
                break;
            default:
                $query = $this->select_all . $this->table_name;
                break;
        }
        $order_by = " ORDER BY storeName ASC";
        $stmt = $this->conn->prepare($query . $order_by);
        $stmt->execute();

        return $stmt;
    }

    public function getById()
    {
        $query = $this->select_all . $this->table_name . "
            WHERE
                storeId = " . $this->storeId . "
                LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->storeName = $row["storeName"] ?? null;
        $this->address = $row["address"] ?? null;
        $this->city = $row["city"] ?? null;
        $this->state = $row["state"] ?? null;
        $this->zip = $row["zip"] ?? null;
        $this->phoneNum = $row["phoneNum"] ?? null;
        $this->email = $row["email"] ?? null;
        $this->website = $row["website"] ?? null;
        $this->isCreditUnion = $row["isCreditUnion"] ?? null;
        $this->isCompleted = $row["isCompleted"] ?? null;
    }

    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . "
            SET
                storeName = :storeName,
                address = :address,
                city = :city,
                state = :state,
                zip = :zip,
                phoneNum = :phoneNum,
                email = :email,
                website = :website,
                isCreditUnion = :isCreditUnion,
                isCompleted = :isCompleted";

        $stmt = $this->conn->prepare($query);

        // clean data
        $this->storeName = htmlspecialchars(strip_tags($this->storeName));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->city = htmlspecialchars(strip_tags($this->city));
        $this->state = htmlspecialchars(strip_tags($this->state));
        $this->zip = htmlspecialchars(strip_tags($this->zip));
        $this->phoneNum = htmlspecialchars(strip_tags($this->phoneNum));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->website = htmlspecialchars(strip_tags($this->website));
        $this->isCreditUnion = htmlspecialchars(strip_tags($this->isCreditUnion));
        $this->isCompleted = htmlspecialchars(strip_tags($this->isCompleted));

        // Bind data
        $stmt->bindParam(":storeName", $this->storeName);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":city", $this->city);
        $stmt->bindParam(":state", $this->state);
        $stmt->bindParam(":zip", $this->zip);
        $stmt->bindParam(":phoneNum", $this->phoneNum);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":website", $this->website);
        $stmt->bindParam(":isCreditUnion", $this->isCreditUnion);
        $stmt->bindParam(":isCompleted", $this->isCompleted);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function update()
    {
        $query = "UPDATE " . $this->table_name . "
            SET
                storeName = :storeName,
                address = :address,
                city = :city,
                state = :state,
                zip = :zip,
                phoneNum = :phoneNum,
                email = :email,
                website = :website,
                isCreditUnion = :isCreditUnion,
                isCompleted = :isCompleted
            WHERE
                storeId = " . $this->storeId;

        $stmt = $this->conn->prepare($query);

        // clean data
        $this->storeName = htmlspecialchars(strip_tags($this->storeName));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->city = htmlspecialchars(strip_tags($this->city));
        $this->state = htmlspecialchars(strip_tags($this->state));
        $this->zip = htmlspecialchars(strip_tags($this->zip));
        $this->phoneNum = htmlspecialchars(strip_tags($this->phoneNum));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->website = htmlspecialchars(strip_tags($this->website));
        $this->isCreditUnion = htmlspecialchars(strip_tags($this->isCreditUnion));
        $this->isCompleted = htmlspecialchars(strip_tags($this->isCompleted));

        // Bind data
        $stmt->bindParam(":storeName", $this->storeName);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":city", $this->city);
        $stmt->bindParam(":state", $this->state);
        $stmt->bindParam(":zip", $this->zip);
        $stmt->bindParam(":phoneNum", $this->phoneNum);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":website", $this->website);
        $stmt->bindParam(":isCreditUnion", $this->isCreditUnion);
        $stmt->bindParam(":isCompleted", $this->isCompleted);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE storeId = " . $this->storeId;

        $stmt = $this->conn->prepare($query);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
