<?php

namespace App\Filament\Resources\RoomResource\Pages;

use App\Filament\Resources\RoomResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\View\View;

class ListRooms extends ListRecords
{
    protected static string $resource = RoomResource::class;
    protected static ?string $title = 'Ruang Kolaborasi';
    // navigation label
    protected static ?string $navigationLabel = 'Ruang Kolaborasi';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getBreadcrumb(): ?string
    {
        return 'Ruang Kolaborasi'; // Ubah teks breadcrumb halaman list
    }

}
