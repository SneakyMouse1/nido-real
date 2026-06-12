<?php

namespace App\Filament\Admin\Resources;

use App\Enums\FeatureCategory;
use App\Filament\Admin\Resources\FeatureResource\Pages;
use App\Models\Feature;
use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class FeatureResource extends Resource
{
    protected static ?string $model = Feature::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-sparkles';

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return __('filament.navigation.catalogs');
    }

    public static function getModelLabel(): string
    {
        return __('features.resource');
    }

    public static function getPluralModelLabel(): string
    {
        return __('features.resource_plural');
    }

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('name_es')
                            ->label(__('features.name_es'))
                            ->required()
                            ->maxLength(255),
                        TextInput::make('name_en')
                            ->label(__('features.name_en'))
                            ->required()
                            ->maxLength(255),
                        Select::make('category')
                            ->label(__('features.category'))
                            ->options(collect(FeatureCategory::cases())->mapWithKeys(
                                fn(FeatureCategory $cat) => [$cat->value => $cat->label(app()->getLocale())]
                            ))
                            ->required()
                            ->searchable(),
                        TextInput::make('icon')
                            ->label(__('features.icon'))
                            ->required()
                            ->placeholder('heroicon-o-sparkles')
                            ->maxLength(255),
                        TextInput::make('sort_order')
                            ->label(__('features.sort_order'))
                            ->numeric()
                            ->default(0),
                        Toggle::make('is_active')
                            ->label(__('features.is_active'))
                            ->default(true),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('icon')
                    ->label(__('features.icon'))
                    ->badge()
                    ->color('gray'),
                TextColumn::make('name_es')
                    ->label(__('features.name_es'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name_en')
                    ->label(__('features.name_en'))
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('category')
                    ->label(__('features.category'))
                    ->badge()
                    ->formatStateUsing(
                        fn($state) => $state instanceof FeatureCategory
                            ? $state->label(app()->getLocale())
                            : __("enums.feature_category.{$state}")
                    )
                    ->color(fn($state) => match ($state instanceof FeatureCategory ? $state->value : (string) $state) {
                        'interior'   => 'info',
                        'exterior'   => 'success',
                        'building'   => 'warning',
                        'security'   => 'danger',
                        'technology' => 'primary',
                        default      => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('sort_order')
                    ->label(__('features.sort_order'))
                    ->sortable()
                    ->toggleable(),
                ToggleColumn::make('is_active')
                    ->label(__('features.is_active')),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->label(__('features.category'))
                    ->options(collect(FeatureCategory::cases())->mapWithKeys(
                        fn(FeatureCategory $cat) => [$cat->value => $cat->label(app()->getLocale())]
                    )),
                TernaryFilter::make('is_active')
                    ->label(__('features.is_active')),
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListFeatures::route('/'),
            'create' => Pages\CreateFeature::route('/create'),
            'edit'   => Pages\EditFeature::route('/{record}/edit'),
        ];
    }
}
