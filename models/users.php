<?php
class Users
{
    private $conn;
    private $tableName = "users";
    private $select_all = "SELECT * FROM ";
    private $order_by = " ORDER BY firstName ASC";

    // Properties
    public $userId;
    public $firstName;
    public $lastName;
    public $email;
    public $password;
    public $isAdmin;
    public $phoneNum;
    public $salary;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read()
    {
            if(isset($_GET["search"])) {
                $search = $_GET["search"];
                $query = $this->select_all . $this->tableName . "
                WHERE firstName LIKE '%$search%' OR lastName LIKE '%$search%' OR email LIKE '%$search%'";
            } else {
                $query = $this->select_all . $this->tableName;
            }

        $stmt = $this->conn->prepare($query . $this->order_by);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    public function read_single()
    {
        $query = "SELECT 
            u.userId,
            u.firstName,
            u.lastName,
            u.email,
            u.password,
            u.isAdmin,
            u.phoneNum,
            u.salary
        FROM " . $this->tableName . " u
            WHERE
                u.userId = " . $this->userId;
        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->userId = $row["userId"] ?? null;
        $this->firstName = $row["firstName"] ?? null;
        $this->lastName = $row['lastName'] ?? null;
        $this->email = $row["email"] ?? null;
        $this->password = $row["password"] ?? null;
        $this->isAdmin = $row["isAdmin"] ?? null;
        $this->phoneNum = $row["phoneNum"] ?? null;
        $this->salary = $row["salary"] ?? null;
    }

    // Create User
    public function create()
    {
        $query = 'INSERT INTO ' . $this->tableName . '
            SET
                firstName = :firstName,
                lastName = :lastName,
                email = :email,
                password = :password,
                isAdmin = :isAdmin,
                phoneNum = :phoneNum,
                salary = :salary';

        $stmt = $this->conn->prepare($query);

        // Clean Data
        $this->firstName = htmlspecialchars(strip_tags($this->firstName));
        $this->lastName = htmlspecialchars(strip_tags($this->lastName));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->isAdmin = htmlspecialchars(strip_tags($this->isAdmin));
        $this->phoneNum = htmlspecialchars(strip_tags($this->phoneNum));
        $this->salary = htmlspecialchars(strip_tags($this->salary));

        // Bind data
        $stmt->bindParam(':firstName', $this->firstName);
        $stmt->bindParam(':lastName', $this->lastName);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':isAdmin', $this->isAdmin);
        $stmt->bindParam(":phoneNum", $this->phoneNum);
        $stmt->bindParam(":salary", $this->salary);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function update()
    {
        $query = 'UPDATE ' . $this->tableName . '
            SET
                firstName = :firstName,
                lastName = :lastName,
                email = :email,
                password = :password,
                isAdmin = :isAdmin,
                phoneNum = :phoneNum,
                salary = :salary
            WHERE
                userId = ' . $this->userId;

        $stmt = $this->conn->prepare($query);

        // Clean Data
        $this->firstName = htmlspecialchars(strip_tags($this->firstName));
        $this->lastName = htmlspecialchars(strip_tags($this->lastName));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->isAdmin = htmlspecialchars(strip_tags($this->isAdmin));
        $this->phoneNum = htmlspecialchars(strip_tags($this->phoneNum));
        $this->salary = htmlspecialchars(strip_tags($this->salary));

        // Bind data
        $stmt->bindParam(':firstName', $this->firstName);
        $stmt->bindParam(':lastName', $this->lastName);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':isAdmin', $this->isAdmin);
        $stmt->bindParam(":phoneNum", $this->phoneNum);
        $stmt->bindParam(":salary", $this->salary);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function delete()
    {
        $query = "DELETE FROM " . $this->tableName . " WHERE userId = " . $this->userId;

        $stmt = $this->conn->prepare($query);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
