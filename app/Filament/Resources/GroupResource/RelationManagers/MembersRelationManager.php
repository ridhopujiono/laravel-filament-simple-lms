<?php

namespace App\Filament\Resources\GroupResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MembersRelationManager extends RelationManager
{
    protected static string $relationship = 'members';

    protected static ?string $label = 'Anggota Kelompok';
    protected static ?string $title = 'Daftar Anggota';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id'),
            ])
            ->headerActions([])
            ->actions([])
            ->paginated(false);
    }
}
