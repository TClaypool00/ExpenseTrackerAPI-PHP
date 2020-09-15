<?php
class Bills {
    private $conn;
    private $table_name = "bills";

    // Properties
    public $billId;
    public $billName;
    public $billDate;
    public $billPrice;
    public $isLate;
    public $userId;

    public function __construct($db)
    {
        $this->conn = $db;
    }
}