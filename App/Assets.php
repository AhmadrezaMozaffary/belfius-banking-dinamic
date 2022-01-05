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

    use \movementFunctionality;
    use \userFunctionality;


    public function isExistIdCard($idCard): object|bool
    {
        $sql = "SELECT * FROM users WHERE idCard = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idCard]);
        return $stmt->fetch(\PDO::FETCH_OBJ) ?? false;
    }

    public function loanRequest($userID, $amountMoneyForLoan): bool
    {
        $countOfMovements = $this->countOfMovements($userID);
        if ($countOfMovements * 10 >= $amountMoneyForLoan) {
            $stmt = $this->conn->prepare("UPDATE users SET money = money + ? WHERE id = ?");
            return $stmt->execute([$amountMoneyForLoan, $userID]) ?? false;
        }
        return false;
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
