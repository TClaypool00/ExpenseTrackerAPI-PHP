<?php
class Reply
{
    private $conn;
    private $table_name = " reply r ";
    private $select_all = "SELECT r.replyId, r.replyBody, r.date, r.postId, r.userId, u.firstName, u.lastName FROM";
    private $inner_join = "INNER JOIN users u ON r.userId=u.userId ";
    private $order_by = " ORDER BY date ASC";

    public $replyiId;
    public $replyBody;
    public $date;
    public $postId;
    public $userId;
    public $firstName;
    public $lastName;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Private function to prepare and execute query statement
    // Returns statement
    private function prepareQuery($query) {
        return $this->conn->prepare($query);
    }

    private function CleanAndBindData($stmt) {
        // Clean Data
        $this->replyBody = htmlspecialchars(strip_tags($this->replyBody));
        $this->date = htmlspecialchars(strip_tags($this->date));
        $this->postId = htmlspecialchars(strip_tags($this->postId));
        $this->userId = htmlspecialchars(strip_tags($this->userId));

        // Bind Data
        $stmt->bindParam(":replyBody", $this->replyBody);
        $stmt->bindParam(":date", $this->date);
        $stmt->bindParam(":postId", $this->postId);
        $stmt->bindParam(":userId", $this->userId);
    }

    private function executeBool($stmt) {
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function getAll() {
        $query = $this->select_all . $this->table_name . $this->inner_join;
        
        if (isset($_GET["postId"])) {
            $this->postId = $_GET["postId"];
            $query = $query . "WHERE postId=" . $this->postId;
        } else {
            $query;
        }

        $stmt = $this->prepareQuery($query . $this->order_by);

        $stmt->execute();

        return $stmt;
    }

    public function getById() {
        $query = $this->select_all . $this->table_name . $this->inner_join . "
            WHERE replyId=" . $this->replyiId;

        $stmt = $this->prepareQuery($query);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->replyiId = $row["replyId"] ?? null;
        $this->replyBody = $row["replyBody"] ?? null;
        $this->date = $row["date"] ?? null;
        $this->postId = $row["postId"] ?? null;
        $this->userId = $row["userId"] ?? null;
        $this->firstName = $row["firstName"] ?? null;
        $this->lastName = $row["lastName"] ?? null;
    }

    public function create() {
        $query = "INSERT INTO" . $this->table_name . "
            SET
                replyBody = :replyBody,
                date = :date,
                postId = :postId,
                userId = :userId";
        
        $stmt = $this->prepareQuery($query);

        $this->CleanAndBindData($stmt);

        return $this->executeBool($stmt);
    }

    public function update() {
        $query = "UPDATE" . $this->table_name . "
            SET
                replyBody = :replyBody,
                date = :date,
                postId = :postId,
                userId = :userId
            WHERE
                replyId=" . $this->replyiId;
        
        $stmt = $this->prepareQuery($query);

        $this->CleanAndBindData($stmt);

        return $this->executeBool($stmt);
    }

    public function delete() {
        $query = "DELETE FROM" . $this->table_name . "WHERE replyId=" . $this->replyiId;

        $stmt = $this->prepareQuery($query);

        return $this->executeBool($stmt);
    }
}