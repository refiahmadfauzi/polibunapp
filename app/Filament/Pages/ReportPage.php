<?php

namespace App\Filament\Pages;

use App\Models\CashierTransaction;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Database\Eloquent\Builder;

class ReportPage extends Page implements HasTable, HasForms
{
    use InteractsWithTable, InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationGroup = 'Accounting & Farmasi';

    protected static ?int $navigationSort = 4;

    protected static ?string $title = 'Laporan';

    protected static ?string $navigationLabel = 'Laporan';

    protected static string $view = 'filament.pages.report-page';

    public string $activeTab = 'per_medis';

    public function updatedActiveTab(): void
    {
        $this->resetTable();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(fn() => match ($this->activeTab) {
            'per_medis' => $this->queryPerMedis(),
            'per_metode' => $this->queryPerMetode(),
            'margin' => $this->queryMargin(),
            'batal' => $this->queryBatal(),
            default => $this->queryPerMedis(),
        })
            ->columns(match ($this->activeTab) {
                'per_medis' => $this->columnsPerMedis(),
                'per_metode' => $this->columnsPerMetode(),
                'margin' => $this->columnsMargin(),
                'batal' => $this->columnsBatal(),
                default => $this->columnsPerMedis(),
            })
            ->filters([
            Tables\Filters\Filter::make('date_range')
            ->form([
                \Filament\Forms\Components\DatePicker::make('from')->label('Dari'),
                \Filament\Forms\Components\DatePicker::make('until')->label('Sampai'),
            ])
            ->query(function (Builder $query, array $data): Builder {
            return $query
                ->when($data['from'], fn(Builder $q, $d) => $q->whereDate('payment_date', '>=', $d))
                ->when($data['until'], fn(Builder $q, $d) => $q->whereDate('payment_date', '<=', $d));
        }),
        ])
            ->bulkActions([
            \pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction::make(),
        ]);
    }

    protected function queryPerMedis(): Builder
    {
        return CashierTransaction::query()
            ->with(['registration.medicalStaff', 'registration.patient']);
    }

    protected function columnsPerMedis(): array
    {
        return [
            Tables\Columns\TextColumn::make('id')->label('ID')->sortable(),
            Tables\Columns\TextColumn::make('registration.medicalStaff.name')->label('Tenaga Medis')->searchable()->default('-'),
            Tables\Columns\TextColumn::make('registration.patient.name')->label('Pasien')->searchable()->default('-'),
            Tables\Columns\TextColumn::make('total_amount')->label('Total')->money('IDR')->sortable(),
            Tables\Columns\TextColumn::make('payment_date')->label('Tanggal')->date('d/m/Y')->sortable(),
            Tables\Columns\TextColumn::make('payment_method')->label('Metode')->badge(),
        ];
    }

    protected function queryPerMetode(): Builder
    {
        return CashierTransaction::query();
    }

    protected function columnsPerMetode(): array
    {
        return [
            Tables\Columns\TextColumn::make('id')->label('ID')->sortable(),
            Tables\Columns\TextColumn::make('payment_method')->label('Metode Pembayaran')->badge()
            ->color(fn(string $state): string => match ($state) {
            'Tunai' => 'success', 'BPJS' => 'info', 'Transfer' => 'warning', default => 'gray',
        })->sortable(),
            Tables\Columns\TextColumn::make('total_amount')->label('Total')->money('IDR')->sortable(),
            Tables\Columns\TextColumn::make('payment_date')->label('Tanggal')->date('d/m/Y')->sortable(),
            Tables\Columns\TextColumn::make('registration.patient.name')->label('Pasien')->searchable()->default('-'),
        ];
    }

    protected function queryMargin(): Builder
    {
        return \App\Models\PharmacyTransaction::query();
    }

    protected function columnsMargin(): array
    {
        return [
            Tables\Columns\TextColumn::make('id')->label('ID')->sortable(),
            Tables\Columns\TextColumn::make('type')->label('Tipe')->badge()
            ->color(fn(string $state) => $state === 'Penjualan' ? 'success' : 'info'),
            Tables\Columns\TextColumn::make('total_amount')->label('Total')->money('IDR')->sortable(),
            Tables\Columns\TextColumn::make('date')->label('Tanggal')->date('d/m/Y')->sortable(),
            Tables\Columns\TextColumn::make('transaction_items_count')->label('Jumlah Item')->counts('transactionItems'),
        ];
    }

    protected function queryBatal(): Builder
    {
        return \App\Models\Registration::query()
            ->where('status', 'Batal')
            ->with(['patient', 'medicalStaff']);
    }

    protected function columnsBatal(): array
    {
        return [
            Tables\Columns\TextColumn::make('id')->label('No. Reg')->sortable(),
            Tables\Columns\TextColumn::make('patient.name')->label('Pasien')->searchable(),
            Tables\Columns\TextColumn::make('medicalStaff.name')->label('Tenaga Medis')->searchable()->default('-'),
            Tables\Columns\TextColumn::make('registration_date')->label('Tgl Daftar')->date('d/m/Y')->sortable(),
            Tables\Columns\TextColumn::make('status')->label('Status')->badge()->color('danger'),
        ];
    }
}
