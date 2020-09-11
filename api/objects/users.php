<?php
class Users
{
    private $conn;
    private $tableName = "users";

    // Properties
    public $UserId;
    public $FirstName;
    public $LastName;
    public $EmailAddress;
    public $Password;
    public $IsAdmin;
    public $Address;
    public $City;
    public $State;
    public $Zip;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    function read()
    {
        // select all query
        $query = "SELECT * FROM " . $this->tableName . "
            ORDER BY FirstName ASC";

        $pStatement = $this->conn->prepare($query);

        // execute query
        $pStatement->execute();

        return $pStatement;
    }

    function create()
    {
        $query = "INSERT INTO
                " . $this->tableName . "
            SET
                FirstName=:FirstName, LastName=:LastName, EmailAddress=:EmailAddress, Password=:Password, IsAdmin=:IsAdmin, Address=:Address, City=:City, State=:State, Zip=:Zip";

        $pStatement = $this->conn->prepare($query);

        // Sanitize
        $this->FirstName = htmlspecialchars(strip_tags($this->FirstName));
        $this->LastName = htmlspecialchars(strip_tags($this->LastName));
        $this->EmailAddress = htmlspecialchars(strip_tags($this->EmailAddress));
        $this->Password = htmlspecialchars(strip_tags($this->Password));
        $this->IsAdmin = htmlspecialchars(strip_tags($this->IsAdmin));
        $this->Address = htmlspecialchars(strip_tags($this->Address));
        $this->City = htmlspecialchars(strip_tags($this->City));
        $this->State = htmlspecialchars(strip_tags($this->State));
        $this->Zip = htmlspecialchars(strip_tags($this->Zip));

        // Bind Values
        $pStatement->bindParam(":FirstName", $this->FirstName);
        $pStatement->bindParam(":LastName", $this->LastName);
        $pStatement->bindParam(":EmailAddress", $this->EmailAddress);
        $pStatement->bindParam(":Password", $this->Password);
        $pStatement->bindParam(":IsAdmin", $this->IsAdmin);
        $pStatement->bindParam(":Address", $this->Address);
        $pStatement->bindParam(":City", $this->City);
        $pStatement->bindParam(":State", $this->State);
        $pStatement->bindParam(":Zip", $this->Zip);

        // Execute query
        if ($pStatement->execute()) {
            return true;
        }

        return false;
    }
}
