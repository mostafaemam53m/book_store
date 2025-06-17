<?php
require __DIR__ . "/../../Config/Database.php";
use App\Database;
use App\Core\FlashMessage;
// session_start();
 

$db = Database::getInstance($config)->getConnection();

// التحقق من إرسال البيانات
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // التحقق من وجود البيانات
    if (empty($email) || empty($password)) {
        // die('');
        FlashMessage::set_message("danger","حقل الايميل او كلمة المرور فارغ");
    }

    // تجهيز الاستعلام
    $stmt = $db->prepare("SELECT * FROM adminuser WHERE AdminEmail = :email LIMIT 1");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && $admin['Password'] == $password && $admin['Active']) {
        // تسجيل دخول ناجح
        $_SESSION['admin_id'] = $admin['AdminId'];
        $_SESSION['admin_name'] = $admin['AdminName'];
        header("Location: index.php?page=dashboard");
        exit();
    } else {
          FlashMessage::set_message("danger","الايميل او الباسورد غير موجود");
    }
} else {
     FlashMessage::set_message("danger", "خطأ في الطلب");
}
?>
