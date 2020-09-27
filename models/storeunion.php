<?php
class StoreUnion {
    private $conn;
    private $table_name = "storeunion";

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

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll() {
        switch (isset($_GET)) {
            case isset($_GET["search"]):
                $search = $_GET["search"];
                $query = "SELECT * FROM " . $this->table_name . "
                    WHERE storeName LIKE '%$search%' OR address LIKE '%$search%' OR city LIKE '%$search%' OR state LIKE '%$search%' OR zip LIKE '%$search%'";
            break;
            case isset($_GET["storeName"]):
                    $this->storeName= $_GET["storeName"];
                    $query = "SELECT * FROM " . $this->table_name . "
                        WHERE storeName LIKE '%" . $this->storeName . "%'";
            break;
            case isset($_GET["address"]):
                $this->address = $_GET["address"];
                $query = "SELECT * FROM " . $this->table_name . "
                        WHERE address LIKE '%" . $this->address . "%'";
            break;
            case isset($_GET["city"]):
                $this->city = $_GET["city"];
                $query = "SELECT * FROM " . $this->table_name . "
                        WHERE city LIKE '%" . $this->city . "%'";
            break;
            case isset($_GET["state"]):
                $this->state = $_GET["state"];
                $query = "SELECT * FROM " . $this->table_name . "
                        WHERE state LIKE '%" . $this->state . "%'";
            break;
            case isset($_GET["zip"]):
                $this->zip = $_GET["zip"];
                $query = "SELECT * FROM " . $this->table_name . "
                        WHERE zip LIKE '%" . $this->zip . "%'";
            break;
            default:
                $query = "SELECT * FROM " . $this->table_name;
                break;
        }
        $order_by = " ORDER BY storeName ASC";
        $stmt = $this->conn->prepare($query . $order_by);
        $stmt->execute();

        return $stmt;
    }

    public function getById() {
        $query = "SELECT 
            s.storeName,
            s.address,
            s.city,
            s.state,
            s.zip,
            s.phoneNum,
            s.email,
            s.website
        FROM . " . $this->table_name . " s
            WHERE
                s.storeId = " . $this->storeId . "
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
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
            SET
                storeName = :storeName,
                address = :address,
                city = :city,
                state = :state,
                zip = :zip,
                phoneNum = :phoneNum,
                email = :email,
                website = :website";

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

        // Bind data
        $stmt->bindParam(":storeName", $this->storeName);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":city", $this->city);
        $stmt->bindParam(":state", $this->state);
        $stmt->bindParam(":zip", $this->zip);
        $stmt->bindParam(":phoneNum", $this->phoneNum);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":website", $this->website);

        if($stmt->execute())
            return true;
        
        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . "
            SET
                storeName = :storeName,
                address = :address,
                city = :city,
                state = :state,
                zip = :zip,
                phoneNum = :phoneNum,
                email = :email,
                website = :website
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

        // Bind data
        $stmt->bindParam(":storeName", $this->storeName);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":city", $this->city);
        $stmt->bindParam(":state", $this->state);
        $stmt->bindParam(":zip", $this->zip);
        $stmt->bindParam(":phoneNum", $this->phoneNum);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":website", $this->website);

        if($stmt->execute())
            return true;
        
        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE storeId = " . $this->storeId;

        $stmt = $this->conn->prepare($query);

        if($stmt->execute())
            return true;

        return false;
    }
}