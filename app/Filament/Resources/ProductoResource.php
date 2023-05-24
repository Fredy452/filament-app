<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductoResource\Pages;
use App\Filament\Resources\ProductoResource\RelationManagers;
use App\Models\Producto;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
// Spatie
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
// Export
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
// filters
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;



class ProductoResource extends Resource
{
    protected static ?string $model = Producto::class;

     // Filtro para global filter
     protected static ?string $recordTitleAttribute = 'nombre';


    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('descripción')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('precio')
                    ->required(),
                SpatieMediaLibraryFileUpload::make('imagen')->collection('productos'),
                Forms\Components\Select::make('medida_id')
                        ->required()->relationship('medida', 'nombre'),
                Forms\Components\Select::make('proveedors_id')
                        ->label('Proveedor')
                        ->relationship('proveedors', 'nombre'),
                Forms\Components\TextInput::make('stock')
                    ->required(),
                Forms\Components\Select::make('categoria_producto_id')
                    ->required()->relationship('categoria_producto', 'nombre'),
                Forms\Components\Toggle::make('promocion')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('imagen')->collection('productos'),
                Tables\Columns\TextColumn::make('nombre')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('descripción'),
                Tables\Columns\TextColumn::make('precio'),
                Tables\Columns\TextColumn::make('stock'),
                Tables\Columns\TextColumn::make('medida.nombre'),
                Tables\Columns\TextColumn::make('categoria_producto.nombre')->label('Categoria'),
                Tables\Columns\TextColumn::make('proveedors.nombre')->label('Proveedor'),
                Tables\Columns\IconColumn::make('promocion')
                    ->boolean(),
            ])
            ->filters([
                // Creamos filtro para promoción
                Filter::make('En promoción')->toggle()
                ->query(fn (Builder $query): Builder => $query->where('promocion', true)),
                Filter::make('Sin promoción')->toggle()
                ->query(fn (Builder $query): Builder => $query->where('promocion', false)),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductos::route('/'),
            'create' => Pages\CreateProducto::route('/create'),
            'view' => Pages\ViewProducto::route('/{record}'),
            'edit' => Pages\EditProducto::route('/{record}/edit'),
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
