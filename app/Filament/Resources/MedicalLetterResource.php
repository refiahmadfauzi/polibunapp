<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MedicalLetterResource\Pages;
use App\Models\MedicalLetter;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class MedicalLetterResource extends Resource
{
    protected static ?string $model = MedicalLetter::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationGroup = 'Klinik & Rekam Medis';

    protected static ?int $navigationSort = 5;

    protected static ?string $modelLabel = 'Surat Medis';

    protected static ?string $pluralModelLabel = 'Surat Medis';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Forms\Components\Section::make('Data Surat Medis')
            ->columns(2)
            ->schema([
                Forms\Components\Select::make('patient_id')
                ->label('Pasien')
                ->relationship('patient', 'name')
                ->searchable()
                ->preload()
                ->required(),
                Forms\Components\Select::make('type')
                ->label('Jenis Surat')
                ->options([
                    'Rujukan' => 'Surat Rujukan',
                    'Keterangan Sakit' => 'Surat Keterangan Sakit',
                ])
                ->required(),
                Forms\Components\RichEditor::make('description')
                ->label('Keterangan')
                ->required()
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
            Tables\Columns\TextColumn::make('patient.name')
            ->label('Pasien')
            ->searchable()
            ->sortable(),
            Tables\Columns\TextColumn::make('type')
            ->label('Jenis')
            ->badge()
            ->color(fn(string $state) => $state === 'Rujukan' ? 'info' : 'warning'),
            Tables\Columns\TextColumn::make('description')
            ->label('Keterangan')
            ->html()
            ->limit(50)
            ->toggleable(),
            Tables\Columns\TextColumn::make('created_at')
            ->label('Tanggal')
            ->dateTime('d/m/Y H:i')
            ->sortable(),
        ])
            ->filters([
            Tables\Filters\SelectFilter::make('type')
            ->label('Jenis Surat')
            ->options([
                'Rujukan' => 'Surat Rujukan',
                'Keterangan Sakit' => 'Surat Keterangan Sakit',
            ]),
            Tables\Filters\SelectFilter::make('patient_id')
            ->label('Pasien')
            ->relationship('patient', 'name')
            ->searchable()
            ->preload(),
        ])
            ->actions([
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
            Tables\Actions\Action::make('printPdf')
            ->label('Cetak PDF')
            ->icon('heroicon-o-printer')
            ->color('success')
            ->action(function (MedicalLetter $record) {
            $record->load('patient');
            $pdf = Pdf::loadView('pdf.medical-letter', ['letter' => $record]);
            return response()->streamDownload(
            fn() => print($pdf->output()),
                "surat-medis-{$record->id}.pdf"
            );
        }),
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
            'index' => Pages\ListMedicalLetters::route('/'),
            'create' => Pages\CreateMedicalLetter::route('/create'),
            'view' => Pages\ViewMedicalLetter::route('/{record}'),
            'edit' => Pages\EditMedicalLetter::route('/{record}/edit'),
        ];
    }
}
