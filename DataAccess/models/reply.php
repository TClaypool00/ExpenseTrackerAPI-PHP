<?php
class Reply
{
    private $conn;
    private $table_name = " reply ";
    private $select_all = "SELECT * FROM";
    private $order_by = " ORDER BY date ASC";

    public $replyiId;
    public $replyBody;
    public $date;
    public $postId;
    public $userId;

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
        if (isset($_GET["postId"])) {
            $this->postId = $_GET["postId"];
            $query = $this->postId . $this->table_name . "WHERE postId=" . $this->postId;
        } else {
            $query = $this->select_all . $this->table_name;
        }

        $stmt = $this->prepareQuery($query . $this->order_by);

        $stmt->execute();

        return $stmt;
    }

    public function getById() {
        $query = $this->select_all . $this->table_name . "
            WHERE replyId=" . $this->replyiId;

        $stmt = $this->prepareQuery($query);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->replyiId = $row["replyId"] ?? null;
        $this->replyBody = $row["replyBody"] ?? null;
        $this->date = $row["date"] ?? null;
        $this->postId = $row["postId"] ?? null;
        $this->userId = $row["userId"] ?? null;
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