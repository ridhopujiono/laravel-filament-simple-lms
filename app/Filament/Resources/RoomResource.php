<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoomResource\Pages;
use App\Filament\Resources\RoomResource\RelationManagers;
use App\Models\Room;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
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
                Card::make() // Bungkus semua field dalam Card
                    ->schema([
                        $isMahasiswa
                            ? Placeholder::make('name')
                            ->label('') // kosongkan label bawaan
                            ->content(fn($record) => new \Illuminate\Support\HtmlString('
                                <label class="text-sm font-bold text-gray-800 block mb-1">Nama Ruang Kolaborasi</label>
                                ' . $record?->name . '
                            '))
                            : TextInput::make('name')
                            ->label('Nama Ruang Kolaborasi')
                            ->required(),

                        $isMahasiswa
                            ? Placeholder::make('description')
                            ->label('') // kosongkan label bawaan
                            ->content(fn($record) => new \Illuminate\Support\HtmlString('
                                <label class="text-sm font-bold text-gray-800 block mb-1">Deskripsi Ruang Kolaborasi</label>
                                ' . $record?->description . '
                            '))
                            : Textarea::make('description')
                            ->label('Deskripsi Ruang Kolaborasi'),

                        $isMahasiswa
                            ? Placeholder::make('instruction')
                            ->label('') // kosongkan label bawaan
                            ->content(fn($record) => new \Illuminate\Support\HtmlString('
                                <label class="text-sm font-bold text-gray-800 block mb-1">Instruksi Ruang Kolaborasi</label>
                                ' . $record?->instruction . '
                            '))
                            : RichEditor::make('instruction')
                            ->label('Instruksi Ruang Kolaborasi')
                            ->required(),


                        $isMahasiswa
                            ? Placeholder::make('file_path')
                            ->label('File Ruang Kolaborasi')
                            ->content(
                                fn($record) => $record?->file_path
                                    ? new \Illuminate\Support\HtmlString('<a class="inline-flex items-center px-4 py-2 text-dark text-sm font-semibold rounded-lg shadow-md transition duration-300" href="' . Storage::url($record->file_path) . '" target="_blank" download="' . $record->name . '">Download File</a>')
                                    : 'Tidak ada file'
                            )
                            : FileUpload::make('file_path')
                            ->directory('rooms')
                            ->label('File Ruang Kolaborasi')
                            ->required(),

                        Forms\Components\Hidden::make('created_by')
                            ->default(fn() => auth()->id()),
                    ])
                    ->columns(1), // Atur kolom dalam card jika diperlukan
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
