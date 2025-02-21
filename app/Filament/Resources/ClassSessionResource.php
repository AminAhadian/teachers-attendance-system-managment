<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Enum\Status;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ClassSession;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ClassSessionResource\Pages;
use App\Filament\Resources\ClassSessionResource\RelationManagers;

class ClassSessionResource extends Resource
{
    protected static ?string $model = ClassSession::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('Name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('class_time_id')
                    ->label(__('Class Time'))
                    ->relationship('classTime', 'id')
                    ->required(),
                Forms\Components\Select::make('teacher_id')
                    ->label(__('Teacher'))
                    ->relationship('teacher', 'id')
                    ->required(),
                Forms\Components\TimePicker::make('actual_start_time')
                    ->label(__('Actual Start Time')),
                Forms\Components\TimePicker::make('actual_end_time')
                    ->label(__('Actual End Time')),
                Forms\Components\DatePicker::make('date')
                    ->label(__('Date'))
                    ->jalali(),
                Forms\Components\Select::make('status')
                    ->label(__('Status'))
                    ->required()
                    ->options([
                        Status::SCHEDULED() => Status::SCHEDULED(),
                        Status::ENTER_ONLY() => Status::ENTER_ONLY(),
                        Status::COMPLETED() => Status::COMPLETED(),
                        Status::CANCELLED() => Status::CANCELLED(),
                        Status::POSTPONDED() => Status::POSTPONDED(),
                        Status::ABSENT() => Status::ABSENT(),
                    ]),
                Forms\Components\Toggle::make('is_active')
                    ->label(__('Active'))
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
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
                Tables\Columns\SelectColumn::make('status')
                    ->label(__('Status'))
                    ->options([
                        Status::SCHEDULED() => Status::SCHEDULED(),
                        Status::ENTER_ONLY() => Status::ENTER_ONLY(),
                        Status::COMPLETED() => Status::COMPLETED(),
                        Status::CANCELLED() => Status::CANCELLED(),
                        Status::POSTPONDED() => Status::POSTPONDED(),
                        Status::ABSENT() => Status::ABSENT(),
                    ]),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('Active'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
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
            'index' => Pages\ListClassSessions::route('/'),
            'create' => Pages\CreateClassSession::route('/create'),
            'edit' => Pages\EditClassSession::route('/{record}/edit'),
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
        return __('Class Session');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Class Sessions');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Classes Managment');
    }
}
