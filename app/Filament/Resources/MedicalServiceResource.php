<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MedicalServiceResource\Pages;
use App\Models\MedicalService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class MedicalServiceResource extends Resource
{
    protected static ?string $model = MedicalService::class;

    protected static ?string $navigationIcon = 'heroicon-o-heart';

    protected static ?string $navigationGroup = 'Klinik & Rekam Medis';

    protected static ?int $navigationSort = 4;

    protected static ?string $modelLabel = 'Layanan Medis';

    protected static ?string $pluralModelLabel = 'Layanan Medis';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Layanan Medis')
                    ->schema([
                        Forms\Components\Select::make('registration_id')
                            ->label('Pendaftaran')
                            ->relationship('registration', 'id', fn ($query) => $query->with('patient'))
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->patient->name} - {$record->registration_date->format('d/m/Y')}")
                            ->searchable(['patient.name'])
                            ->preload()
                            ->required(),
                        Forms\Components\RichEditor::make('examination_details')
                            ->label('Detail Pemeriksaan')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('notes')
                            ->label('Catatan')
                            ->rows(3)
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
                Tables\Columns\TextColumn::make('registration.patient.name')
                    ->label('Pasien')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('registration.registration_date')
                    ->label('Tanggal Pendaftaran')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('examination_details')
                    ->label('Detail Pemeriksaan')
                    ->html()
                    ->limit(50)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('notes')
                    ->label('Catatan')
                    ->limit(50)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('registration_id')
                    ->label('Pendaftaran')
                    ->relationship('registration', 'id', fn ($query) => $query->with('patient'))
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->patient->name} - {$record->registration_date->format('d/m/Y')}")
                    ->searchable(['patient.name'])
                    ->preload(),
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
            'index' => Pages\ListMedicalServices::route('/'),
            'create' => Pages\CreateMedicalService::route('/create'),
            'view' => Pages\ViewMedicalService::route('/{record}'),
            'edit' => Pages\EditMedicalService::route('/{record}/edit'),
        ];
    }
}
