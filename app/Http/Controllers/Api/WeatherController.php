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
        //return response()->json((new Weather($request->getClientIp()))->get());
        return response()->json((new Weather($this->myIP()))->get());
    }

    // Se você quiser usar com o "artisan serve";
    private function myIP() {
        $response = Http::get('http://meuip.com/api/meuip.php');
        if ($response->status() !== 200)
            $response->throw();

        return $response->body();
    }
}
