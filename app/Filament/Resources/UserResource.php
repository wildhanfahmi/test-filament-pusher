<?php

namespace App\Filament\Resources;

use App\Filament\Exports\UserExporter;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MorphToSelect;
use Filament\Forms\Components\MorphToSelect\Type;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                ->placeholder('Full Name')
                ->required(),
                TextInput::make('nip')
                ->placeholder('Nomor Induk Pegawai')
                ->required(),
                TextInput::make('password')
                ->autocomplete(false)
                ->password()
                ->dehydrateStateUsing(fn ($state) => Hash::make($state))
    ->dehydrated(fn ($state) => filled($state))
    ->required(fn (string $context): bool => $context === 'create')
                ->revealable(),
           
                Select::make("roles")
                ->relationship('roles')
                ->multiple()
                ->searchable()
                ->getSearchResultsUsing(fn (string $search) => Role::where("name","like","%{$search}%")->limit(10)->pluck('name','id')->toArray())
                ->getOptionLabelsUsing(fn (array $values): array => Role::whereIn('id', $values)->pluck('name', 'id')->toArray())
                ->options(Role::all()->pluck("name","id")->toArray())
                ->createOptionForm([
                    TextInput::make("name")
                    ]),
                TextInput::make('email')
                ->autocomplete(false)
                ->placeholder('paijo@example.com')
                ->email(),
                DatePicker::make('date_of_birth')
                ->maxDate(now()),
                TextInput::make('address'),
                TextInput::make('phone')
                ->prefix('+62')
                ->tel(),
                Select::make('group')
                ->options([
                    'Grup A' => 'Grup A',
                    'Grup B' => 'Grup B',
                    'Grup C' => 'Grup C',
                    'Grup D' => 'Grup D',
                ]),
                FileUpload::make('profile_picture')
                ->directory("profile_picture")
                ->avatar()
                ->image()
                ->imageEditor()
                ->circleCropper()
                ->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('profile_picture')
                ->circular(),
                TextColumn::make('nip')
                ->searchable(),
                TextColumn::make('name')
                ->searchable(),
                TextColumn::make('roles.name'),
                TextColumn::make('email'),
                TextColumn::make('date_of_birth'),
                TextColumn::make('address'),
                TextColumn::make('phone'),
                TextColumn::make('group'),
            ])
            ->filters([
                SelectFilter::make('roles')
                ->relationship('roles','name')
                ->options(Role::all()->pluck('name','id')->toArray()),
                SelectFilter::make('grup')
                ->options([
                    'Grup A' => 'Grup A',
                    'Grup B' => 'Grup B',
                    'Grup C' => 'Grup C',
                    'Grup D' => 'Grup D',
                    ])

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                ViewAction::make(),
                DeleteAction::make()
            ])
            ->headerActions([
                ExportAction::make()
                ->exporter(UserExporter::class)
                ->formats([
        ExportFormat::Xlsx,
        ExportFormat::Csv
    ])
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
