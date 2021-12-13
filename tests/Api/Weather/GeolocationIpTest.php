<?php

namespace Tests\Api\Weather;

use App\Services\Api\Weather\Providers\MetaWeather;
use App\Services\Api\Weather\Providers\Predicted;
use App\Services\Api\Weather\Weather;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GeolocationIpTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Verificar se o ip do visitante é válido
     */
    public function test_verify_invalid_ip()
    {
        try {
            response()->json((new Weather('127.0.0.1'))->get());
        } catch (\Exception $e) {
            $this->assertEquals(102, $e->getCode());
        }
    }

    /**
     * Passando uma região vazia para o provedor
     */
    public function test_provider_fetch_string_empty()
    {
        try {
            $provider = new MetaWeather();
            $provider->search('');
        } catch (\Exception $e) {
            $this->assertEquals(200, $e->getCode());
        }
    }

    /**
     * Validando a estrutura de saída de dados do provedor
     */
    public function test_validate_struct_data_provider()
    {
        $provider = new MetaWeather();
        $result = $provider->search('Rio de janeiro');
        $this->assertInstanceOf(Predicted::class, $result);
    }
}
