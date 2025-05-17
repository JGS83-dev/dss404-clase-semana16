<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VentasResource\Pages;
use App\Filament\Resources\VentasResource\RelationManagers;
use App\Models\Productos;
use App\Models\Ventas;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Log;

class VentasResource extends Resource
{
    protected static ?string $model = Ventas::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('id_producto')->relationship('producto', 'nombre')->required()
                    ->live()
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        Self::CalcularTotalVenta($get, $set);
                    }),
                TextInput::make('codigo')->required(),
                TextInput::make('cantidad')->numeric()->required()
                    ->live()
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        Self::CalcularTotalVenta($get, $set);
                    }),
                TextInput::make('totalVenta')->numeric()->required()->readOnly(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('producto.nombre')->sortable(),
                TextColumn::make('codigo'),
                TextColumn::make('cantidad'),
                TextColumn::make('totalVenta')->money('USD')->sortable()
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

    public static function CalcularTotalVenta(Get $get, Set $set): void
    {
        try {
            $producto = Productos::select('precio','stock')->where('id', $get('id_producto'));
            $precioProducto = $producto->value('precio');
            $stock = $producto->value('stock');
            if($get('cantidad')>$stock){
                $set('cantidad',$stock);
                Notification::make()
                        ->title('No se puede exceder el Stock del producto')
                        ->color('danger')
                        ->danger()
                        ->duration(3000)
                        ->send();
            }
            $totalVenta = $get('cantidad') * $precioProducto;
            $set('totalVenta',$totalVenta);
        } catch (\Throwable $th) {
            Log::error('Error al calcular total de venta: ' . $th->getMessage());
        }
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVentas::route('/'),
            'create' => Pages\CreateVentas::route('/create'),
            'edit' => Pages\EditVentas::route('/{record}/edit'),
        ];
    }
}
