<?php
namespace App\Filament\Resources\CashierTransactionResource\Pages;
use App\Filament\Resources\CashierTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
class ListCashierTransactions extends ListRecords
{
    protected static string $resource = CashierTransactionResource::class;
    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
