<?php
session_start();

require_once __DIR__ . '/../../../vendor/autoload.php';
include "../../Config/Database.php";

use App\Database;
use App\Core\FlashMessage;
use App\Controllers\LoginControl;
use App\Core\Validation;




$db = Database::getInstance($config)->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $email = $_POST["email"];
    $password = $_POST["password"];

    // التحقق من البيانات اذا كانت لا يوجد بها اي مشكلة
    // لو ظهر مشكلة نرسلها الي السيشن لتظظهر في صورة خطا
    // اذا لم يظهر اي شئ يتم استدعاء داله حفظ البيانات في الداتا بيز

    $result = new LoginControl( $email, $password, $db);

    if ($result->check_data() == null) {
        $message=$result->check_data_base();
       if ($message === "تم تسجيل الدخول بنجاح"){

             FlashMessage::set_message("success", $message);
           header("Location: ../../../index.php");
        exit();



        }else{
                FlashMessage::set_message("danger", $message);
        header("Location: ../../../index.php?page=account");
        exit();
        }

       
    } else {
        FlashMessage::set_message("danger", $result->check_data());
        header("Location: ../../../index.php?page=account");
        exit();
    }
}
?>