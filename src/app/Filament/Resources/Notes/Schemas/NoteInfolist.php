<?php

namespace App\Filament\Resources\Notes\Schemas;

use App\Models\Note;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class NoteInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('client_id')
                    ->numeric(),
                TextEntry::make('content')
                    ->columnSpanFull(),
                IconEntry::make('is_important')
                    ->boolean(),
                TextEntry::make('created_by')
                    ->numeric(),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Note $record): bool => $record->trashed()),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
