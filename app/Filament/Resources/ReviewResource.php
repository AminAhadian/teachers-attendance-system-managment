<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Enum\Status;
use App\Models\User;
use Filament\Tables;
use App\Models\Review;
use App\Models\Teacher;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ClassSession;
use Filament\Resources\Resource;
use Illuminate\Support\Collection;
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('head_manager_id', auth()->id());
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('class_session_id')
                    ->label(__('Class Session'))
                    ->options(ClassSession::whereStatus(['Absent', 'Enter_Only'])->pluck('name', 'id'))
                    ->required()
                    ->preload()
                    ->live()
                    ->searchable()
                    ->afterStateUpdated(function ($state, Set $set) {
                        $classSession = ClassSession::find($state);
                        if ($classSession) {
                            $set('teacher_id', $classSession->teacher_id);
                        } else {
                            $set('teacher_id', null);
                        }
                    })
                    ->disabled(),
                Forms\Components\Select::make('teacher_id')
                    ->label(__('Teacher'))
                    ->options(fn(Get $get): Collection => Teacher::query()->where('id', $get('teacher_id'))->with('user')->get()->pluck('user.name', 'id'))
                    ->required()
                    ->disabled()
                    ->dehydrated(),
                Forms\Components\Select::make('attendance_manager_decision')
                    ->label(__('Attendance Manager Decision'))
                    ->options(Status::attendanceManagerOptions())
                    ->disabled(),
                Forms\Components\Select::make('head_manager_decision')
                    ->label(__('Head Manager Decision'))
                    ->options(Status::headManagerOptions()),
                Forms\Components\TextArea::make('description')
                    ->label(__('Description'))
                    ->nullable()
                    ->columnSpanFull()
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('classSession.name')
                    ->label(__('Class Session'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('teacher.user.name')
                    ->label(__('Teacher'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('attendanceManager.name')
                    ->label(__('Attendance Manager'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('attendance_manager_decision')
                    ->label(__('Attendance Manager Decision'))
                    ->badge()
                    ->color(fn(string $state): string => Status::from($state)->color())
                    ->formatStateUsing(fn(string $state): string => __($state)),
                Tables\Columns\TextColumn::make('headManager.name')
                    ->label(__('Head Manager'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('head_manager_decision')
                    ->label(__('Head Manager Decision'))
                    ->placeholder(__('No Data'))
                    ->badge()
                    ->color(fn(string $state): string => Status::from($state)->color())
                    ->formatStateUsing(fn(string $state): string => __($state)),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('Status'))
                    ->badge()
                    ->color(fn(string $state): string => Status::from($state)->color())
                    ->formatStateUsing(fn(string $state): string => __($state)),
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
