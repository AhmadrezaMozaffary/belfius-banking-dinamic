<?php

namespace App;

/**
 * This Class For start Connection with database
 * Driver : PDO
 */
class Connection
{
    protected $conn;
    private $dbConfig = [
        'dbname'    => "bankproject",
        'username'  => "root",
        'password'  => '',
        'dbms'      => 'mysql',
        'host'      => 'localhost'
    ];

    public function connection()
    {
        try {
            $this->conn =  new \PDO(
                "{$this->dbConfig['dbms']}:host={$this->dbConfig['host']};dbname={$this->dbConfig['dbname']}",
                $this->dbConfig['username'],
                $this->dbConfig['password']
            );
        } catch (\PDOException $th) {
            die("an Exception exist , in Line {$th->getLine()} , and in File {$th->getFile()} -> {$th->getMessage()}");
        }
    }
}
