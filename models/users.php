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
            u.userId,
            u.firstName,
            u.lastName,
            u.emailAddress,
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

        $stmt->bindParams(1, $this->UserId);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->userId = $row["userId"];
        $this->firstName = $row["firstName"];
        $this->lastName = $row['lastName'];
        $this->email = $row["email"];
        $this->password = $row["password"];
        $this->isAdmin = $row["isAdmin"];
        $this->address = $row["address"];
        $this->city = $row["city"];
        $this->state = $row["state"];
        $this->zip = $row["zip"];
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
}
