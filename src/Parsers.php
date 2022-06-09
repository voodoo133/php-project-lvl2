<?php

namespace Differ\Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function parse(string $fileData, string $type)
{
    switch ($type) {
        case 'json':
            return json_decode($fileData, false);

        case 'yml':
        case 'yaml':
            return Yaml::parse($fileData, Yaml::PARSE_OBJECT_FOR_MAP);

        default:
            return [];
    }
}
