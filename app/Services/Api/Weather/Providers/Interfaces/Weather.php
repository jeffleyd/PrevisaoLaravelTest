<?php

namespace App\Services\Api\Weather\Providers\Interfaces;

interface Weather
{
    public function search(string $region);
    public function formattedResult();
}
