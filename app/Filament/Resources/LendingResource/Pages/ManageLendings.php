<?php

namespace App\Filament\Resources\LendingResource\Pages;

use App\Filament\Resources\LendingResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageLendings extends ManageRecords
{
    protected static string $resource = LendingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->visible(fn () => auth()->user()->hasRole('operator')),
        ];
    }
}
