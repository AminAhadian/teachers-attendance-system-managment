<?php

namespace App\Filament\Teacher\Pages;

use App\Models\User;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Infolists\Infolist;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\Section;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Concerns\InteractsWithInfolists;

class ViewQrCode extends Page implements HasInfolists
{
    use InteractsWithInfolists;

    protected static ?string $navigationIcon = 'heroicon-o-qr-code';

    protected static string $view = 'filament.teacher.pages.view-qr-code';

    public ?string $attendanceCode;

    public function mount()
    {
        $this->attendanceCode = auth()->user()->teacher->attendance_code;
    }

    public static function getNavigationLabel(): string
    {
        return __('View Qr Code');
    }

    public function getHeading(): string
    {
        return __('View Qr Code');
    }
}
