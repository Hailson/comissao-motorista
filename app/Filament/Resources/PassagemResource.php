<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PassagemResource\Pages;
use App\Filament\Resources\PassagemResource\RelationManagers;
use App\Models\Passagem;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PassagemResource extends Resource
{
    protected static ?string $model = Passagem::class;
    protected static ?string $navigationIcon = 'heroicon-o-printer';
    protected static ?string $navigationLabel = 'Passagens Lançadas';


    public array $data_list= [
        'valor_total' => [
        ],
    ];

    protected function getTableContentFooter(): ?View
{
    return view('table.footer', $this->data_list);
}

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                /*
                
                Select::make('venda_id')
                    ->relationship('venda', 'id')
                    ->searchable()
                    ->preload(),
               TextInput::make('frota')
                    ->numeric()
                    ->required()
                    ->maxLength(255),
               TextInput::make('quant_ida_manual')
                    ->numeric()
                    ->required(),
               TextInput::make('quant_volta_manual')
               ->numeric()
               ->required(),
               TextInput::make('quant_ida_pos')
               ->numeric()
                    ->required(),
               TextInput::make('quant_volta_pos')
               ->numeric()
                    ->required(),
               TextInput::make('quant_total')
               ->numeric()
                    ->required(),
               TextInput::make('valor_total')
               ->numeric()
                    ->required(),
               TextInput::make('quant_excesso')
               ->numeric(),
               TextInput::make('valor_excesso')
               ->numeric(),

                */
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('venda.data_venda')->date('d/m/y')->label('data da venda'),
                Tables\Columns\TextColumn::make('venda.colaborador.apelido')->label('Motorista'),
                Tables\Columns\TextColumn::make('frota'),
                Tables\Columns\TextColumn::make('valor_manual_ida')->money('brl'),
                Tables\Columns\TextColumn::make('valor_manual_volta')->money('brl'),
                Tables\Columns\TextColumn::make('valor_pos_ida')->money('brl'),
                Tables\Columns\TextColumn::make('valor_pos_volta')->money('brl'),
                Tables\Columns\TextColumn::make('quantidade_total_passagem'),
                Tables\Columns\TextColumn::make('valor_total_passagem')->money('brl'),
            ])
            ->filters([
                //SelectFilter::make('colaboradores')->relationship('venda', 'colaborador_id')

            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                //Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListPassagems::route('/'),
            //'create' => Pages\CreatePassagem::route('/create'),
            //'edit' => Pages\EditPassagem::route('/{record}/edit'),
        ];
    }    
}
