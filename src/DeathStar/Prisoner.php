<?php

namespace App\DeathStar;

use GuzzleHttp\Client;
use App\DeathStar\Exceptions\InvalidArgumentException;

class Prisoner implements PrisonerInterface {

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function get(string $name): string
    {
        if( strlen($name) == 0 ) {
            throw new InvalidArgumentException("prisoner name should be longer than 0 characters");
        }
        
        return $this->client
            ->get("/prisoner/".$name)
            ->getBody();
    }
}