<?php

namespace App\Services\Api\Weather\Providers;

use App\Services\Api\Weather\Providers\Interfaces\Weather;
use Illuminate\Support\Facades\Http;

class MetaWeather implements Weather
{
    const URL = 'https://www.metaweather.com/api';
    const QUERY_REGION = '/location/search/?query=';
    const QUERY_LOCATION = '/location/';
    private $region;

    public function search(string $region): array
    {
        $this->region = $region;
        return $this->formattedResult();
    }

    public function formattedResult() {

        $region = $this->httpClient(self::URL.self::QUERY_REGION.$this->region);
        if (!count($region))
            return [];

        $weather = $this->httpClient(self::URL.self::QUERY_LOCATION.$region[0]['woeid']);
        if (!count($weather))
            return [];

        $consolidated = $weather['consolidated_weather'][0];

        return [
            'regiao' => $this->region,
            'temperatura_min' => round($consolidated['min_temp'], 0),
            'temperatura_max' => round($consolidated['max_temp'], 0),
            'temperatura' => round($consolidated['the_temp'], 0),
            'clima' => $this->weatherStates($consolidated['weather_state_abbr']),
            'probabilidade' => round($consolidated['predictability'], 0),
        ];
    }

    private function weatherStates($Abbreviation) {
        $abb = ['sn' => 'Nevando','sl' => 'Granizo','h' => 'Chuva de granizo','t' => 'Tempestade',
            'hr' => 'Chuva pesada','lr' => 'Chuva fraca','s' => 'Sol com chuva','hc' => 'Nublinado',
            'lc' => 'Parcial Nublado','c' => 'Ensolarado',
        ];
        return $abb[$Abbreviation];
    }

    private function httpClient($url) {
        $response = Http::get($url);
        if ($response->status() !== 200)
            return [];

        return json_decode($response->body(), true);
    }
}
