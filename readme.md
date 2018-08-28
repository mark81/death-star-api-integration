## Imperial Operating System hacking tool

## Task Part 1 - API Consumption.

* Guzzle as Http Client 
* `App\DeathStar\DeathStarClient.php` - client factory
* `App\DeathStar\Exhaust.php` - reactor/exhaust api calls
* `App\DeathStar\Prisoner.php` - prisoner api calls
* configuration stored in .env file - for the purpose of this demo .env is tracked by git
* ssl cert path in .env file

The way API consumption should look like:

```php
use App\DeathStar\DeathStarClient;
use App\DeathStar\Exhaust;
use App\DeathStar\Prisoner;

//pass options to client
$opts = [
    'ssl_key' => env('SSL_KEY_PATH'),
    'api_uri' => env('API_URL'),
    'client_secret' => env('CLIENT_SECRET'),
    'client_id' => env('CLIENT_ID'),
    'scope' => 'TheForce'
];
//create client
$client = DeathStarClient::fromConfigArray($opts);

//throw thorpedos on reactor
$exhaust = new Exhaust($client);
$exhaust->delete(1);

//fetch leia location
$leia = new Prisoner($client);
$leia->get('leia');
```

## Task Part 2 - Data Processing.

* Used php unit as test runner
* tests in /tests/DeathStar folder
* Guzzle MockHandler used to mock API calls
* added unit tests for Prisoner, Exhaust and Translator service, tests contain both success and failures
* added `App\DeathStar\TranslationInterface` and its `Droidspeak2GalacticBasicTranslator`  implementation


```
> vendor/bin/phpunit

...........                                                       11 / 11 (100%)

Time: 530 ms, Memory: 4.00MB

OK (11 tests, 13 assertions)
```

## Running 

* If you're running from Docker, start container first, run docker-compose

```
docker-compose up
```

when ready, ssh to container 

```
docker exec -it [container_id] bash
```

... and go to /var/www/html 

```
cd /var/www/html
```

* Install dependencies 

```
composer install
```

* Run `phpunit` 

```
vendor/bin/phpunit
```

### Thats it

