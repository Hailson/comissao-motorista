<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VendaResource\Pages;
use App\Filament\Resources\VendaResource\RelationManagers;
use App\Models\Linha;
use App\Models\Passagem;
use App\Models\Venda;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Grouping\Group;
use Symfony\Component\Finder\Iterator\DateRangeFilterIterator;

class VendaResource extends Resource
{
    protected static ?string $model = Venda::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Cadastro de Venda')
                ->schema([
                    DatePicker::make('data_venda')->required(),
                    Select::make('colaborador_id')->label('Motorista')
                    ->relationship(name: 'colaborador', titleAttribute: 'apelido')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('matricula')->required('number')->unique(),
                        Forms\Components\TextInput::make('nome')->required(),
                        Forms\Components\TextInput::make('apelido')->required()->unique(),
                    ]),

                    Select::make('linha_id')->required()
                    ->relationship(name: 'linha', titleAttribute: 'nome_linha')
                    ->searchable()->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('nome_linha')
                            ->required()
                            ->maxLength(255),
                            
                    ]),
                    
                    
                    TextInput::make('valor_total')->numeric()->prefix('R$')->label('Valor Total Passagens'),
                    //TextInput::make('cobrador')->placeholder('se existir cobrador junto da viagem digite o nome'),
                    //Toggle::make('paga_comissao')
                    //->default(false)
                    //->label('nao pagar comissao')
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('data_venda')->date('d-m-Y')->toggleable()->sortable(),
                Tables\Columns\TextColumn::make('colaborador.apelido')->label('Motorista')->toggleable(),
                Tables\Columns\TextColumn::make('linha.nome_linha')->toggleable(),
                
                //Tables\Columns\TextColumn::make('valor_total')->money('brl')->extraAttributes(['class' => 'bg-gray-400'])->toggleable()
                //->summarize(Sum::make()->label('Total')->money('brl')),
                
                //Tables\Columns\TextColumn::make('comissao')->money('brl')->extraAttributes(['class' => 'bg-gray-200'])->toggleable()
                //->summarize(Sum::make()->label('Total Comissao')->money('brl')),

                Tables\Columns\TextColumn::make('passagens.valor_total_passagem')->label('Valor Total')->money('brl')->toggleable()
                ->summarize(Sum::make()->label('Valor Total')->money('brl')),

                Tables\Columns\TextColumn::make('passagens.quantidade_total_passagem')->label('Quant Total')->toggleable()
                ->summarize(Sum::make()->label('Total quantidade')),

                Tables\Columns\TextColumn::make('passagens.valor_comissao')->label('Comissão')->money('brl')->extraAttributes(['class' => 'bg-gray-200'])->toggleable()
                ->summarize(Sum::make()->label('Total Comissão')->money('brl')->extraAttributes(['class' => 'bg-gray-400'])),

                IconColumn::make('passagens.pagar_comissao')->label('Recebe Comissão')
                ->boolean()
                /*
                Tables\Columns\TextColumn::make('Comissao')
                    ->getStateUsing(function(Model $record) {
                        // return whatever you need to show
                        return ($record->valor_total * 8)/100;
                    })->money('brl'),
               */
            ])->groups([
                Group::make('colaborador.apelido')
                ->label('Agrupar por Colaborador')
                //->collapsible(),
            ])
            ->groupsOnly()
            ->filters([
                
                SelectFilter::make('motorista')->relationship('colaborador', 'apelido')->searchable()->preload(),

                SelectFilter::make('linha')->relationship('linha', 'nome_linha')->searchable()->multiple()->preload(),

                Filter::make('passagens.pagar_comissao')
                    ->default(),
                
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from'),
                        DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('data_venda', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('data_venda', '<=', $date),
                            );
                    })

            ])->filtersFormMaxHeight('600px')
            ->actions([
                //Tables\Actions\EditAction::make(),
                //EditAction::make()
                    //->mutateFormDataUsing(function (array $data): array {
                       /* if($data['paga_comissao'] == false && $data['cobrador'] == null)
                            {
                                $data['comissao'] = $data['valor_total'] * 8 /100;
                            }
                            else
                            {
                                $data['comissao'] = null;
                                $data['paga_comissao'] = true;
                            }

                            return $data;*/
                   // })
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            RelationManagers\PassagensRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVendas::route('/'),
            'create' => Pages\CreateVenda::route('/create'),
            'edit' => Pages\EditVenda::route('/{record}/edit'),
        ];
    }    
}
