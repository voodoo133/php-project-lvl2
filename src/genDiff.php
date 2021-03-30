<?php 

namespace Gendiff;

function genDiff($pathToFile1, $pathToFile2)
{
    $data1 = getDataFromJsonFile($pathToFile1, true);
    $data2 = getDataFromJsonFile($pathToFile2, true);

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

function getDataFromJsonFile($pathToFile)
{
    return json_decode(file_get_contents($pathToFile), true);
}

function varToString($var)
{
    if (is_bool($var)) return var_export($var, true);
    else return strval($var);
}

?>