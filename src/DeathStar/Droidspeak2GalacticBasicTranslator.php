<?php

namespace App\DeathStar;
use App\DeathStar\Exceptions\TranslatorInvalidArgumentException;

class Droidspeak2GalacticBasicTranslator implements TranslatorInterface {

    public function translate(string $toTranslate): string
    {
        $charsArray = explode(' ', $toTranslate);
        return implode('', array_map(function($singleBinaryWord) {

            if(!preg_match('~^[01]+$~', $singleBinaryWord)) { 
                throw new TranslatorInvalidArgumentException("'"+$singleBinaryWord."' is not binary string");
            } 
            return chr(bindec($singleBinaryWord));
        }, $charsArray));
    }
}