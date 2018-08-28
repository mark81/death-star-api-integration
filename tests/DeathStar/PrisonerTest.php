<?php

namespace Tests\DeathStar;

use PHPUnit\Framework\TestCase;
use App\DeathStar\Prisoner;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;
use App\DeathStar\Exceptions\InvalidArgumentException;

class PrisonerTest extends TestCase
{
    public function testShouldReturnValidResponse()
    {
        $expectedResponse = '{
            "cell": "01000011 01100101 01101100 01101100 00100000 00110010 00110001 00111000 00110111",
            "block": "01000100 01100101 01110100 01100101 01101110 01110100 01101001 01101111 01101110 00100000 01000010 01101100 01101111 01100011 01101011 00100000 01000001 01000001 00101101 00110010 00110011 00101100"
        }';
    
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], $expectedResponse)
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client([
            'handler' => $handler
        ]);
        
        $prisoner = new Prisoner($client);
        $response = $prisoner->get('leia');
        
        $this->assertEquals($response, $expectedResponse);
    }

    public function testShouldFailPrisonerDataRetrieval()
    {
        $mock = new MockHandler([
            new Response(404, ['Content-Type' => 'application/json'])
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client([
            'handler' => $handler
        ]);
        
        $prisoner = new Prisoner($client);
        $this->expectException(ClientException::class);
        $this->expectExceptionCode(404);

        $prisoner->get('unknown_prisoner');
    }      

    public function testShouldFailInvalidPrisonerName()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'])
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client([
            'handler' => $handler
        ]);
        
        $prisoner = new Prisoner($client);
        $this->expectException(InvalidArgumentException::class);

        $prisoner->get('');
    }      
}
