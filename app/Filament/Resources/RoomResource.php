<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoomResource\Pages;
use App\Filament\Resources\RoomResource\RelationManagers;
use App\Models\Room;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\Layout\Grid;
use Filament\Tables\Columns\Layout\View;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class RoomResource extends Resource
{
    protected static ?string $model = Room::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Ruang Kolaborasi';

    public static function form(Form $form): Form
    {
        $isMahasiswa = auth()->user()?->hasRole('mahasiswa');

        return $form
            ->schema([
                $isMahasiswa
                    ? Placeholder::make('name')
                    ->label('Nama Ruang Kolaborasi')
                    ->content(fn($record) => $record?->name)
                    : Forms\Components\TextInput::make('name')
                    ->label('Nama Ruang Kolaborasi')
                    ->required(),

                $isMahasiswa
                    ? Placeholder::make('description')
                    ->label('Deskripsi Ruang Kolaborasi')
                    ->content(fn($record) => $record?->description)
                    : Forms\Components\Textarea::make('description')
                    ->label('Deskripsi Ruang Kolaborasi'),

                $isMahasiswa
                    ? Placeholder::make('instruction')
                    ->label('Instruksi Ruang Kolaborasi')
                    ->content(fn($record) => strip_tags($record?->instruction))
                    : RichEditor::make('instruction')
                    ->label('Instruksi Ruang Kolaborasi')
                    ->required(),

                $isMahasiswa
                    ? Placeholder::make('file_path')
                    ->label('File Ruang Kolaborasi')
                    ->content(
                        fn($record) => $record?->file_path
                            ? '<a href="' . Storage::url($record->file_path) . '" target="_blank">Download File</a>'
                            : 'Tidak ada file'
                    )
                    : Forms\Components\FileUpload::make('file_path')
                    ->directory('rooms')
                    ->label('File Ruang Kolaborasi')
                    ->required(),

                Forms\Components\Hidden::make('created_by')
                    ->default(fn() => auth()->id()),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->paginated(false)
            ->columns([
                View::make('filament.tables.columns.room-card')
            ])
            // ->container(false)
            ->contentGrid([
                'md' => 1,
                'xl' => 2,
                '2xl' => 3,
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\GroupsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRooms::route('/'),
            'create' => Pages\CreateRoom::route('/create'),
            'edit' => Pages\EditRoom::route('/{record}/edit'),
        ];
    }
}
