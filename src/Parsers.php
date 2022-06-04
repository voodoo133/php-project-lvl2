<?php

namespace Differ\Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function parse($fileData, $type)
{
    switch ($type) {
        case 'json':
            return json_decode($fileData, false);
            break;

        case 'yml':
        case 'yaml':
            return Yaml::parse($fileData, Yaml::PARSE_OBJECT_FOR_MAP);
            break;

        default:
            return [];
            break;
    }
}
