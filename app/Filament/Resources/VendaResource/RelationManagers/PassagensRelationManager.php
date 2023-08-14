<?php

namespace App\Filament\Resources\VendaResource\RelationManagers;

use App\Models\Passagem;
use App\Models\Venda;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Actions\EditAction;
use Filament\Support\Enums\IconPosition;
use Filament\Tables\Columns\ToggleColumn;

class PassagensRelationManager extends RelationManager
{
    protected static string $relationship = 'passagens';

    protected static ?string $recordTitleAttribute = 'id';

    

    public function form(Form $form): Form
    {
        return $form
            
            ->schema([
                Grid::make(1)
                ->schema([
                    Section::make('')
                        ->schema([
                            //Toggle::make('pagar_comissao'),
                        ])
                ])
                ->schema([
                    Section::make('Informações da Viagem')
                        ->schema([
                            Toggle::make('pagar_comissao')->label('Recebe Comissao')->default(true),
                            TextInput::make('cobrador'),
                            TextInput::make('frota')->required()->numeric()->minLength(3)
                               /* ->columnSpan([
                                    'sm' => 4,
                                    'xl' => 4,
                                    '2xl' => 4,
                                ]),*/
                        ])->compact(),
                    Tabs::make('Cadastro de Passagens')
                ->tabs([
                    Tabs\Tab::make('Vendas Manuais (Talão)')->icon('heroicon-m-paper-clip')
                    ->iconPosition(IconPosition::After)
                        ->schema([
                           Grid::make(2)
                            ->schema([
                                
                                
                                TextInput::make('quantidade_manual_ida')->numeric(),
                                TextInput::make('valor_manual_ida')->numeric() ->prefix('R$')->suffix(',00'),
                                TextInput::make('quantidade_manual_volta')->numeric(),
                                TextInput::make('valor_manual_volta')->numeric() ->prefix('R$')->suffix(',00'),
                            ])
                        ]),
                    Tabs\Tab::make('Vendas Maquina (POS)')->icon('heroicon-m-device-phone-mobile')
                    ->iconPosition(IconPosition::After)
                        ->schema([
                            Grid::make(2)
                            ->schema([
                                TextInput::make('quantidade_pos_ida')->numeric(),
                                TextInput::make('valor_pos_ida')->numeric() ->prefix('R$')->suffix(',00'),
                                TextInput::make('quantidade_pos_volta')->numeric(),
                                TextInput::make('valor_pos_volta')->numeric() ->prefix('R$')->suffix(',00'),
                            ])
                        ]),

                    Tabs\Tab::make('Excesso de Bagagem')->icon('heroicon-m-shopping-bag')
                    ->iconPosition(IconPosition::After)
                        ->schema([
                            Grid::make(2)
                            ->schema([
                               //
                            ])
                        ]),
                ])->activeTab(1)
                    ])
            ]);
            

            /* Repeteted
            ->schema([
                Repeater::make('passagens')
                ->schema([
                    Fieldset::make('Cadastro de Venda')
                    ->schema([
                        TextInput::make('frota')->required()->numeric()->minLength(3),
                        TextInput::make('quantidade_passagem')->required()->numeric(),
                        Select::make('tipo_passagem')->required()
                            ->options([
                                'manual' => 'VENDA MANUAL',
                                'pos' => 'VENDA MAQUINA (POS)',
                            ]),
                        Radio::make('sentido_linha')->required()
                        ->options([
                            'ida' => 'IDA ==>',
                            'volta' => 'VOLTA <==',
                        ])
                        ->descriptions([
                            'ida' => 'Sentido saindo de Belem ==>',
                            'volta' => 'Sentido volta para Belem <==.',
                        ])
                    ])
                ])
                ->columns(4)->defaultItems(2)
            ]);
            */


            //formulario funcional
            /*
            ->schema([
                Fieldset::make('Cadastro de Venda')
                ->schema([
                    TextInput::make('frota')->required()->numeric()->minLength(3),
                    TextInput::make('quantidade_passagem')->required()->numeric(),
                    Select::make('tipo_passagem')->required()->default('manual')
                        ->options([
                            'manual' => 'VENDA MANUAL',
                            'pos' => 'VENDA MAQUINA (POS)',
                        ]),
                    Radio::make('sentido_linha')->required()
                    ->options([
                        'ida' => 'IDA ==>',
                        'volta' => 'VOLTA <==',
                    ])
                    ->descriptions([
                        'ida' => 'Sentido saindo de Belem ==>',
                        'volta' => 'Sentido volta para Belem <==.',
                    ])
                ])
            ]);
            */
            
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('frota'),
                Tables\Columns\TextColumn::make('quantidade_total_passagem'),
                Tables\Columns\TextColumn::make('valor_total_manual')->money('brl'),
                Tables\Columns\TextColumn::make('valor_total_pos')->money('brl'),
                Tables\Columns\TextColumn::make('valor_total_passagem')->money('brl')
                ->summarize(Sum::make()->label('Total Passagens')->money('brl')),
                Tables\Columns\TextColumn::make('valor_comissao')->money('brl')
                ->summarize(Sum::make()->label('Total Comissão')->money('brl')),

                ToggleColumn::make('pagar_comissao')

                //Tables\Columns\TextColumn::make('frota'),
                //Tables\Columns\TextColumn::make('tipo_passagem'),
                //Tables\Columns\TextColumn::make('sentido_linha'),
                //Tables\Columns\TextColumn::make('quantidade_passagem')
                //->summarize(Sum::make()->label('Total Passagens')),

                //Tables\Columns\TextColumn::make('quantidade_passagem')
                //->summarize(Sum::make()->label('Total Passagens')),

                //Tables\Columns\TextColumn::make('valor_comissao')->label('comissão')
                //->summarize(Sum::make()->label('Total Comissão')),


                //Tables\Columns\TextColumn::make('quant_volta_pos'),
                //Tables\Columns\TextColumn::make('quant_total'),
                //Tables\Columns\TextColumn::make('valor_total')->money('brl'),
                //Tables\Columns\TextColumn::make('SomaIda')
                   // ->getStateUsing(function(Model $record) {
                        // return whatever you need to show
                        //return $record->quant_ida_manual + $record->quant_ida_pos;
                    //})
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //Tables\Actions\CreateAction::make(),
                
                CreateAction::make()
                ->mutateFormDataUsing(function (array $data): array {

                    //dd($data);

                    $data['valor_total_manual'] = $data['valor_manual_ida'] + $data['valor_manual_volta']; // total valor manual
                    $data['valor_total_pos'] = $data['valor_pos_ida'] + $data['valor_pos_volta']; // total valor pos
                    $data['quantidade_total_passagem'] = $data['quantidade_manual_ida'] + $data['quantidade_manual_volta'] + $data['quantidade_pos_ida'] + $data['quantidade_pos_volta']; // quantidade total de passagens
                    $data['valor_total_passagem'] = $data['valor_manual_ida'] + $data['valor_manual_volta'] + $data['valor_pos_ida'] + $data['valor_pos_volta'];
                    //$data['valor_comissao'] = ($data['valor_manual_ida'] + $data['valor_manual_volta'] + $data['valor_pos_ida'] + $data['valor_pos_volta']) * 8 /100;

                    if ($data['pagar_comissao'] && $data['cobrador'] = null ) {
                        $data['valor_comissao'] = ($data['valor_manual_ida'] + $data['valor_manual_volta'] + $data['valor_pos_ida'] + $data['valor_pos_volta']) * 8 /100;
                    }else {
                        $data['valor_comissao'] = null;
                    }
                    
                    /*
                    if($data['paga_comissao'] == false && $data['cobrador'] == null)
                        {
                            $data['comissao'] = $data['valor_total'] * 8 /100;
                        }
                        else
                        {
                            $data['comissao'] = null;
                            $data['paga_comissao'] = true;
                        }

                    */
                    return $data;
                }),

                
                
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    //Tables\Actions\EditAction::make(),
                    EditAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        //dd($data['pagar_comissao']);
                        if ($data['pagar_comissao']) {
                            $data['valor_comissao'] = ($data['valor_manual_ida'] + $data['valor_manual_volta'] + $data['valor_pos_ida'] + $data['valor_pos_volta']) * 8 /100;
                        }else {
                            $data['valor_comissao'] = null;
                        }
                        

                        $data['valor_total_manual'] = $data['valor_manual_ida'] + $data['valor_manual_volta']; // total valor manual
                        $data['valor_total_pos'] = $data['valor_pos_ida'] + $data['valor_pos_volta']; // total valor pos
                        $data['quantidade_total_passagem'] = $data['quantidade_manual_ida'] + $data['quantidade_manual_volta'] + $data['quantidade_pos_ida'] + $data['quantidade_pos_volta']; // quantidade total de passagens
                        $data['valor_total_passagem'] = $data['valor_manual_ida'] + $data['valor_manual_volta'] + $data['valor_pos_ida'] + $data['valor_pos_volta'];
                        //$data['valor_comissao'] = ($data['valor_manual_ida'] + $data['valor_manual_volta'] + $data['valor_pos_ida'] + $data['valor_pos_volta']) * 8 /100;

                        return $data;
                    })
                    //Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }    
}
