<?php
session_start();

require_once __DIR__ . '/../../../vendor/autoload.php';
include "../../Config/Database.php";

use App\Database;
use App\Core\FlashMessage;
use App\Controllers\RegisterControl;
use App\Core\Validation;




$db = Database::getInstance($config)->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fristname = $_POST["fristname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // التحقق من البيانات اذا كانت لا يوجد بها اي مشكلة
    // لو ظهر مشكلة نرسلها الي السيشن لتظظهر في صورة خطا
    // اذا لم يظهر اي شئ يتم استدعاء داله حفظ البيانات في الداتا بيز

    $result = new RegisterControl($fristname, $lastname, $email, $password, $db);

    if ($result->check_data() == null) {
         $result->savedataData();

        FlashMessage::set_message("success", "تم التسجيل بنجاح");
        header("Location: ../../../index.php");
        exit();
    } else {
        FlashMessage::set_message("danger", $result->check_data());
        header("Location: ../../../index.php?page=account");
        exit();
    }
}
