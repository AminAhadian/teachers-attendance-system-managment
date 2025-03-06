<?php

namespace App\Filament\Pages;

use App\Models\Teacher;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class Dashboard extends \Filament\Pages\Dashboard
{
    use HasFiltersForm;

    public function filtersForm(Form $form): Form
    {
        return $form->schema([
            Section::make(__('Filters'))
                ->description(__('Use this section to filter your data'))
                ->icon('heroicon-m-funnel')
                ->schema([
                    Select::make('teacher_id')
                        ->label(__('Teacher'))
                        ->options(Teacher::all()->pluck('user.name', 'id'))
                        ->preload()
                        ->searchable(),
                    DatePicker::make('start_date')
                        ->label(__('Start Date'))
                        ->jalali(),
                    DatePicker::make('end_date')
                        ->label(__('End Date'))
                        ->jalali()
                ])->columns(3),
        ]);
    }
}
