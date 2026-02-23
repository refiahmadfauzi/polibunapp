<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PatientResource\Pages;
use App\Models\Patient;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationGroup = 'Klinik & Rekam Medis';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'Pasien';

    protected static ?string $pluralModelLabel = 'Pasien';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Pasien')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('gender')
                            ->label('Jenis Kelamin')
                            ->options([
                                'L' => 'Laki-laki',
                                'P' => 'Perempuan',
                            ])
                            ->required(),
                        Forms\Components\DatePicker::make('birth_date')
                            ->label('Tanggal Lahir')
                            ->maxDate(now())
                            ->displayFormat('d/m/Y')
                            ->native(false),
                        Forms\Components\TextInput::make('education')
                            ->label('Pendidikan')
                            ->maxLength(255),
                        Forms\Components\Select::make('insurance_type')
                            ->label('Jenis Asuransi')
                            ->options([
                                'BPJS' => 'BPJS',
                                'Umum' => 'Umum',
                            ])
                            ->default('Umum')
                            ->required(),
                        Forms\Components\TextInput::make('insurance_number')
                            ->label('Nomor Asuransi')
                            ->maxLength(255),
                        Forms\Components\Textarea::make('address')
                            ->label('Alamat')
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
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('gender')
                    ->label('JK')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'L' ? 'info' : 'warning')
                    ->formatStateUsing(fn (string $state): string => $state === 'L' ? 'Laki-laki' : 'Perempuan'),
                Tables\Columns\TextColumn::make('birth_date')
                    ->label('Tanggal Lahir')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('age')
                    ->label('Usia')
                    ->sortable()
                    ->getStateUsing(fn (Patient $record): ?int => $record->age),
                Tables\Columns\TextColumn::make('insurance_type')
                    ->label('Asuransi')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'BPJS' ? 'success' : 'gray'),
                Tables\Columns\TextColumn::make('insurance_number')
                    ->label('No. Asuransi')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('registrations_count')
                    ->label('Jumlah Pendaftaran')
                    ->counts('registrations')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('gender')
                    ->label('Jenis Kelamin')
                    ->options([
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan',
                    ]),
                Tables\Filters\SelectFilter::make('insurance_type')
                    ->label('Jenis Asuransi')
                    ->options([
                        'BPJS' => 'BPJS',
                        'Umum' => 'Umum',
                    ]),
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
            'index' => Pages\ListPatients::route('/'),
            'create' => Pages\CreatePatient::route('/create'),
            'view' => Pages\ViewPatient::route('/{record}'),
            'edit' => Pages\EditPatient::route('/{record}/edit'),
        ];
    }
}
