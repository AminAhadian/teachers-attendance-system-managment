@extends('layouts.errors')

@section('title', '403 - عدم دسترسی')

@section('content')
    <!-- Hero Section -->
    <section id="hero" class="hero section">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center">
                    <h1 class="mb-4" data-aos="fade-up">403</h1>
                    <h3 data-aos="fade-up">سامانه جامع حضور و غیاب اساتید </h3>
                    <p data-aos="fade-up" data-aos-delay="100">دانشگاه آزاد اسلامی واحد سبزوار</p>
                    <p data-aos="fade-up" data-aos-delay="100">عدم دسترسی</p>

                    <div class="d-flex flex-column flex-md-row mt-4" data-aos="fade-up" data-aos-delay="200">
                        <a href="{{ route('filament.teacher.auth.login') }}" class="btn-get-started text-bold">ورود
                            به
                            سامانه</a>
                    </div>
                </div>
                <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-out">
                    <img src="{{ asset('assets/img/403.png') }}" class="img-fluid animated" alt="">
                </div>
            </div>
        </div>

    </section><!-- /Hero Section -->
@endsection
