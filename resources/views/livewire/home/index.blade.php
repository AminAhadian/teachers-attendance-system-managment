<div>
    <!-- Hero Section -->
    <section id="hero" class="hero section">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center">
                    <h1 data-aos="fade-up" wire:ignore>سامانه جامع حضور و غیاب اساتید </h1>
                    <p data-aos="fade-up" data-aos-delay="100" wire:ignore>دانشگاه آزاد اسلامی واحد سبزوار</p>

                    <div class="mt-5">
                        <h4>ثبت حضور با یک اسکن ساده</h4>
                        <p>لطفاً با قرار دادن کد QR خود در مقابل دستگاه، حضور خود را ثبت کنید.</p>
                        <div class="php-email-form">
                            <div class="qr-code-form" x-data x-init="$refs.attendanceCode.focus()">
                                <input type="text" autofocus id="attendanceCode" x-ref="attendanceCode"
                                    name="attendanceCode" maxlength="10" autofocus wire:model='attendanceCode'
                                    wire:change='save' placeholder="کد حضور و غیاب">
                            </div>
                            @error('attendanceCode')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex flex-column flex-md-row mt-4" data-aos="fade-up" data-aos-delay="200"
                        wire:ignore>
                        <a href="{{ route('filament.teacher.auth.login') }}" class="btn-get-started text-bold">ورود به
                            سامانه</a>
                    </div>
                </div>
                <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-out" wire:ignore wire:ignore>
                    <img src="{{ asset('assets/img/hero-img-1.png') }}" class="img-fluid animated" alt="">
                </div>
            </div>
        </div>

    </section><!-- /Hero Section -->
</div>
