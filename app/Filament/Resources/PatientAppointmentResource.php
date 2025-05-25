<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PatientAppointmentResource\Pages;
use App\Models\PatientAppointment;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class PatientAppointmentResource extends Resource
{
    protected static ?string $model = PatientAppointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('patient_id')
                    ->relationship('patient', 'name')
                    ->required()
                    ->searchable(),

                Forms\Components\Select::make('doctor_id')
                    ->relationship('doctor', 'name')
                    ->required(),

                Forms\Components\DatePicker::make('date_of_appointment')
                    ->required(),

                Forms\Components\Textarea::make('note')
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('prescription')
                    ->columnSpanFull(),

                Forms\Components\Select::make('status')
                    ->options([
                        'jadwal dibuat' => 'Jadwal Dibuat',
                        'selesai periksa' => 'Selesai Periksa',
                        'obat sudah diserahkan' => 'Obat Sudah Diberikan'
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table

            ->modifyQueryUsing(function (Builder $query) {
                $isDoctor = Auth::user()->hasRole('Dokter');
                $isApoteker = Auth::user()->hasRole('Apoteker');

                if ($isDoctor) {
                    $userId = Auth::user()->id;
                    $query->where('doctor_id', $userId);
                }

                if ($isApoteker) {
                    $query->where('status', 'selesai periksa')->orWhere('status', 'obat sudah diserahkan');
                }
            })
            ->columns([
                Tables\Columns\TextColumn::make('patient.name')
                    ->sortable(),

                Tables\Columns\TextColumn::make('doctor.name')
                    ->sortable(),

                Tables\Columns\TextColumn::make('date_of_appointment')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPatientAppointments::route('/'),
            'create' => Pages\CreatePatientAppointment::route('/create'),
            'edit' => Pages\EditPatientAppointment::route('/{record}/edit'),
        ];
    }
}
