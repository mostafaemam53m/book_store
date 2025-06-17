<?php
session_start();

require_once __DIR__ . '/../../../vendor/autoload.php';
include "../../Config/Database.php";

use App\Database;
use App\Core\FlashMessage;
use App\Controllers\RegisterControl;
use App\Core\Validation;
use App\Controllers\ComforimOldPass;




$db = Database::getInstance($config)->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $UserId = $_POST["UserId"];
    $first_name = $_POST["UserFirstName"];
    $last_name = $_POST["UserLastName"];
    $email = $_POST["UserEmail"];
    $current_password = $_POST["current_password"];
    $new_password = $_POST["new_password"];
    $comforim_new_password = $_POST["comforim_new_password"];


    echo $UserId . "<br>";
    echo $first_name . "<br>";
    echo $last_name . "<br>";
    echo $email . "<br>";


    $result = new RegisterControl($first_name, $last_name, $email, $current_password, $db);

    // لتحقق من قيم الباسورد الثلاث
    $result1 = ComforimOldPass::VerifyOldPassword($current_password, $UserId, $db);
    $result2 = ComforimOldPass::Validation_new_pass1($new_password);
    $result3 = ComforimOldPass::Validation_new_pass2($comforim_new_password);
    $result4 = ComforimOldPass::ComparePasswords($new_password, $comforim_new_password);

    // تجميع النتائج
    $results = [$result1, $result2, $result3, $result4];

    // استخراج أول رسالة خطأ (string)
    $error_message = null;
    foreach ($results as $res) {
        if (is_string($res)) {
            $error_message = $res;
            break;
        }
    }




    if ($result->check_data() == null) {

        if ($error_message === null) {
            // كل الدوال رجعت true، نعدل البيانات
            $resul_of_Edit = $result->EditData($UserId, $first_name, $last_name, $email, $current_password);
            if ($resul_of_Edit === true) {
                FlashMessage::set_message("success", "تم تعديل البيانات بنجاح");
                  header("Location: ../../../index.php?page=account_details");
                  exit;
            } else {
                FlashMessage::set_message("danger", "حدث خطأ أثناء تعديل البيانات.");
                  header("Location: ../../../index.php?page=account_details");
                  exit;
            }
        } else {
            // في رسالة خطأ من الدوال
            FlashMessage::set_message("danger", $error_message);
              header("Location: ../../../index.php?page=account_details");
              exit;
        }
    } else {
        FlashMessage::set_message("danger", $resul_of_Edit);
        header("Location: ../../../index.php?page=account_details");
         exit();
    }


   
} else {
    FlashMessage::set_message("danger", $result->check_data());
    header("Location:  ../../../index.php?page=account_details");
    exit();
}
