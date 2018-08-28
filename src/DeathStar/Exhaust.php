<?php

namespace App\DeathStar;

use GuzzleHttp\Client;
use App\DeathStar\Exceptions\InvalidArgumentException;

class Exhaust implements ExhaustInterface {

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function delete(int $id): bool
    {
        if( $id <= 0 ) {
            throw new InvalidArgumentException("exhaust id should be a positive integer");
        }
        
        return $this->client
            ->delete("/reactor/exhaust/".$id, [
                'headers' => ['x-torpedoes' => '2']
            ])
            ->getStatusCode() == 200 ? true : false
        ;
    }
}