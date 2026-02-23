<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PharmacyTransactionResource\Pages;
use App\Filament\Resources\PharmacyTransactionResource\RelationManagers;
use App\Models\PharmacyTransaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class PharmacyTransactionResource extends Resource
{
    protected static ?string $model = PharmacyTransaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationGroup = 'Accounting & Farmasi';

    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'Transaksi Farmasi';

    protected static ?string $pluralModelLabel = 'Transaksi Farmasi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Transaksi Farmasi')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('type')
                            ->label('Jenis Transaksi')
                            ->options([
                                'Penjualan' => 'Penjualan',
                                'Pembelian' => 'Pembelian',
                            ])
                            ->required(),
                        Forms\Components\DatePicker::make('date')
                            ->label('Tanggal')
                            ->default(now())
                            ->required()
                            ->displayFormat('d/m/Y')
                            ->native(false),
                        Forms\Components\TextInput::make('total_amount')
                            ->label('Total')
                            ->numeric()
                            ->prefix('Rp')
                            ->required()
                            ->default(0)
                            ->columnSpanFull(),
                        Forms\Components\Placeholder::make('items_info')
                            ->label('')
                            ->content('Item transaksi dapat dikelola di halaman detail transaksi.')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Jenis')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'Penjualan' ? 'success' : 'info'),
                Tables\Columns\TextColumn::make('date')
                    ->label('Tanggal')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('items_count')
                    ->label('Jumlah Item')
                    ->counts('items')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Total')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Jenis Transaksi')
                    ->options([
                        'Penjualan' => 'Penjualan',
                        'Pembelian' => 'Pembelian',
                    ]),
                Tables\Filters\Filter::make('date')
                    ->form([
                        Forms\Components\DatePicker::make('from')
                            ->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('until')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when(
                                $data['from'],
                                fn ($query, $date) => $query->whereDate('date', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn ($query, $date) => $query->whereDate('date', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPharmacyTransactions::route('/'),
            'create' => Pages\CreatePharmacyTransaction::route('/create'),
            'view' => Pages\ViewPharmacyTransaction::route('/{record}'),
            'edit' => Pages\EditPharmacyTransaction::route('/{record}/edit'),
        ];
    }
}
