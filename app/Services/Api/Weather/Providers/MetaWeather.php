<?php

namespace App\Services\Api\Weather\Providers;

use App\Services\Api\Weather\Providers\Interfaces\Weather;
use Illuminate\Support\Facades\Http;

class MetaWeather extends Predicted implements Weather
{
    const URL = 'https://www.metaweather.com/api';
    const QUERY_REGION = '/location/search/?query=';
    const QUERY_LOCATION = '/location/';
    private $region;

    public function search(string $region): Predicted
    {
        $this->region = $region;
        return $this->formattedResult();
    }

    public function formattedResult(): Predicted {

        $region = $this->httpClient(self::URL.self::QUERY_REGION.$this->region);
        if (!count($region))
            throw new \Exception('Não foi possível encontrar a região');

        $weather = $this->httpClient(self::URL.self::QUERY_LOCATION.$region[0]['woeid']);
        if (!count($weather))
            throw new \Exception('Não foi possível encontrar os dados dessa localização');

        $consolidated = $weather['consolidated_weather'][0];

        $data = new Predicted();
        $data->location = $this->region;
        $data->min_temp = round($consolidated['min_temp'], 0);
        $data->max_temp = round($consolidated['max_temp'], 0);
        $data->the_temp = round($consolidated['the_temp'], 0);
        $data->weather = $this->weatherStates($consolidated['weather_state_abbr']);
        $data->predictability = round($consolidated['predictability'], 0);

        return $data;
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
