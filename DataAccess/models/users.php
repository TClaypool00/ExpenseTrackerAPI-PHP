<?php
class Users
{
    private $conn;
    private $tableName = "users";
    private $select_all = "SELECT * FROM ";
    private $order_by = " ORDER BY firstName ASC";
    private $bind_email = ":email";

    // Properties
    public $userId;
    public $firstName;
    public $lastName;
    public $email;
    public $password;
    public $is_superuser;
    public $phoneNum;
    public $salary;
    public $date_joined;
    public $is_active;
    public $is_staff;
    public $last_login;

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
        $query = "SELECT *
        FROM " . $this->tableName . "
            WHERE
                userId = " . $this->userId;
        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->userId = $row["userId"] ?? null;
        $this->firstName = $row["firstName"] ?? null;
        $this->lastName = $row['lastName'] ?? null;
        $this->email = $row["email"] ?? null;
        $this->password = $row["password"] ?? null;
        $this->is_superuser = $row["is_superuser"] ?? null;
        $this->phoneNum = $row["phoneNum"] ?? null;
        $this->salary = $row["salary"] ?? null;
        $this->date_joined = $row["date_joined"] ?? null;
        $this->is_active = $row["is_active"] ?? null;
        $this->is_staff = $row["is_staff"] ?? null;
        $this->last_login = $row["last_login"] ?? null;
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
                is_superuser = :is_superuser,
                phoneNum = :phoneNum,
                salary = :salary';

        $stmt = $this->conn->prepare($query);

        // Clean Data
        $this->firstName = htmlspecialchars(strip_tags($this->firstName));
        $this->lastName = htmlspecialchars(strip_tags($this->lastName));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->is_superuser = htmlspecialchars(strip_tags($this->is_superuser));
        $this->phoneNum = htmlspecialchars(strip_tags($this->phoneNum));
        $this->salary = htmlspecialchars(strip_tags($this->salary));

        // Bind data
        $stmt->bindParam(':firstName', $this->firstName);
        $stmt->bindParam(':lastName', $this->lastName);
        $stmt->bindParam($this->bind_email, $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(':is_superuser', $this->is_superuser);
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
                is_superuser = :is_superuser,
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
        $this->is_superuser = htmlspecialchars(strip_tags($this->is_superuser));
        $this->phoneNum = htmlspecialchars(strip_tags($this->phoneNum));
        $this->salary = htmlspecialchars(strip_tags($this->salary));

        // Bind data
        $stmt->bindParam(':firstName', $this->firstName);
        $stmt->bindParam(':lastName', $this->lastName);
        $stmt->bindParam($this->bind_email, $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(':is_superuser', $this->is_superuser);
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

    public function emailExist() {
        $query = "SELECT * FROM " . $this->tableName . "
            WHERE email = :email";

            $stmt = $this->conn->prepare($query);
            $this->email = htmlspecialchars(strip_tags($this->email));
            $stmt->bindParam(":email", $this->email);
            $stmt->execute();

            $num = $stmt->rowCount();

            if($num > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                $this->userId = $row["userId"] ?? null;
                $this->firstName = $row["firstName"] ?? null;
                $this->lastName = $row['lastName'] ?? null;
                $this->email = $row["email"] ?? null;
                $this->password = $row["password"] ?? null;
                $this->is_superuser = $row["is_superuser"] ?? null;
                $this->phoneNum = $row["phoneNum"] ?? null;
                $this->salary = $row["salary"] ?? null;

                return true;
            }
            return false;
    }
}
