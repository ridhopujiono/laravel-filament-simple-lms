<?php

namespace App\Filament\Resources\GroupResource\Widgets;

use Filament\Forms;
use Filament\Widgets\Widget;
use App\Models\Discussion;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Form;

class GroupChatWidget extends Widget
{
    protected static string $view = 'filament.resources.group-resource.widgets.group-chat-widget';

    public $group;
    public $message = '';

    public function mount($record)
    {
        $this->group = $record;
    }

    public function send()
    {
        if (trim($this->message) === '') return;

        Discussion::create([
            'group_id' => $this->group->id,
            'user_id' => Auth::id(),
            'message' => $this->message,
        ]);

        $this->reset('message');
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Textarea::make('message')
                ->placeholder('Tulis pesan...')
                ->autosize()
                ->required(),
        ]);
    }

    protected function getFormModel(): static
    {
        return $this;
    }
}
