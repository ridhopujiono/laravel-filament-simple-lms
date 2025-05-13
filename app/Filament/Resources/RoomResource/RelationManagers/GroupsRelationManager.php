<?php

namespace App\Filament\Resources\RoomResource\RelationManagers;

use App\Filament\Resources\GroupResource;
use App\Models\Group;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\Layout\View;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GroupsRelationManager extends RelationManager
{
    protected static string $relationship = 'groups';
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $label = 'Daftar Kelompok';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Kelompok')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('members')
                    ->label('Anggota Kelompok')
                    ->relationship('members', 'name')
                    ->multiple(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->paginated(false)
            ->columns([
                View::make('filament.tables.columns.group-card')
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            // ->container(false)
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
                '2xl' => 4,
            ]);
    }

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return 'Daftar Kelompok';
    }
}
