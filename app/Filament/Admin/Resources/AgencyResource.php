<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\AgencyResource\Pages;
use App\Models\Agency;
use App\Models\Plan;
use App\Services\AgencyService;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

use Filament\Notifications\Notification;
use Filament\Forms\Components\Placeholder;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;


class AgencyResource extends Resource
{
    protected static ?string $model = Agency::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-building-office';

    protected static ?int $navigationSort = 1;

    /**
     * Eager-load plan to avoid N+1 on plan.name and listings_limit column.
     */
    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->with('plan');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('filament.navigation.agencies');
    }

    public static function getModelLabel(): string
    {
        return __('agencies.resource');
    }

    public static function getPluralModelLabel(): string
    {
        return __('agencies.resource_plural');
    }

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Tabs::make('Agency')
                    ->tabs([
                        // Tab 1 — Basic info
                        Tabs\Tab::make(__('properties.tabs.basic'))
                            ->schema([
                                TextInput::make('name')
                                    ->label(__('agencies.name'))
                                    ->required()
                                    ->maxLength(255)
                                    ->live(debounce: 500)
                                    ->afterStateUpdated(function (?string $state, callable $set, callable $get) {
                                        if (!$get('agency_code_modified') && $state) {
                                            $set('agency_code', static::suggestAgencyCode($state));
                                        }
                                    }),
                                TextInput::make('agency_code')
                                    ->label('Código de agencia')
                                    ->required()
                                    ->maxLength(10)
                                    ->live()
                                    ->afterStateUpdated(fn(callable $set) => $set('agency_code_modified', true))
                                    ->unique(Agency::class, 'agency_code', ignoreRecord: true)
                                    ->helperText('Generado automáticamente. Puede modificarlo (solo mayúsculas y números).')
                                    ->rules(['regex:/^[A-Z0-9]{2,10}$/']),
                                Hidden::make('agency_code_modified')->default(false),
                                TextInput::make('slug')
                                    ->label(fn() => __('properties.slug'))
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255)
                                    ->dehydrated()
                                    ->disabled(
                                        fn(string $operation): bool =>
                                        $operation === 'create' || !auth()->user()->hasAnyRole(['superadmin', 'admin'])
                                    )
                                    ->helperText(
                                        fn(string $operation): string =>
                                        $operation === 'create'
                                            ? __('properties.slug_auto_generated')
                                            : __('properties.slug_edit_warning')
                                    ),
                                FileUpload::make('logo_path')
                                    ->label(__('agencies.logo'))
                                    ->image()
                                    ->directory('agencies/logos')
                                    ->columnSpanFull(),
                                TextInput::make('phone')
                                    ->label(__('agencies.phone'))
                                    ->tel()
                                    ->maxLength(255),
                                TextInput::make('email')
                                    ->label(__('agencies.email'))
                                    ->email()
                                    ->maxLength(255),
                                TextInput::make('website')
                                    ->label(__('agencies.website'))
                                    ->url()
                                    ->maxLength(255),
                                TextInput::make('address')
                                    ->label(__('agencies.address'))
                                    ->maxLength(255),
                                TextInput::make('city')
                                    ->label(__('agencies.city'))
                                    ->maxLength(255),
                                TextInput::make('province')
                                    ->label(__('agencies.province'))
                                    ->maxLength(255),
                                TextInput::make('cif')
                                    ->label(__('agencies.cif'))
                                    ->maxLength(255),
                            ])
                            ->columns(2),

                        // Tab 2 — Plan & Limits
                        Tabs\Tab::make(__('agencies.plan'))
                            ->schema([
                                Select::make('plan_id')
                                    ->label(__('agencies.plan'))
                                    ->relationship('plan', 'name')
                                    ->required()
                                    ->preload(),
                                TextInput::make('listings_used')
                                    ->label(__('agencies.listings_used'))
                                    ->numeric()
                                    ->disabled()
                                    ->dehydrated(false),
                                Placeholder::make('plan_changed_at_display')
                                    ->label(__('agencies.plan_changed_at'))
                                    ->content(fn(?Agency $record) => $record?->plan_changed_at?->format('d/m/Y H:i') ?? '—'),
                                Toggle::make('is_active')
                                    ->label(__('agencies.is_active'))
                                    ->helperText(__('agencies.block_warning'))
                                    ->default(true),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo_path')
                    ->label(__('agencies.logo'))
                    ->circular()
                    ->defaultImageUrl(fn() => 'https://ui-avatars.com/api/?name=A&color=7F9CF5&background=EBF4FF')
                    ->size(40),
                TextColumn::make('name')
                    ->label(__('agencies.name'))
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('city')
                    ->label(__('agencies.city'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('province')
                    ->label(__('agencies.province'))
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('plan.name')
                    ->label(__('agencies.plan'))
                    ->badge()
                    ->color(fn(string $state) => match (strtolower($state)) {
                        'starter'   => 'gray',
                        'pro'       => 'info',
                        'unlimited' => 'warning',
                        default     => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('listings_used')
                    ->label(__('agencies.listings_used'))
                    ->formatStateUsing(
                        fn(Agency $record) =>
                        "{$record->listings_used} / {$record->plan->listings_limit}"
                    )
                    ->sortable(),
                ToggleColumn::make('is_active')
                    ->label(__('agencies.is_active')),
                TextColumn::make('created_at')
                    ->label(__('filament.labels.created_at'))
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('plan_id')
                    ->label(__('agencies.plan'))
                    ->relationship('plan', 'name'),
                SelectFilter::make('province')
                    ->label(__('agencies.province'))
                    ->options(fn() => Agency::query()->whereNotNull('province')->distinct()->pluck('province', 'province')),
                TernaryFilter::make('is_active')
                    ->label(__('agencies.is_active')),
            ])
            ->actions([
                Actions\EditAction::make(),

                // Change plan action
                Actions\Action::make('changePlan')
                    ->label(__('agencies.change_plan'))
                    ->icon('heroicon-o-credit-card')
                    ->color('warning')
                    ->form([
                        Select::make('plan_id')
                            ->label(__('agencies.plan'))
                            ->options(Plan::active()->ordered()->pluck('name', 'id'))
                            ->required(),
                        Textarea::make('admin_note')
                            ->label(__('agencies.admin_note'))
                            ->placeholder('Razón del cambio...')
                            ->nullable(),
                    ])
                    ->action(function (Agency $record, array $data) {
                        $plan = Plan::findOrFail($data['plan_id']);

                        // Downgrade warning: new limit is lower than current usage
                        if ($plan->listings_limit < $record->listings_used) {
                            Notification::make()
                                ->title(__('plans.downgrade_warning'))
                                ->warning()
                                ->persistent()
                                ->send();
                        }

                        app(AgencyService::class)->changePlan($record, $plan);

                        Notification::make()
                            ->title(__('agencies.plan_changed_success'))
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation(),

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
            'index'  => Pages\ListAgencies::route('/'),
            'create' => Pages\CreateAgency::route('/create'),
            'edit'   => Pages\EditAgency::route('/{record}/edit'),
        ];
    }

    /**
     * Suggest an agency_code from the agency name.
     * Multi-word: first 3 chars of word1 + 2 chars of word2 + 1 char of word3.
     * Single-word: consonants only (first 5).
     * Appends a numeric suffix only if the code already exists.
     */
    private static function suggestAgencyCode(string $name): string
    {
        // Transliterate and normalize to uppercase A-Z only
        if (function_exists('transliterator_transliterate')) {
            $clean = transliterator_transliterate('Any-Latin; Latin-ASCII; Upper()', $name);
        } else {
            $clean = strtoupper($name);
        }
        $clean = strtoupper(preg_replace('/[^A-Z0-9\s]/', '', $clean));

        $words = array_values(array_filter(explode(' ', $clean)));

        if (count($words) >= 2) {
            $base  = substr($words[0], 0, 3);
            $base .= substr($words[1], 0, 2);
            $base .= isset($words[2]) ? substr($words[2], 0, 1) : '';
        } else {
            $consonants = preg_replace('/[AEIOU0-9]/', '', $words[0] ?? 'AGNCY');
            $base = $consonants ?: preg_replace('/[^A-Z0-9]/', '', $words[0] ?? 'AGNCY');
        }

        $base = substr($base, 0, 5) ?: 'AGNCY';

        $code = $base;
        $i = 2;
        while (Agency::where('agency_code', $code)->exists()) {
            $code = $base . $i++;
        }

        return $code;
    }
}
