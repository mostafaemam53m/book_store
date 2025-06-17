<?php
session_start();

use App\Database;
use App\Core\FlashMessage;

require_once "vendor/autoload.php";
require_once "App/config/database.php";


// الاتصال بقاعدة البيانات
$db = Database::getInstance($config)->getConnection();




$page = $_GET['page'] ?? 'home';

$isAdminPage = in_array($page, [
    'admin',
    'dashboard',
    'category',
    'subcategory',
    'brands',
    'products',
    'shipping',
    'orders',
    'discount',
    'users',
    'pages',
    'create-brand',
    'create-category',
    'create-page',
    'create-product',
    'create-subcategory',
    'create-user',
    'payment-methods',
    'order-detail'
], true);


$pageTitle = match ($page) {
    'home' => 'الصفحة الرئيسية',
    'account' => 'تسجيل الدخول',
    'favourites' => 'المفضلة',
    'profile' => 'حسابي',
    'shop' => 'التسوق',
    'about' => 'عنا',
    'contact' => 'تواصل معنا',
    'privacy-policy' => 'سياسة الخصوصية',
    'refund-policy' => 'سياسة الاسترجاع',
    'track-order' => 'حالة الطلب',
    default => 'الصفحة غير موجودة'
};

//   حماية صفحات لوحة التحكم
if ($isAdminPage && $page !== 'admin' && !isset($_SESSION['admin_id'])) {
    header("Location: index.php?page=admin");
    exit();
}
// تضمين أجزاء الصفحة
/* -------------------------  Header & Nav  ------------------------- */

if ($isAdminPage) {
    // هيدر وفوتر مخصّصان للإدارة
    include __DIR__ . "/App/dashbored/header.php";
    // include __DIR__ . "/App/dashbored/nav.php"; // إن وُجد
} else {
    include __DIR__ . "/App/views/layouts/header.php";
    include __DIR__ . "/App/views/layouts/nav.php";
}
//  top prin flash message 
FlashMessage::get_message();



// Router


switch ($page) {
    case 'home':
        require 'home.php';
        break;

    case 'account':
        require 'App/views/pages/account.php';
        break;
    case 'orders':
        require 'App/views/pages/orders.php';
        break;
    case 'account_details':
        require 'App/views/pages/account_details.php';
        break;
    case 'logout':
        require 'App/views/auth/logout.php';
        break;

    case 'favourites':
        require 'App/views/pages/favourites.php';
        break;

    case 'profile':
        require 'App/views/pages/profile.php';
        break;

    case 'shop':
        require 'App/views/pages/shop.php';
        break;

    case 'about':
        require 'App/views/pages/about.php';
        break;

    case 'contact':
        require 'App/views/pages/contact.php';
        break;

    case 'privacy-policy':
        require 'App/views/pages/privacy-policy.php';
        break;

    case 'refund-policy':
        require 'App/views/pages/refund-policy.php';
        break;

    case 'track-order':
        require 'App/views/pages/track-order.php';
        break;
    case 'branches':
        require 'App/views/pages/branches.php';
        break;
    // admin dashbored
    case 'admin':
        require 'App/dashbored/login.php';
        break;

        case 'admin_login':
        require 'App/dashbored/auth/admin_login.php';
        break;

         case 'logout':
        require 'App/dashbored/auth/admin_loginout.php';
        break;

     case 'dashboard':
        require 'App/dashbored/dashboard.php';
        break;

    case 'category':
        require 'App/dashbored/categories.php';
        break;

    case 'subcategory':
        require 'App/dashbored/subcategory.php';
        break;

    case 'brands':
        require 'App/dashbored/brands.php';
        break;

    case 'products':
        require 'App/dashbored/products.php';
        break;

    case 'shipping':
        require 'App/dashbored/shipping.php';
        break;

    case 'orders':
        require 'App/dashbored/orders.php';
        break;

    case 'discount':
        require 'App/dashbored/discount.php';
        break;

    case 'users':
        require 'App/dashbored/users.php';
        break;

    case 'pages':
        require 'App/dashbored/pages.php';
        break;
    case 'create-brand':
        require 'App/dashbored/create-brand.php';
        break;
    case 'create-category':
        require 'App/dashbored/create-category.php';
        break;
    case 'create-page':
        require 'App/dashbored/create-page.php';
        break;
    case 'create-product':
        require 'App/dashbored/create-product.php';
        break;
    case 'create-subcategory':
        require 'App/dashbored/create-subcategory.php';
        break;
    case 'create-user':
        require 'App/dashbored/create-user.php';
        break;
    case 'payment-methods':
        require 'App/dashbored/payment-methods.php';
        break;
    case 'order-detail':
        require 'App/dashbored/order-detail.php';
        break;
    

    default:
        echo "<div class='container py-5'><div class='alert alert-danger'>Page not found!</div></div>";
        break;
}






/* -------------------------  Footer  ------------------------- */
if ($isAdminPage) {
    include __DIR__ . "/App/dashbored/footer.php";
} else {
    include __DIR__ . "/App/views/layouts/footer.php";
}
