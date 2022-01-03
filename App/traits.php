<?php

use PHPMailer\PHPMailer\PHPMailer;


/**
 * Data validation functionality
 */
trait dataValidation
{
    /**
     * Is safe password
     *
     * @param string $password
     * @return boolean
     */
    public function isSafePass(string $password): bool
    {
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);

        if (!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
            return false;
        }
        return true;
    }

    /**
     * Is there Email
     *
     * @param string $email
     * @return boolean
     */
    public function isExistEmail(string $email): bool
    {
        $sql = "SELECT COUNT(id) AS id FROM {$this->tableName} WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);
        if ($stmt->fetch(PDO::FETCH_ASSOC)['id']) {
            return true;
        }
        return false;
    }

    /**
     * get user information from user
     *
     * @param [sting] $email
     * @return array
     */
    public function getUserByEmail($email): array
    {
        $sql = "SELECT * FROM {$this->tableName} WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?? null;
    }

    /**
     * update Password method use for reset password
     *
     * @param string $email
     * @param string $newPassword
     * @return boolean
     */
    public function updatePassword(string $email, string $newPassword): bool
    {
        $newPassEncode = password_hash($newPassword, PASSWORD_BCRYPT);
        $sql = "UPDATE {$this->tableName} SET password = :password WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':password' => $newPassEncode, ':email' => $email]) ?? false;
    }
}

/**
 * Notification functionality
 */
trait notification
{
    /**
     * Send Email Method use for sending email to user for registeration password
     *
     * @param string $userEmail
     * @return integer|null
     */
    public function sendEmail(string $userEmail): ?int
    {
        $this->resetPasswordCode = rand(100000, 999999);
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'belfiusbanking5@gmail.com';
            $mail->Password = 'belfius1234';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            $mail->SMTPAuth = true;
            $mail->CharSet = 'utf-8';
            $mail->FromName = 'Belfius Banking';
            $mail->ContentType = 'text/html;charset=utf-8';

            # Content 
            $mail->isHTML(true);
            $mail->addAddress($userEmail);
            $mail->Subject = "Reset Password | Belfius Banking";
            $userFullName = $this->getUserByEmail($userEmail)['fullname'];
            $body = "<section style='display:block; width: 70%; height: 50%; text-align:center; margin: 0 auto; border: 3px solid green; padding: 20px; background: linear-gradient(to top left, #39b385, #9be15d);'>
            <p>Hello dear <span class='name' style='font-size:25px; text-transform: uppercase;]'><b>{$userFullName}</b></span></p>
            <p>Use the code below to reset your password
            </p>
            <p style='font-weight: bold; font-size: 20px;'>{$this->resetPasswordCode}</p>
            <p style='font-weight: bold;'>
              If you don't tried to change your password, easily get rid of this
              message
            </p>
          </section>";
            $mail->Body = $body;

            $send = $mail->send();
            if ($send) {
                return $this->resetPasswordCode;
            }
        } catch (Exception $th) {
            die("Email Not Sended : " . $th->getMessage());
        }
        $mail->smtpClose();
    }
}
