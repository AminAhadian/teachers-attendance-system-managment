<?php

namespace App\Filament\AttendanceManager\Resources;

use Filament\Forms;
use App\Enum\Status;
use App\Models\User;
use Filament\Tables;
use App\Models\Review;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ClassSession;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\AttendanceManager\Resources\ReviewResource\Pages;
use App\Filament\AttendanceManager\Resources\ReviewResource\RelationManagers;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                Forms\Components\Select::make('head_manager_id')
                    ->options(User::role('headManager')->pluck('name', 'id'))
                    ->preload()
                    ->searchable(),
                Forms\Components\Select::make('attendance_manager_decision')
                    ->otipns([
                        Status::Completed->value => Status::Completed->value,
                        Status::Cancelled->value => Status::Cancelled->value,
                        Status::RequiresHeadManagerReview->value => Status::RequiresHeadManagerReview->value,
                    ]),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('teacher.personnel_code')
                    ->sortable(),
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
}
