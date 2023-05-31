<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClienteResource\Pages;
use App\Filament\Resources\ClienteResource\RelationManagers;
use App\Models\Cliente;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
// Export
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
// filters
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;


class ClienteResource extends Resource
{
    protected static ?string $model = Cliente::class;

    // Filtro para global filter
    protected static ?string $recordTitleAttribute = 'nombre';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                    SpatieMediaLibraryFileUpload::make('imagen')->collection('clientes'),
                    Forms\Components\Select::make('tipo_cliente_id')
                        ->relationship('tipo_clientes', 'nombre'),
                    Forms\Components\TextInput::make('nombre')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('apellido')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('direccion')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('telefono')
                        ->tel()
                        ->required()
                        ->maxLength(20),
                    Forms\Components\TextInput::make('correo')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\DatePicker::make('fecha_registro')
                        ->required()->default(fn () => now())->disabled(),
                    Forms\Components\TextInput::make('total_gasto'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('imagen')->collection('clientes'),
                Tables\Columns\TextColumn::make('nombre')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('apellido'),
                Tables\Columns\TextColumn::make('direccion'),
                Tables\Columns\TextColumn::make('telefono'),
                Tables\Columns\TextColumn::make('correo')->searchable(),
                Tables\Columns\TextColumn::make('fecha_registro')
                    ->date(),
                Tables\Columns\TextColumn::make('tipo_clientes.nombre')->label('Tipo'),
                Tables\Columns\TextColumn::make('total_gasto'),
            ])
            ->filters([
                SelectFilter::make('Tipo')->relationship('tipo_clientes', 'nombre'),//filtrar por tipo
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
                FilamentExportBulkAction::make('export'),//exportar
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
            'index' => Pages\ListClientes::route('/'),
            'create' => Pages\CreateCliente::route('/create'),
            'view' => Pages\ViewCliente::route('/{record}'),
            'edit' => Pages\EditCliente::route('/{record}/edit'),
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
