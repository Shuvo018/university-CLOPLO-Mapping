<?php

class DBController
{
    private $conn;
    function __construct()
    {
        $this->conn = mysqli_connect("localhost", "root", "", "university002");
    }
    function isConn()
    {
        if ($this->conn) {
            echo "Database connected";
        } else {
            echo "Database connection failed";
        }
    }
    function insertData($query)
    {
        $result = mysqli_query($this->conn, $query);
        return mysqli_insert_id($this->conn);
    }
    function updataData($query)
    {
        mysqli_query($this->conn, $query);
    }
    function readData($query)
    {
        $result = mysqli_query($this->conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        if (!empty($data)) {
            return $data;
        }
        return null;
    }
    function clanData($data)
    {
        $data = mysqli_real_escape_string($this->conn, $data);
        return $data;
    }
}

// $call = new DBController();
// $call->isConn();
