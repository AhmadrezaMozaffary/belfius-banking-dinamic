<?php

namespace App;

include "../vendor/autoload.php";

include "interfaces.php";
include "traits.php";
include "../configs/dataConfigs.php";

/**
 * Auth calss --- Authentication class
 * @property private string $tablename
 * @method public login(): bool
 * @method public signin(): array
 */
class Auth extends Connection implements \Authable
{
    use \dataValidation;
    use \notification;
    use \userFunctionality;

    private string $tableName = "users";
    private int $resetPasswordCode;

    # This constructor method use for connection to database
    public function __construct()
    {
        $this->connection();
    }
    /**
     * Login method
     * ?argument [string] user's email , [string] user's password 
     * @param [array] $data
     * @return array
     */
    public function login($data): bool
    {
        if (!$this->isExistEmail($data['email'])) {
            return false;
        }
        if (password_verify($data['password'], $this->getUserByEmail($data['email'])['password'])) {
            $_SESSION['userLogin'] = $this->getUserByEmail($data['email']);
            if (isset($_SESSION['userLogin'])) {
                return true;
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * Register method
     *
     * @param [string:email , string:fullname , string:password , string:reset passwrod , int:currency , string:locale] $data
     * @return array
     */
    public function signup($data): array
    {
        # Cheack if email exist.
        if ($this->isExistEmail($data['email'])) {
            $registerInfo = [
                'msg'  => "This email is already exsists!",
                'bool' => false
            ];
            return $registerInfo;
        }

        # Passwrod validation --- safe password : 8 digits , numbers , uppercases , lowercases
        if (!$this->isSafePass($data['password'])) {
            $registerInfo = [
                'msg'  => "Your password isn't safe, it must be 8 digits and 
                contains uppercase, lowercase and numbers",
                'bool' => false
            ];
            return $registerInfo;
        }
        # Cheack confirm password with itself passwrod
        if ($data['password'] != $data['resetPassword']) {
            $registerInfo = [
                'msg'  => "Your confirm password is not the same with entered password!",
                'bool' => false
            ];
            return $registerInfo;
        }

        # Currency Validation
        if (!($data['currencies'] >= 0) || !($data['currencies'] < sizeof(CURRENCY_CONFIG))) {
            $registerInfo = [
                'msg'  => "Please choose a currency :D",
                'bool' => false
            ];
            return $registerInfo;
        }

        # Encoding Password         
        $passEncoded = password_hash($data['password'], PASSWORD_BCRYPT);

        # Check locale is set or isn't set
        $locale = null;
        isset($data['locale']) and !empty($data['locale']) ? $locale = $data['locale'] : $locale = null;

        # Adding process to the dataBase
        !is_null($locale) ? $sql = "INSERT INTO {$this->tableName} (idCard ,email , fullname , password , curency , locale) VALUES (:idCard ,:email , :fullname , :password , :curency , :locale)"
            : $sql = "INSERT INTO {$this->tableName} (idCard , email , fullname , password , curency ) VALUES (:idCard , :email , :fullname , :password , :curency)";

        $stmt = $this->conn->prepare($sql);
        # Generate an idCard
        $idCard = rand(1000000000000000, 9999999999999999);
        # Executing query
        if (!is_null($locale)) {
            $result = $stmt->execute([
                ':idCard' => $idCard, ':email' => $data['email'], ':fullname' => $data['fullname'], ':password' => $passEncoded, ':curency' => $data['currencies'], ':locale' => $data['locale']
            ]);
            $result ? $registerInfo = [
                'msg'  => "Welcome to Our Website :D",
                'bool' => true
            ] :  $registerInfo = [
                'msg'  => "Unfortunatly , you aren't register , please try again :(",
                'bool' => false
            ];
        } else {
            $result = $stmt->execute([
                ':idCard' => $idCard, ':email' => $data['email'], ':fullname' => $data['fullname'], ':password' => $passEncoded, ':curency' => $data['currencies']
            ]);
            $result ? $registerInfo = [
                'msg'  => "Welcome to Our Website :D",
                'bool' => true
            ] :  $registerInfo = [
                'msg'  => "Unfortunatly , you aren't register , please try again :(",
                'bool' => false
            ];
        }
        return $registerInfo;
    }

    /**
     * lougout function
     *
     * @return void
     */
    public function lougout(): void
    {
        unset($_SESSION['userLogin']);
    }
}
