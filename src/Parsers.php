<?php

namespace GenDiff\Parsers;

use Symfony\Component\Yaml\Yaml;

function parse($fileData, $type)
{
    switch ($type) {
        case 'json':
            return json_decode($fileData, true);
            break;

        case 'yml':
        case 'yaml':
            return get_object_vars(Yaml::parse($fileData, Yaml::PARSE_OBJECT_FOR_MAP));
            break;

        default:
            return [];
            break;
    }
}
