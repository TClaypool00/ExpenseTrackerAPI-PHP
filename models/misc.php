<?php
class Misc {
    private $conn;
    private $table_name = "misc";

    public $miscId;
    public $price;
    public $date;
    public $storeId;
    public $userId;

    public function __construct($db)
    {
        $this->conn = $db;
    }
}