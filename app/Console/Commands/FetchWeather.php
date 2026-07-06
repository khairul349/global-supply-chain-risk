<?php

namespace App\Console\Commands;

use App\Models\Country;
use App\Models\WeatherSnapshot;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchWeather extends Command
{
    protected $signature = 'fetch:weather';

    protected $description = 'Mengambil data cuaca dari Open-Meteo';

    public function handle()
    {
        $this->info('Mengambil data cuaca...');

        $success = 0;
        $failed = 0;

        $countries = Country::orderBy('id')->get();

        foreach ($countries as $country) {

            if (!$country->latitude || !$country->longitude) {
                $this->warn($country->name . ' -> Koordinat tidak ada');
                $failed++;
                continue;
            }

            $url = "https://api.open-meteo.com/v1/forecast?latitude={$country->latitude}&longitude={$country->longitude}&current=temperature_2m,wind_speed_10m,rain";

            try {

                $response = Http::timeout(30)
                    ->retry(3, 1000)
                    ->acceptJson()
                    ->get($url);

            } catch (\Exception $e) {

                $this->error($country->name . ' -> Timeout');
                $failed++;
                continue;
            }

            if (!$response->successful()) {

                $this->warn($country->name . ' -> Gagal');
                $failed++;
                continue;
            }

            $current = $response->json()['current'] ?? [];

            $temperature = $current['temperature_2m'] ?? null;
            $windSpeed = $current['wind_speed_10m'] ?? null;
            $rainfall = $current['rain'] ?? 0;

            // Penentuan risiko badai sederhana
            if ($windSpeed >= 60 || $rainfall >= 50) {
                $stormRisk = 'high';
            } elseif ($windSpeed >= 30 || $rainfall >= 20) {
                $stormRisk = 'medium';
            } else {
                $stormRisk = 'low';
            }

            WeatherSnapshot::create([
                'country_id' => $country->id,
                'temperature' => $temperature,
                'wind_speed' => $windSpeed,
                'rainfall' => $rainfall,
                'storm_risk' => $stormRisk,
            ]);

            $this->info($country->name . ' ✔');

            $success++;

            usleep(300000);
        }

        $this->newLine();

        $this->info("==============================");
        $this->info("Berhasil : {$success}");
        $this->warn("Gagal : {$failed}");
        $this->info("==============================");

        return Command::SUCCESS;
    }
}