<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RegistrationResource\Pages;
use App\Models\Registration;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class RegistrationResource extends Resource
{
    protected static ?string $model = Registration::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'Klinik & Rekam Medis';

    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'Pendaftaran';

    protected static ?string $pluralModelLabel = 'Pendaftaran';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Pendaftaran')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('patient_id')
                            ->label('Pasien')
                            ->relationship('patient', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\DatePicker::make('registration_date')
                            ->label('Tanggal Pendaftaran')
                            ->default(now())
                            ->required()
                            ->displayFormat('d/m/Y')
                            ->native(false),
                        Forms\Components\Select::make('medical_staff_id')
                            ->label('Tenaga Medis')
                            ->relationship('medicalStaff', 'name')
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'Antrian Poli' => 'Antrian Poli',
                                'Panggilan Poli' => 'Panggilan Poli',
                                'Farmasi' => 'Farmasi',
                                'Kasir' => 'Kasir',
                                'Selesai' => 'Selesai',
                                'Batal' => 'Batal',
                            ])
                            ->default('Antrian Poli')
                            ->required(),
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
                Tables\Columns\TextColumn::make('registration_date')
                    ->label('Tanggal')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('medicalStaff.name')
                    ->label('Tenaga Medis')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Antrian Poli' => 'warning',
                        'Panggilan Poli' => 'info',
                        'Farmasi' => 'purple',
                        'Kasir' => 'success',
                        'Selesai' => 'gray',
                        'Batal' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'Antrian Poli' => 'Antrian Poli',
                        'Panggilan Poli' => 'Panggilan Poli',
                        'Farmasi' => 'Farmasi',
                        'Kasir' => 'Kasir',
                        'Selesai' => 'Selesai',
                        'Batal' => 'Batal',
                    ]),
                Tables\Filters\SelectFilter::make('patient_id')
                    ->label('Pasien')
                    ->relationship('patient', 'name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\Filter::make('registration_date')
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
                                fn ($query, $date) => $query->whereDate('registration_date', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn ($query, $date) => $query->whereDate('registration_date', '<=', $date),
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
            'index' => Pages\ListRegistrations::route('/'),
            'create' => Pages\CreateRegistration::route('/create'),
            'calendar' => Pages\RegistrationCalendar::route('/calendar'),
            'view' => Pages\ViewRegistration::route('/{record}'),
            'edit' => Pages\EditRegistration::route('/{record}/edit'),
        ];
    }
}
