<?php

namespace App\Filament\Resources\GroupResource\Pages;

use App\Filament\Resources\GroupResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditGroup extends EditRecord
{
    protected static string $resource = GroupResource::class;

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

    protected function getFooterWidgets(): array
    {
        return [
            \Coolsam\NestedComments\Filament\Widgets\CommentsWidget::class,
        ];
    }

    public function getCommentsProperty()
    {
        return $this->record->comments()->latest()->get();
    }
}
