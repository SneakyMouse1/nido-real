<?php

namespace App\Filament\Admin\Resources;

use App\Enums\DealType;
use App\Enums\EnergyCertificate;
use App\Enums\Orientation;
use App\Enums\PropertyStatus;
use App\Filament\Admin\Resources\PropertyResource\Pages;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Models\Property;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
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

    public static function getNavigationGroup(): ?string
    {
        return __('filament.navigation.properties');
    }

    public static function getModelLabel(): string
    {
        return __('properties.resource');
    }

    public static function getPluralModelLabel(): string
    {
        return __('properties.resource_plural');
    }

    /**
     * Show count of pending-review properties on the sidebar badge.
     */
    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::withoutGlobalScope(\App\Models\Scopes\ActiveAgencyScope::class)
            ->where('status', PropertyStatus::Pending->value)
            ->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    /**
     * Admin sees ALL properties (bypass ActiveAgencyScope).
     */
    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScope(\App\Models\Scopes\ActiveAgencyScope::class)
            ->with(['agency', 'propertyType', 'user']);
    }

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Tabs::make('Property')
                    ->tabs([
                        // Tab 1 — Basic info
                        Tabs\Tab::make(__('properties.tabs.basic'))
                            ->schema([
                                TextInput::make('title')
                                    ->label(__('properties.title'))
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('slug')
                                    ->label(fn() => __('properties.slug'))
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255)
                                    ->dehydrated()
                                    ->disabled(
                                        fn(string $operation): bool => $operation === 'create' || ! auth()->user()->hasAnyRole(['superadmin', 'admin'])
                                    )
                                    ->helperText(
                                        fn(string $operation): string => $operation === 'create'
                                            ? __('properties.slug_auto_generated')
                                            : __('properties.slug_edit_warning')
                                    ),
                                Select::make('property_type_id')
                                    ->label(__('properties.property_type'))
                                    ->relationship('propertyType', 'name_es')
                                    ->required()
                                    ->searchable()
                                    ->preload(),
                                Select::make('deal_type')
                                    ->label(__('properties.deal_type'))
                                    ->options(DealType::class)
                                    ->required(),
                                Select::make('agency_id')
                                    ->label(__('properties.agency'))
                                    ->relationship('agency', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->nullable(),
                                TextInput::make('price')
                                    ->label(__('properties.price'))
                                    ->numeric()
                                    ->prefix('€')
                                    ->required(),
                                RichEditor::make('description')
                                    ->label(__('properties.description'))
                                    ->columnSpanFull(),
                                TextInput::make('property_code')
                                    ->label('Código del inmueble')
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->helperText('Generado automáticamente al crear el inmueble'),
                            ])
                            ->columns(2),

                        // Tab 2 — Details
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

                        // Tab 3 — Multimedia
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
                                            ->maxFiles(30)
                                            ->maxSize(5120)                       // 5MB per file
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
                                                    ->maxSize(20480)            // 20MB for PDFs
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

                        // Tab 4 — Location
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

                        // Tab 4 — Publication
                        Tabs\Tab::make(__('properties.tabs.publication'))
                            ->schema([
                                Select::make('status')
                                    ->label(__('properties.status'))
                                    ->options(PropertyStatus::class)
                                    ->required(),
                                Toggle::make('is_featured')
                                    ->label(__('properties.is_featured')),
                                TextInput::make('video_url')
                                    ->label(__('properties.video_url'))
                                    ->url()
                                    ->maxLength(500),
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
                TextColumn::make('property_code')
                    ->label('Código')
                    ->copyable()
                    ->copyMessage('Código copiado')
                    ->fontFamily('mono')
                    ->default('—')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('title')
                    ->label(__('properties.title'))
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                TextColumn::make('propertyType.name_es')
                    ->label(__('properties.property_type'))
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('agency.name')
                    ->label(__('properties.agency'))
                    ->searchable()
                    ->sortable()
                    ->default('—'),
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
                        'pending' => 'warning',
                        'published' => 'success',
                        'moderated' => 'danger',
                        'rejected' => 'danger',
                        'sold' => 'info',
                        'archived' => 'gray',
                        default => 'gray',
                    }),
                ToggleColumn::make('is_featured')
                    ->label(__('properties.is_featured')),
                TextColumn::make('created_at')
                    ->label(__('filament.labels.created_at'))
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('properties.status'))
                    ->options(PropertyStatus::class),
                SelectFilter::make('deal_type')
                    ->label(__('properties.deal_type'))
                    ->options(DealType::class),
                SelectFilter::make('agency_id')
                    ->label(__('properties.agency'))
                    ->relationship('agency', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('province')
                    ->label(__('properties.province'))
                    ->options(fn() => Property::query()->whereNotNull('province')->distinct()->pluck('province', 'province')),
                TernaryFilter::make('is_featured')
                    ->label(__('properties.is_featured')),
            ])
            ->actions([
                Actions\EditAction::make(),

                // Approve action — approve a pending property
                Actions\Action::make('approve')
                    ->label('Aprobar')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(function (Property $record) {
                        $record->update([
                            'status' => PropertyStatus::Published->value,
                            'rejection_reason' => null,
                        ]);
                        Notification::make()->title('Propiedad aprobada')->success()->send();
                    })
                    ->visible(fn(Property $record) => (
                        $record->status instanceof PropertyStatus
                        ? $record->status
                        : PropertyStatus::tryFrom((string) $record->status)
                    ) === PropertyStatus::Pending)
                    ->requiresConfirmation()
                    ->modalHeading('Aprobar propiedad')
                    ->modalDescription('La propiedad se publicará y será visible para todos los usuarios.')
                    ->modalSubmitActionLabel('Sí, aprobar'),

                // Reject action — reject a pending property with a reason
                Actions\Action::make('reject')
                    ->label('Rechazar')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->form([
                        \Filament\Forms\Components\Textarea::make('rejection_reason')
                            ->label('Motivo del rechazo')
                            ->helperText('El usuario verá este mensaje. Sé específico: "Foto de baja calidad", "Título inapropiado", etc.')
                            ->required()
                            ->rows(3)
                            ->maxLength(500),
                    ])
                    ->action(function (Property $record, array $data) {
                        $record->update([
                            'status' => PropertyStatus::Rejected->value,
                            'rejection_reason' => $data['rejection_reason'],
                        ]);
                        Notification::make()->title('Propiedad rechazada')->warning()->send();
                    })
                    ->visible(fn(Property $record) => in_array(
                        $record->status instanceof PropertyStatus ? $record->status : PropertyStatus::tryFrom((string) $record->status),
                        [PropertyStatus::Pending, PropertyStatus::Published]
                    ))
                    ->modalHeading('Rechazar propiedad')
                    ->modalSubmitActionLabel('Rechazar'),

                // Moderate action — hide a published property (admin ban)
                Actions\Action::make('moderate')
                    ->label(__('properties.action_moderate'))
                    ->icon('heroicon-o-shield-exclamation')
                    ->color('warning')
                    ->action(function (Property $record) {
                        $record->update(['status' => PropertyStatus::Moderated->value]);
                        Notification::make()->title(__('enums.property_status.moderated'))->success()->send();
                    })
                    ->visible(fn(Property $record) => (
                        $record->status instanceof PropertyStatus
                        ? $record->status
                        : PropertyStatus::tryFrom((string) $record->status)
                    ) === PropertyStatus::Published)
                    ->requiresConfirmation()
                    ->modalHeading(__('enums.property_status.moderated'))
                    ->modalDescription(__('properties.moderation_description'))
                    ->modalSubmitActionLabel(__('filament.labels.confirm')),

                // Publish action — re-publish a moderated/draft property
                Actions\Action::make('publish')
                    ->label(__('properties.action_publish'))
                    ->icon('heroicon-o-arrow-up-circle')
                    ->color('info')
                    ->action(function (Property $record) {
                        $record->update([
                            'status' => PropertyStatus::Published->value,
                            'rejection_reason' => null,
                        ]);
                        Notification::make()->title(__('enums.property_status.published'))->success()->send();
                    })
                    ->visible(fn(Property $record) => in_array(
                        $record->status instanceof PropertyStatus ? $record->status : PropertyStatus::tryFrom((string) $record->status),
                        [PropertyStatus::Moderated, PropertyStatus::Draft, PropertyStatus::Rejected]
                    ))
                    ->requiresConfirmation()
                    ->modalHeading(__('properties.action_publish'))
                    ->modalDescription(__('properties.action_publish_description'))
                    ->modalSubmitActionLabel(__('filament.labels.confirm')),

                Actions\DeleteAction::make(),
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
