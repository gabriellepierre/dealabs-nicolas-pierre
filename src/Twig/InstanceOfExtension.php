<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigTest;

class InstanceOfExtension extends AbstractExtension
{
    public function getTests(): array
    {
        return [
            new TwigTest('instanceOf',[$this, 'isInstanceOf']),
        ];
    }

    public function isInstanceOf($var,$instance){
        return $var instanceof $instance;
    }
}