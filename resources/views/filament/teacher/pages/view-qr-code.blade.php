@php
    $isDarkMode = request()->cookie('dark_mode', false);
    $foregroundColor = $isDarkMode ? [255, 255, 255] : [0, 0, 0];
    $backgroundColor = $isDarkMode ? [0, 0, 0] : [255, 255, 255];
@endphp

<x-filament-panels::page>
    <x-filament::grid>
        <x-filament::section column="1">
            <x-slot name="heading">
                Qr Code
            </x-slot>

            <x-slot name="description">
                This is all the information we hold about the user.
            </x-slot>

            <div class="flex items-center justify-center">
                <div class="text-center" x-data="{ mode: 'light' }" x-on:dark-mode-toggled.window="mode = $event.detail">
                    <span x-show="mode === 'light'">
                        {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(350)->margin(2)->color(0, 0, 0)->backgroundColor(255, 255, 255)->generate($attendanceCode) !!}
                    </span>

                    <span x-show="mode === 'dark'">
                        {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(350)->margin(2)->color(255, 255, 255)->backgroundColor(0, 0, 0)->generate($attendanceCode) !!}
                    </span>
                    <div class="text-center">
                        <p class="mt-2">
                            {{ $attendanceCode }}
                        </p>
                    </div>
                </div>
            </div>
        </x-filament::section>
    </x-filament::grid>
</x-filament-panels::page>
