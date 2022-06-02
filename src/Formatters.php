<?php

namespace GenDiff\Formatters;

use function GenDiff\Formatters\Plain\format as plain;
use function GenDiff\Formatters\Json\format as json;
use function GenDiff\Formatters\Stylish\format as stylish;

function format($diff, $type = 'stylish')
{
    switch ($type) {
        case 'plain':
            return plain($diff);

        case 'json':
            return json($diff);

        case 'stylish':
        default:
            return stylish($diff);
    }
}
