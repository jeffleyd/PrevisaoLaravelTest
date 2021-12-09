<?php

namespace App\Services\Api\Weather\Providers\Interfaces;

use App\Services\Api\Weather\Providers\Predicted;

interface Weather
{
    public function search(string $region): Predicted;
    public function formattedResult(): Predicted;
}
