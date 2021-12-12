<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Api\Weather\Weather;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{

    public function retrieveWeather(Request $request) {
        try {
            // return response()->json((new Weather($request->getClientIp()))->get());
            return response()->json((new Weather($this->myIP()))->get());
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'code' => $e->getCode()
            ], 400);
        }
    }

    // Se você quiser usar com o "artisan serve";
    private function myIP() {
        $response = Http::get('http://meuip.com/api/meuip.php');
        if ($response->status() !== 200)
            throw new \Exception('Ocorreu um erro ao tentar pesquisar seu ip publico.', 999);

        return $response->body();
    }
}
