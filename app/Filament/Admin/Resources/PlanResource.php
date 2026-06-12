<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PlanResource\Pages;
use App\Models\Plan;
use Filament\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class PlanResource extends Resource
{
    protected static ?string $model = Plan::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-credit-card';

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string
    {
        return __('filament.navigation.agencies');
    }

    public static function getModelLabel(): string
    {
        return __('plans.resource');
    }

    public static function getPluralModelLabel(): string
    {
        return __('plans.resource_plural');
    }

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('name')
                            ->label(__('plans.name'))
                            ->required()
                            ->maxLength(255),
                        TextInput::make('slug')
                            ->label(fn() => __('properties.slug'))
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->dehydrated()
                            ->disabled(
                                fn(string $operation): bool =>
                                $operation === 'create' || !auth()->user()->hasRole('superadmin')
                            )
                            ->helperText(fn() => __('properties.slug_edit_warning_plan')),
                        TextInput::make('listings_limit')
                            ->label(__('plans.listings_limit'))
                            ->numeric()
                            ->required(),
                        TextInput::make('price_eur')
                            ->label(__('plans.price_eur'))
                            ->numeric()
                            ->prefix('€')
                            ->required(),
                        TextInput::make('sort_order')
                            ->label(__('plans.sort_order'))
                            ->numeric()
                            ->default(0),
                        Toggle::make('is_active')
                            ->label(__('plans.is_active'))
                            ->default(true),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('plans.name'))
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(fn(string $state) => match (strtolower($state)) {
                        'starter'   => 'gray',
                        'pro'       => 'info',
                        'unlimited' => 'warning',
                        default     => 'gray',
                    }),
                TextColumn::make('slug')
                    ->label(__('plans.slug'))
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('listings_limit')
                    ->label(__('plans.listings_limit'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('price_eur')
                    ->label(__('plans.price_eur'))
                    ->money('EUR')
                    ->sortable(),
                TextColumn::make('agencies_count')
                    ->counts('agencies')
                    ->label(__('agencies.resource_plural'))
                    ->sortable(),
                ToggleColumn::make('is_active')
                    ->label(__('plans.is_active')),
            ])
            ->actions([
                Actions\EditAction::make(),
            ])
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPlans::route('/'),
            'create' => Pages\CreatePlan::route('/create'),
            'edit'   => Pages\EditPlan::route('/{record}/edit'),
        ];
    }
}
