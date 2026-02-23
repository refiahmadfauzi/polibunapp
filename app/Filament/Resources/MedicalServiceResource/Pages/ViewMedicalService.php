<?php
namespace App\Filament\Resources\MedicalServiceResource\Pages;
use App\Filament\Resources\MedicalServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
class ViewMedicalService extends ViewRecord
{
    protected static string $resource = MedicalServiceResource::class;
    protected function getHeaderActions(): array
    {
        return [Actions\EditAction::make()];
    }
}
