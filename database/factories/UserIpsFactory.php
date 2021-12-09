<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Http;

class UserIpsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'ip' => $this->myIP()
        ];
    }

    private function myIP() {
        $response = Http::get('http://meuip.com/api/meuip.php');
        if ($response->status() !== 200)
            $response->throw();

        return $response->body();
    }
}
