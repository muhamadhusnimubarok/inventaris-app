<?php

namespace App\Filament\Resources;

use App\Exports\LandingExport;
use App\Exports\LendingExport;
use App\Filament\Resources\LendingResource\Pages;
use App\Filament\Resources\LendingResource\RelationManagers;
use App\Models\Lending;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Notifications\Notification;
use Maatwebsite\Excel\Facades\Excel;

class LendingResource extends Resource
{
    protected static ?string $model = Lending::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Data Barang';
    protected static ?string $navigationLabel = 'Landing';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_name')->columnSpanFull()->required()->label('Nama Peminjam')->placeholder('Masukkan nama peminjam barang...'),
                Forms\Components\Hidden::make('created_by')
                    ->default(auth()->id()),

                Forms\Components\Repeater::make('lendingDetails')
                    ->relationship()
                    ->schema([
                        Forms\Components\Select::make('item_id')
                            ->relationship('item', 'name')
                            ->reactive()
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\TextInput::make('qty')
                            ->numeric()
                            ->required()
                            ->lazy()
                            ->afterStateUpdated(function ($state, $get, $set) {
                                $item = \App\Models\Item::find($get('item_id'));
                                if ($item && $state > $item->available) {
                                    Notification::make()
                                        ->danger()
                                        ->color('danger')
                                        ->title('Stok Kurang!')
                                        ->send();
                                    $set('qty', 0);
                                }
                            }),
                    ])
                    ->columnSpanFull()
                    ->addActionLabel('Tambah Barang')
                    ->itemLabel('Tambah Barang'),
                Forms\Components\DatePicker::make('loan_date')
                    ->label('Tanggal Pinjam')
                    ->default(now())
                    ->required()
                    ->columnSpanFull()
                    ->displayFormat('d F, Y'),
                Forms\Components\TextInput::make('notes')->columnSpanFull()->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('No. ')->rowIndex(),
                Tables\Columns\TextColumn::make('lendingDetails.item.name')
                    ->label('Barang')
                    ->bulleted()
                    ->listWithLineBreaks(),

                Tables\Columns\TextColumn::make('lendingDetails.qty')->label('Total')->searchable()
                    ->bulleted()
                    ->listWithLineBreaks(),

                Tables\Columns\TextColumn::make('user_name')->label('Name')->searchable(),

                Tables\Columns\TextColumn::make('loan_date')->label('Date')->date('d F, Y'),
                Tables\Columns\TextColumn::make('return_date')
                    ->label('Returned')
                    ->placeholder('not returned')
                    ->date('d F, Y')
                    ->badge()
                    ->color(fn($state) => $state ? 'success' : 'warning'),

                Tables\Columns\TextColumn::make('createdBy.name')
                    ->label('Operator')
                    ->description(function ($record) {
                        if (!$record->return_date || !$record->returnedBy) {
                            return null;
                        }

                        return new \Illuminate\Support\HtmlString(
                            "<span class='inline-flex items-center justify-center px-2 py-0.5 mt-1 text-xs font-medium tracking-tight rounded-xl bg-gray-500/10 text-gray-700 border border-gray-500/20'>
                Diterima oleh: {$record->returnedBy->name}
            </span>"
                        );
                    })
                    ->html()
                    ->badge()
                    ->color('primary'),
            ])
            ->headerActions([
                Tables\Actions\Action::make('exportExcel')
                    ->label('Export')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->action(function () {
                        $fileName = 'Data_lending' . now()->format('Y-m-d') . '.xlsx';
                        return Excel::download(new LendingExport, $fileName);
                    }),
            ])
            ->recordUrl(Null)
            ->actions([
                Tables\Actions\Action::make('returned')
                    ->label('Returned')
                    ->icon('heroicon-m-arrow-path')
                    ->color('warning')
                    ->button()
                    ->visible(fn($record) => $record->return_date === null)
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi Pengembalian')
                    ->modalDescription('Pastikan barang sudah sesuai dengan sebelum dipinjam.')
                    ->action(function ($record) {
                        $currentUserId = auth()->id();
                        $returnedBy = ($currentUserId !== $record->created_by) ? $currentUserId : null;
                        $record->update([
                            'return_date' => now(),
                            'returned_by' => $returnedBy,
                        ]);
                        foreach ($record->lendingDetails as $detail) {
                            $detail->item->refreshAvailable();
                        }
                        Notification::make()->success()->title('Barang telah dikembalikan!')->send();
                    }),
                Tables\Actions\DeleteAction::make()->button(),
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
            'index' => Pages\ManageLendings::route('/'),

        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::whereNull('return_date')->count();
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Jumlah Peminjaman: ' . static::getModel()::whereNull('return_date')->count();
    }
    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() >= 3
            ? 'danger'
            : (static::getModel()::count() < 3 ? 'warning' : 'primary');
    }
}
