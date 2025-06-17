<!--    -->
<nav class="nav">
  <div class="section-container w-100 d-flex align-items-center gap-4 h-100">
    <div class="nav__categories-btn align-items-center justify-content-center rounded-1 d-none d-lg-flex">
      <button class="border-0 bg-transparent" data-bs-toggle="offcanvas" data-bs-target="#nav__categories">
        <i class="fa-solid fa-align-center fa-rotate-180"></i>
      </button>
    </div>
    <div class="nav__logo">
      <a href="index.php?page=home">
        <img class="h-100" src="App/assets/images/logo.png" alt="">
      </a>
    </div>
    <div class="nav__search w-100">
      <input class="nav__search-input w-100" type="search" placeholder="أبحث هنا عن اي شئ تريده...">
      <span class="nav__search-icon">
        <i class="fa-solid fa-magnifying-glass"></i>
      </span>
    </div>
    <ul class="nav__links gap-3 list-unstyled d-none d-lg-flex m-0">
    <?php if (!isset($_SESSION["user_data"])): ?>
  <!-- عرض رابط تسجيل الدخول إذا لم يكن هناك بيانات في الجلسة -->
  <li class="nav__link">
    <a class="d-flex align-items-center gap-2" href="index.php?page=account">
      تسجيل الدخول
      <i class="fa-regular fa-user"></i>
    </a>
  </li>
<?php else: ?>
  <!-- عرض أيقونة واسم المستخدم إذا كانت بيانات الجلسة موجودة -->
  <li class="nav__link">
    <a class="d-flex align-items-center gap-2" href="index.php?page=profile">
      <i class="fa-regular fa-user"></i>
      <?php 
        echo htmlspecialchars($_SESSION["user_data"]["UserFirstName"] . ' ' . $_SESSION["user_data"]["UserLastName"]); 
      ?>
    </a>
  </li>
<?php endif; ?>

      
      <li class="nav__link">
        <a class="d-flex align-items-center gap-2" href="index.php?page=favourites">
          المفضلة
          <div class="position-relative">
            <i class="fa-regular fa-heart"></i>
            <div class="nav__link-floating-icon">0</div>
          </div>
        </a>
      </li>
      <li class="nav__link">
        <a class="d-flex align-items-center gap-2" data-bs-toggle="offcanvas" data-bs-target="#nav__cart">
          عربة التسوق
          <div class="position-relative">
            <i class="fa-solid fa-cart-shopping"></i>
            <div class="nav__link-floating-icon">0</div>
          </div>
        </a>
      </li>
    </ul>
  </div>

  <div class="nav-mobile fixed-bottom d-block d-lg-none">
    <ul class="nav-mobile__list d-flex justify-content-around gap-2 list-unstyled  m-0 border-top">
      <li class="nav-mobile__link">
        <a class="d-flex align-items-center flex-column gap-1 text-decoration-none" href="index.php?page=home">
          <i class="fa-solid fa-house"></i>
          الرئيسية
        </a>
      </li>
      <li class="nav-mobile__link d-flex align-items-center flex-column gap-1" data-bs-toggle="offcanvas"
        data-bs-target="#nav__categories">
        <i class="fa-solid fa-align-center fa-rotate-180"></i>
        الاقسام
      </li>
      <li class="nav-mobile__link d-flex align-items-center flex-column gap-1">
        <a class="d-flex align-items-center flex-column gap-1 text-decoration-none" href="index.php?page=profile">
          <i class="fa-regular fa-user"></i>
          حسابي 
        </a>
      </li>
      <li class="nav-mobile__link d-flex align-items-center flex-column gap-1">
        <a class="d-flex align-items-center flex-column gap-1 text-decoration-none" href="index.php?page=favourites">
          <i class="fa-regular fa-heart"></i>
          المفضلة 
        </a>
      </li>
      <li class="nav-mobile__link d-flex align-items-center flex-column gap-1" data-bs-toggle="offcanvas"
        data-bs-target="#nav__cart">
        <i class="fa-solid fa-cart-shopping"></i>
        السلة
      </li>
    </ul>
  </div>
</nav>

<div class="nav__categories offcanvas offcanvas-start px-4 py-2" tabindex="-1" id="nav__categories"
  aria-labelledby="nav__categories">
  <div class="nav__categories-header offcanvas-header justify-content-end">
    <button type="button" class="border-0 bg-transparent text-danger nav__close" data-bs-dismiss="offcanvas"
      aria-label="Close">
      <i class="fa-solid fa-x fa-1x fw-light"></i>
    </button>
  </div>
  <div class="nav__categories-body offcanvas-body pt-0">
    <div class="nav__side-logo mb-2">
      <img class="w-100" src="App/assets/images/logo.png" alt="logo">
    </div>
    <ul class="nav__list list-unstyled">
      <li class="nav__link nav__side-link"><a href="index.php?page=shop" class="py-3">جميع المنتجات</a></li>
      <li class="nav__link nav__side-link"><a href="index.php?page=shop" class="py-3">كتب عربيه</a></li>
      <li class="nav__link nav__side-link"><a href="index.php?page=shop" class="py-3">كتب انجليزية</a></li>
    </ul>
  </div>
</div>

<div class="nav__cart offcanvas offcanvas-end px-3 py-2" tabindex="-1" id="nav__cart" aria-labelledby="nav__cart">
  <div class="nav__categories-header offcanvas-header align-items-center">
    <h5>سلة التسوق</h5>
    <button type="button" class="border-0 bg-transparent text-danger nav__close" data-bs-dismiss="offcanvas"
      aria-label="Close">
      <i class="fa-solid fa-x fa-1x fw-light"></i>
    </button>
  </div>
  <div class="nav__categories-body offcanvas-body pt-4">
    <p>لا توجد منتجات في سلة المشتريات.</p>
    <div class="cart-products">
      <ul class="nav__list list-unstyled">
        <li class="cart-products__item d-flex justify-content-between gap-2">
          <div class="d-flex gap-2">
            <div>
              <button class="cart-products__remove">x</button>
            </div>
            <div>
              <p class="cart-products__name m-0 fw-bolder">Flutter Apprentice</p>
              <p class="cart-products__price m-0">1 x 350.00 جنيه</p>
            </div>
          </div>
          <div class="cart-products__img">
            <img class="w-100" src="App/assets/images/product-1.webp" alt="">
          </div>
        </li>
      </ul>
      <div class="d-flex justify-content-between">
        <p class="fw-bolder">المجموع:</p>
        <p>350.00 جنيه</p>
      </div>
    </div>
    <button class="nav__cart-btn text-center text-white w-100 border-0 mb-3 py-2 px-3 bg-success">اتمام الطلب</button>
    <button class="nav__cart-btn text-center w-100 py-2 px-3 bg-transparent">تابع التسوق</button>
  </div>
</div>

<!-- News Content Start -->
<section class="sales text-center p-2 d-block d-lg-none">
  شحن مجاني للطلبات 💥 عند الشراء ب 699ج او اكثر
</section>
<!-- News Content End -->
</div>
<!-- Header Content End -->
  
<main class="pt-4">
