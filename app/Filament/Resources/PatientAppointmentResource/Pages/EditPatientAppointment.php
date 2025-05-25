<?php

namespace App\Filament\Resources\PatientAppointmentResource\Pages;

use App\Filament\Resources\PatientAppointmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPatientAppointment extends EditRecord
{
    protected static string $resource = PatientAppointmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
