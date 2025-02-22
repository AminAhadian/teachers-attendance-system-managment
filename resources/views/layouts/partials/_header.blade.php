<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

        <a href="{{ route('index') }}" class="logo d-flex align-items-center ms-auto">
            <!-- Uncomment the line below if you also wish to use an image logo -->
            <img src="{{ asset('assets/img/custom-5.png') }}" alt="">
            <h5 class="sitename me-4">سامانه جامع اساتید دانشگاه آزاد اسلامی سبزوار</h5>
        </a>

        <a class="btn-getstarted flex-md-shrink-0 d-none d-sm-block" href="{{ route('filament.teacher.auth.login') }}">ورود به سامانه</a>

    </div>
</header>
