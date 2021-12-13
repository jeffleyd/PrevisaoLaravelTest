<?php

namespace Tests\Api\Weather;

use App\Services\Api\Weather\Providers\MetaWeather;
use App\Services\Api\Weather\Providers\Predicted;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MetaWeaterProviderTest extends TestCase
{
    use RefreshDatabase;

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
