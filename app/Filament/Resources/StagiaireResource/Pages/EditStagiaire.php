<?php

namespace App\Filament\Resources\StagiaireResource\Pages;

use App\Filament\Resources\StagiaireResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStagiaire extends EditRecord
{
    protected static string $resource = StagiaireResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
