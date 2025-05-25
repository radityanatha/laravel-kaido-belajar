<?php

namespace App\Filament\Resources\PatientAppointmentResource\Pages;

use App\Filament\Resources\PatientAppointmentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePatientAppointment extends CreateRecord
{
    protected static string $resource = PatientAppointmentResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
