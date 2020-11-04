<?php
class Loan
{
    private $conn;
    private $table_name = "loan";

    public $loanId;
    public $loanName;
    public $dueDate;
    public $monthlyAmountDue;
    public $deposit;
    public $totalAmountDue;
    public $userId;
    public $storeId;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        $select_all = "SELECT * FROM " . $this->table_name;
        $order_by = " ORDER BY dueDate ASC";

        switch (isset($_GET)) {
            case isset($_GET["search"]):
                $search = $_GET["search"];
                $query = $select_all . " WHERE loanName LIKE '%$search%' OR dueDate LIKE '%$search%' OR monthlyAmountDue LIKE '%$search%' OR deposit LIKE '%$search%' OR totalAmountDue LIKE '%$search%'";
                break;
            case isset($_GET["userId"]):
                $this->userId = $_GET["userId"];
                $query = $select_all . " WHERE userId = " . $this->userId;
                break;
            case isset($_GET["storeId"]):
                $this->storeId = $_GET["storeId"];
                $query = $select_all . " WHERE storeId = " . $this->storeId;
                break;
            case isset($_GET["userId"]) && isset($_GET["search"]):
                $this->userId = $_GET["userId"];
                $search = $_GET["search"];
                $query = $select_all . " WHERE loanName LIKE '%$search%' OR dueDate LIKE '%$search%' OR monthlyAmountDue LIKE '%$search%' OR deposit LIKE '%$search%' OR totalAmountDue LIKE '%$search%' AND userId = " . $this->userId;
                break;
            case isset($_GET["userId"]) && isset($_GET["search"]) && isset($_GET["storeId"]):
                $this->userId = $_GET["userId"];
                $this->storeId = $_GET["storeId"];
                $search = $_GET["search"];
                $query = $select_all . " WHERE loanName LIKE '%$search%' OR dueDate LIKE '%$search%' OR monthlyAmountDue LIKE '%$search%' OR deposit LIKE '%$search%' OR totalAmountDue LIKE '%$search%' AND userId = " . $this->userId . " AND storeId = storeId = " . $this->storeId;
                break;
            default:
                $query = $select_all;
                break;
        }

        $stmt = $this->conn->prepare($query . $order_by);
        $stmt->execute();

        return $stmt;
    }

    public function getById()
    {
        $query = "SELECT * FROM " . $this->table_name . " 
            WHERE loanId = " . $this->loanId;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->loanId = $row["loanId"] ?? null;
        $this->loanName = $row["loanName"] ?? null;
        $this->dueDate = $row["dueDate"] ?? null;
        $this->monthlyAmountDue = $row["monthlyAmountDue"] ?? null;
        $this->deposit = $row["deposit"] ?? null;
        $this->totalAmountDue = $row["totalAmountDue"] ?? null;
        $this->userId = $row["userId"] ?? null;
        $this->storeId = $row["storeId"] ?? null;
    }

    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . "
            SET
                loanName = :loanName,
                dueDate = :dueDate,
                monthlyAmountDue = :monthlyAmountDue,
                deposit = :deposit,
                totalAmountDue = :totalAmountDue,
                storeId = :storeId,
                userId = :userId";

        $stmt = $this->conn->prepare($query);
        
        // Clean Data
        $this->loanName = htmlspecialchars(strip_tags($this->loanName));
        $this->dueDate = htmlspecialchars(strip_tags($this->dueDate));
        $this->monthlyAmountDue = htmlspecialchars(strip_tags($this->monthlyAmountDue));
        $this->deposit = htmlspecialchars(strip_tags($this->deposit));
        $this->totalAmountDue = htmlspecialchars(strip_tags($this->totalAmountDue));
        $this->storeId = htmlspecialchars(strip_tags($this->storeId));
        $this->userId = htmlspecialchars(strip_tags($this->userId));

        // Bind Data
        $stmt->bindParam(':loanName', $this->loanName);
        $stmt->bindParam(':dueDate', $this->dueDate);
        $stmt->bindParam(':monthlyAmountDue', $this->monthlyAmountDue);
        $stmt->bindParam(':deposit', $this->deposit);
        $stmt->bindParam(':totalAmountDue', $this->totalAmountDue);
        $stmt->bindParam(':storeId', $this->storeId);
        $stmt->bindParam(':userId', $this->userId);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function update()
    {
        $query = "UPDATE " . $this->table_name . "
            SET
                loanName = :loanName,
                dueDate = :dueDate,
                monthlyAmountDue = :monthlyAmountDue,
                deposit = :deposit,
                totalAmountDue = :totalAmountDue,
                storeId = :storeId,
                userId = :userId
            WHERE
                loanId = " . $this->loanId;

                $stmt = $this->conn->prepare($query);
        
                // Clean Data
                $this->loanName = htmlspecialchars(strip_tags($this->loanName));
                $this->dueDate = htmlspecialchars(strip_tags($this->dueDate));
                $this->monthlyAmountDue = htmlspecialchars(strip_tags($this->monthlyAmountDue));
                $this->deposit = htmlspecialchars(strip_tags($this->deposit));
                $this->totalAmountDue = htmlspecialchars(strip_tags($this->totalAmountDue));
                $this->storeId = htmlspecialchars(strip_tags($this->storeId));
                $this->userId = htmlspecialchars(strip_tags($this->userId));
        
                // Bind Data
                $stmt->bindParam(':loanName', $this->loanName);
                $stmt->bindParam(':dueDate', $this->dueDate);
                $stmt->bindParam(':monthlyAmountDue', $this->monthlyAmountDue);
                $stmt->bindParam(':deposit', $this->deposit);
                $stmt->bindParam(':totalAmountDue', $this->totalAmountDue);
                $stmt->bindParam(':storeId', $this->storeId);
                $stmt->bindParam(':userId', $this->userId);
        
                if ($stmt->execute()) {
                    return true;
                }
        
                return false;
    }

    public function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE loanId = " . $this->loanId;

        $stmt = $this->conn->prepare($query);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
