<?php
trait dataValidation
{
    private function isSafePass(string $password): bool
    {
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);

        if (!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
            return false;
        }
        return true;
    }

    private function isExistEmail(string $email): bool
    {
        $sql = "SELECT id FROM {$this->tableName} WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);
        return @is_string($stmt->fetch(PDO::FETCH_ASSOC)['id']) ?? false;
    }
}
