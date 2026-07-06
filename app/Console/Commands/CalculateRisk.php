<?php

namespace App\Console\Commands;

use App\Models\Country;
use App\Models\EconomicIndicator;
use App\Models\ExchangeRate;
use App\Models\RiskScore;
use App\Models\WeatherSnapshot;
use Illuminate\Console\Command;

class CalculateRisk extends Command
{
    protected $signature = 'calculate:risk';

    protected $description = 'Menghitung risk score setiap negara';

    public function handle()
    {
        $this->info('Menghitung Risk Score...');

        foreach (Country::all() as $country) {

            $weather = WeatherSnapshot::where('country_id', $country->id)
                ->latest()
                ->first();

            $economic = EconomicIndicator::where('country_id', $country->id)
                ->latest()
                ->first();

            $currency = ExchangeRate::where('country_id', $country->id)
                ->latest()
                ->first();

            // Weather Score
            $weatherScore = match ($weather->storm_risk ?? 'low') {
                'high' => 90,
                'medium' => 50,
                default => 10,
            };

            // Inflation Score
            $inflation = $economic->inflation ?? 0;

            $inflationScore = min($inflation * 5, 100);

            // News Score (sementara)
            $newsScore = 0;

            // Currency Score (sementara)
            $currencyScore = $currency ? 20 : 0;

            // Total Score
            $total =
                ($weatherScore * 0.30) +
                ($inflationScore * 0.20) +
                ($newsScore * 0.40) +
                ($currencyScore * 0.10);

            // Risk Level
            if ($total < 33) {
                $level = 'Low';
            } elseif ($total < 66) {
                $level = 'Medium';
            } else {
                $level = 'High';
            }

            RiskScore::updateOrCreate(
                [
                    'country_id' => $country->id,
                ],
                [
                    'weather_score' => $weatherScore,
                    'inflation_score' => $inflationScore,
                    'news_score' => $newsScore,
                    'currency_score' => $currencyScore,
                    'total_score' => round($total, 2),
                    'risk_level' => $level,
                ]
            );

            $this->info($country->name . ' ✔');
        }

        $this->newLine();

        $this->info('==============================');
        $this->info('Risk Score berhasil dihitung');
        $this->info('==============================');

        return Command::SUCCESS;
    }
}