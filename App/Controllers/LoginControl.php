<?php

namespace App\Controllers;

use App\Core\Validation;
// use Validation as GlobalValidation;
use PDO;
session_start();




class LoginControl
{
    private string $email;
    private string $password;
    public $db;

    public function __construct(string $email, string $password, $db)
    {

        $this->email = $email;
        $this->password = $password;
        $this->db = $db;
    }

    public function check_data(): ?string
    {
        $myarry = [

            "الايميل" => $this->email,
            "كلمة المرور" => $this->password
        ];

        foreach ($myarry as $index => $value) {
            $result = Validation::validateRequired($value, $index);
            if ($result) {
                return $result;
            }
        }


        if ($error = Validation::validateEmail($this->email)) return $error;
        if ($error = Validation::validatePassword($this->password)) return $error;

        return null;
    }

    public function check_data_base(): string|bool
    {
        if (!$this->db instanceof PDO) {
            return false;
        }

        try {
            $checkStmt = $this->db->prepare("SELECT COUNT(*) FROM user WHERE UserEmail = :email");
            $checkStmt->execute([':email' => $this->email]);
            $count = $checkStmt->fetchColumn();

            if ($count > 0) {
                $checkStmt = $this->db->prepare("SELECT * FROM user WHERE UserEmail = :email");
                $checkStmt->execute([':email' => $this->email]);
                $userData = $checkStmt->fetch(\PDO::FETCH_ASSOC);


                if ($userData["UserPassword"]) {
                    // تحقق من كلمة المرور المدخلة باستخدام password_verify
                    if (password_verify($this->password, $userData["UserPassword"])) {
                        $_SESSION["user_data"] = [
                            "UserId" => $userData["UserId"],
                            'UserFirstName' => $userData["UserFirstName"],
                            'UserLastName' => $userData["UserLastName"],
                            'UserEmail' => $userData["UserEmail"]
                        ];
                        //   كلمة المرور صحيحة
                        return "تم تسجيل الدخول بنجاح";
                    } else {

                        return "كلمة المرور غير صحيحة";
                    }
                }
            }



            return "هذا الايميل غير مسجل الرجاء انشاء حساب جديد";
        } catch (\PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}
