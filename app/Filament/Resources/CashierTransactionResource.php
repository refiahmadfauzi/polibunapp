<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CashierTransactionResource\Pages;
use App\Models\CashierTransaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class CashierTransactionResource extends Resource
{
    protected static ?string $model = CashierTransaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Accounting & Farmasi';

    protected static ?int $navigationSort = 3;

    protected static ?string $modelLabel = 'Transaksi Kasir';

    protected static ?string $pluralModelLabel = 'Transaksi Kasir';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Transaksi Kasir')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('registration_id')
                            ->label('Pendaftaran')
                            ->relationship('registration', 'id', fn ($query) => $query->with('patient'))
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->patient->name} - {$record->registration_date->format('d/m/Y')}")
                            ->searchable(['patient.name'])
                            ->preload(),
                        Forms\Components\Select::make('payment_method')
                            ->label('Metode Pembayaran')
                            ->options([
                                'Tunai' => 'Tunai',
                                'BPJS' => 'BPJS',
                                'Transfer' => 'Transfer',
                                'Lainnya' => 'Lainnya',
                            ])
                            ->default('Tunai')
                            ->required(),
                        Forms\Components\TextInput::make('total_amount')
                            ->label('Total')
                            ->numeric()
                            ->prefix('Rp')
                            ->required()
                            ->default(0),
                        Forms\Components\DatePicker::make('payment_date')
                            ->label('Tanggal Pembayaran')
                            ->default(now())
                            ->required()
                            ->displayFormat('d/m/Y')
                            ->native(false),
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
                Tables\Columns\TextColumn::make('registration.patient.name')
                    ->label('Pasien')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('registration.registration_date')
                    ->label('Tanggal Pendaftaran')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Tunai' => 'success',
                        'BPJS' => 'info',
                        'Transfer' => 'warning',
                        'Lainnya' => 'gray',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Total')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_date')
                    ->label('Tanggal Pembayaran')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->options([
                        'Tunai' => 'Tunai',
                        'BPJS' => 'BPJS',
                        'Transfer' => 'Transfer',
                        'Lainnya' => 'Lainnya',
                    ]),
                Tables\Filters\SelectFilter::make('registration_id')
                    ->label('Pendaftaran')
                    ->relationship('registration', 'id', fn ($query) => $query->with('patient'))
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->patient->name} - {$record->registration_date->format('d/m/Y')}")
                    ->searchable(['patient.name'])
                    ->preload(),
                Tables\Filters\Filter::make('payment_date')
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
                                fn ($query, $date) => $query->whereDate('payment_date', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn ($query, $date) => $query->whereDate('payment_date', '<=', $date),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCashierTransactions::route('/'),
            'create' => Pages\CreateCashierTransaction::route('/create'),
            'view' => Pages\ViewCashierTransaction::route('/{record}'),
            'edit' => Pages\EditCashierTransaction::route('/{record}/edit'),
        ];
    }
}
