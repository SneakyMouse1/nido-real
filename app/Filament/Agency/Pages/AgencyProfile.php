<?php

namespace App\Filament\Agency\Pages;

use App\Models\Agency;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Placeholder;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AgencyProfile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-building-office';
    protected static ?int $navigationSort = 3;
    protected string $view = 'filament.agency.pages.agency-profile';

    public ?array $data = [];

    public static function getNavigationLabel(): string
    {
        return __('cabinet.agency_profile');
    }

    public function getTitle(): string
    {
        return __('cabinet.agency_profile');
    }

    /**
     * Only accessible to Agency Managers.
     */
    public static function canAccess(): bool
    {
        return auth()->user()?->hasRole('agency_manager') ?? false;
    }

    public function mount(): void
    {
        $agency = Filament::getTenant();
        $this->form->fill($agency->toArray());
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Section::make(__('cabinet.agency_info'))
                    ->schema([
                        TextInput::make('name')
                            ->label(__('agencies.name'))
                            ->required()
                            ->maxLength(255),
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

                Section::make(__('cabinet.current_plan'))
                    ->headerActions([
                        Action::make('upgrade_plan')
                            ->label(__('cabinet.upgrade_plan'))
                            ->icon('heroicon-o-credit-card')
                            ->url(route('billing.plans'))
                            ->color('warning'),
                    ])
                    ->schema([
                        Placeholder::make('plan_name')
                            ->label(__('agencies.plan'))
                            ->content(fn() => Filament::getTenant()->plan?->name ?? '—'),
                        Placeholder::make('listings_info')
                            ->label(__('cabinet.listings_usage'))
                            ->content(function () {
                                $agency = Filament::getTenant();
                                return "{$agency->listings_used} / {$agency->plan?->listings_limit}";
                            }),
                        Placeholder::make('plan_changed_at_display')
                            ->label(__('agencies.plan_changed_at'))
                            ->content(fn() => Filament::getTenant()->plan_changed_at?->format('d/m/Y H:i') ?? '—'),
                    ])
                    ->columns(3),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        $agency = Filament::getTenant();

        $agency->update($data);

        Notification::make()
            ->title(__('cabinet.profile_saved'))
            ->success()
            ->send();
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label(__('cabinet.save'))
                ->submit('save'),
        ];
    }
}
