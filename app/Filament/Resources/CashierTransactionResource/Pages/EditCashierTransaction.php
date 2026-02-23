<?php
namespace App\Filament\Resources\CashierTransactionResource\Pages;
use App\Filament\Resources\CashierTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
class EditCashierTransaction extends EditRecord
{
    protected static string $resource = CashierTransactionResource::class;
    protected function getHeaderActions(): array
    {
        return [Actions\ViewAction::make(), Actions\DeleteAction::make()];
    }
}
