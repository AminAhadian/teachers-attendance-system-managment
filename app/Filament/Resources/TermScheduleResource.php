<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\TermSchedule;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TermScheduleResource\Pages;
use App\Filament\Resources\TermScheduleResource\RelationManagers;

class TermScheduleResource extends Resource
{
    protected static ?string $model = TermSchedule::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('Name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('start_date')
                    ->label(__('Start Date'))
                    ->required()
                    ->jalali(),
                Forms\Components\DatePicker::make('end_date')
                    ->label(__('End Date'))
                    ->required()
                    ->jalali(),
                Forms\Components\TextInput::make('code')
                    ->label(__('Code'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('sessions_number')
                    ->label(__('Sessions Number'))
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->label(__('Start Date'))
                    ->jalaliDate(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label(__('End Date'))
                    ->jalaliDate(),
                Tables\Columns\TextColumn::make('sessions_number')
                    ->label(__('Sessions Number'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListTermSchedules::route('/'),
            'create' => Pages\CreateTermSchedule::route('/create'),
            'edit' => Pages\EditTermSchedule::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getModelLabel(): string
    {
        return __('Term Schedule');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Term Schedules');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Classes Managment');
    }
}
