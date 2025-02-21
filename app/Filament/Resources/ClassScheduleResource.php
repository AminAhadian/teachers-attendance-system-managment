<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Teacher;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ClassSchedule;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ClassScheduleResource\Pages;
use App\Filament\Resources\ClassScheduleResource\RelationManagers;
use App\Filament\Resources\ClassScheduleResource\RelationManagers\ClassTimesRelationManager;

class ClassScheduleResource extends Resource
{
    protected static ?string $model = ClassSchedule::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('teacher_id')
                    ->required()
                    ->options(Teacher::with('user')->get()->pluck('user.name', 'id'))
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('term_id')
                    ->required()
                    ->relationship(name: 'term', titleAttribute: 'code')
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('code')
                    ->maxLength(255),
                Forms\Components\TextInput::make('presentation_code')
                    ->maxLength(255),
                Forms\Components\Select::make('educational_group_id')
                    ->relationship(name: 'educationalGroup', titleAttribute: 'name'),
                Forms\Components\DatePicker::make('start_date')
                    ->disabled()
                    ->dehydrated()
                    ->jalali(),
                Forms\Components\DatePicker::make('end_date')
                    ->disabled()
                    ->dehydrated()
                    ->jalali(),
                Forms\Components\TextInput::make('attendance_time_frame')
                    ->required()
                    ->numeric()
                    ->default(15),
                Forms\Components\TextInput::make('location')
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_active')
                    ->required()
                    ->inline(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('teacher.user.name')
                    ->label(__('Teacher'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('code')
                    ->label(__('Code'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('presentation_code')
                    ->label(__('Presentation Code'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('educationalGroup.name')
                    ->label(__('Educational Group'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('term.name')
                    ->label(__('Term'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('attendance_time_frame')
                    ->label(__('Attendance Time Frame'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('location')
                    ->label(__('Location'))
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('Active'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('Updated At'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->label(__('Deleted At'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            ClassTimesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClassSchedules::route('/'),
            'create' => Pages\CreateClassSchedule::route('/create'),
            'edit' => Pages\EditClassSchedule::route('/{record}/edit'),
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
        return __('Class Schedule');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Class Schedules');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Classes Managment');
    }
}
