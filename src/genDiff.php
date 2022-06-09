<?php

namespace Differ\Differ;

use function Differ\Differ\Parsers\parse;
use function Differ\Differ\Formatters\format;
use function Functional\sort;

function genDiff(string $pathToFile1, string $pathToFile2, string $format = 'stylish')
{
    [$fileData1, $type] = getFileInfo($pathToFile1);
    [$fileData2] = getFileInfo($pathToFile2);

    $data1 = parse($fileData1, $type);
    $data2 = parse($fileData2, $type);

    $diff = getDiff($data1, $data2);

    return format($diff, $format);
}

function getFileInfo(string $pathToFile)
{
    $data = file_get_contents($pathToFile);
    $type = pathinfo($pathToFile, PATHINFO_EXTENSION);

    return [$data, $type];
}

function getDiff(object $obj1, object $obj2)
{
    $keys1 = array_keys(get_object_vars($obj1));
    $keys2 = array_keys(get_object_vars($obj2));

    $keys = array_unique(array_merge($keys1, $keys2));
    $sortedKeys = sort($keys, fn ($left, $right) => strcmp($left, $right));

    return array_map(function ($key) use ($obj1, $obj2) {
        if (property_exists($obj1, $key) && !property_exists($obj2, $key)) {
            return makeDiffItem($key, 'removed', $obj1->$key, null);
        }

        if (!property_exists($obj1, $key) && property_exists($obj2, $key)) {
            return makeDiffItem($key, 'added', null, $obj2->$key);
        }

        if (property_exists($obj1, $key) && property_exists($obj2, $key)) {
            if (is_object($obj1->$key) && is_object($obj2->$key)) {
                return makeDiffItem($key, 'nested', null, null, getDiff($obj1->$key, $obj2->$key));
            } else {
                if ($obj1->$key === $obj2->$key) {
                    return makeDiffItem($key, 'not-changed', $obj1->$key, $obj2->$key);
                } else {
                    return makeDiffItem($key, 'changed', $obj1->$key, $obj2->$key);
                }
            }
        }
    }, $sortedKeys);
}

function makeDiffItem(string $name, string $type, $prevValue, $newValue, ?array $children = null)
{
    return [
        'name' => $name,
        'type' => $type,
        'prevValue' => $prevValue,
        'newValue' => $newValue,
        'children' => $children
    ];
}
