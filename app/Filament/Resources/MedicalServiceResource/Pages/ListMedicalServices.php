<?php
namespace App\Filament\Resources\MedicalServiceResource\Pages;
use App\Filament\Resources\MedicalServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
class ListMedicalServices extends ListRecords
{
    protected static string $resource = MedicalServiceResource::class;
    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
