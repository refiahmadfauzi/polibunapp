<?php
namespace App\Filament\Resources\PharmacyTransactionResource\Pages;
use App\Filament\Resources\PharmacyTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
class ViewPharmacyTransaction extends ViewRecord
{
    protected static string $resource = PharmacyTransactionResource::class;
    protected function getHeaderActions(): array
    {
        return [Actions\EditAction::make()];
    }
}
