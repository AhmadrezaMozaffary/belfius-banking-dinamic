<?php

namespace App;

use PDO;
use PDORow;

include_once "traits.php";

class Assets extends Connection
{
    private string $tableName = "assets";
    public function __construct()
    {
        $this->connection();
    }

    public function addMovement(int $userId, int $movement = null): bool
    {
        if (is_null($movement)) {
            $sql = "INSERT INTO {$this->tableName} (user_id) VALUES (?)";
        } else {
            $sql = "INSERT INTO {$this->tableName} (user_id , movement) VALUES (? , ?)";
        }
        $stmt = $this->conn->prepare($sql);
        if (is_null($movement)) {
            return $stmt->execute([$userId]) ?? false;
        } else {
            return $stmt->execute([$userId, $movement]) ?? false;
        }
    }
    public function getMovement(int $userId)
    {
        $sql = "SELECT * FROM {$this->tableName} WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_OBJ) ?? null;
    }

    public function requestLoan($money)
    {
    }
    public function transferMoney($idCard, $money)
    {
    }
}
