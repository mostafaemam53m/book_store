<?php

namespace App\Controllers;

use App\Core\Validation;

use PDO;

class ComforimOldPass
{



    public static function VerifyOldPassword($oldPass, $UserId, $db)

    {
        if ($db instanceof PDO) {
            return false;
        }


        // التحقق من وجود المستخدمs
        $checkStmt = $db->prepare("SELECT * FROM user WHERE UserId = :UserId");
        $checkStmt->execute([':UserId' => $UserId]);
        $user = $checkStmt->fetch(PDO::FETCH_ASSOC);



        if (!$user) {
            return "المستخدم غير موجود";
        }

        // تحقق من كلمة المرور باستخدام password_verify
        if (!password_verify($oldPass, $user['password'])) {
            return "كلمة المرور القديمة غير صحيحة.";
        }

        return null;
    }

    public static function Validation_new_pass1($new_pass1)
    {

        if ($error = Validation::validatePassword($new_pass1)) {
            return $error;
        }
    }
    public static function Validation_new_pass2($new_pass2)
    {

        if ($error = Validation::validatePassword($new_pass2)) {
            return $error;
        }
    }

    public static function ComparePasswords($new_pass1, $new_pass2)
    {
        if ($new_pass1 !== $new_pass2) {
            return "كلمتا المرور غير متطابقتين.";
        }
        return null;
    }
}
