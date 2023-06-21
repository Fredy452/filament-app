<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VentaResource\Pages;
use App\Filament\Resources\VentaResource\RelationManagers;
use App\Models\Venta;
use App\Models\Cliente;
use App\Models\Producto;
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
// Section
use Filament\Forms\Components\Section;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Placeholder;

class VentaResource extends Resource
{
    protected static ?string $model = Venta::class;
    // blobal searchable
    protected static ?string $recordTitleAttribute = 'numero_factura';

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';

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
                        ->disabled()
                        ->default('OR-' . random_int(100000, 999999)),
                    Forms\Components\DateTimePicker::make('fecha')
                        ->default(fn () => now())->disabled(),
                        Forms\Components\Select::make('estado_pagos_id')
                        ->relationship('estado_pagos', 'nombre')->default('pagado')->default(1)
                        ->label('Estado'),
                    Forms\Components\TextInput::make('total_venta')//Quiero guaradar en este la suma de todas las ventas
                        ->reactive(),
                ])
                ->columns(2),

                Section::make('Productos')
                ->description('Agregar productos')
                ->collapsible()
                ->schema([
                    // products
                    Repeater::make('productos')
                            ->relationship()
                            ->schema([
                                Select::make('producto_id')
                                    ->label('Producto')
                                    ->options(Producto::all()->pluck('nombre', 'id'))
                                    ->required()
                                    ->searchable()
                                    ->reactive()
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('precio', Producto::find($state)?->precio ?? 0))
                                    ->columnSpan([
                                        'md' => 5,
                                    ]),

                                Forms\Components\TextInput::make('cantidad')
                                    ->numeric()
                                    ->default(1)
                                    ->reactive()
                                    ->afterStateUpdated(fn ($state, callable $set, callable $get) => $set('precio', $state * $get('precio')))
                                    ->columnSpan([
                                        'md' => 2,
                                    ])
                                    ->required(),
                                Forms\Components\TextInput::make('precio')
                                    ->label('Precio Unitario')
                                    ->disabled()
                                    ->numeric()
                                    ->required()
                                    ->columnSpan([
                                        'md' => 3,
                                    ]),
                            ])
                            ->orderable()
                            ->defaultItems(1)
                            ->disableLabel()
                            ->columns([
                                'md' => 10,
                            ])
                            ->required(),
                ])
            ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('numero_factura')->label('N°')->searchable(),
                Tables\Columns\TextColumn::make('estado_pagos.nombre')->label('Estado'),
                Tables\Columns\TextColumn::make('users.name'),
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
                Tables\Actions\DetachBulkAction::make(),
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
