<?php

namespace App\Filament\AttendanceManager\Resources;

use Filament\Forms;
use App\Enum\Status;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\AbsenceList;
use App\Models\ClassSession;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\AttendanceManager\Resources\AbsenceListResource\Pages;
use App\Filament\AttendanceManager\Resources\AbsenceListResource\RelationManagers;

class AbsenceListResource extends Resource
{
    protected static ?string $model = ClassSession::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('status', Status::Absent->value);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Session Name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('classTime.classSchedule.name')
                    ->label(__('Class Name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('teacher.user.name')
                    ->label(__('Teacher'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('teacher_enter_at')
                    ->label(__('Teacher Entery'))
                    ->placeholder(__('No Data')),
                Tables\Columns\TextColumn::make('teacher_exit_at')
                    ->label(__('Teacher Exit'))
                    ->placeholder(__('No Data')),
                Tables\Columns\TextColumn::make('date')
                    ->label(__('Date'))
                    ->searchable()
                    ->jalaliDate('j/F/Y'),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('Status'))
                    ->badge()
                    ->color(fn(string $state): string => Status::from($state)->color())
                    ->formatStateUsing(fn(string $state): string => __($state)),
            ])
            ->filters([
                //
            ])
            ->actions([])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAbsenceLists::route('/'),
        ];
    }

    public static function getModelLabel(): string
    {
        return __('Absence List');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Absences List');
    }
}
