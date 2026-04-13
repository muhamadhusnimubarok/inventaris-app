<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';
    protected static ?string $navigationGroup = 'Data Barang';
    protected static ?string $navigationLabel = 'Kategori';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                  Forms\Components\TextInput::make('name')
                ->label('Nama')
                ->placeholder('Masukkan Nama')
                ->columnSpanFull()
                ->required(),
                  Forms\Components\Select::make('division_pj')
                ->label('Division PJ')
                ->options([
                    'Sapras' =>'Sapras', 
                    'Tata Usaha' => 'Tata Usaha',
                    'Tefa' => 'Tefa',
                ])
                ->placeholder('Pilih Division PJ')
                ->columnSpanFull()
                ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('No. ')->rowIndex(),
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('division_pj')->searchable(),


            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->button()->icon('heroicon-o-pencil'),
                Tables\Actions\DeleteAction::make()->button()->icon('heroicon-o-trash'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCategories::route('/'),
        ];
    }
}
