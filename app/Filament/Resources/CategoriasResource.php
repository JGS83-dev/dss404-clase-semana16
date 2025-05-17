<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoriasResource\Pages;
use App\Filament\Resources\CategoriasResource\RelationManagers;
use App\Models\Categorias;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoriasResource extends Resource
{
    protected static ?string $model = Categorias::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nombre')->required(),
                TextInput::make('descripcion'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre'),
                TextColumn::make('descripcion'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategorias::route('/'),
            'create' => Pages\CreateCategorias::route('/create'),
            'edit' => Pages\EditCategorias::route('/{record}/edit'),
        ];
    }
}
