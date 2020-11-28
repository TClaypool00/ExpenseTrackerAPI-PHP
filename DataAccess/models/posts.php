<?php
class Posts
{
    private $conn;
    private $table_name = "posts p ";
    private $select_all = "SELECT p.postId, p.title, p.postBody, p.date, p.userId, u.firstName, u.lastName FROM ";
    private $inner_join = "INNER JOIN users u ON p.userId = u.userId ";
    private $order_by = "ORDER BY date ASC";

    public $postId;
    public $title;
    public $postBody;
    public $date;
    public $userId;
    public $firstName;
    public $lastName;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll() {
        switch(isset($_GET)) {
            case isset($_GET["search"]):
                $search = $_GET["search"];
                $query = $this->select_all . $this->table_name . $this->inner_join . "WHERE title LIKE '%$search%' OR postBody LIKE '%$search%' OR date LIKE '%$search%'";
            break;
            case isset($_GET["userId"]):
                $this->userId = $_GET["userId"];
                $query = $this->select_all . $this->table_name . $this->inner_join . "WHERE userId = " . $this->userId;
            break;
            default:
                $query = $this->select_all . $this->table_name . $this->inner_join;
            break;
        }

        $stmt = $this->conn->prepare($query . $this->order_by);
        $stmt->execute();

        return $stmt;
    }

    public function getbyId() {
        $query = $this->select_all . $this->table_name . $this->inner_join . "
        WHERE
            postId = " . $this->postId;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->postId = $row["postId"] ?? null;
        $this->title = $row["title"] ?? null;
        $this->postBody = $row["postBody"] ?? null;
        $this->date = $row["date"] ?? null;
        $this->userId = $row["userId"] ?? null;
        $this->firstName = $row["firstName"] ?? null;
        $this->lastName = $row["lastName"] ?? null;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
            SET
                title = :title,
                postBody = :postBody,
                date = :date,
                userId = :userId";
        $stmt = $this->conn->prepare($query);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->postBody = htmlspecialchars(strip_tags($this->postBody));
        $this->date = htmlspecialchars(strip_tags($this->date));
        $this->userId = htmlspecialchars(strip_tags($this->userId));

        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(":postBody", $this->postBody);
        $stmt->bindParam(":date", $this->date);
        $stmt->bindParam(":userId", $this->userId);

        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . "
            SET
                title = :title,
                postBody = :postBody,
                date = :date,
                userId = :userId
            WHERE
                postId=" . $this->postId;

        $stmt = $this->conn->prepare($query);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->postBody = htmlspecialchars(strip_tags($this->postBody));
        $this->date = htmlspecialchars(strip_tags($this->date));
        $this->userId = htmlspecialchars(strip_tags($this->userId));

        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(":postBody", $this->postBody);
        $stmt->bindParam(":date", $this->date);
        $stmt->bindParam(":userId", $this->userId);

        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . "WHERE postId=" . $this->postId;
        $stmt = $this->conn->prepare($query);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}