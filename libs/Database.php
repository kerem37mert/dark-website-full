<?php

class Database
{
    private $host = "localhost";
    private $db = "site";
    private $username = "root";
    private $password = "";
    public $pdo = null;
    public $stmt = null;

    public function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->db;charset=utf8mb4", $this->username, $this->password);
        }
        catch (PDOException $e)
        {
            die($e->getMessage());
        }
    }

    public function getRow($query, $params=null)
    {
        try {
            if(is_null($params)):
                $this->stmt = $this->pdo->query($query);
            else:
                $this->stmt = $this->pdo->prepare($query, $params);
                $this->stmt->execute($params);
            endif;

            return $this->stmt->fetch();
        }
        catch(PDOException $e)
        {
            die($e->getMessage());
        }
    }
}