<?php

namespace App\DeathStar;

use GuzzleHttp\Client;

interface ExhaustInterface {

    public function delete(int $id): bool;
}