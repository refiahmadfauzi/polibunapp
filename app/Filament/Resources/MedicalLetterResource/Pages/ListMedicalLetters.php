<?php
namespace App\Filament\Resources\MedicalLetterResource\Pages;
use App\Filament\Resources\MedicalLetterResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
class ListMedicalLetters extends ListRecords
{
    protected static string $resource = MedicalLetterResource::class;
    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
