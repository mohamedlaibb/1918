<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FormationResource\Pages;
use App\Filament\Resources\FormationResource\RelationManagers;
use App\Models\Formation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FormationResource extends Resource
{
    protected static ?string $model = Formation::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('titre')->required(),
                Select::make('client_id')
                    ->relationship('client', 'raison_sociale'),
                TextInput::make('formateur_nom')->required(),
                DatePicker::make('date_d')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('titre')->searchable(),
                TextColumn::make('client.raison_sociale'),
                TextColumn::make('formateur_nom'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('generate_pdf')
                    ->label('Générer PDF')
                    ->url(fn ($record) => route('generate.pdf', $record))
                    ->openUrlInNewTab(),
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
            'index' => Pages\ListFormations::route('/'),
            'create' => Pages\CreateFormation::route('/create'),
            'edit' => Pages\EditFormation::route('/{record}/edit'),
        ];
    }
}
