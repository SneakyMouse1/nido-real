<?php

namespace App\Filament\Agency\Resources;

use App\Enums\DealType;
use App\Enums\EnergyCertificate;
use App\Enums\Orientation;
use App\Enums\PropertyStatus;
use App\Filament\Agency\Resources\PropertyResource\Pages;
use App\Models\Property;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-home-modern';

    protected static ?int $navigationSort = 1;

    protected static ?string $tenantOwnershipRelationshipName = 'agency';

    public static function getModelLabel(): string
    {
        return __('properties.resource');
    }

    public static function getPluralModelLabel(): string
    {
        return __('properties.resource_plural');
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->hasAnyRole(['agency_manager', 'agent']) ?? false;
    }

    /**
     * Scope properties to the current tenant (agency).
     * Agents see only their own; managers see all agency properties.
     */
    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        // Start with the base query and eager load relationships for performance
        $query = parent::getEloquentQuery()
            ->with(['propertyType', 'user']);

        $user = auth()->user();

        // Agent can only see their own properties
        if ($user && $user->hasRole('agent') && ! $user->hasRole('agency_manager')) {
            $query->where('user_id', $user->id);
        }

        return $query;
    }

    public static function form(Schema $form): Schema
    {
        $locale = app()->getLocale();

        return $form
            ->schema([
                Tabs::make('Property')
                    ->tabs([
                        // Tab 1 — Información básica
                        Tabs\Tab::make(__('properties.tabs.basic'))
                            ->schema([
                                Select::make('property_type_id')
                                    ->label(__('properties.property_type'))
                                    ->relationship('propertyType', 'name_es')
                                    ->required()
                                    ->searchable()
                                    ->preload(),
                                TextInput::make('title')
                                    ->label(__('properties.title'))
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('slug')
                                    ->label(fn() => __('properties.slug'))
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255)
                                    ->hidden(fn(string $operation): bool => $operation === 'create')
                                    ->dehydrated(fn(string $operation): bool => $operation !== 'create')
                                    ->disabled(fn(): bool => ! auth()->user()->hasAnyRole(['superadmin', 'admin']))
                                    ->helperText(
                                        fn(string $operation): string => $operation === 'create'
                                            ? __('properties.slug_auto_generated')
                                            : __('properties.slug_edit_warning')
                                    ),
                                RichEditor::make('description')
                                    ->label(__('properties.description'))
                                    ->columnSpanFull(),
                                Select::make('deal_type')
                                    ->label(__('properties.deal_type'))
                                    ->options(DealType::class)
                                    ->required(),
                                TextInput::make('price')
                                    ->label(__('properties.price'))
                                    ->numeric()
                                    ->prefix('€')
                                    ->required(),
                            ])
                            ->columns(2),

                        // Tab 2 — Detalles
                        Tabs\Tab::make(__('properties.tabs.details'))
                            ->schema([
                                TextInput::make('bedrooms')
                                    ->label(__('properties.bedrooms'))
                                    ->numeric(),
                                TextInput::make('bathrooms')
                                    ->label(__('properties.bathrooms'))
                                    ->numeric(),
                                TextInput::make('toilets')
                                    ->label(__('properties.toilets'))
                                    ->numeric(),
                                TextInput::make('area_total')
                                    ->label(__('properties.area_total'))
                                    ->numeric()
                                    ->suffix('m²'),
                                TextInput::make('area_useful')
                                    ->label(__('properties.area_useful'))
                                    ->numeric()
                                    ->suffix('m²'),
                                TextInput::make('floor_number')
                                    ->label(__('properties.floor_number'))
                                    ->numeric(),
                                TextInput::make('total_floors')
                                    ->label(__('properties.total_floors'))
                                    ->numeric(),
                                TextInput::make('year_built')
                                    ->label(__('properties.year_built'))
                                    ->numeric()
                                    ->minValue(1800)
                                    ->maxValue(date('Y')),
                                Toggle::make('has_garage')
                                    ->label(__('properties.has_garage')),
                                Toggle::make('has_storage')
                                    ->label(__('properties.has_storage')),
                                TextInput::make('community_fees')
                                    ->label(__('properties.community_fees'))
                                    ->numeric()
                                    ->prefix('€'),
                                TextInput::make('ibi_tax')
                                    ->label(__('properties.ibi_tax'))
                                    ->numeric()
                                    ->prefix('€'),
                                Select::make('energy_certificate')
                                    ->label('Certificado Energético')
                                    ->options(EnergyCertificate::class),
                                Select::make('orientation')
                                    ->label('Orientación')
                                    ->options(Orientation::class),
                            ])
                            ->columns(3),

                        // Tab 3 — Características (Features)
                        Tabs\Tab::make(__('properties.tabs.features'))
                            ->schema([
                                CheckboxList::make('features')
                                    ->relationship('features', 'name_es')
                                    ->columns(3)
                                    ->searchable()
                                    ->columnSpanFull(),
                            ]),

                        // Tab 4 — Multimedia
                        Tabs\Tab::make(__('properties.tabs.media'))
                            ->schema([
                                Section::make(__('properties.images'))
                                    ->description(__('properties.images_hint'))
                                    ->schema([
                                        SpatieMediaLibraryFileUpload::make('photos')
                                            ->label('')
                                            ->collection('photos')
                                            ->multiple()
                                            ->reorderable()
                                            ->image()
                                            ->imageEditor()
                                            ->minFiles(6)
                                            ->maxFiles(30)
                                            ->maxSize(5120)                  // 5MB per file
                                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                            ->columnSpanFull()
                                            // Skip deleteAbandonedFiles(): state is not reliably persisted
                                            // in Livewire (dehydrated:false), so calling it would wipe photos.
                                            ->saveRelationshipsUsing(static function (SpatieMediaLibraryFileUpload $component) {
                                                $component->saveUploadedFiles();
                                            }),
                                    ]),

                                Section::make(__('properties.floor_plans'))
                                    ->description(__('properties.floor_plans_hint'))
                                    ->schema([
                                        Repeater::make('floor_plans_data')
                                            ->label('')
                                            ->schema([
                                                // Tracks Spatie media UUID for existing floor plans
                                                Hidden::make('media_uuid'),

                                                // Read-only filename for EXISTING floor plans (hidden for new items)
                                                TextInput::make('existing_filename')
                                                    ->label(__('properties.existing_file'))
                                                    ->disabled()
                                                    ->hidden(fn($get) => ! $get('media_uuid')),

                                                // FileUpload shown only for NEW floor plans
                                                FileUpload::make('file')
                                                    ->label(__('properties.floor_plan_file'))
                                                    ->image()
                                                    ->directory('tmp/floor-plans')
                                                    ->disk('public')
                                                    ->maxSize(5120)
                                                    ->hidden(fn($get) => (bool) $get('media_uuid')),

                                                TextInput::make('title_es')
                                                    ->label(__('properties.floor_plan_title_es'))
                                                    ->maxLength(100),
                                                TextInput::make('title_en')
                                                    ->label(__('properties.floor_plan_title_en'))
                                                    ->maxLength(100),
                                            ])
                                            ->columns(3)
                                            ->addActionLabel(__('properties.add_floor_plan'))
                                            ->collapsed()
                                            ->cloneable()
                                            ->columnSpanFull(),
                                    ])
                                    ->collapsed(),

                                Section::make(__('properties.documents'))
                                    ->description(__('properties.documents_hint'))
                                    ->schema([
                                        Repeater::make('documents_data')
                                            ->label('')
                                            ->schema([
                                                // Tracks Spatie media UUID for existing documents
                                                Hidden::make('media_uuid'),

                                                // Read-only filename for EXISTING documents (hidden for new items)
                                                TextInput::make('existing_filename')
                                                    ->label(__('properties.existing_file'))
                                                    ->disabled()
                                                    ->hidden(fn($get) => ! $get('media_uuid')),

                                                // FileUpload shown only for NEW documents
                                                FileUpload::make('file')
                                                    ->label(__('properties.document_file'))
                                                    ->acceptedFileTypes(['application/pdf'])
                                                    ->directory('tmp/documents')
                                                    ->disk('public')
                                                    ->maxSize(20480)        // 20MB for PDFs
                                                    ->hidden(fn($get) => (bool) $get('media_uuid')),

                                                TextInput::make('title')
                                                    ->label(__('properties.document_title'))
                                                    ->maxLength(150)
                                                    ->required(),
                                                Toggle::make('is_public')
                                                    ->label(__('properties.document_public'))
                                                    ->helperText(__('properties.document_public_hint'))
                                                    ->default(false),
                                            ])
                                            ->columns(3)
                                            ->addActionLabel(__('properties.add_document'))
                                            ->collapsed()
                                            ->cloneable()
                                            ->columnSpanFull(),
                                    ])
                                    ->collapsed(),

                                Section::make(__('properties.video'))
                                    ->schema([
                                        TextInput::make('video_url')
                                            ->label(__('properties.video_url'))
                                            ->url()
                                            ->placeholder('https://youtube.com/watch?v=...')
                                            ->suffixIcon('heroicon-o-video-camera'),
                                    ])
                                    ->collapsed(),
                            ]),

                        // Tab 5 — Ubicación
                        Tabs\Tab::make(__('properties.tabs.location'))
                            ->schema([
                                TextInput::make('address_line')
                                    ->label(__('properties.address_line'))
                                    ->maxLength(255),
                                Toggle::make('hide_exact_address')
                                    ->label(__('properties.hide_exact_address')),
                                TextInput::make('neighborhood')
                                    ->label(__('properties.neighborhood'))
                                    ->maxLength(255),
                                TextInput::make('city')
                                    ->label(__('properties.city'))
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('province')
                                    ->label(__('properties.province'))
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('zip_code')
                                    ->label(__('properties.zip_code'))
                                    ->maxLength(10),
                                TextInput::make('latitude')
                                    ->label(__('properties.latitude'))
                                    ->numeric(),
                                TextInput::make('longitude')
                                    ->label(__('properties.longitude'))
                                    ->numeric(),
                            ])
                            ->columns(2),

                        // Tab 6 — Publicación
                        Tabs\Tab::make(__('properties.tabs.publication'))
                            ->schema([
                                Select::make('status')
                                    ->label(__('properties.status'))
                                    ->options([
                                        PropertyStatus::Draft->value => PropertyStatus::Draft->label($locale),
                                        PropertyStatus::Published->value => PropertyStatus::Published->label($locale),
                                    ])
                                    ->required()
                                    ->default(PropertyStatus::Draft->value),
                                Toggle::make('is_featured')
                                    ->label(__('properties.is_featured'))
                                    ->disabled(fn() => ! auth()->user()->hasAnyRole(['superadmin', 'admin'])),
                                TextInput::make('meta_title')
                                    ->label(__('properties.meta_title'))
                                    ->maxLength(255),
                                Textarea::make('meta_description')
                                    ->label(__('properties.meta_description'))
                                    ->maxLength(500),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn($query) => $query->select([
                'id',
                'title',
                'slug',
                'price',
                'deal_type',
                'status',
                'city',
                'bedrooms',
                'bathrooms',
                'area_total',
                'user_id',
                'agency_id',
                'property_type_id',
                'is_featured',
                'views_count',
                'created_at',
            ]))
            ->columns([
                TextColumn::make('title')
                    ->label(__('properties.title'))
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                TextColumn::make('propertyType.name_es')
                    ->label(__('properties.property_type'))
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('user.name')
                    ->label(fn() => __('cabinet.added_by'))
                    ->searchable()
                    ->sortable()
                    ->visible(fn() => auth()->user()->hasRole('agency_manager')),
                TextColumn::make('city')
                    ->label(__('properties.city'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('price')
                    ->label(__('properties.price'))
                    ->money('EUR')
                    ->sortable(),
                TextColumn::make('deal_type')
                    ->label(__('properties.deal_type'))
                    ->badge()
                    ->formatStateUsing(
                        fn($state) => $state instanceof DealType
                            ? $state->label(app()->getLocale())
                            : __("enums.deal_type.{$state}")
                    )
                    ->color(fn($state) => match ($state instanceof DealType ? $state->value : (string) $state) {
                        'sale' => 'success',
                        'rent' => 'info',
                        default => 'gray',
                    }),
                TextColumn::make('status')
                    ->label(__('properties.status'))
                    ->badge()
                    ->formatStateUsing(
                        fn($state) => $state instanceof PropertyStatus
                            ? $state->label(app()->getLocale())
                            : __("enums.property_status.{$state}")
                    )
                    ->color(fn($state) => match ($state instanceof PropertyStatus ? $state->value : (string) $state) {
                        'draft' => 'gray',
                        'published' => 'success',
                        'moderated' => 'danger',
                        'sold' => 'warning',
                        'archived' => 'gray',
                        default => 'gray',
                    }),
                TextColumn::make('views_count')
                    ->label(__('properties.views_count'))
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label(__('filament.labels.created_at'))
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('properties.status'))
                    ->options([
                        PropertyStatus::Draft->value => PropertyStatus::Draft->label(app()->getLocale()),
                        PropertyStatus::Published->value => PropertyStatus::Published->label(app()->getLocale()),
                        PropertyStatus::Moderated->value => PropertyStatus::Moderated->label(app()->getLocale()),
                    ]),
                SelectFilter::make('user_id')
                    ->label(fn() => __('cabinet.filter_by_agent'))
                    ->options(function () {
                        $agency = Filament::getTenant();

                        return $agency->agents()
                            ->pluck('users.name', 'users.id')
                            ->toArray();
                    })
                    ->visible(fn() => auth()->user()->hasRole('agency_manager')),
                SelectFilter::make('deal_type')
                    ->label(__('properties.deal_type'))
                    ->options(DealType::class),
                TernaryFilter::make('is_featured')
                    ->label(__('properties.is_featured')),
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make()
                    ->visible(
                        fn(Property $record) => auth()->user()->hasRole('agency_manager') ||
                            $record->user_id === auth()->id()
                    ),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProperties::route('/'),
            'create' => Pages\CreateProperty::route('/create'),
            'edit' => Pages\EditProperty::route('/{record}/edit'),
        ];
    }
}
