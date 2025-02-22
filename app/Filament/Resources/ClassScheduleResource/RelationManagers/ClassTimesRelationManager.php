<?php

namespace App\Filament\Resources\ClassScheduleResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Events\ClassTimeCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class ClassTimesRelationManager extends RelationManager
{
    protected static string $relationship = 'classTimes';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('day')
                    ->label(__('Name'))
                    ->required()
                    ->options([
                        1 => __('Monday'),
                        2 => __('Tuesday'),
                        3 => __('Wednesday'),
                        4 => __('Thursday'),
                        5 => __('Friday'),
                        6 => __('Saturday'),
                        7 => __('Sunday'),
                    ]),
                Forms\Components\TimePicker::make('start_time')
                    ->label(__('Start Time'))
                    ->required(),
                Forms\Components\TimePicker::make('end_time')
                    ->label(__('End Time'))
                    ->required(),
                Forms\Components\Select::make('type')
                    ->label(__('Type'))
                    ->required()
                    ->options([
                        'static' => __('Static'),
                        'odd' => __('Odd'),
                        'even' => __('Even'),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\SelectColumn::make('day')
                    ->label(__('Name'))
                    ->options([
                        1 => __('Monday'),
                        2 => __('Tuesday'),
                        3 => __('Wednesday'),
                        4 => __('Thursday'),
                        5 => __('Friday'),
                        6 => __('Saturday'),
                        7 => __('Sunday'),
                    ]),
                Tables\Columns\TextColumn::make('start_time')
                    ->label(__('Start Time')),
                Tables\Columns\TextColumn::make('end_time')
                    ->label(__('End Time')),
                Tables\Columns\TextColumn::make('type')
                    ->label(__('Type'))
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'static' => 'gray',
                        'odd' => 'primary',
                        'even' => 'success',
                    })->formatStateUsing(fn(string $state): string => __(ucfirst($state))),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Class Times');
    }

    public static function getModelLabel(): string
    {
        return __('Class Time');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Class Times');
    }
}
