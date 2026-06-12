<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Spatie\Permission\Models\Role;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-users';

    protected static ?int $navigationSort = 1;

    /**
     * Eager-load roles and agencies to avoid N+1 in table columns.
     */
    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->with(['roles', 'agencies']);
    }

    public static function getNavigationGroup(): ?string
    {
        return __('filament.navigation.users');
    }

    public static function getModelLabel(): string
    {
        return __('filament.navigation.users');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.navigation.users');
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
                        TextInput::make('password')
                            ->password()
                            ->required(fn(?User $record) => $record === null)
                            ->dehydrated(fn(?string $state) => filled($state))
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->label(__('agencies.phone'))
                            ->tel()
                            ->maxLength(255),
                        Select::make('roles')
                            ->label('Roles')
                            ->multiple()
                            ->relationship('roles', 'name')
                            ->preload()
                            ->visible(fn() => auth()->user()?->hasRole('superadmin')),
                        Toggle::make('is_active')
                            ->label(__('agencies.is_active'))
                            ->default(true)
                            ->disabled(function (?User $record) {
                                if ($record === null) return false; // creating
                                $authUser = auth()->user();
                                if ($authUser->id === $record->id) return true;
                                if ($authUser->hasRole('superadmin')) return false;
                                if ($authUser->hasRole('admin')) {
                                    return $record->hasAnyRole(['superadmin', 'admin']);
                                }
                                return true;
                            })
                            ->helperText(function (?User $record) {
                                if ($record === null) return null;
                                $authUser = auth()->user();
                                if ($authUser->id === $record->id) {
                                    return __('users.cannot_deactivate_self');
                                }
                                if ($authUser->hasRole('admin') && $record->hasAnyRole(['superadmin', 'admin'])) {
                                    return __('users.cannot_deactivate_admin');
                                }
                                return null;
                            }),
                        Select::make('locale')
                            ->label('Locale')
                            ->options([
                                'es' => '🇪🇸 Español',
                                'en' => '🇬🇧 English',
                            ])
                            ->default('es'),
                    ])
                    ->columns(2),

                Section::make('Datos de contacto del agente')
                    ->description('Campos visibles en la ficha de la propiedad (sección "Contactar con el vendedor")')
                    ->collapsed()
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
                TextColumn::make('roles.name')
                    ->label('Roles')
                    ->badge()
                    ->color(fn(string $state) => match ($state) {
                        'superadmin'     => 'danger',
                        'admin'          => 'warning',
                        'agency_manager' => 'info',
                        'agent'          => 'success',
                        'user'           => 'gray',
                        default          => 'gray',
                    }),
                TextColumn::make('agencies.name')
                    ->label(__('agencies.resource'))
                    ->searchable()
                    ->default('—')
                    ->toggleable(),
                ToggleColumn::make('is_active')
                    ->label(__('agencies.is_active'))
                    ->disabled(function (User $record): bool {
                        $authUser = auth()->user();
                        // Cannot toggle yourself
                        if ($authUser->id === $record->id) return true;
                        // Superadmin can toggle anyone else
                        if ($authUser->hasRole('superadmin')) return false;
                        // Admin cannot toggle other admins or superadmins
                        if ($authUser->hasRole('admin')) {
                            return $record->hasAnyRole(['superadmin', 'admin']);
                        }
                        return true;
                    }),
                TextColumn::make('created_at')
                    ->label(__('filament.labels.created_at'))
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('roles')
                    ->label('Roles')
                    ->relationship('roles', 'name'),
                TernaryFilter::make('is_active')
                    ->label(__('agencies.is_active')),
            ])
            ->actions([
                Actions\EditAction::make(),

                // Assign role action (superadmin only)
                Actions\Action::make('assignRole')
                    ->label('Asignar rol')
                    ->icon('heroicon-o-shield-check')
                    ->color('warning')
                    ->form([
                        Select::make('roles')
                            ->label('Roles')
                            ->multiple()
                            ->options(Role::all()->pluck('name', 'name'))
                            ->required(),
                    ])
                    ->action(function (User $record, array $data) {
                        $record->syncRoles($data['roles']);
                        Notification::make()
                            ->title('Roles actualizados')
                            ->success()
                            ->send();
                    })
                    ->visible(fn() => auth()->user()?->hasRole('superadmin')),

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
            'index'  => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit'   => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
