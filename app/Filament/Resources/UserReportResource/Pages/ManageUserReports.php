<?php

namespace App\Filament\Resources\UserReportResource\Pages;

use App\Filament\Resources\UserReportResource;
use Filament\Actions;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;

class ManageUserReports extends ManageRecords
{
    protected static string $resource = UserReportResource::class;

      protected ?string $generatedPassword = null;


    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->successNotification(function () {
                    return Notification::make()
                        ->success()
                        ->title('Pembuatan User Berhasil!')
                        ->body('Default Password adalah: **' . session('generated_password') . '**')
                        ->persistent();
                }),
        ];
    }
    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Pembuatan User Berhasil!')
            ->body("Default Password adalah: **{$this->generatedPassword}**")
            ->persistent();
    }
}
