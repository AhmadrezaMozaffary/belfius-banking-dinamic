<?php

namespace App;

// include "Connection.php";

include "interfaces.php";
include "traits.php";
include "../configs/dataConfigs.php";
class Auth extends Connection implements \Authable
{
    use \dataValidation;
    private string $tableName = "users";
    # This constructor method use for connection to database
    public function __construct()
    {
        $this->connection();
    }
    public function login()
    {
    }

    /**
     * Register method
     *
     * @param [string:email , string:fullname , string:password , string:reset passwrod , int:currency , string:locail] $data
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
                'msg'  => "Your Currecy isn't valid , Please close your Developer Tools :D",
                'bool' => false
            ];
            return $registerInfo;
        }
        # Check locail is set or isn't set
        $locail = null;
        isset($data['locail']) and !empty($data['locail']) ? $locail = $data['locail'] : $locail = null;
        # Adding process to the dataBase
        !is_null($locail) ? $sql = "INSERT INTO {$this->tableName} (email , fullname , password , curency , locail) VALUES (:email , :fullname , :password , :curency , :locail)"
            : $sql = "INSERT INTO {$this->tableName} (email , fullname , password , curency ) VALUES (:email , :fullname , :password , :curency)";

        $stmt = $this->conn->prepare($sql);
        if (!is_null($locail)) {
            $result = $stmt->execute([
                ':email' => $data['email'], ':fullname' => $data['fullname'], ':password' => $data['password'], ':curency' => $data['currencies'], ':locail' => $data['locail']
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
                ':email' => $data['email'], ':fullname' => $data['fullname'], ':password' => $data['password'], ':curency' => $data['currencies']
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
}
