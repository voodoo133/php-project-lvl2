<?php

namespace Differ\Differ\Formatters;

use function Differ\Differ\Formatters\Plain\format as plain;
use function Differ\Differ\Formatters\Json\format as json;
use function Differ\Differ\Formatters\Stylish\format as stylish;

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
