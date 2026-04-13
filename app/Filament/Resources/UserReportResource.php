<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserReportResource\Pages;
use App\Filament\Resources\UserReportResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Exports\UserReportExport;
use Maatwebsite\Excel\Facades\Excel;

class UserReportResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationLabel = 'Operator';
    protected static ?string $slug = 'operator-user-reports';
        protected static ?string $navigationGroup = 'Users';


    public static function getEloquentQuery(): Builder
{
    return parent::getEloquentQuery()
        ->whereHas('roles', function ($query) {
            $query->where('name', 'operator');
        });
}

   public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                ->label('Nama')
                ->placeholder('Masukkan Nama User')
                ->columnSpanFull()
                ->required(),
                Forms\Components\TextInput::make('email')
                ->label('Email')
                ->placeholder('Masukkan Email User')
                ->required(),
                Forms\Components\Select::make('roles')
                ->label('Role')
                ->required()
                ->relationship('roles','name')
                ->preload(),
                Forms\Components\TextInput::make('new_password')
                ->password()
                ->label('New Password')
                ->placeholder('Optional')
                ->nullable()
                ->visibleOn('edit')
                ->dehydrated(fn ($state) => filled($state)) 
                ->afterStateUpdated(function ($state, $record) {
                    if (filled($state)) {
                        $record->is_password_modified = true;
                    }
                }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('No. ')->rowIndex(),
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('roles.name')->searchable(),
            ])
            ->recordUrl(Null)
            ->filters([
                //
            ])
            ->headerActions([
            Tables\Actions\Action::make('exportExcel')
                ->label('Export')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->action(function () {
                    $fileName = 'Laporan_User_' . now()->format('Y-m-d') . '.xlsx';
                    return Excel::download(new UserReportExport, $fileName);
                }),
        ])
            ->actions([
                Tables\Actions\EditAction::make()->button()->color('primary'),
                Tables\Actions\DeleteAction::make()->button()->color('danger'),
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
            'index' => Pages\ManageUserReports::route('/'),
        ];
    }
}
