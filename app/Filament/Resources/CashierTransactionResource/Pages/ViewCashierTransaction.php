<?php
namespace App\Filament\Resources\CashierTransactionResource\Pages;
use App\Filament\Resources\CashierTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
class ViewCashierTransaction extends ViewRecord
{
    protected static string $resource = CashierTransactionResource::class;
    protected function getHeaderActions(): array
    {
        return [Actions\EditAction::make()];
    }
}
