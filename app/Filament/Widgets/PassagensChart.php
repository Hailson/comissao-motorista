<?php

namespace App\Filament\Widgets;

use App\Models\Passagem as ModelsPassagem;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use Models\Passagem;
use DB;

class PassagensChart extends ApexChartWidget
{
    protected static ?string $loadingIndicator = 'Aguarde carregando dados...';
    
    /**
     * Chart Id
     *
     * @var string
     */
    protected static string $chartId = 'passagensChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Passagens Vendidas';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $passagens = DB::select(
            "SELECT COUNT(quantidade_total_passagem) as passagens, MONTH(vendas.data_venda) as mes
            FROM passagems
            LEFT JOIN vendas
            ON passagems.venda_id = vendas.id
            group by mes
            ORDER BY 'DES'"
        );
        dd($passagens);
         $passagemData = null;
         $mesData = null;

         foreach ($passagens as $val ) {
            $passagemData []= $val->passagens;
        }
        $passagensgraf = implode(',', $passagemData);
        //dd($passagensjsn);

         return [
            'chart' => [
                'type' => 'pie',
                'height' => 300,
            ],
            'series' => [$passagensgraf],
            'labels' => ['Jul', 'Agost'],
            'legend' => [
                'labels' => [
                    'colors' => '#9ca3af',
                    'fontWeight' => 600,
                ],
            ],
        ];
    }
}
