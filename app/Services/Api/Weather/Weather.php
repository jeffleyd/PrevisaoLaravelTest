<?php

namespace App\Services\Api\Weather;


use App\Events\Weather\WeatherEvent;
use App\Services\Api\Weather\Providers\MetaWeather;
use App\Services\Api\Weather\Providers\Predicted;
use Illuminate\Support\Facades\Http;

class Weather
{

    const providers = [
        'MetaWeather' => MetaWeather::class
    ];
    private $region;
    private $provider;

    /**
     * @param null $ip [IP do solicitante]
     * @param string $provider [Nome do provedor da API]
     * @throws \Exception
     */
    public function __construct($ip, string $provider = 'MetaWeather')
    {
        $this->region = $this->resolverRegion($ip);
        $this->provider = $provider;
    }

    /**
     * Realiza a busca no provedor
     * @return Predicted
     * @throws \Exception
     */
    public function get(): Predicted {
        if (!isset(self::providers[$this->provider]))
            throw new \Exception('Não foi possível encontrar a classe do provedor.', 100);

        $provider = new (self::providers[$this->provider]);
        $data = $provider->search($this->region);

        // Registra o resultado da API de temperatura.
        event(new WeatherEvent($data));

        return $data;
    }

    /**
     * Retorna os dados com base no IP do solicitante
     * @param $ip
     * @return mixed
     * @throws \Exception
     */
    private function resolverRegion($ip) {
        $response = Http::get('http://ip-api.com/json/'.$ip);
        if ($response->status() !== 200)
            throw new \Exception('Não foi possível consultar seu IP em nossa api, tente novamente.', 101);

        $result = json_decode($response->body());
        if ($result->status === 'fail')
            throw new \Exception('Você passou um ip inválido.', 102);

        return $result->city;
    }

}
