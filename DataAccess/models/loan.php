<?php
class Loan
{
    private $conn;
    private $table_name = "loan";
    private $select_all = "SELECT loan.loanId, loan.loanName, loan.dueDate, loan.monthlyAmountDue, loan.deposit, loan.totalAmountDue, loan.storeId, storeunion.storeName, storeunion.website, loan.userId, loan.amountRemaining, loan.isLate, loan.isPaid FROM ";
    private $inner_join = " INNER JOIN storeunion ON loan.storeId = storeunion.storeId";
    private $order_by = " ORDER BY dueDate ASC";

    public $loanId;
    public $loanName;
    public $dueDate;
    public $monthlyAmountDue;
    public $deposit;
    public $totalAmountDue;
    public $amountRemaining;
    public $userId;
    public $storeId;
    public $storeName;
    public $webiste;
    public $isLate;
    public $isPaid;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        switch (isset($_GET)) {
            case isset($_GET["search"]):
                $search = $_GET["search"];
                $query = $this->select_all . $this->table_name . $this->inner_join . " WHERE loanName LIKE '%$search%' OR dueDate LIKE '%$search%' OR monthlyAmountDue LIKE '%$search%' OR deposit LIKE '%$search%' OR totalAmountDue LIKE '%$search%'";
                break;
            case isset($_GET["userId"]):
                $this->userId = $_GET["userId"];
                $query = $this->select_all . $this->table_name . $this->inner_join . " WHERE userId = " . $this->userId;
                break;
            case isset($_GET["storeId"]):
                $this->storeId = $_GET["storeId"];
                $query = $this->select_all . $this->table_name . $this->inner_join . " WHERE storeId = " . $this->storeId;
                break;
            case isset($_GET["userId"]) && isset($_GET["search"]):
                $this->userId = $_GET["userId"];
                $search = $_GET["search"];
                $query = $this->select_all . $this->table_name . $this->inner_join . " WHERE loanName LIKE '%$search%' OR dueDate LIKE '%$search%' OR monthlyAmountDue LIKE '%$search%' OR deposit LIKE '%$search%' OR totalAmountDue LIKE '%$search%' AND userId = " . $this->userId;
                break;
            case isset($_GET["userId"]) && isset($_GET["search"]) && isset($_GET["storeId"]):
                $this->userId = $_GET["userId"];
                $this->storeId = $_GET["storeId"];
                $search = $_GET["search"];
                $query = $this->select_all . $this->table_name . $this->inner_join . " WHERE loanName LIKE '%$search%' OR dueDate LIKE '%$search%' OR monthlyAmountDue LIKE '%$search%' OR deposit LIKE '%$search%' OR totalAmountDue LIKE '%$search%' AND userId = " . $this->userId . " AND storeId = storeId = " . $this->storeId;
                break;
            default:
                $query = $this->select_all . $this->table_name . $this->inner_join;
                break;
        }

        $stmt = $this->conn->prepare($query . $this->order_by);
        $stmt->execute();

        return $stmt;
    }

    public function getById()
    {
        $query = $this->select_all . $this->table_name . $this->inner_join . " 
        WHERE 
            loanId = " . $this->loanId;

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
        $this->storeName = $row["storeName"] ?? null;
        $this->webiste = $row["website"] ?? null;
        $this->amountRemaining = $row["amountRemaining"] ?? null;
        $this->isLate = $row["isLate"] ?? null;
        $this->isPaid = $row["isPaid"] ?? null;
        
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
                amountRemaining = :amountRemaining,
                storeId = :storeId,
                userId = :userId,
                isLate = :isLate,
                isPaid = :isPaid";

        $stmt = $this->conn->prepare($query);
        
        // Clean Data
        $this->loanName = htmlspecialchars(strip_tags($this->loanName));
        $this->dueDate = htmlspecialchars(strip_tags($this->dueDate));
        $this->monthlyAmountDue = htmlspecialchars(strip_tags($this->monthlyAmountDue));
        $this->deposit = htmlspecialchars(strip_tags($this->deposit));
        $this->totalAmountDue = htmlspecialchars(strip_tags($this->totalAmountDue));
        $this->storeId = htmlspecialchars(strip_tags($this->storeId));
        $this->userId = htmlspecialchars(strip_tags($this->userId));
        $this->amountRemaining = htmlspecialchars(strip_tags($this->amountRemaining));
        $this->isLate = htmlspecialchars(strip_tags($this->isLate));
        $this->isPaid = htmlspecialchars(strip_tags($this->isPaid));

        // Bind Data
        $stmt->bindParam(':loanName', $this->loanName);
        $stmt->bindParam(':dueDate', $this->dueDate);
        $stmt->bindParam(':monthlyAmountDue', $this->monthlyAmountDue);
        $stmt->bindParam(':deposit', $this->deposit);
        $stmt->bindParam(':totalAmountDue', $this->totalAmountDue);
        $stmt->bindParam(':storeId', $this->storeId);
        $stmt->bindParam(':userId', $this->userId);
        $stmt->bindParam(':amountRemaining', $this->amountRemaining);
        $stmt->bindParam(':isLate', $this->isLate);
        $stmt->bindParam(':isPaid', $this->isPaid);

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
                amountRemaining = :amountRemaining,
                storeId = :storeId,
                userId = :userId,
                isLate = :isLate,
                isPaid = :isPaid
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
                $this->amountRemaining = htmlspecialchars(strip_tags($this->amountRemaining));
                $this->isLate = htmlspecialchars(strip_tags($this->isLate));
                $this->isPaid = htmlspecialchars(strip_tags($this->isPaid));

                // Bind Data
                $stmt->bindParam(':loanName', $this->loanName);
                $stmt->bindParam(':dueDate', $this->dueDate);
                $stmt->bindParam(':monthlyAmountDue', $this->monthlyAmountDue);
                $stmt->bindParam(':deposit', $this->deposit);
                $stmt->bindParam(':totalAmountDue', $this->totalAmountDue);
                $stmt->bindParam(':storeId', $this->storeId);
                $stmt->bindParam(':userId', $this->userId);
                $stmt->bindParam(':amountRemaining', $this->amountRemaining);
                $stmt->bindParam(':isLate', $this->isLate);
                $stmt->bindParam(':isPaid', $this->isPaid);
        
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
