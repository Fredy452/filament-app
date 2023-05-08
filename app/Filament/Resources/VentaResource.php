<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VentaResource\Pages;
use App\Filament\Resources\VentaResource\RelationManagers;
use App\Models\Venta;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VentaResource extends Resource
{
    protected static ?string $model = Venta::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('name')
                    ->required()->relationship('users', 'name')->default(fn () =>
                    auth()->user()->id)->hidden(),
                Forms\Components\Select::make('cliente_id')
                    ->required()->relationship('clientes', 'nombre'),
                Forms\Components\Select::make('metodo_pago_id')
                    ->required()->relationship('metodo_pagos', 'nombre')->default(1),
                Forms\Components\Select::make('estado_pago_id')
                    ->relationship('estado_pagos', 'nombre')->default('pagado')->default(1),
                Forms\Components\DateTimePicker::make('fecha')
                    ->required()->default(fn () => now()),
                Forms\Components\TextInput::make('numero_factura')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('total_venta'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('users.name'),
                Tables\Columns\TextColumn::make('metodo_pago_id'),
                Tables\Columns\TextColumn::make('estado_pago_id'),
                Tables\Columns\TextColumn::make('fecha')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('numero_factura'),
                Tables\Columns\TextColumn::make('cliente_id'),
                Tables\Columns\TextColumn::make('categoria_producto_id'),
                Tables\Columns\TextColumn::make('total_venta'),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListVentas::route('/'),
            'create' => Pages\CreateVenta::route('/create'),
            'view' => Pages\ViewVenta::route('/{record}'),
            'edit' => Pages\EditVenta::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
