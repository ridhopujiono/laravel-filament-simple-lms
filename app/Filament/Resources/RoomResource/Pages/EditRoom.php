<?php

namespace App\Filament\Resources\RoomResource\Pages;

use App\Filament\Resources\RoomResource;
use Filament\Actions;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class EditRoom extends EditRecord
{
    protected static string $resource = RoomResource::class;
    protected static ?string $title = 'Ruang Kolaborasi';


    protected function canEdit(): bool
    {
        return Auth::user()->hasRole('admin') || Auth::user()->hasRole('dosen');
    }

    protected function getSaveFormAction(): \Filament\Actions\Action
    {
        return parent::getSaveFormAction()
            ->visible(function (): bool {
                return $this->canEdit();
            });
    }

    protected function getCancelFormAction(): \Filament\Actions\Action
    {
        return parent::getCancelFormAction()
            ->visible(function (): bool {
                return $this->canEdit();
            });
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getHeaderTitle(): ?string
    {
        return 'Edit Ruang Kolaborasi';
    }
}
