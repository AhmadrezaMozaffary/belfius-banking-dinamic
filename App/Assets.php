<?php

namespace App;


include_once "traits.php";

/**
 * Assets : All functionality that relate with user's assets 
 * @property string $tableName
 * @property object $conn : Connection to dataBase
 * @method - @param ([int $userId , int $movement = null, bool $status = null]) addMovement():bool
 */
class Assets extends Connection
{
    private string $tableName = "assets";
    public function __construct()
    {
        $this->connection();
    }

    use \assetsFunctionality;
    use \userFunctionality;

    public function addMovement(int $userId, int $movement, bool $status): int|bool
    {
        $sql = "INSERT INTO {$this->tableName} (user_id , movement, status) VALUES (? , ? , ?)";
        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute([$userId, $movement, $status]) ?? false;
        if ($result) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    public function getMovementByUserID(int $userId)
    {
        $sql = "SELECT * FROM {$this->tableName} WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(\PDO::FETCH_OBJ) ?? null;
    }

    public function getMovementByID(int $id): ?object
    {
        $sql = "SELECT * FROM {$this->tableName} WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_OBJ) ?? null;
    }

    public function requestLoan($money)
    {
    }

    public function transferMoney($transactionOwnerID, $idCard, $money): bool
    {
        $sql = "UPDATE users SET money = money + :money WHERE idCard = :idCard";
        $stmt = $this->conn->prepare($sql);

        $sqlOwner = "UPDATE users SET money = money - :money WHERE id = :ownerId";
        $stmtOwner = $this->conn->prepare($sqlOwner);

        $destinaitonResult = $stmt->execute([':money' => $money, ':idCard' => $idCard]) ?? false;
        $ownerResult = $stmtOwner->execute([':money' => $money, ':ownerId' => $transactionOwnerID]) ?? false;
        if ($destinaitonResult and $ownerResult) {
            return true;
        }
        return false;
    }
}
