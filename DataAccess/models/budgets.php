<?php
class Budgets
{
    private $conn;
    private $table_name = "budget";
    private $select_all = "SELECT * FROM ";
    private $bind_userId = ":userId";

    // Properties
    public $budgetId;
    public $totalBills;
    public $moneyLeft;
    public $savingsMoney;
    public $userId;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        switch (isset($_GET)) {
            case isset($_GET["search"]):
                $search = $_GET["search"];
                $query = $this->select_all . $this->table_name . " HERE totalBills LIKE '%$search%' OR moneyLeft LIKE '%$search%' OR savingsMoney LIKE '%$search%'";
                break;
            case isset($_GET["userId"]):
                $this->userId = $_GET["userId"];
                $query = $this->select_all . $this->table_name . " WHERE userId = " . $this->userId;
                break;
            case isset($_GET["userId"]) && isset($_GET["search"]):
                $this->userId = $_GET["userId"];
                $search = $_GET["search"];
                $query = $this->select_all . $this->table_name . " HERE totalBills LIKE '%$search%' OR moneyLeft LIKE '%$search%' AND userId = " . $this->userId;
                break;
            case isset($_GET["totalBills"]):
                $this->totalBills = $_GET["totalBills"];
                $query = $this->select_all . $this->table_name . " WHERE totalBills LIKE '%" . $this->totalBills . "%'";
                break;
            case isset($_GET["moneyLeft"]):
                $this->moneyLeft = $_GET["moneyLeft"];
                $query = $this->select_all . $this->table_name . " WHERE moneyLeft LIKE '%" . $this->moneyLeft . "%'";
                break;
            default:
                $query = $this->select_all . $this->table_name;
                break;
        }

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function getById()
    {
        $query = $this->select_all . $this->table_name;

        if($this->budgetId == null) {
            $query = $query . " WHERE userId=" . $this->userId;
        } elseif($this->userId == null) {
            $query = $query . " WHERE budgetId=" . $this->budgetId;
        } else {
            die();
        }

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->budgetId = $row["budgetId"] ?? null;
        $this->totalBills = $row["totalBills"] ?? null;
        $this->moneyLeft = $row["moneyLeft"] ?? null;
        $this->savingsMoney = $row["savingsMoney"] ?? null;
        $this->userId = $row["userId"] ?? null;
    }

    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . "
            SET
                totalBills = :totalBills,
                moneyLeft = :moneyLeft,
                savingsMoney = :savingsMoney,
                userid = :userId";

        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->totalBills = htmlspecialchars(strip_tags($this->totalBills));
        $this->moneyLeft = htmlspecialchars(strip_tags($this->moneyLeft));
        $this->savingsMoney = htmlspecialchars(strip_tags($this->savingsMoney));
        $this->userId = htmlspecialchars(strip_tags($this->userId));

        // Bind data
        $stmt->bindParam(":totalBills", $this->totalBills);
        $stmt->bindParam(":moneyLeft", $this->moneyLeft);
        $stmt->bindParam(":savingsMoney", $this->savingsMoney);
        $stmt->bindParam($this->bind_userId, $this->userId);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function update()
    {
        $query = "UPDATE " . $this->table_name . "
            SET
                totalBills = :totalBills,
                moneyLeft = :moneyLeft,
                savingsMoney = :savingsMoney,
                userid = :userId
            WHERE
                budgetId = " . $this->budgetId;

        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->totalBills = htmlspecialchars(strip_tags($this->totalBills));
        $this->moneyLeft = htmlspecialchars(strip_tags($this->moneyLeft));
        $this->savingsMoney = htmlspecialchars(strip_tags($this->savingsMoney));
        $this->userId = htmlspecialchars(strip_tags($this->userId));

        // Bind data
        $stmt->bindParam(":totalBills", $this->totalBills);
        $stmt->bindParam(":moneyLeft", $this->moneyLeft);
        $stmt->bindParam(":savingsMoney", $this->savingsMoney);
        $stmt->bindParam($this->bind_userId, $this->userId);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE budgetId = " . $this->budgetId;

        $stmt = $this->conn->prepare($query);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function getTotalBillAmt() {
        $query = "SELECT SUM(bills.billPrice) AS value_sum FROM bills WHERE bills.userId = :userId";

        return $this->extractQuery($query);
    }

    public function getTotalLoanAmt() {
        $query = "SELECT SUM(loan.monthlyAmountDue) AS value_sum FROM loan WHERE loan.userId = :userId";

        return $this->extractQuery($query);
    }

    public function getTotalSubAmt() {
        $query = "SELECT SUM(subscriptions.amountDue) AS value_sum FROM subscriptions WHERE subscriptions.userId = :userId";

        return $this->extractQuery($query);
    }

    public function getSalary() {
        $query = "SELECT users.salary AS value_sum FROM users WHERE users.userId = :userId";
        
        return $this->extractQuery($query);
    }

    public function budgetExist() {
        $query = "SELECT budget.budgetId FROM "  . $this->table_name . "
            WHERE userId = :userId";

            $stmt = $this->conn->prepare($query);

            $this->userId = htmlspecialchars(strip_tags($this->userId));
            $stmt->bindParam($this->bind_userId, $this->userId);
    
            $stmt->execute();

            $num = $stmt->rowCount();

            if($num > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                $this->budgetId = $row["budgetId"] ?? null;

                return true;
            }

            return false;
    }

    public function extractQuery($query) {
        $stmt = $this->conn->prepare($query);

        $this->userId = htmlspecialchars(strip_tags($this->userId));
        $stmt->bindParam($this->bind_userId, $this->userId);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['value_sum'];
    }
}
