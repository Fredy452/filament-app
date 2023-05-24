<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VentaResource\Pages;
use App\Filament\Resources\VentaResource\RelationManagers;
use App\Models\Venta;
use App\Models\Cliente;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
// filters
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
// Export
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
// hiden input
use Filament\Forms\Components\Hidden;
// FIELDSET
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Card;
//BelongsToRelation
use Filament\Forms\Components\Select;

class VentaResource extends Resource
{
    protected static ?string $model = Venta::class;
    // blobal searchable
    protected static ?string $recordTitleAttribute = 'numero_factura';

    protected static ?string $navigationIcon = 'heroicon-o-lightning-bolt';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                ->schema([
                    Forms\Components\Hidden::make('users_id')
                    ->default(fn () => auth()->user()->id),
                    Forms\Components\Select::make('clientes_id')
                    ->label('Cliente')
                        ->required()->options(Cliente::all()
                        ->pluck('nombre', 'id'))
                        ->preload()
                        ->searchable(),
                    Forms\Components\Select::make('metodo_pagos_id')
                        ->required()->relationship('metodo_pagos', 'nombre')->default(1),
                        Forms\Components\TextInput::make('numero_factura')
                            ->required()
                            ->maxLength(255)
                            ->unique(),
                        Forms\Components\DateTimePicker::make('fecha')
                            ->required()->default(fn () => now())->disabled(),
                        Forms\Components\Select::make('estado_pagos_id')
                        ->relationship('estado_pagos', 'nombre')->default('pagado')->default(1)
                        ->label('Estado'),
                        Forms\Components\TextInput::make('total_venta'),
                ])
                ->columns(2),
                Card::make()
                    ->schema([
                        Select::make('productos')
                            ->multiple()
                            ->relationship('productos', 'nombre')
                            ->preload()
                            ->searchable()
                            ->multiple(),
                    ])
            ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('users.name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('metodo_pagos.nombre'),
                Tables\Columns\TextColumn::make('estado_pagos.nombre'),
                Tables\Columns\TextColumn::make('fecha')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('numero_factura')->searchable(),
                Tables\Columns\TextColumn::make('clientes.nombre'),
                Tables\Columns\TextColumn::make('total_venta'),
            ])
            ->filters([
                SelectFilter::make('Estado')->relationship('estado_pagos', 'nombre'),//filtrar por tipo
                SelectFilter::make('Metodo de pago')->relationship('metodo_pagos', 'nombre'),//filtrar por metodo pago
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                FilamentExportBulkAction::make('export'),
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ProductosRelationManager::class,
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
