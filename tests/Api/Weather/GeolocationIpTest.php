<?php

namespace Tests\Api\Weather;

use App\Services\Api\Weather\Providers\Predicted;
use App\Services\Api\Weather\Weather;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GeolocationIpTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Verificar se o ip 127.0.0.1 é valido.
     */
    public function test_verify_invalid_ip_127_0_0_1()
    {
        try {
            response()->json((new Weather('127.0.0.1'))->get());
        } catch (\Exception $e) {
            $this->assertEquals(102, $e->getCode());
        }
    }

    /**
     * Verificar se o ip localhost é válido.
     */
    public function test_verify_invalid_ip_localhost()
    {
        try {
            response()->json((new Weather('localhost'))->get());
        } catch (\Exception $e) {
            $this->assertEquals(102, $e->getCode());
        }
    }

    /**
     * Verificar se o ip vazio é válido
     */
    public function test_verify_invalid_ip_empty()
    {
        $res = (new Weather(''))->get();
        $this->assertInstanceOf(Predicted::class, $res);
    }
}
