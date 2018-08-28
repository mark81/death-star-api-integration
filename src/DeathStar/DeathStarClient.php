<?php

namespace App\DeathStar;

use App\DeathStar\Exceptions\DeathStarClientConfigurationException;
use kamermans\OAuth2\GrantType\ClientCredentials;
use kamermans\OAuth2\OAuth2Middleware;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client;

class DeathStarClient {

    /** 
     * guzzle http client factory
     * @param $opts array 
     * @throws DeathStarClientConfigurationException
     * @return Client
     */
    public static function fromConfigArray(array $opts): Client
    {
        if (!isset($opts['api_uri'])) {
            throw new DeathStarClientConfigurationException("missing base uri", 1);
        }

        if (!isset($opts['client_id'])) {
            throw new DeathStarClientConfigurationException("missing client_id", 2);
        }

        if (!isset($opts['client_secret'])) {
            throw new DeathStarClientConfigurationException("missing client_secret", 3);
        }

        if (!isset($opts['scope'])) {
            throw new DeathStarClientConfigurationException("missing scope", 4);
        }

        if (!isset($opts['ssl_key'])) {
            throw new DeathStarClientConfigurationException("missing ssl key", 5);
        }

        $client = new Client([
            'base_uri' => $opts['api_uri'].'/Token',
            'ssl_key' => $opts['ssl_key']
        ]);
        
        $grant_type = new ClientCredentials($client, [
            "client_id" => $opts["client_id"],
            "client_secret" => $opts["client_secret"],
            "scope" => $opts["scope"]
        ]);
        $oauth = new OAuth2Middleware($grant_type);
        
        $stack = HandlerStack::create();
        $stack->push($oauth);
        
        return new Client([
            'handler' => $stack,
            'auth'    => 'oauth',
        ]);        
    }
}