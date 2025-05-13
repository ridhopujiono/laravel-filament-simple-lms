<?php

namespace App\Filament\Resources\GroupResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class DiscussionsRelationManager extends RelationManager
{
    protected static string $relationship = 'discussions';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('user_id')->default(Auth::id()),

                Textarea::make('message')
                    ->rows(3)
                    ->placeholder('Tulis pesanmu di sini...')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('message')
            ->columns([
                TextColumn::make('user.name') // tampilkan nama user
                    ->label('Pengirim')
                    ->color('primary')
                    ->weight('bold'),

                TextColumn::make('message')
                    ->label('Pesan')
                    ->wrap(),

                TextColumn::make('created_at')
                    ->since()
                    ->label('Waktu'),
            ])
            ->defaultSort('created_at', 'desc') // biar terbaru di atas
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Kirim')
                    ->modalHeading('Kirim Pesan')
                    ->modalSubmitActionLabel('Kirim'),
            ])
            ->actions([]) // matikan edit/delete biar seperti chat
            ->bulkActions([]);
    }

}
