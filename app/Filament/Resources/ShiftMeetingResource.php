<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShiftMeetingResource\Pages;
use App\Filament\Resources\ShiftMeetingResource\RelationManagers;
use App\Models\ShiftMeeting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ShiftMeetingResource extends Resource
{
    protected static ?string $model = ShiftMeeting::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('prev_group')
                    ->label("Current group")
                    ->options([
                            "Grup A" => "Grup A",
                            "Grup B" => "Grup B",
                            "Grup C" => "Grup C",
                            "Grup D" => "Grup D",
                        ])
                    ->required(),
                Forms\Components\Select::make('next_group')
                    ->options([
                            "Grup A" => "Grup A",
                            "Grup B" => "Grup B",
                            "Grup C" => "Grup C",
                            "Grup D" => "Grup D",
                        ])
                    ->required(),
                Forms\Components\Select::make('prev_shift')
                    ->label("Current shift")
                    ->options([
                            "Shift Pagi" => "Shift Pagi",
                            "Shift Sore" => "Shift Sore",
                            "Shift Malam" => "Shift Malam",
                        ])
                    ->required(),
                Forms\Components\Select::make('next_shift')
                ->options([
                            "Shift Pagi" => "Shift Pagi",
                            "Shift Sore" => "Shift Sore",
                            "Shift Malam" => "Shift Malam",
                        ])
                    ->required(),
                Forms\Components\RichEditor::make('notulen')
                    ->disableToolbarButtons(["attachFiles"])
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('attachments')
                    ->multiple()
                    ->directory("attachments")
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_expired')
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('prev_group')
                    ->searchable(),
                Tables\Columns\TextColumn::make('next_group')
                    ->searchable(),
                Tables\Columns\TextColumn::make('prev_shift')
                    ->searchable(),
                Tables\Columns\TextColumn::make('next_shift')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_expired')
                    ->boolean(),
                
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListShiftMeetings::route('/'),
            'create' => Pages\CreateShiftMeeting::route('/create'),
            'edit' => Pages\EditShiftMeeting::route('/{record}/edit'),
        ];
    }
}
