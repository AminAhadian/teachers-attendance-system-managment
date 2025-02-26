<?php

namespace App\Filament\Teacher\Widgets;

use App\Enum\Status;
use Filament\Tables;
use App\Helper\Helper;
use Filament\Tables\Table;
use App\Models\ClassSession;
use Illuminate\Database\Eloquent\Builder;
use Filament\Widgets\TableWidget as BaseWidget;

class TeacherClassSessions extends BaseWidget
{
    protected static ?string $maxHeight = 'auto';
    protected int | string | array $columnSpan = 2;
    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->heading(__('Your Class Sessions'))
            ->emptyStateHeading(__('No Class Session Yet'))
            ->query(fn(ClassSession $query) => $query->where('teacher_id', auth()->user()->teacher->id))
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('classTime.classSchedule.name')
                    ->label(__('Class Name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('teacher_enter_at')
                    ->label(__('Teacher Entery'))
                    ->placeholder(__('No Data'))
                    ->dateTime('H:i:s'),
                Tables\Columns\TextColumn::make('teacher_exit_at')
                    ->label(__('Teacher Exit'))
                    ->placeholder(__('No Data'))
                    ->dateTime('H:i:s'),
                Tables\Columns\TextColumn::make('teacher_delay')
                    ->label(__('Teacher Delay'))
                    ->placeholder(__('No Data'))
                    ->formatStateUsing(fn(string $state): string => Helper::convertMinutesToHoursMinutes($state)),
                Tables\Columns\TextColumn::make('teacher_hurry')
                    ->label(__('Teacher Hurry'))
                    ->placeholder(__('No Data'))
                    ->formatStateUsing(fn(string $state): string => Helper::convertMinutesToHoursMinutes($state)),
                Tables\Columns\TextColumn::make('date')
                    ->label(__('Date'))
                    ->searchable()
                    ->jalaliDate('j/F/Y'),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('Status'))
                    ->badge()
                    ->color(fn(string $state): string => Status::from($state)->color())
                    ->formatStateUsing(fn(string $state): string => __($state)),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('Active'))
                    ->boolean(),
            ]);
    }
}
