<?php
namespace App\Filament\Resources\RegistrationResource\Pages;
use App\Filament\Resources\RegistrationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
class ListRegistrations extends ListRecords
{
    protected static string $resource = RegistrationResource::class;
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('calendar')
            ->label('Calendar View')
            ->icon('heroicon-o-calendar')
            ->url(RegistrationResource::getUrl('calendar')),
        ];
    }
}
