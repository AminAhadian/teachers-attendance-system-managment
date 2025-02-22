<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Enum\Status;
use App\Models\User;
use Filament\Tables;
use App\Models\Review;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ReviewResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ReviewResource\RelationManagers;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 4;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('class_session_id')
                    ->relationship('classSession', 'name')
                    ->required()
                    ->preload()
                    ->searchable(),
                Forms\Components\Select::make('teacher_id')
                    ->relationship('teacher', 'id')
                    ->required(),
                Forms\Components\Select::make('attendance_manager_id')
                    ->required()
                    ->options(User::role('attendanceManager')->pluck('name', 'id')),
                Forms\Components\Select::make('attendance_manager_decision')
                    ->otipns([
                        Status::Completed->value => Status::Completed->value,
                        Status::Cancelled->value => Status::Cancelled->value,
                        Status::RequiresHeadManagerReview->value => Status::RequiresHeadManagerReview->value,
                    ]),
                Forms\Components\Select::make('head_manager_id')
                    ->options(User::role('headManager')->pluck('name', 'id'))
                    ->preload()
                    ->searchable(),
                Forms\Components\Select::make('head_manager_decision')
                    ->otipns([
                        Status::Approved->value => Status::Approved->value,
                        Status::Cancelled->value => Status::Cancelled->value,
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('classSession.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('teacher.personnel_code')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('attendanceManager.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('attendance_manager_decision')
                    ->searchable(),
                Tables\Columns\TextColumn::make('headManager.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('head_manager_decision')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
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
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListReviews::route('/'),
            'create' => Pages\CreateReview::route('/create'),
            'edit' => Pages\EditReview::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return __('Review List');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Reviews List');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Reports');
    }
}
