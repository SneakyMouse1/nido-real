<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PropertyTypeResource\Pages;
use App\Models\PropertyType;
use Filament\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class PropertyTypeResource extends Resource
{
    protected static ?string $model = PropertyType::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-tag';

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string
    {
        return __('filament.navigation.properties');
    }

    public static function getModelLabel(): string
    {
        return __('filament.navigation.property_types');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.navigation.property_types');
    }

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('name_es')
                            ->label('Nombre (ES)')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('name_en')
                            ->label('Name (EN)')
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
                            ->helperText(fn() => __('properties.slug_edit_warning_frontend')),
                        TextInput::make('icon')
                            ->label(__('features.icon'))
                            ->placeholder('heroicon-o-home')
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
                TextColumn::make('name_es')
                    ->label('Nombre (ES)')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name_en')
                    ->label('Name (EN)')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('icon')
                    ->label(__('features.icon'))
                    ->badge()
                    ->color('gray'),
                TextColumn::make('properties_count')
                    ->counts('properties')
                    ->label(__('agencies.properties_count'))
                    ->sortable(),
                TextColumn::make('sort_order')
                    ->label(__('features.sort_order'))
                    ->sortable()
                    ->toggleable(),
                ToggleColumn::make('is_active')
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
            'index'  => Pages\ListPropertyTypes::route('/'),
            'create' => Pages\CreatePropertyType::route('/create'),
            'edit'   => Pages\EditPropertyType::route('/{record}/edit'),
        ];
    }
}
