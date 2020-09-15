<?php
class Users
{
    private $conn;
    private $tableName = "users";

    // Properties
    public $userId;
    public $firstName;
    public $lastName;
    public $email;
    public $password;
    public $isAdmin;
    public $address;
    public $city;
    public $state;
    public $zip;

    public function __construct($db){
        $this->conn = $db;
    }

    public function read()
    {
        // select all query
        $query = "SELECT * FROM " . $this->tableName . "
            ORDER BY firstName ASC";

        $pStatement = $this->conn->prepare($query);

        // execute query
        $pStatement->execute();

        return $pStatement;
    }

    public function read_single(){
        $query = "SELECT 
            u.firstName,
            u.lastName,
            u.email,
            u.password,
            u.isAdmin,
            u.address,
            u.city,
            u.state,
            u.zip
        FROM " . $this->tableName . " u
            WHERE
                u.userId = ?
                LIMIT 0,1";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->userId);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->firstName = $row["firstName"] ?? null;
        $this->lastName = $row['lastName'] ?? null;
        $this->email = $row["email"] ?? null;
        $this->password = $row["password"] ?? null;
        $this->isAdmin = $row["isAdmin"] ?? null;
        $this->address = $row["address"] ?? null;
        $this->city = $row["city"] ?? null;
        $this->state = $row["state"] ?? null;
        $this->zip = $row["zip"] ?? null;
    }

    // Create User
    public function create(){
        $query = 'INSERT INTO ' . $this->tableName . '
            SET
                firstName = :firstName,
                lastName = :lastName,
                email = :email,
                password = :password,
                isAdmin = :isAdmin,
                address = :address,
                city = :city,
                state = :state,
                zip = :zip';

        $stmt = $this->conn->prepare($query);
        
        // Clean Data
        $this->firstName = htmlspecialchars(strip_tags($this->firstName));
        $this->lastName = htmlspecialchars(strip_tags($this->lastName));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->isAdmin = htmlspecialchars(strip_tags($this->isAdmin));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->city = htmlspecialchars(strip_tags($this->city));
        $this->state = htmlspecialchars(strip_tags($this->state));
        $this->zip = htmlspecialchars(strip_tags($this->zip));

        // Bind data
        $stmt->bindParam(':firstName', $this->firstName);
        $stmt->bindParam(':lastName', $this->lastName);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':isAdmin', $this->isAdmin);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':city', $this->city);
        $stmt->bindParam(':state', $this->state);
        $stmt->BindParam(':zip', $this->zip);

        if($stmt->execute())
            return true;

        return false;
    }

    public function update(){
        $query = 'UPDATE ' . $this->tableName . '
            SET
                firstName = :firstName,
                lastName = :lastName,
                email = :email,
                password = :password,
                isAdmin = :isAdmin,
                address = :address,
                city = :city,
                state = :state,
                zip = :zip
            WHERE
                userId = :userId';
            
            $stmt = $this->conn->prepare($query);
    
            // Clean Data
            $this->userId = htmlspecialchars(strip_tags($this->userId));
            $this->firstName = htmlspecialchars(strip_tags($this->firstName));
            $this->lastName = htmlspecialchars(strip_tags($this->lastName));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->password = htmlspecialchars(strip_tags($this->password));
            $this->isAdmin = htmlspecialchars(strip_tags($this->isAdmin));
            $this->address = htmlspecialchars(strip_tags($this->address));
            $this->city = htmlspecialchars(strip_tags($this->city));
            $this->state = htmlspecialchars(strip_tags($this->state));
            $this->zip = htmlspecialchars(strip_tags($this->zip));
    
            // Bind data
            $stmt->bindParam(":userId", $this->userId);
            $stmt->bindParam(':firstName', $this->firstName);
            $stmt->bindParam(':lastName', $this->lastName);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':password', $this->password);
            $stmt->bindParam(':isAdmin', $this->isAdmin);
            $stmt->bindParam(':address', $this->address);
            $stmt->bindParam(':city', $this->city);
            $stmt->bindParam(':state', $this->state);
            $stmt->BindParam(':zip', $this->zip);
    
            if($stmt->execute())
                return true;
    
            return false;
    }

    public function delete (){
        $query = "DELETE FROM " . $this->tableName . " WHERE userId = :userId";

        $stmt = $this->conn->prepare($query);

        $this->userId = htmlspecialchars(strip_tags($this->userId));

        $stmt->bindParam(":userId", $this->userId);

        if($stmt->execute())
            return true;

        return false;
    }
}
