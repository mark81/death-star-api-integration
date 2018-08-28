<?php

namespace App\DeathStar;

interface PrisonerInterface {

    public function get(string $name): string;
}