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

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table_name . "
            ORDER BY storeName ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function getById() {
        $query = "SELECT 
            s.storeName,
            s.address,
            s.city,
            s.state,
            s.zip
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
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
            SET
                storeName = :storeName,
                address = :address,
                city = :city,
                state = :state,
                zip = :zip";

        $stmt = $this->conn->prepare($query);

        // clean data
        $this->storeName = htmlspecialchars(strip_tags($this->storeName));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->city = htmlspecialchars(strip_tags($this->city));
        $this->state = htmlspecialchars(strip_tags($this->state));
        $this->zip = htmlspecialchars(strip_tags($this->zip));

        // Bind data
        $stmt->bindParam(":storeName", $this->storeName);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":city", $this->city);
        $stmt->bindParam(":state", $this->state);
        $stmt->bindParam(":zip", $this->zip);

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
                zip = :zip
            WHERE
                storeId = " . $this->storeId;

        $stmt = $this->conn->prepare($query);

        // clean data
        $this->storeName = htmlspecialchars(strip_tags($this->storeName));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->city = htmlspecialchars(strip_tags($this->city));
        $this->state = htmlspecialchars(strip_tags($this->state));
        $this->zip = htmlspecialchars(strip_tags($this->zip));

        // Bind data
        $stmt->bindParam(":storeName", $this->storeName);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":city", $this->city);
        $stmt->bindParam(":state", $this->state);
        $stmt->bindParam(":zip", $this->zip);

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