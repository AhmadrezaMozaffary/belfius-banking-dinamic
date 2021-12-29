<?php

namespace App;

session_start();

/**
 * Connection calss --- connect to the "bankprojectt" dataBase with PDO driver
 * @property object $conn
 * @property array $dbConfig
 * @method connect()
 */
class Connection
{
    protected  $conn;
    private array $dbConfig = [
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
