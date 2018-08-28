<?php

namespace Tests\DeathStar;

use PHPUnit\Framework\TestCase;
use App\DeathStar\Droidspeak2GalacticBasicTranslator;
use App\DeathStar\Exceptions\TranslatorInvalidArgumentException;

class Droidspeak2GalacticBasicTranslatorTest extends TestCase
{
    public function setUp()
    {
        $this->translator = new Droidspeak2GalacticBasicTranslator();
    }

    /**
     * @dataProvider provideDroidSpeech
     */
    public function testShouldCorrectlyTranslateDroidToEnglish($droidSpeech, $expected)
    {
        $result = $this->translator->translate($droidSpeech);
        $this->assertEquals($result, $expected);
    }

    public function provideDroidSpeech()
    {
        return [
            [
                "01000011 01100101 01101100 01101100 00100000 00110010 00110001 00111000 00110111", 
                "Cell 2187"
            ],
            [
                "01000100 01100101 01110100 01100101 01101110 01110100 01101001 01101111 01101110 00100000 01000010 01101100 01101111 01100011 01101011 00100000 01000001 01000001 00101101 00110010 00110011 00101100", 
                "Detention Block AA-23,"
            ]
        ];
    }

    /**
     * @dataProvider provideInvalidDroidSpeech
     */
    public function testShouldFailToTranslate($toTranslate)
    {
        $this->expectException(TranslatorInvalidArgumentException::class);
        $this->translator->translate($toTranslate);
        
    }

    public function provideInvalidDroidSpeech()
    {
        return [
            ["01000011 01100101 a1101100"],
            [""],
            ["0?"]
        ];
    }    
}
