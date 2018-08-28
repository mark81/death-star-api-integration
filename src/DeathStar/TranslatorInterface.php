<?php

namespace App\DeathStar;

interface TranslatorInterface {

    public function translate(string $text): string;
}