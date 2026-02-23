<?php

namespace App\Filament\Resources\RegistrationResource\Pages;

use App\Models\Registration;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Saade\FilamentFullCalendar\Data\EventData;
use App\Filament\Resources\RegistrationResource;

class RegistrationCalendarWidget extends FullCalendarWidget
{
    public Model|string|null $model = Registration::class;

    public function fetchEvents(array $fetchInfo): array
    {
        return Registration::with(['patient', 'medicalStaff'])
            ->whereBetween('registration_date', [
                Carbon::parse($fetchInfo['start'])->startOfDay(),
                Carbon::parse($fetchInfo['end'])->endOfDay()
            ])
            ->get()
            ->map(function (Registration $registration) {
                // Handle null patient
                if (!$registration->patient) {
                    return null;
                }

                $color = match ($registration->status) {
                    'Antrian Poli' => '#f59e0b',
                    'Panggilan Poli' => '#3b82f6',
                    'Farmasi' => '#8b5cf6',
                    'Kasir' => '#10b981',
                    'Selesai' => '#6b7280',
                    'Batal' => '#ef4444',
                    default => '#6b7280',
                };

                return EventData::make()
                    ->id($registration->id)
                    ->title($registration->patient->name . ' - ' . $registration->status)
                    ->start($registration->registration_date->format('Y-m-d'))
                    ->end($registration->registration_date->format('Y-m-d'))
                    ->backgroundColor($color)
                    ->borderColor($color)
                    ->url(RegistrationResource::getUrl('view', ['record' => $registration->id]));
            })
            ->filter() // Remove null values
            ->values() // Re-index array
            ->toArray();
    }
}
