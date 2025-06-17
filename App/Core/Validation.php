<?php
namespace App\Core;
class Validation
{

    public static function validateRequired(string $value, string $fieldName): ?string
    {

        return empty($value) ?  "يلزم ادخال $fieldName" : null;
    }

    public static function validateFullName(string $name): ?string
    {

        return preg_match('/^[\p{Arabic}a-zA-Z ]{3,50}$/u', $name)? null: "خطأ في الاسم: يُسمح فقط بالأحرف العربية أو الإنجليزية والمسافات. لا تُستخدم الأرقام أو الرموز الخاصة.";
    }
    public static function validateEmail(string $email): ?string
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) ? null : "صيغة الإيميل غير صحيحة";
    }

    public static function validatePassword(string $pass): ?string
    {


        return preg_match('/^.{6,}$/', $pass) ? null : "اقل عدد حروف للباسورد 6 ؤواستخدم حروف انجلزيه";
    }

    // register validations

    public static function validateRegister(string $name, string $email, string $pass): ?string
    {


        $user_data = [
            "الاسم كامل" => $name,
            "الايميل" => $email,
            "الباسورد" => $pass

        ];

        foreach ($user_data as $fieldName => $value) {
            if ($error = self::validateRequired($value, $fieldName)) {
                return $error;
            }
        }
        if ($error = self::validateFullName($name)) {
            return $error;
        }

        if ($error = self::validateEmail($email)) {
            return $error;
        }

        if ($error = self::validatePassword($pass)) {
            return $error;
        }
        return null;
    }

    public static function validatelogin( string $email,string $pass): ?string
    {
    $login_data=[
        "الايميل"=>$email,
        "كلمة المرور"=>$pass

    ];

    foreach($login_data as $fieldName=>$value){

        if($error=self::validateRequired($value,$fieldName)){
            return $error;
        }
    }
    if ($error = self::validateEmail($email)) {
        return $error;
    }

    if ($error = self::validatePassword($pass)) {
        return $error;
    }
return null;
}
}
