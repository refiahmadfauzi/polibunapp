<?php
namespace App\Filament\Resources\MedicalLetterResource\Pages;
use App\Filament\Resources\MedicalLetterResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
class EditMedicalLetter extends EditRecord
{
    protected static string $resource = MedicalLetterResource::class;
    protected function getHeaderActions(): array
    {
        return [Actions\ViewAction::make(), Actions\DeleteAction::make()];
    }
}
