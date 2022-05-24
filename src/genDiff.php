<?php

namespace GenDiff;

use function GenDiff\Parsers\parse;
use function GenDiff\Formatters\format;

function genDiff($pathToFile1, $pathToFile2, $format = 'stylish')
{
    [$fileData1, $type] = getFileInfo($pathToFile1);
    [$fileData2, $type] = getFileInfo($pathToFile2);

    $data1 = parse($fileData1, $type);
    $data2 = parse($fileData2, $type);

    $diff = getDiff($data1, $data2);

    return format($diff, $format);
}

function getFileInfo($pathToFile)
{
    $data = file_get_contents($pathToFile);
    $type = pathinfo($pathToFile, PATHINFO_EXTENSION);

    return [$data, $type];
}

function getDiff($obj1, $obj2)
{
    $diff = [];

    $keys1 = array_keys(get_object_vars($obj1));
    $keys2 = array_keys(get_object_vars($obj2));

    $keys = array_unique(array_merge($keys1, $keys2));
    sort($keys);

    foreach ($keys as $key) {
        if (property_exists($obj1, $key) && !property_exists($obj2, $key)) {
            $diff[] = makeDiffItem($key, 'removed', $obj1->$key, null);
        }

        if (!property_exists($obj1, $key) && property_exists($obj2, $key)) {
            $diff[] = makeDiffItem($key, 'added', null, $obj2->$key);
        }

        if (property_exists($obj1, $key) && property_exists($obj2, $key)) {
            if (is_object($obj1->$key) && is_object($obj2->$key)) {
                $diff[] = makeDiffItem($key, 'nested', null, null, getDiff($obj1->$key, $obj2->$key));
            } else {
                if ($obj1->$key === $obj2->$key) {
                    $diff[] = makeDiffItem($key, 'not-changed', $obj1->$key, $obj2->$key);
                } else {
                    $diff[] = makeDiffItem($key, 'changed', $obj1->$key, $obj2->$key);
                }
            }
        }
    }

    return $diff;
}

function makeDiffItem($name, $type, $prevValue, $newValue, $children = null)
{
    return [
        'name' => $name,
        'type' => $type,
        'prevValue' => $prevValue,
        'newValue' => $newValue,
        'children' => $children
    ];
}
