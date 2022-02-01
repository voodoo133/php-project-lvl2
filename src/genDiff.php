<?php

namespace GenDiff;

use function GenDiff\Parsers\parse;

function genDiff($pathToFile1, $pathToFile2)
{
    $fileData1 = file_get_contents($pathToFile1);
    $fileData2 = file_get_contents($pathToFile2);

    $type = pathinfo($pathToFile1, PATHINFO_EXTENSION);

    $path1Extension = pathinfo($pathToFile1)['extension'];
    $path2Extension = pathinfo($pathToFile2)['extension'];

    $data1 = parse($fileData1, $type);
    $data2 = parse($fileData2, $type);

    ksort($data1);
    ksort($data2);

    $resultStrArr = [];

    foreach ($data1 as $key => $value) {
        if (!array_key_exists($key, $data2)) {
            $resultStrArr[] = str_repeat(" ", 2) . "- {$key}: " . varToString($data1[$key]);
        } else {
            if ($data1[$key] === $data2[$key]) {
                $resultStrArr[] = str_repeat(" ", 4) . "{$key}: " . varToString($data1[$key]);
            } else {
                $resultStrArr[] = str_repeat(" ", 2) . "- {$key}: " . varToString($data1[$key]);
                $resultStrArr[] = str_repeat(" ", 2) . "+ {$key}: " . varToString($data2[$key]);
            }

            unset($data2[$key]);
        }
    }

    if (count($data2) > 0) {
        foreach ($data2 as $key => $value) {
            $resultStrArr[] = str_repeat(" ", 2) . "+ {$key}: " . varToString($data2[$key]);
        }
    }

    return "{\n" . join("\n", $resultStrArr) . "\n}\n";
}

function varToString($var)
{
    if (is_bool($var)) {
        return var_export($var, true);
    } else {
        return strval($var);
    }
}
