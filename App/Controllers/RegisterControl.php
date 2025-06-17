<?php

namespace App\Controllers;

use App\Core\Validation;
 // use Validation as GlobalValidation;
use PDO;




class RegisterControl
{
    public  $userId;
    public string $firstName;
    public string $lastName;
    private string $email;
    private string $password;
    public $db;

    public function __construct(string $firstName, string $lastName, string $email, string $password, $db)
    {
         $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->db = $db;
    }

    public function check_data(): ?string
    {
        $myarry = [
            "الاسم الاول" => $this->firstName,
            "الاسم الاخير" => $this->lastName,
            "الايميل" => $this->email,
            "كلمة المرور" => $this->password
        ];

        foreach ($myarry as $index => $value) {
            $result = Validation::validateRequired($value, $index);
            if ($result) {
                return $result;
            }
        }

        if ($error = Validation::validateFullName($this->firstName)) return $error;
        if ($error = Validation::validateFullName($this->lastName)) return $error;
        if ($error = Validation::validateEmail($this->email)) return $error;
        if ($error = Validation::validatePassword($this->password)) return $error;

        return null;
    }

    public function savedataData(): string|bool
    {
        if (!$this->db instanceof PDO) {
            return false;
        }

        try {
            $checkStmt = $this->db->prepare("SELECT COUNT(*) FROM user WHERE UserEmail = :email");
            $checkStmt->execute([':email' => $this->email]);
            $count = $checkStmt->fetchColumn();

            if ($count > 0) {
                return "البريد الإلكتروني موجود بالفعل";
            }

            $stmt = $this->db->prepare("INSERT INTO user (UserFirstName, UserLastName, UserEmail, UserPassword) VALUES (:UserFirstName, :UserLastName, :UserEmail, :UserPassword)");

            $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);

            $stmt->execute([
                ':UserFirstName' => $this->firstName,
                ':UserLastName' => $this->lastName,
                ':UserEmail' => $this->email,
                ':UserPassword' => $hashedPassword
            ]);

            $_SESSION["user_data"] = [
                'UserFirstName' => $this->firstName,
                'UserLastName' => $this->lastName,
                'UserEmail' => $this->email
            ];

            return true;
        } catch (\PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

public function EditData(int $userId, string $firstName, string $lastName, string $email, string $password): string|bool
{
    if (!$this->db instanceof PDO) {
        return false;
    }

    try {
        // التحقق من وجود المستخدمs
        $checkStmt = $this->db->prepare("SELECT * FROM user WHERE UserId = :UserId");
        $checkStmt->execute([':UserId' => $userId]);
        $user = $checkStmt->fetch();

        if (!$user) {
            return "المستخدم غير موجود";
        }

        // التحقق من أن البريد الإلكتروني غير مستخدم من قبل مستخدم آخر
        $emailCheckStmt = $this->db->prepare("SELECT * FROM user WHERE UserEmail = :UserEmail AND UserId != :UserId");
        $emailCheckStmt->execute([
            ':UserEmail' => $email,
            ':UserId' => $userId
        ]);
        if ($emailCheckStmt->fetch()) {
            return "البريد الإلكتروني مستخدم من قبل مستخدم آخر";
        }

        // تحديث البيانات حسب وجود كلمة المرور
        if (!empty($password)) {
            $stmt = $this->db->prepare("UPDATE user 
                SET UserFirstName = :UserFirstName, 
                    UserLastName = :UserLastName, 
                    UserEmail = :UserEmail, 
                    UserPassword = :UserPassword 
                WHERE UserId = :UserId");

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt->execute([
                ':UserFirstName' => $firstName,
                ':UserLastName' => $lastName,
                ':UserEmail' => $email,
                ':UserPassword' => $hashedPassword,
                ':UserId' => $userId
            ]);
        } else {
            $stmt = $this->db->prepare("UPDATE user 
                SET UserFirstName = :UserFirstName, 
                    UserLastName = :UserLastName, 
                    UserEmail = :UserEmail 
                WHERE UserId = :UserId");

            $stmt->execute([
                ':UserFirstName' => $firstName,
                ':UserLastName' => $lastName,
                ':UserEmail' => $email,
                ':UserId' => $userId
            ]);
        }

        // تحديث بيانات الجلسة
        $_SESSION["user_data"] = [
            'UserId' => $userId,
            'UserFirstName' => $firstName,
            'UserLastName' => $lastName,
            'UserEmail' => $email
        ];

        return true;
    } catch (\PDOException $e) {
        error_log($e->getMessage());
        return false;
    }
}


}
