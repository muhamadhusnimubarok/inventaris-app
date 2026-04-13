<?php

namespace App\Filament\Resources;

use App\Exports\ItemExport;
use App\Exports\UserReportExport;
use App\Filament\Resources\ItemResource\Pages;
use App\Filament\Resources\ItemResource\RelationManagers;
use App\Models\Item;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Notifications\Notification;


class ItemResource extends Resource
{
    protected static ?string $model = Item::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';
    protected static ?string $navigationGroup = 'Data Barang';
    protected static ?string $navigationLabel = 'Barang';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama')
                    ->placeholder('Masukkan Nama')
                    ->columnSpanFull()
                    ->required(),
                Forms\Components\Select::make('category_id')
                    ->label('Pilih Kategori')
                    ->searchable()
                    ->preload()
                    ->relationship('category', 'name')
                    ->placeholder('Pilih Division PJ')
                    ->columnSpanFull()
                    ->required(),
                Forms\Components\TextInput::make('total')
                    ->label('Total')
                    ->placeholder('Masukkan total')
                    ->columnSpanFull()
                    ->required(),

                Forms\Components\TextInput::make('new_broke_item')
                    ->label(fn($get) => "New Broke Item (currently: " . ($get('repair') ?? 0) . ")")
                    ->numeric()
                    ->visibleOn('edit')
                    ->helperText('Input angka untuk menambah jumlah data repair sebelumnya')
                    ->dehydrated(false)
                    ->afterStateUpdated(function ($state, $set, $get) {
                        if ($state > 0) {
                            $currentRepair = (int)$get('repair') ?? 0;
                            $set('repair', $currentRepair + (int)$state);
                        }
                    })->reactive(),

                Forms\Components\Hidden::make('repair')->default(0),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('No. ')->rowIndex(),
                Tables\Columns\TextColumn::make('category.name')->searchable()->label('Kategori'),
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('total')->searchable(),
                Tables\Columns\TextColumn::make('repair')->searchable(),
                Tables\Columns\TextColumn::make('available')
                    ->label('Available')
                    ->getStateUsing(function ($record) {
                        $ongoingLending = $record->lendingDetails()
                            ->whereHas('lending', fn($q) => $q->whereNull('return_date'))
                            ->sum('qty');
                        return $record->total - ($record->repair ?? 0) - $ongoingLending;
                    })
                    ->badge()
                    ->color(fn($state) => $state > 0 ? 'success' : 'danger'),
                Tables\Columns\TextColumn::make('lending_details_count')
                    ->counts([
                        'lendingDetails as lending_details_count' => function ($query) {
                            $query->whereHas('lending', fn($q) => $q->whereNull('return_date'));
                        },
                    ])->label('Lending')
                    ->formatStateUsing(fn($state) => $state > 0 ? "{$state} Items" : "0")
                    ->url(fn($record) => $record->lending_details_count > 0
                        ? LendingResource::getUrl('index', ['tableFilters[item_id][value]' => $record->id])
                        : null)
                    ->color(fn($state) => $state > 0 ? 'primary' : 'gray')
                    ->description(fn($state) => $state > 0 ? 'Click to see details' : '')

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->button()->color('primary'),
                Tables\Actions\DeleteAction::make()->button()->color('danger') ,

                // Tables\Actions\Action::make('fix_repair')
                //     ->label('Selesai Perbaikan')
                //     ->icon('heroicon-m-check-circle')
                //     ->color('success')
                //     ->requiresConfirmation()
                //     ->hidden(fn($record) => $record->repair <= 0)
                //     ->form([
                //         Forms\Components\TextInput::make('fixed_qty')
                //             ->label('Jumlah yang Selesai')
                //             ->numeric()
                //             ->required()
                //             ->maxValue(fn($record) => $record->repair)
                //     ])
                //     ->action(function ($record, array $data) {
                //         $record->decrement('repair', $data['fixed_qty']);

                //         $record->refreshAvailable();

                //         Notification::make()
                //             ->success()
                //             ->title('Barang kembali tersedia!')
                //             ->send();
                //     }),
            ])
            ->headerActions([
                Tables\Actions\Action::make('exportExcel')
                    ->label('Export')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->action(function () {
                        $fileName = 'Data_barang' . now()->format('Y-m-d') . '.xlsx';
                        return Excel::download(new ItemExport, $fileName);
                    }),
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
            'index' => Pages\ManageItems::route('/'),
        ];
    }
}
