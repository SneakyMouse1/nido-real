<?php

namespace App\Filament\Agency\Resources;

use App\Filament\Agency\Resources\AgentResource\Pages;
use App\Models\User;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AgentResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-user-group';

    protected static ?int $navigationSort = 2;

    public static function getModelLabel(): string
    {
        return __('cabinet.agent');
    }

    public static function getPluralModelLabel(): string
    {
        return __('cabinet.agents');
    }

    public static function getSlug(?\Filament\Panel $panel = null): string
    {
        return 'agents';
    }

    /**
     * Only Agency Managers can access this resource.
     */
    public static function canAccess(): bool
    {
        return auth()->user()?->hasRole('agency_manager') ?? false;
    }

    /**
     * Scope to the current agency's users.
     * Eager-load agencies (with pivot) and property count to avoid N+1.
     */
    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $tenant = Filament::getTenant();

        return User::query()
            ->whereHas('agencies', fn($q) => $q->where('agencies.id', $tenant->id))
            ->with(['agencies' => fn($q) => $q->where('agencies.id', $tenant->id)])
            ->withCount('properties');
    }

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('name')
                            ->label(__('agencies.name'))
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label(__('agencies.email'))
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->label(__('agencies.phone'))
                            ->tel()
                            ->maxLength(255),
                        TextInput::make('password')
                            ->password()
                            ->required(fn(?User $record) => $record === null)
                            ->dehydrated(fn(?string $state) => filled($state))
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Section::make('Datos de contacto del agente')
                    ->description('Campos visibles en la ficha de la propiedad (sección "Contactar con el vendedor")')
                    ->schema([
                        TextInput::make('phone_secondary')
                            ->label('Teléfono secundario')
                            ->tel()
                            ->placeholder('+34 600 000 000')
                            ->maxLength(255),
                        TextInput::make('whatsapp')
                            ->label('WhatsApp')
                            ->tel()
                            ->placeholder('+34 600 000 000')
                            ->maxLength(255),
                        TextInput::make('address')
                            ->label('Dirección')
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        $tenant = Filament::getTenant();

        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('agencies.name'))
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('email')
                    ->label(__('agencies.email'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('pivot_role')
                    ->label(__('cabinet.role'))
                    ->state(function (User $record) use ($tenant) {
                        // Read from eager-loaded collection, not a new query
                        return $record->agencies->firstWhere('id', $tenant->id)?->pivot?->role ?? '—';
                    })
                    ->badge()
                    ->color(fn(string $state) => match ($state) {
                        'manager' => 'warning',
                        'agent' => 'info',
                        default => 'gray',
                    }),
                TextColumn::make('properties_count')
                    ->label(__('agencies.properties_count'))
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label(__('filament.labels.created_at'))
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Actions\EditAction::make(),

                // Block/unblock agent within the agency
                Actions\Action::make('toggleAgentActive')
                    ->label(
                        fn(User $record) => $record->is_active
                            ? __('cabinet.block_agent')
                            : __('cabinet.unblock_agent')
                    )
                    ->icon(
                        fn(User $record) => $record->is_active
                            ? 'heroicon-o-lock-closed'
                            : 'heroicon-o-lock-open'
                    )
                    ->color(fn(User $record) => $record->is_active ? 'danger' : 'success')
                    ->action(function (User $record) {
                        $record->update(['is_active' => ! $record->is_active]);
                        Notification::make()
                            ->title($record->is_active ? __('cabinet.agent_unblocked') : __('cabinet.agent_blocked'))
                            ->success()
                            ->send();
                    })
                    ->visible(fn(User $record) => $record->id !== auth()->id())
                    ->requiresConfirmation(),
            ])
            ->defaultSort('name');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAgents::route('/'),
            'create' => Pages\CreateAgent::route('/create'),
            'edit' => Pages\EditAgent::route('/{record}/edit'),
        ];
    }
}
