<?php
namespace App\Filament\Resources\MedicalLetterResource\Pages;
use App\Filament\Resources\MedicalLetterResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
class ViewMedicalLetter extends ViewRecord
{
    protected static string $resource = MedicalLetterResource::class;
    protected function getHeaderActions(): array
    {
        return [Actions\EditAction::make()];
    }
}
