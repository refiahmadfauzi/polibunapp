<?php

namespace App\Filament\Resources\RegistrationResource\Pages;

use App\Filament\Resources\RegistrationResource;
use App\Models\Registration;
use Filament\Resources\Pages\Page;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class RegistrationCalendar extends Page
{
    protected static string $resource = RegistrationResource::class;

    protected static string $view = 'filament.resources.registration-resource.pages.registration-calendar';

    protected static ?string $title = 'Kalender Pendaftaran';

    public function getWidgets(): array
    {
        return [
            RegistrationCalendarWidget::class,
        ];
    }

    public function getWidgetsColumns(): int | array
    {
        return 1;
    }
}
