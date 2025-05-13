<?php

namespace App\Filament\Resources\GroupResource\RelationManagers;

use App\Models\Submission;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SubmissionsRelationManager extends RelationManager
{
    protected static string $relationship = 'submissions';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')
                    ->default(Auth::id()),
                FileUpload::make('file_path')
                    ->directory('submissions')
                    ->required(),
                Forms\Components\TextInput::make('description')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('description')
            ->columns([
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // can create if this user in this group
                Tables\Actions\CreateAction::make()
                    ->visible(function () {
                        return Auth::user()->groups()->where('group_id', $this->ownerRecord->id)->exists();
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // show delete if this user in this group
                Tables\Actions\DeleteAction::make()
                    ->visible(function (Submission $record) {
                        return $record->user_id === Auth::id();
                    }),
                Tables\Actions\ViewAction::make(),
                // Download
                Tables\Actions\Action::make('download')
                    ->label('Download')
                    // ->icon('heroicon-o-download')
                    ->url(fn(Submission $record) => asset('storage/' . $record->file_path))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return 'Daftar Submission';
    }
}
