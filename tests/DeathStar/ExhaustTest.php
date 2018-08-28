<?php

namespace Tests\DeathStar;

use PHPUnit\Framework\TestCase;
use App\DeathStar\Exhaust;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;
use App\DeathStar\Exceptions\InvalidArgumentException;

class ExhaustTest extends TestCase
{
    public function testShouldSuccessfullyDestroyReactorExhaust()
    {
        $mock = new MockHandler([
            new Response(200)
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client([
            'handler' => $handler
        ]);
        
        $exhaust = new Exhaust($client);
        $this->assertTrue($exhaust->delete(1));
    }

    public function testShouldMissReactorExhaust()
    {
        $mock = new MockHandler([
            new Response(400)
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client([
            'handler' => $handler
        ]);
        
        $exhaust = new Exhaust($client);

        $this->expectException(ClientException::class);
        $this->expectExceptionCode(400);
                
        $exhaust->delete(5);
    }

    public function testShouldFailInvalidExhaustId()
    {
        $mock = new MockHandler([
            new Response(200)
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client([
            'handler' => $handler
        ]);
        
        $exhaust = new Exhaust($client);

        $this->expectException(InvalidArgumentException::class);
        $exhaust->delete(0);
    }    
}
